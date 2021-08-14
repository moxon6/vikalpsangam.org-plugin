<template>
  <div class="stories-map">
    <l-map ref="map" :center="center" :zoom="zoom" @ready="onMapReady()">
      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
      <v-marker-cluster :options="clusterOptions">
        <div v-for="coordinate in coordinates" :key="coordinate.id">
          <l-marker
            v-if="showMarker(coordinate)"
            :icon="getIcon(coordinate)"
            :lat-lng="[coordinate.latitude, coordinate.longitude]"
          >
            <l-popup>
              <div class="card post-tile-card">
                <a :href="coordinate.url">
                  <img
                    v-lazy="coordinate.thumbnail"
                    class="card-img-top popup-image"
                  />
                </a>
                <div class="card-body">
                  <a :href="coordinate.url">
                    <h6 class="card-title popup-title">
                      {{ coordinate.title }}
                    </h6>
                  </a>
                  <p class="card-text post-tile-text">
                    {{ coordinate.excerpt }}
                  </p>
                </div>
                <footer class="card-footer d-flex justify-content-end p-0">
                  <a :href="coordinate.url" class="btn btn-primary btn-sm"
                    >Read More</a
                  >
                </footer>
              </div>
            </l-popup>
          </l-marker>
        </div>
      </v-marker-cluster>
      <l-control position="bottomright" v-if="showCategoriesMenu">
        <div class="category-list">
          <a
            class="category-list-header"
            data-toggle="collapse"
            href="#categories"
          >
            <img class="category-list-header-image" />
            <p>Filter by category</p>
            <h5 class="ml-2 mb-0 text-primary">
              <i class="fas fa-angle-up collapse-icon"></i>
            </h5>
          </a>
          <div id="categories" class="collapse show" ref="categories">
            <button
              :key="category.cat_ID"
              v-on:click="selectCategory(category)"
              v-for="category in categories"
              v-bind:class="[
                { selected: category.cat_ID === selectedCategory },
                'category',
              ]"
              :style="category.menuItemStyle"
            >
              <div class="bullet"></div>
              {{ category.name }}
            </button>
          </div>
        </div>
      </l-control>
    </l-map>
    <div v-if="!coordinates.length" class="loading-overlay">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup, LControl } from "vue2-leaflet";
import VueLazyload from "vue-lazyload";
import Vue2LeafletMarkerCluster from "vue2-leaflet-markercluster";
import Vue from "vue";

Vue.use(VueLazyload);

const setVh = () =>
  document.documentElement.style.setProperty(
    "--vh",
    `${window.innerHeight * 0.01}px`
  );
setVh();
window.addEventListener("resize", setVh);

import "leaflet/dist/leaflet.css";
import "leaflet-fullscreen";
import "leaflet-fullscreen/dist/leaflet.fullscreen.css";
import "leaflet.markercluster/dist/MarkerCluster.css";
import "leaflet.markercluster/dist/MarkerCluster.Default.css";

const getCenter = (coordinates) => [
  [
    Math.min(...coordinates.map((x) => x.latitude)),
    Math.min(...coordinates.map((x) => x.longitude)),
  ],
  [
    Math.max(...coordinates.map((x) => x.latitude)),
    Math.max(...coordinates.map((x) => x.longitude)),
  ],
];

const txt = document.createElement("textarea");
const decode = (html) => {
  txt.innerHTML = html;
  return txt.value;
};

export default {
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LControl,
    "v-marker-cluster": Vue2LeafletMarkerCluster,
  },
  props: {
    clusterOptions: {
      type: Object,
    },
    showCategoriesMenu: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      message: "Hello Vue!",
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      zoom: 5,
      center: [21.6, 82.5],
      coordinates: [],
      categories: [],
      selectedCategory: null,
    };
  },
  mounted() {
    const map = this.$refs.map.mapObject;

    this.onMobile = this.$el.clientWidth <= 767;

    this.zoom =
      this.$el.clientWidth > 767 ? 6 : this.$el.clientWidth > 600 ? 5 : 4;

    map.addControl(new L.Control.Fullscreen({ position: "topright" }));
    this.fetchGeoJson(map)
    this.fetchData()
  },
  methods: {
    onMapReady() {
      if (this.onMobile) {
        jQuery(this.$refs.categories).collapse();
      }
    },
    getIcon(coordinate) {
      return this.selectedCategory
        ? this.categories[this.selectedCategory].icon
        : this.categories[coordinate.categories[0]].icon;
    },
    selectCategory(category) {
      this.selectedCategory =
        this.selectedCategory !== category.cat_ID ? category.cat_ID : null;
    },
    showMarker(coordinate) {
      return (
        !this.selectedCategory ||
        coordinate.categories.includes(this.selectedCategory)
      );
    },
    async fetchGeoJson(map) {
        return fetch("/wp-content/plugins/vikalpsangam.org-plugin/widgets/stories-map/states_india.json")
          .then(res => res.json())
          .then(boundaries => L.geoJSON(boundaries).addTo(map) )
    },
    async fetchData() {
      const response = await wp.apiRequest({
        path: "vikalpsangam-plugin/v2/map",
      });

      this.categories = _.chain(response.categories)
        .map((category) => ({
          ...category,
          icon: L.divIcon({
            className: "story-marker-icon",
            html: `<div style='background-color: ${category.color}'></div>`,
          }),
          menuItemStyle: {
            "--bullet-color": category.color,
          },
        }))
        .indexBy("cat_ID")
        .value();

      this.coordinates = Object.values(response.coordinates).map(
        (coordinate) => ({
          ...coordinate,
          title: decode(coordinate.title),
          excerpt: decode(coordinate.excerpt),
        })
      );
      this.center = new L.LatLngBounds(getCenter(this.coordinates)).getCenter();
    },
  },
};
</script>

<style lang="scss">
$dark-brick-col: #9e332e;

.stories-map-title {
  color: #9e332e;
  text-shadow: none;
  text-transform: uppercase;
  opacity: 1;
  font-size: 20px;
  font-weight: 700;
}

.map-container {
  box-shadow: 0 0 2px black;
  height: 400px;
  margin-bottom: 32px;
}

.stories-map {
  box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.4);

  flex: 1;
  height: 100%;
  position: relative;

  .leaflet-popup-content-wrapper {
    background: transparent;
    padding: 0;
  }

  .leaflet-popup-content {
    margin: 0;
    width: 300px !important;

    .btn-primary {
      color: white;
    }

    .popup-title {
      color: $dark-brick-col;
    }

    .popup-image {
      object-fit: cover;
    }
  }

  .story-marker-icon {
    > div {
      width: 100%;
      height: 100%;
      border: 1px solid black;
      border-radius: 50%;
      display: block;
    }
  }

  .loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    background-color: rgba(0, 0, 0, 0.2);
  }

  .category-list {
    background-color: white;
    padding: 4px 8px;

    box-shadow: rgba(0, 0, 0, 0.2) 0 0 4px 2px;
    border-radius: 4px;

    .collapsed {
      .collapse-icon {
        transform: rotate(180deg);
      }
    }

    .category {
      .bullet {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: var(--bullet-color);
        font-size: 40px;
        border: 1px solid rgba(0, 0, 0, 0.2);
      }

      display: list-item;
      background-color: transparent;
      border: none;
      margin-bottom: 7px;
      font-size: 10px;
      color: #666666;
      font-weight: bold;
      font-family: "Helvetica", Arial;
      text-transform: uppercase;
      text-align: left;
      line-height: 10px;

      &.selected {
        font-weight: 900;
      }
    }

    .category-list-header {
      display: flex;
      justify-content: center;
      align-items: center;
      .category-list-header-image {
        width: 48px;
        content: url("./logo.png");
      }
      p {
        font-family: "Roboto-Black";
        color: $dark-brick-col;
        text-shadow: none;
        text-transform: uppercase;
        opacity: 1;
        margin: 0;
        margin-left: 4px;
        font-size: 16px;
      }
    }
  }
}
</style>
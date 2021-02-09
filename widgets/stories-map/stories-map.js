const INITIAL_ZOOM_LEVEL = 5;

const mean = (arr) => arr.reduce((x, y) => x + y, 0) / arr.length;

// Required for licensing purposes
const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'; 

const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

async function fetchCoordinates() {
  const response = await fetch('/wp-json/vikalpsangam/v1/map');
  const coordinatesMap = await response.json();
  return Object.values(coordinatesMap);
}

async function renderMap(id) {
    const coordinates = await fetchCoordinates();
    const mapCenter = [
      mean(coordinates.map((x) => x.latitude)),
      mean(coordinates.map((x) => x.longitude)),
    ]
  
    const map = L.map(id).setView(mapCenter, INITIAL_ZOOM_LEVEL);
  
    L.tileLayer(tileUrl, {
      attribution,
    }).addTo(map);
  
    const markers = L.markerClusterGroup();
  
    coordinates.forEach((coordinate) => {
      const marker = L.marker([coordinate.latitude, coordinate.longitude]);
      marker.bindPopup(`<a href="${coordinate.url}">${coordinate.title}</a>`);
      markers.addLayer(marker);
    });
    map.addLayer(markers);
  }
  
  window.renderMap = renderMap;
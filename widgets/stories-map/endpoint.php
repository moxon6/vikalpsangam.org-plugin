<?php

namespace Vikalpsangam\Plugin\Widgets;

$cache_key = "get_article_coordinates";

function get_coordinates() {
    
    $posts = get_posts([
        "numberposts" => -1
    ]);

    $coordinates = array_map(function($post) {
        $latitude = get_post_meta($post->ID, 'latitude', TRUE);
        $longitude = get_post_meta($post->ID, 'longitude', TRUE);
        return [
            "id" => $post->ID,
            "title" => get_the_title( $post->ID ),
            "url" => get_the_permalink($post->ID),
            "categories" => $post->post_category,
            "latitude" => (float)$latitude,
            "longitude" => (float)$longitude,
            "thumbnail" => get_the_post_thumbnail_url($post),
            "excerpt" => get_the_excerpt($post)
        ];
    }, $posts);

    return array_filter(
        $coordinates, 
        fn($c) => (
            $c["latitude"] != 0 && 
            $c["longitude"] != 0 && 
            count($c["categories"]) > 0
        )
    );
}

function get_article_coordinates($request) {    
    global $cache_key;

    $cached = true;
    
    $coordinates = get_transient($cache_key);
    if (empty($coordinates)) {
        $cached = false;
        $coordinates = get_coordinates();
        set_transient( $cache_key, $coordinates, DAY_IN_SECONDS );
    }

    $categories = get_categories();

    foreach($categories as $category) {
        $category->color = get_field('color', $category) ?? "white";
    }

    $response = new \WP_REST_Response([
        "cached" => $cached,
        "coordinates" => $coordinates,
        "categories" => $categories
    ]);
    $response->set_status(200);
    $response->set_headers(array('Cache-Control' => 'max-age=3600'));			
    return $response;
}

function register_map_endpoint() {
	register_rest_route( 'vikalpsangam-plugin/v2', 'map', array(
		'methods'  => 'GET',
		'callback' => __NAMESPACE__ . '\get_article_coordinates'
	));
}

add_action('rest_api_init', function () {
    register_map_endpoint();
});

// Schedule rebuilding cache twice-daily
function rebuild_vikalpsangam_map_cache() {
    global $cache_key;
    delete_transient($cache_key);
    get_article_coordinates(null);
}

if ( ! wp_next_scheduled( 'rebuild_vikalpsangam_map_cache' ) ) {
    wp_schedule_event( time(), 'twicedaily', 'rebuild_vikalpsangam_map_cache' );
}

add_action( 'rebuild_vikalpsangam_map_cache',  __NAMESPACE__ . '\rebuild_vikalpsangam_map_cache');
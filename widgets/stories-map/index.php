<?php

include 'stories-map.php';
// include 'endpoint.php';

function vikalpsangam_scripts() {

    wp_enqueue_script('jquery');
    wp_enqueue_script( 'wp-api' );

    wp_enqueue_script("leaflet/js", "https://unpkg.com/leaflet@1.7.1/dist/leaflet.js");
	wp_enqueue_style( 'leaflet/css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css' );
    
    wp_enqueue_style('leaflet.MarkerCluster/css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css' );
	wp_enqueue_style('leaflet.MarkerCluster.Default/css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css' );
	wp_enqueue_script('leaflet.MarkerCluster/js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', ["leaflet/js"] );

	wp_enqueue_script( 'vikalpsangam', get_template_directory_uri() . '/js/site/index.js', ["jquery", "leaflet/js", "wp-api"], vikalpsangam_VERSION );	
}
// add_action( 'wp_enqueue_scripts', 'vikalpsangam_scripts' );
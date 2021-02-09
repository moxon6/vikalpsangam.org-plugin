<?php

namespace Vikalpsangam\Plugin\Widgets;

include 'stories-map.php';
include 'endpoint.php';

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script( 'wp-api' );

    wp_enqueue_script("leaflet/js", "https://unpkg.com/leaflet@1.7.1/dist/leaflet.js");
	wp_enqueue_style( 'leaflet/css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css' );
    
	wp_enqueue_script('leaflet.MarkerCluster/js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', ["leaflet/js"] );
    wp_enqueue_style('leaflet.MarkerCluster/css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css' );
	wp_enqueue_style('leaflet.MarkerCluster.Default/css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css' );

	wp_enqueue_script( 'vikalpsangam-plugin', plugin_dir_url( __FILE__ ). "/stories-map.js", ["leaflet/js", "leaflet.MarkerCluster/js", "wp-api"], vikalpsangam_VERSION );	
});
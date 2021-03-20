<?php

namespace Vikalpsangam\Plugin\Widgets;

include 'stories-map.php';
include 'endpoint.php';

function enqueue_scripts() {
	wp_enqueue_script( 'vikalpsangam/stories-map', plugin_dir_url( __FILE__ ). '/dist/index.js', [], vikalpsangam_plugin_VERSION );
	wp_enqueue_style("vikalpsangam/stories-map/css", plugin_dir_url( __FILE__ ). '/dist/index.css');
}

add_action( 'wp_enqueue_scripts', 'Vikalpsangam\Plugin\Widgets\enqueue_scripts');
add_action( 'admin_enqueue_scripts', 'Vikalpsangam\Plugin\Widgets\enqueue_scripts');
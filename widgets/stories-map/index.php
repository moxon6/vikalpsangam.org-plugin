<?php

namespace Vikalpsangam\Plugin\Widgets;

include 'endpoint.php';
include 'widget.php';

function enqueue_scripts() {
	$build_time = filemtime(dirname(__FILE__) . '/dist/index.css');
	wp_enqueue_script( 'vikalpsangam/stories-map', plugin_dir_url( __FILE__ ). 'dist/index.js', ["jquery", "wp-api", "underscore"], "$build_time" );
	wp_enqueue_style("vikalpsangam/stories-map/css", plugin_dir_url( __FILE__ ). 'dist/index.css', [], $build_time);
}

add_action( 'wp_enqueue_scripts', 'Vikalpsangam\Plugin\Widgets\enqueue_scripts');
add_action( 'admin_enqueue_scripts', 'Vikalpsangam\Plugin\Widgets\enqueue_scripts');
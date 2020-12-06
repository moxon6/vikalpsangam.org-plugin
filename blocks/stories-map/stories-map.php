<?php

function register_stories_map_block() {
	require_once "render.php";
	require_once "endpoints.php";

	wp_register_script(
		'stories-map/editor/script',
		plugins_url( 'build/editor/index.js' , __FILE__ ),
		array(),
		vikalpsangam_plugin_VERSION
	);

	wp_register_style(
		'stories-map/editor/style',
		plugins_url( "build/client/index.css", __FILE__ ),
		array(),
		vikalpsangam_plugin_VERSION
	);

	wp_register_script(
		'stories-map/client/script',
		plugins_url( 'build/client/index.js', __FILE__ ),
		['wp-polyfill', 'wp-api-fetch' ],
		vikalpsangam_plugin_VERSION		
	);

	wp_localize_script(
		'stories-map/client/script',
		"pluginBaseUrl",
		plugins_url( 'build/client/', __FILE__ )
	);

	register_block_type( 'vikalpsagam-blocks/stories-map', array(
		'editor_script'   => 'stories-map/editor/script',
		'style'           => 'stories-map/editor/style',
		'script'          => 'stories-map/client/script',
		'render_callback' => 'render_vikalpsangam_map_block',
	));
}

add_action( 'init', 'register_stories_map_block' );

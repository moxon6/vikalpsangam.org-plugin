<?php
$dir = dirname( __FILE__ );

function register_stories_map_block() {
	global $dir;
	require_once "$dir/render.php";
	require_once "$dir/endpoints.php";

	wp_register_script(
		'stories-map/editor/script',
		plugins_url( 'build/editor/index.js' , __FILE__ ),
		array(),
		filemtime( "$dir/build/editor/index.js" )
	);

	wp_register_style(
		'stories-map/editor/style',
		plugins_url( "build/client/index.css", __FILE__ ),
		array(),
		filemtime( "$dir/build/client/index.css" )
	);

	wp_register_script(
		'stories-map/client/script',
		plugins_url( 'build/client/index.js', __FILE__ ),
		['wp-polyfill', 'wp-api-fetch' ]
	);

	wp_localize_script(
		'stories-map/client/script',
		"pluginBaseUrl",
		plugins_url( 'build/client/', __FILE__ ),
	);

	register_block_type( 'vikalpsagam-blocks/stories-map', array(
		'editor_script'   => 'stories-map/editor/script',
		'style'           => 'stories-map/editor/style',
		'script'          => 'stories-map/client/script',
		'render_callback' => 'render_vikalpsangam_map_block',
		));
}

add_action( 'init', 'register_stories_map_block' );

<?php

namespace Vikalpsangam\Plugin\Widgets;

function register_map_endpoint() {
    function get_coordinates() {
        $posts = get_posts([
            "numberposts" => -1
        ]);

        $coordinates = array_map(function($post) {
            $latitude = get_post_meta($post->ID, 'latitude', TRUE);
            $longitude = get_post_meta($post->ID, 'longitude', TRUE);
            return [
                "title" => get_the_title( $post->ID ),
                "url" => get_the_permalink($post->ID),
                "latitude" => (float)$latitude,
                "longitude" => (float)$longitude,
            ];
        }, $posts);
    
        return array_filter(
            $coordinates, 
            fn($c) => $c["latitude"] != 0 && $c["longitude"] != 0
        );
    }

    function get_article_coordinates($request) {
        
        $cache_key = "get_article_coordinates";

        $coordinates = get_transient($cache_key);
        if (empty($coordinates)) {
            $coordinates = get_coordinates();
            set_transient( $cache_key, $coordinates, DAY_IN_SECONDS );
        }

        $response = new WP_REST_Response($coordinates);
		$response->set_status(200);
		$response->set_headers(array('Cache-Control' => 'max-age=3600'));
		
        return $response;
    }

	register_rest_route( 'vikalpsangam/v1', 'map', array(
		'methods'  => 'GET',
		'callback' => 'get_article_coordinates'
	));
}

add_filter( 'rest_allow_anonymous_comments', '__return_true' ); 

function register_comments_endpoint() {

    function get_comments_rest($request) {       
        global $post;
        $post = get_post($request["post_id"]);
        setup_postdata($post);

        $response = new WP_REST_Response(
            Timber::compile(
                'partials/_comments.twig', 
                [ "post" => new Timber\Post($post)]
            )
        );
        $response->set_status(200);
        return $response;
    }

	register_rest_route( 'vikalpsangam/v1', 'comments/(?P<post_id>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'get_comments_rest'
	));
}

add_action('rest_api_init', function () {
    register_map_endpoint();
    register_comments_endpoint();
});
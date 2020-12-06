<?php 

add_action('rest_api_init', function () {
    function get_article_coordinates($request) {

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

        $coordinates = array_filter(
            $coordinates, 
            fn($c) => $c["latitude"] != 0 && $c["longitude"] != 0
        );

        $response = new WP_REST_Response($coordinates);
		$response->set_status(200);
		$response->set_headers(array('Cache-Control' => 'max-age=3600'));
		
        return $response;
    }

	register_rest_route( 'vikalpsangam/v1', 'map', array(
		'methods'  => 'GET',
		'callback' => 'get_article_coordinates'
	));
});
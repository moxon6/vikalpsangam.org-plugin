<?php

class Vikalpsangam_StoriesMapWidget extends WP_Widget {

    function __construct() {
        parent::__construct( false, __( 'Vikalpsangam Stories Map Widget', 'textdomain' ) );
    }

    function widget( $args, $instance ) {
        Timber::render("stories-map.twig");
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        Timber::render("stories-map.twig");
        return $instance;
    }
}
 
add_action( 'widgets_init', 'register_stories_map_widget' );
 
function register_stories_map_widget() {
    register_widget( 'Vikalpsangam_StoriesMapWidget' );
}   
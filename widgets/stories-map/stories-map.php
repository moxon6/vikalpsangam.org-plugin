<?php

class Vikalpsangam_StoriesMapWidget extends WP_Widget {

    function __construct() {
        parent::__construct( false, __( 'Vikalpsangam Stories Map Widget', 'textdomain' ) );
    }

    function widget( $args, $instance ) {
        echo "<p> This is the widget widget </p>";
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        echo "<p> This is the widget form </p>";
    }
}
 
add_action( 'widgets_init', 'register_stories_map_widget' );
 
function register_stories_map_widget() {
    register_widget( 'Vikalpsangam_StoriesMapWidget' );
}   
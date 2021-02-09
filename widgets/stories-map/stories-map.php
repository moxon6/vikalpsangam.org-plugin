<?php

namespace Vikalpsangam\Plugin\Widgets;

class StoriesMapWidget extends \WP_Widget {

    function __construct() {
        parent::__construct( 'StoriesMapWidget', __( 'Vikalpsangam Stories Map Widget', 'textdomain' ) );
    }

    function widget( $args, $instance ) {
        \Timber::render("stories-map.twig");
    }

    function form( $instance ) {
        \Timber::render("stories-map.twig");
        return 'noform';
    }
}
 
add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\StoriesMapWidget' );
});
 
<?php

namespace Vikalpsangam\Plugin\Widgets;

class VikalpsangamCategories extends \WP_Widget {

    function __construct() {
        parent::__construct( 'VikalpsangamCategories', __( 'Vikalpsangam Categories Widget', 'textdomain' ) );
    }

    function widget( $args, $instance ) {
        \Timber::render("categories.twig");
    }

    function form( $instance ) {
        \Timber::render("categories.twig");
        return 'noform';
    }
}
 
add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\VikalpsangamCategories' );
});
 
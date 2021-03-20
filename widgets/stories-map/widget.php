<?php

namespace Vikalpsangam\Plugin\Widgets;

class StoriesMapWidget extends \WP_Widget {

    function __construct() {
        parent::__construct( 'StoriesMapWidget', 'Vikalpsangam Stories Map Widget' );
    }

    private function getContext($instance) {
        $context = \Timber::context();

        $context["title"] = esc_attr( $instance['title'] ?? '' );
        $context["title_field_id"] = $this->get_field_id( 'title' );
        $context["title_field_name"] = $this->get_field_name( 'title' );

        return $context;
    }

    function widget( $args, $instance ) {
        \Timber::render("templates/stories-map.twig", $this->getContext($instance));
    }

    function form( $instance ) {
        \Timber::render("templates/stories-map-admin.twig", $this->getContext($instance));
    }
}
 
add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\StoriesMapWidget' );
});
 
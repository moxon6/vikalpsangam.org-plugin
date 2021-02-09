<?php

namespace Vikalpsangam\Plugin\Widgets;

class StoriesMapWidget extends \WP_Widget {

    function __construct() {
        parent::__construct( 'StoriesMapWidget', __( 'Vikalpsangam Stories Map Widget', 'textdomain' ) );
    }

    private function getContext($instance) {
        $context = \Timber::context();

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
        $title = esc_attr( $title );

        $context["title"] = $title;
		return $context;
    }

    function widget( $args, $instance ) {
        \Timber::render("stories-map.twig", $this->getContext($instance));
    }

    function form( $instance ) {
        \Timber::render("stories-map-admin.twig", array_merge(
            $this->getContext($instance), 
            [
                "title_field_id" => $this->get_field_id( 'title' ),
                "title_field_name" => $this->get_field_name( 'title' )
            ]
        ));
    }
}
 
add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\StoriesMapWidget' );
});
 
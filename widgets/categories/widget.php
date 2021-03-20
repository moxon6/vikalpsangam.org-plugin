<?php

namespace Vikalpsangam\Plugin\Widgets;

class VikalpsangamCategories extends \WP_Widget {

    function __construct() {
        parent::__construct( 'VikalpsangamCategories', __( 'Vikalpsangam Categories Widget', 'textdomain' ) );
    }

    private function getContext($instance) {
        $context = \Timber::context();
        $context["post_categories"] = \Timber::get_terms('category', [
			'hide_empty' => 1,
			"exclude" => [
                get_cat_ID("Perspectives"),
                get_cat_ID("Uncategorised")
            ]
        ]);

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
        $title = esc_attr( $title );

        $context["title"] = $title;
		return $context;
    }

    function widget( $args, $instance ) {
        \Timber::render("templates/categories.twig", $this->getContext($instance));
    }

    public function form( $instance ) {
        \Timber::render("templates/categories-admin.twig", array_merge(
            $this->getContext($instance), 
            [
                "title_field_id" => $this->get_field_id( 'title' ),
                "title_field_name" => $this->get_field_name( 'title' )
            ]
        ));
	}
}

add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\VikalpsangamCategories' );
});
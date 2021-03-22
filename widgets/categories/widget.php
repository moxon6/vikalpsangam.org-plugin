<?php

namespace Vikalpsangam\Plugin\Widgets;

class VikalpsangamCategories extends \WP_Widget {

    function __construct() {
        parent::__construct( 'VikalpsangamCategories', __( 'Vikalpsangam Categories Widget', 'textdomain' ) );
    }

    private function getContext($instance) {
        $context = \Timber::context();

        $context["title"] = $instance['title'];
        $context["title_field_id"] = $this->get_field_id( 'title' );
        $context["title_field_name"] = $this->get_field_name( 'title' );

        $categories = \Timber::get_terms('category');
        
        $context["categories_with_meta"] = array_map(
            fn($category) => [
                "category" => $category,
                "field_id" => $this->get_field_id( "category-" . $category->ID ),
                "field_name" => $this->get_field_name( "category-" . $category->ID ),
                "selected" => $instance["category-" . $category->ID]
            ],
            $categories
        );

		return $context;
    }

    function widget( $args, $instance ) {
        \Timber::render("templates/categories.twig", $this->getContext($instance));
    }
    
    public function form( $instance ) {
        \Timber::render("templates/categories-admin.twig", $this->getContext($instance));
	}
}

add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\VikalpsangamCategories' );
});
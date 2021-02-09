<?php

namespace Vikalpsangam\Plugin\Widgets;

class VikalpsangamCategories extends \WP_Widget {

    function __construct() {
        parent::__construct( 'VikalpsangamCategories', __( 'Vikalpsangam Categories Widget', 'textdomain' ) );
    }

    private function getContext() {
        $context = \Timber::context();
        $context["post_categories"] = \Timber::get_terms('category', [
			'hide_empty' => 1,
			"exclude" => [
                get_cat_ID("Perspectives"),
                get_cat_ID("Uncategorised")
            ]
		]);
		return $context;
    }

    function widget( $args, $instance ) {
        \Timber::render("categories.twig", $this->getContext());
    }

    function form( $instance ) {
        \Timber::render("categories.twig", $this->getContext());
        return 'noform';
    }
}
 
add_action( 'widgets_init', function() {
    register_widget( 'Vikalpsangam\Plugin\Widgets\VikalpsangamCategories' );
});
 
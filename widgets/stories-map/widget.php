<?php

namespace Vikalpsangam\Plugin\Widgets;

class StoriesMapWidget extends \WP_Widget {

    function __construct() {
        parent::__construct( 'StoriesMapWidget', 'Vikalpsangam Stories Map Widget' );
    }

    private function getContext($instance) {
        $context = \Timber::context();

        $context["title"] = $instance['title'];
        $context["title_field_id"] = $this->get_field_id( 'title' );
        $context["title_field_name"] = $this->get_field_name( 'title' );

        
        $context["showCategoriesMenu"] = $instance["showCategoriesMenu"];
        $context["showCategoriesMenu_field_id"] = $this->get_field_id("showCategoriesMenu");
        $context["showCategoriesMenu_field_name"] = $this->get_field_name("showCategoriesMenu");

        $context["enableClustering"] = $instance["enableClustering"];
        $context["enableClustering_field_id"] = $this->get_field_id("enableClustering");
        $context["enableClustering_field_name"] = $this->get_field_name("enableClustering");

        $context["height"] = $instance["height"];
        $context["height_field_id"] = $this->get_field_id("height");
        $context["height_field_name"] = $this->get_field_name("height");

        $context["marginBottom"] = $instance["marginBottom"];
        $context["marginBottom_field_id"] = $this->get_field_id("marginBottom");
        $context["marginBottom_field_name"] = $this->get_field_name("marginBottom");

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
 
add_shortcode('vikalpsangam_map', function ($atts) {
    return \Timber::compile("templates/stories-map.twig", [
        showCategoriesMenu => ($atts["show-categories-menu"] != "true"),
        enableClustering => ($atts["enable-clustering"] == "true"),
        height => $atts["height"] ?? "400px",
        marginBottom => $atts["margin-bottom"] ?? "32px"
    ]);
});
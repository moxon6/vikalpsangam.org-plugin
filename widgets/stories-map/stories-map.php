<?php

 
class My_Widget extends WP_Widget {
 
    public function __construct() {
    }
 
    public function widget( $args, $instance ) {
        return "<p>This is the Stories-Map widget</p>"
    }
 
    public function form( $instance ) {
    }
 
    public function update( $new_instance, $old_instance ) {
    }
}
 
?>
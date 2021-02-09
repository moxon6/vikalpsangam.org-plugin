<?php
/**
 * Plugin Name:     Vikalpsangam Plugin
 * Description:     Plugin for vikalpsangam.org
 * Version:         0.1.0
 * Author:          Martin Moxon
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     vikalpsangam.org
 *
 * @package         vikalpsangam.org-plugin
 */

require_once( __DIR__ . '/vendor/autoload.php' );

include 'version.php';

include 'widgets/stories-map/index.php';
include 'widgets/categories/index.php';

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('vikalpsangam/plugin/style', plugin_dir_url( __FILE__ ) . '/style.css' );
});
<?php
/**
 * Plugin Name:     Vikalpsangam Plugin
 * Description:     Plugin for vikalpsangam.org
 * Version:
 * Author:          Martin Moxon
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     vikalpsangam.org
 *
 * @package         vikalpsangam.org-plugin
 */

namespace Vikalpsangam\Plugin;

require_once( __DIR__ . '/vendor/autoload.php' );

include 'widgets/stories-map/index.php';
include 'widgets/categories/index.php';

function enqueueScripts() {
    $build_time = filemtime(dirname(__FILE__) . '/style.css');
    wp_enqueue_style('vikalpsangam/plugin/style', plugin_dir_url( __FILE__ ) . 'style.css', [], $build_time);
}

add_action( 'wp_enqueue_scripts', 'Vikalpsangam\Plugin\enqueueScripts');
add_action( 'admin_enqueue_scripts', 'Vikalpsangam\Plugin\enqueueScripts');
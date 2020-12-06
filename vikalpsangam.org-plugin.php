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

$dir = dirname( __FILE__ );

$blocks = array_filter(
    scandir("$dir/blocks"),
    fn($x) => !in_array($x, array('..', '.'))
); 

foreach($blocks as $block) {
    require_once "$dir/blocks/$block/$block.php";
}

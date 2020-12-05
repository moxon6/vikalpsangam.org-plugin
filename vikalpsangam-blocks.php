<?php
/**
 * Plugin Name:     Vikalpsangam Blocks
 * Description:     Blocks for vikalpsangam.org
 * Version:         0.1.0
 * Author:          Martin Moxon
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     vikalpsangam-map
 *
 * @package         vikalpsangam-blocks
 */

$dir = dirname( __FILE__ );

foreach(scandir("blocks") as $block) {
    require_once "$dir/blocks/$block/$block.php";
}

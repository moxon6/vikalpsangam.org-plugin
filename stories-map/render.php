<?php

function render_vikalpsangam_map_block() {
    ob_start(); 
    ?>
        <div id="large-map" class="vikalp-leaflet-block">
            <div class="loader" role="status">
            </div>
        </div>
    <?php
    return ob_get_clean();
}
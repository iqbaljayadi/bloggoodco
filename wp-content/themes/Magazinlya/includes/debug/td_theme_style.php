<?php

function td_theme_style_load_js() {
    wp_enqueue_script('style-customizer', get_template_directory_uri() . '/js/style_customizer.js',array( 'jquery' ), 1, true); //load at begining
}
//add_action('init', 'td_theme_style_load_js');





//the bottom code for analitics and stuff
function td_theme_style_footer() {
    ?>

    <div id="td-theme-settings">
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="td-set-color"></div>
        <div class="clearfix"></div>
        <div class="td-set-hide-show"><a href="#" id="td-theme-set-hide">HIDE</a></div>
    </div>

    <?php
}

add_action('wp_footer', 'td_theme_style_footer');

?>
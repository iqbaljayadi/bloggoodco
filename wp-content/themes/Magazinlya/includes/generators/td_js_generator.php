<?php

function td_render_custom_js() {

    $js_buffy = '';

    /*  ----------------------------------------------------------------------------
        background
     */

    //read global options
    $tds_stretch_background = td_get_option('tds_stretch_background');
    $td_background = get_background_image();

    $td_is_background_on_cat = false; //true if we have a user selected background on cat

    //read category specific options
    if (is_category()) {
        $curCategoryID = get_query_var('cat');
        $tdc_image = get_tax_meta($curCategoryID, 'tdc_image');
        $tdc_image_style = get_tax_meta($curCategoryID, 'tdc_image_style');

        //print_r($tdc_image);
        //die;
        if (!empty($tdc_image)){
            $td_background = $tdc_image['src'];
            $td_is_background_on_cat = true;
        }

        if (!empty($tdc_image_style)) {
            $tds_stretch_background = $tdc_image_style;
        }
    }

    if (is_single()) {
        $curCategoryID = td_global::get_primary_category_id();
        $tdc_image = get_tax_meta($curCategoryID, 'tdc_image');
        $tdc_image_style = get_tax_meta($curCategoryID, 'tdc_image_style');


        if (!empty($tdc_image)){
            $td_background = $tdc_image['src'];
            $td_is_background_on_cat = true;
        }

        if (!empty($tdc_image_style)) {
            $tds_stretch_background = $tdc_image_style;
        }
    }

    if ($tds_stretch_background == 'yes' and !empty($td_background)) {
        //stretch




        $js_buffy .= 'jQuery().ready(function() {' . "\n";
        $js_buffy .= 'if (td_is_phone_screen === false && td_is_iPad === false) {';
            $js_buffy .= 'jQuery.backstretch("' . $td_background . '", {fade:1200});'. "\n";
        $js_buffy .= '}';

        $js_buffy .= '});'. "\n";

    } elseif ($td_is_background_on_cat and !empty($td_background)) {
        //tile - only when the user uploaded a category specific image, if not let wordpress handle it
        ?>
        <style>
            body {
                background: url('<?php echo $td_background; ?>') repeat #474747 !important;
            }
        </style>
        <?php
    } else {
        //wp default background - add the wp default class on load if we don't have our own background
        $js_buffy .= 'jQuery().ready(function() {' . "\n";
            $js_buffy .= 'if (td_is_phone_screen === false && td_is_iPad === false) {';
            $js_buffy .= "jQuery('body').addClass('custom-background');". "\n";
            $js_buffy .= '}';
        $js_buffy .= '});'. "\n";
    }



    /*  ----------------------------------------------------------------------------
        ajax wp dispatch
     */
    $js_buffy .= 'var td_ajax_url="' . admin_url('admin-ajax.php') . '";' . "\n";


    /*  ----------------------------------------------------------------------------
        theme image url
     */
    $js_buffy .= 'var td_get_template_directory_uri="' . get_template_directory_uri() . '";' . "\n";


    /*  ----------------------------------------------------------------------------
        menu settings
     */
    $js_buffy .= 'var tds_snap_menu="' . td_get_option('tds_snap_menu') . '";' . "\n";


    /*  ----------------------------------------------------------------------------
        header style
    */
    $js_buffy .= 'var tds_header_style="' . td_get_option('tds_header_style') . '";' . "\n";



    if (!empty($js_buffy)) {
        echo '<script>' . "\n";
            echo $js_buffy;
        echo '</script>' . "\n";
    }
}

add_action('wp_footer', 'td_render_custom_js');
?>
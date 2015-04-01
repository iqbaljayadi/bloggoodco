<?php

global $td_loop_block_module; //the module type used in the loop

/*  ----------------------------------------------------------------------------
    load the gallery specific layout
 */
$cur_cat_id = get_query_var('cat');
$cur_cat_obj = get_category($cur_cat_id);

//print_r($cur_cat_obj);

$tdc_layout = get_tax_meta($cur_cat_id, 'tdc_layout');

if (!empty($tdc_layout)) {
    //load the gallery specific setting
    $td_loop_block_module = $tdc_layout;
} else {
    //load the global setting
    $td_loop_block_module = td_get_option('tds_category_page_layout');
}



get_header();

//read global sidebar position
$td_category_sidebar_position = td_get_option('tds_category_sidebar_pos');

//read current category sidebar position
$tdc_sidebar_pos = get_tax_meta($cur_cat_id, 'tdc_sidebar_pos');
if (!empty($tdc_sidebar_pos)) {
    $td_category_sidebar_position = $tdc_sidebar_pos;
}


switch ($td_category_sidebar_position) {
    case 'sidebar_left':
        echo td_page_generator::wrap_start();
        ?>
        <div class="span4 column_container">
            <?php get_sidebar(); ?>
        </div>
        <div class="span8 column_container">
            <?php
            echo td_text_with_title(array('title' => $cur_cat_obj->name, 'style' => 'style_2', 'class' => 'category-title'), $cur_cat_obj->description);
            get_template_part('category', 'slider');
            get_template_part('loop', 'block');
            ?>
        </div>
        <?php
        echo td_page_generator::wrap_end();
        break;

    case 'no_sidebar':
        echo td_page_generator::wrap_start();
        ?>
        <div class="span12 column_container">
            <?php
            echo td_text_with_title(array('title' => $cur_cat_obj->name, 'style' => 'style_2', 'class' => 'category-title'), $cur_cat_obj->description);
            get_template_part('category', 'slider');
            get_template_part('loop', 'block');
            ?>
        </div>
        <?php
        echo td_page_generator::wrap_end();
        break;



    default:
        echo td_page_generator::wrap_start();
        ?>
            <div class="span8 column_container">
                <?php
                echo td_text_with_title(array('title' => $cur_cat_obj->name, 'style' => 'style_2', 'class' => 'category-title'), $cur_cat_obj->description);
                get_template_part('category', 'slider');
                get_template_part('loop', 'block');
                ?>
            </div>
            <div class="span4 column_container">
                <?php get_sidebar(); ?>
            </div>
        <?php
        echo td_page_generator::wrap_end();
        break;
}

get_footer();
?>
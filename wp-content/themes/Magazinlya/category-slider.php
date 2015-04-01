<?php
//reset global columns
global $td_category_sidebar_position;


if ($td_category_sidebar_position != 'no_sidebar') {
    $td_force_columns = '2';
} else {
    $td_force_columns = '3';
}


$cur_cat_id = get_query_var('cat');


$tdc_slider = get_tax_meta($cur_cat_id, 'tdc_slider');


if ($tdc_slider != 'hide_slider') {

    if ($tdc_slider == 'page_one') {
        //show only on page 1
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ($paged == '1') {
            echo td_slide(array(
                'category_id' => $cur_cat_id,
                'sort' => 'featured',
                'force_columns' => $td_force_columns,
                'hide_title' => 'hide_title'
            ));
        }
    } else {
        //always show
        echo td_slide(array(
            'category_id' => $cur_cat_id,
            'sort' => 'featured',
            'force_columns' => $td_force_columns,
            'hide_title' => 'hide_title'
        ));
    }

}


?>
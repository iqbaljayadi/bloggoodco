<?php


function td_slide_inner(&$td_query, $td_column_number = '', $autoplay = '') { //$td_query by ref
    global $post;

    $buffy = '';

    $td_block_layout = new td_block_layout();
    if (empty($td_column_number)) {
        $td_column_number = $td_block_layout->get_column_number(); // get the column width of the block
    }

    $td_post_count = 0; // the number of posts rendered
    $td_current_column = 1; //the current column

    $td_unique_id_slide = uniqid();

        $buffy .= '<div id="' . $td_unique_id_slide . '" class="iosSlider iosSlider-col-' . $td_column_number . ' td_mod_wrap">';
            $buffy .= '<div class="slider ">';


                    while ($td_query->have_posts()) : $td_query->the_post();


                        $buffy .= td_modules::mod_slide_render($post, $td_column_number, $td_post_count);


                        //current column
                        if ($td_current_column == $td_column_number) {
                            $td_current_column = 1;
                        } else {
                            $td_current_column++;
                        }


                        $td_post_count++;
                    endwhile;


            $buffy .= $td_block_layout->close_all_tags();





            $buffy .= '</div>'; //close slider


            $buffy .= '<div class = "prevButton"></div>';
            $buffy .= '<div class = "nextButton"></div>';

        $buffy .= '</div>'; //clos ios

        if (!empty($autoplay)) {
            $autoplay_string =  '
            autoSlide: true,
            autoSlideTimer: ' . $autoplay * 1000 . ',
            ';
        } else {
            $autoplay_string = '';
        }

        $buffy .= '
<script>
jQuery(document).ready(function() {
    jQuery("#' . $td_unique_id_slide . '").iosSlider({
        snapToChildren: true,
        desktopClickDrag: true,
        keyboardControls: true,
        ' . $autoplay_string. '

        infiniteSlider: true,
        navPrevSelector: jQuery("#' . $td_unique_id_slide . ' .prevButton"),
        navNextSelector: jQuery("#' . $td_unique_id_slide . ' .nextButton"),
        onSlideComplete: slideContentComplete
    });
});
</script>
    ';
    return $buffy;
}




function td_slide($atts) {
    global $post;

    extract(shortcode_atts(
        array(
            'limit' => 5,
            'sort' => '',
            'category_id' => '',
            'category_ids' => '',
            'custom_title' => '',
            'custom_url' => '',
            'hide_title' => '',
            'show_child_cat' => '',
            'tag_slug' => '',
            'force_columns' => '', //used on categories
            'autoplay' => ''
        ),$atts));

    $buffy = ''; //output buffer
    $td_unique_id = uniqid();


    //go only on one category that was selected from drop down
    if (!empty($category_id) and empty($category_ids)) {
        $atts['category_ids'] = $category_id;
    }

    $td_data_source = new td_data_source(); //new data source
    $td_query = &$td_data_source->get_wp_query($atts); //by ref  do the query


    if ($td_query->have_posts() and $td_query->found_posts > 1 ) {
        //get the js for this block
        $buffy .= td_block_builder::get_block_js($atts, $td_unique_id, $td_query, 'slide');


        $buffy .= '<div class="td_block_wrap td_block_slide">';

            //get the block title
            $buffy .= td_block_builder::get_block_title($atts, $td_data_source);

            //get the sub category filter for this block
            $buffy .= td_block_builder::get_block_sub_cats($atts, $td_unique_id);

            $buffy .= '<div id=' . $td_unique_id . ' class="td_block_inner">';
                //inner content of the block

                $buffy .= td_slide_inner($td_query, $force_columns, $autoplay);

            $buffy .= '</div>';

        $buffy .= '</div> <!-- ./block1 -->';
    }
    return $buffy;
}
add_shortcode('td_slide', 'td_slide');








wpb_map(
    array(
        "name" => __("Slide", TD_THEME_NAME),
        "base" => "td_slide",
        "class" => "td_slide",
        "controls" => "full",
        "category" => __('Blocks', TD_THEME_NAME),
        'icon' => 'icon-pagebuilder-slide',
        "params" =>
        array(
            array(
                "param_name" => "autoplay",
                "type" => "textfield",
                "value" => '',
                "heading" => 'Autoplay slider (at x seconds)',
                "description" => "Leave empty do disable autoplay",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "category_id",
                "type" => "dropdown",
                "value" => td_get_category2id_array(),
                "heading" => __("Category filter:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "category_ids",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Multiple categories filter:", TD_THEME_NAME),
                "description" => "To filter multiple categories, enter here the category IDs separated by commas (example: 13,23,18)",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "tag_slug",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Filter by tag slug:", TD_THEME_NAME),
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "limit",
                "type" => "textfield",
                "value" => __("5", TD_THEME_NAME),
                "heading" => __("Limit post number:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "sort",
                "type" => "dropdown",
                "value" => array('- Latest -' => '', 'Popular' => 'popular', 'Featured' => 'featured'),
                "heading" => __("Sort order:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "custom_title",
                "type" => "textfield",
                "value" => "",
                "heading" => __("Optional - custom title for this block:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "custom_url",
                "type" => "textfield",
                "value" => "",
                "heading" => __("Optional - custom url for this block (when the module title is clicked):", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "hide_title",
                "type" => "dropdown",
                "value" => array('- Show title -' => '', 'Hide title' => 'hide_title'),
                "heading" => __("Hide block title:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "show_child_cat",
                "type" => "dropdown",
                "value" => array('- Hide -' => '', 'Show 1 category' => '1', 'Show 2 categories' => '2', 'Show 3 categories' => '3', 'Show 4 categories' => '4', 'Show 5 categories' => '5', 'Show 6 categories' => '6', 'Show 7 categories' => '7', 'Show 8 categories' => '8', 'Show all' => 'all'),
                "heading" => __("Show child categories menu:", TD_THEME_NAME),
                "description" => "This will show a menu at the top of the block that contains the child categories of the selected category. It only works when you're using a single category filter form the dropdown. It doss't work with multiple categories IDs",
                "holder" => "div",
                "class" => ""
            )
        )
    )
);

?>
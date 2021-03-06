<?php
class td_block_builder {


    static function get_block_title($atts, $td_data_source) {
        extract(shortcode_atts(
            array(
                'limit' => 5,
                'sort' => '',
                'category_id' => '',
                'category_ids' => '',
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'show_child_cat' => ''
            ),$atts));

        $buffy = '';

        //check to see if we show subcats
        //@todo the check is not like the one from get_block_sub_cats
        $css_buffer = '';
        if (!empty($show_child_cat) and !empty($category_id)) {
            $css_buffer = ' block-title-subcats';
        }

        //show the block title
        if ($hide_title != 'hide_title') {
            $buffy .= '<h4 class="block-title' . $css_buffer . '">';
            if (empty($custom_title)) {
                //@todo remove empty title space
                if (empty($custom_url)) {
                    //all is autogenerated
                    $buffy .= '<a href="' . $td_data_source->block_link . '">' . $td_data_source->block_name . '</a>';
                } else {
                    //just custom url by user, the title is autogenerated
                    $buffy .= '<a href="' . $custom_url . '">' . $td_data_source->block_name . '</a>';
                }
            } else {
                if (empty($custom_url)) {
                    //url is autogenerated
                    if (empty($td_data_source->block_link)) {
                        //no url? - popular files for example dosn't have a url
                        $buffy .= '<span>' . $custom_title . '</span>';
                    } else {
                        //url is present
                        $buffy .= '<a href="' . $td_data_source->block_link . '">' . $custom_title . '</a>';
                    }

                } else {
                    //url is custom + custom title
                    $buffy .= '<a href="' . $custom_url . '">' . $custom_title . '</a>';
                }
            }
            $buffy .= '</h4>';
        }

        return $buffy;
    }


    static function get_block_sub_cats($atts, $td_unique_id = '') {
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
                'sub_cat_ajax' => '' //empty we use ajax
            ),$atts));




        $td_block_layout = new td_block_layout();
        $td_column_number = $td_block_layout->get_column_number(); // get the column width of the block

        $buffy = '';

        if (!empty($show_child_cat) and !empty($category_id)) {
            $td_subcategories = get_categories(array('child_of' => $category_id));
            if (!empty($td_subcategories)) {
                if ($show_child_cat != 'all') {
                    $td_subcategories = array_slice($td_subcategories, 0, $show_child_cat);
                }

                $buffy .= '<ul class="block-child-cats">';
                if (empty($sub_cat_ajax)) {
                    $buffy .= '<li><a class="cur-sub-cat ajax-sub-cat sub-cat-' . $td_unique_id . '" id="sub-cat-' . $td_unique_id . '-' . $category_id . '" data-cat_id="' . $category_id . '" data-td_block_id="' . $td_unique_id . '" href="' . get_category_link($category_id) . '">All</a></li>';
                }
                foreach ($td_subcategories as $td_category) {
                    if (empty($sub_cat_ajax)) {
                        $buffy .= '<li><a class="ajax-sub-cat sub-cat-' . $td_unique_id . '" id="sub-cat-' . $td_unique_id . '-' . $td_category->cat_ID . '" data-cat_id="' . $td_category->cat_ID . '" data-td_block_id="' . $td_unique_id . '" href="' . get_category_link($td_category->cat_ID) . '">' . $td_category->name . '</a></li>';
                    } else {
                        $buffy .= '<li><a href="' . get_category_link($td_category->cat_ID) . '">' . $td_category->name . '</a></li>';
                    }

                }


                $buffy .= '</ul>';
            }
        }

        return $buffy;
    }


    static function get_block_js ($atts, $td_unique_id = '', &$td_query, $block_type) {
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
                'sub_cat_ajax' => '',
                'ajax_pagination' => ''
            ),$atts));


        $td_block_layout = new td_block_layout();
        $td_column_number = $td_block_layout->get_column_number(); // get the column width of the block
        $block_item = 'block_' . $td_unique_id;

        $buffy = '';

        $buffy .= '<script>';
        $buffy .= 'var ' . $block_item . ' = new td_block();' . "\n";
        $buffy .= $block_item . '.id = "' . $td_unique_id . '";' . "\n";
        $buffy .= $block_item . ".atts = '" . json_encode($atts) . "';" . "\n";
        $buffy .= $block_item . '.td_cur_cat = "' . $category_id . '";' . "\n";
        $buffy .= $block_item . '.td_column_number = "' . $td_column_number . '";' . "\n";

        $buffy .= $block_item . '.block_type = "' . $block_type . '";' . "\n";

        //wordpress wp query parms
        $buffy .= $block_item . '.post_count = "' . $td_query->post_count . '";' . "\n";
        $buffy .= $block_item . '.found_posts = "' . $td_query->found_posts . '";' . "\n";
        $buffy .= $block_item . '.max_num_pages = "' . $td_query->max_num_pages . '";' . "\n";
        $buffy .= 'td_blocks.push(' . $block_item . ');' . "\n";
        $buffy .= '</script>';


        return $buffy;
    }




    static function get_block_pagination($atts, $td_unique_id = '') {
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
                'sub_cat_ajax' => '',
                'ajax_pagination' => ''
            ),$atts));

        $buffy = '';

        switch ($ajax_pagination) {
            case 'next_prev':
                if ($hide_title != 'hide_title') {
                    $buffy .= '<div class="td-next-prev-wrap">';
                        $buffy .= '<a href="#" class="td_ajax-prev-page ajax-page-disabled td-sp" id="prev-page-' . $td_unique_id . '" data-td_block_id="' . $td_unique_id . '"></a>';
                        $buffy .= '<a href="#"  class="td-ajax-next-page td-sp" id="next-page-' . $td_unique_id . '" data-td_block_id="' . $td_unique_id . '"></a>';
                    $buffy .= '</div>';
                }
                break;
            case 'load_more':
                $buffy .= '<div class="td-load-more-wrap">';
                    $buffy .= '<a href="#" class="td_ajax_load_more" id="next-page-' . $td_unique_id . '" data-td_block_id="' . $td_unique_id . '">' . __td('Load more') . '</a>';
                    $buffy .= '<div class="td-load-more-img-wrap">';
                        $buffy .= '<div class="td-load-more-img td-sp"></div>';
                    $buffy .= '</div>';
                $buffy .= '</div>';
                break;
            case 'infinite':

                    $buffy .= '<div class="td_ajax_infinite" id="next-page-' . $td_unique_id . '" data-td_block_id="' . $td_unique_id . '">';
                        $buffy .= ' ';
                    $buffy .= '</div>';

                break;

        }





        return $buffy;
    }



}


?>
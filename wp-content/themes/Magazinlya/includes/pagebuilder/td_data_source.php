<?php
class td_data_source {
    var $block_name; //used by block title
    var $block_link;


    function td_data_source() {
        $this->block_name = '';
        $this->block_link = '';
    }

    //$paged is used by ajax
    function &get_wp_query ($atts = '', $paged = '') { //by ref
        extract(shortcode_atts(
                array(
                    'category_ids' => '',
                    'tag_slug' => '',
                    'sort' => '',
                    'limit' => 5
                ),
                $atts
            )
        );


        $args = array(
            'showposts' => $limit,
            'ignore_sticky_posts' => 1

        );


        if (!empty($paged)) {
            $args['paged'] = $paged;
        } else {
            $args['paged'] = 1;
        }

        if (!empty($category_ids)) {
            $args['cat'] = $category_ids;
        }

        if (!empty($category_ids)) {
            //@todo fix this / make this faster
            $cat_id_array = explode (',', $category_ids);
            foreach ($cat_id_array as &$cat_id) {
                $cat_id = trim($cat_id);
                //get the category object
                $td_tmp_cat_obj =  get_category($cat_id);
                if (empty($this->block_name)) {
                    //print_r($td_tmp_cat_obj);
                    if (!empty($td_tmp_cat_obj)) {
                        //due to import sometimes the cat object may be empty
                        $this->block_link = get_category_link($td_tmp_cat_obj->cat_ID);
                        $this->block_name = mb_strtoupper($td_tmp_cat_obj->name);
                    }
                } else {
                    $this->block_name = $this->block_name . ' - ' . mb_strtoupper($td_tmp_cat_obj->name);
                }
                unset($td_tmp_cat_obj);
            }
        }


        if (!empty($tag_slug)) {
            $args['tag'] = $tag_slug;
        }

        switch ($sort) {
            case 'featured':
                if (!empty($category_ids)) {
                    //for each category, get the object and compose the slug
                    $cat_id_array = explode (',', $category_ids);

                    foreach ($cat_id_array as &$cat_id) {
                        $cat_id = trim($cat_id);

                        //get the category object
                        $td_tmp_cat_obj =  get_category($cat_id);

                        //make the $args
                        if (empty($args['category_name'])) {
                            $args['category_name'] = $td_tmp_cat_obj->slug; //get by slug (we get the children categories too)
                        } else {
                            $args['category_name'] .= ',' . $td_tmp_cat_obj->slug; //get by slug (we get the children categories too)
                        }
                        unset($td_tmp_cat_obj);
                    }
                }

                $args['cat'] = get_cat_ID(TD_FEATURED_CAT); //add the fetured cat
                break;
            case 'popular':
                $args['meta_key'] = 'post_views_count';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';

                break;
        }

        //print_r($args);

        //only show published posts
        $args['post_status'] = 'publish';

        $td_query = new WP_Query($args);
        wp_reset_query();
        return $td_query;
    }
}


?>
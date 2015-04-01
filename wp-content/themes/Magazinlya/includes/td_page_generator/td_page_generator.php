<?php


class td_page_generator {




    //this is the global page wrap, it prepares the page for the pagebuilder
    static function wrap_start() {
        $buffy = '';

        $buffy .= '
        <div class="container td-page-wrap">
            <div class="row">
                <div class="span12">
                    <div class="td-grid-wrap">
                        <div class="container-fluid">
                            <div class="row-fluid ">
        ';
        return $buffy;
    }

    //page builder wrap end
    static function wrap_end() {
        $buffy = '';
        $buffy .= '
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
        return $buffy;
    }


    static function get_pagination() {
        if (is_singular()) {
            return; //no pagination on single pages
        }

        if (td_global::$is_404) {
            return;
        }




        $buffy = '';
        $buffy .= '<div class="pagination">';

        $td_back_arrow = get_template_directory_uri() . '/images/icons/blog-arrow-left.png';
        $td_next_arrow = get_template_directory_uri() . '/images/icons/blog-arrow-right.png';


        $prevLink = get_previous_posts_link();
        if (!empty($prevLink)) {
            $buffy .= get_previous_posts_link('<img class="td-retina" width="38" src="' . $td_back_arrow . '" alt=""/>');
        } else {
            $buffy .= '<img class="pagination-disabled td-retina" width="38" src="' . $td_back_arrow . '" alt=""/>';
        }

        $nextLink = get_next_posts_link();
        if (!empty($nextLink)) {
            $buffy .= get_next_posts_link('<img class="td-retina" width="38" src="' . $td_next_arrow . '" alt=""/>');
        } else {
            $buffy .= '<img class="pagination-disabled td-retina" width="38" src="' . $td_next_arrow . '" alt=""/>';
        }

        $buffy .= '</div>';
        return $buffy;
    }


    static function no_posts() {
        $buffy = '';
        $buffy .= '<div class="no-results">';
        if (is_search()) {
            $buffy .= '<h2>' . __td('No results for your search', TD_THEME_NAME) . '</h2>';
        } else {
            $buffy .= '<h2>' . __td('No posts to display', TD_THEME_NAME) . '</h2>';
        }
        $buffy .= '</div>';
        return $buffy;
    }


    static function update_page_views($postID) {

        if (is_single()) {
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }

    static function get_page_views($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count;
    }


}
?>
<?php


//here we store the global state

class td_global {

    public static $post = '';
    public static $primary_category = '';

    public static $main_page_id = '';

    public static $is_404 = false; //used by the 404 page + pagination due to some bug in wp

    //public static $css_buffer = '';
    //public static $js_buffer = '';

    static function load_post($post) {
        if (is_single()) {
            self::$post = $post;


            /*  ----------------------------------------------------------------------------
                update the primary category
             */

            //read the post setting
            $td_post_theme_settings = get_post_meta(self::$post->ID, 'td_post_theme_settings', true);
            if (!empty($td_post_theme_settings['td_primary_cat'])) {
                self::$primary_category = $td_post_theme_settings['td_primary_cat'];
                return;
            }

            $categories = get_the_category(self::$post->ID);
            foreach($categories as $category) {
                if ($category->name != TD_FEATURED_CAT) { //ignore the featured category name
                    self::$primary_category = $category->cat_ID;
                    break;
                }
            }
        }
    }

    static function load_main_page_id($main_page_id) {
        self::$main_page_id = $main_page_id;
    }


    static function get_main_page_id() {
        return self::$main_page_id;
    }

    static function get_primary_category_id() {

        if (empty(self::$post->ID)) {
            return get_queried_object_id();
        }
        return self::$primary_category;
    }
}




?>
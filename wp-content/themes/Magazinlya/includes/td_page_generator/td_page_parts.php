<?php


/*
 * extends includes/pagebuilder/td_module_parts.php
 */
class td_page_parts extends td_module_parts {

    var $td_post_theme_settings;

    var $is_single; //true if we are on a single page



    function __construct($post = '') {
        // construct the class without the post object, used in the author template for the box
        if (empty($post)) {
            return;
        }

        parent::__construct($post);

        //read post settings
        $this->td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);

        $this->is_single = is_single();
    }



    function get_bread_crumbs() {
        if (!$this->is_single) {
            return;
        }

        if (td_get_option('tds_breadcrumbs_show') == 'hide') {
            return;
        }

        $category_1_name = '';
        $category_1_url = '';
        $category_2_name = '';
        $category_2_url = '';

        $primary_category_id = td_global::get_primary_category_id();
        $primary_category_obj = get_category($primary_category_id);

        //print_r($primary_category_obj);
        if (!empty($primary_category_obj)) {
            $category_1_name = $primary_category_obj->name;
            $category_1_url = get_category_link($primary_category_obj->cat_ID);


            if ($primary_category_obj->parent != 0) {
                $parent_category_obj = get_category($primary_category_obj->parent);
                if (!empty($parent_category_obj)) {
                    $category_2_name = $parent_category_obj->name;
                    $category_2_url = get_category_link($parent_category_obj->cat_ID);
                }
            }
        }

        //echo $primary_category_id;

        $td_separator = ' <span class="td-sp td-sp-breadcrumb-arrow td-bread-sep"></span> ';

        $buffy = '';
        if (!empty($category_1_name)) {
            $buffy .= '<div itemscope="" itemtype="http://schema.org/WebPage" class="entry-crumbs">';

                //home
                if (td_get_option('tds_breadcrumbs_show_home') != 'hide') {
                    $buffy .=  '<a class="entry-crumb" itemprop="breadcrumb" href="' . get_home_url() . '">Home</a>';
                }

                //parent category
                if (!empty($category_2_name) and td_get_option('tds_breadcrumbs_show_parent') != 'hide' ) {
                    if (td_get_option('tds_breadcrumbs_show_home') != 'hide') {
                        $buffy .=  $td_separator;
                    }

                    $buffy .= '<a class="entry-crumb" itemprop="breadcrumb" href="' . $category_2_url . '" title="' . __td('View all posts in') . ' ' . htmlspecialchars($category_2_name) . '">' . $category_2_name . '</a>';

                    $buffy .=  $td_separator;
                } else {
                    if (td_get_option('tds_breadcrumbs_show_home') != 'hide') {
                        $buffy .=  $td_separator;
                    }
                }


                $buffy .= '<a class="entry-crumb" itemprop="breadcrumb" href="' . $category_1_url . '" title="' . __td('View all posts in') . ' ' . htmlspecialchars($category_1_name) . '">' . $category_1_name . '</a>';

                //article title
                if (td_get_option('tds_breadcrumbs_show_article') != 'hide') {
                    $buffy .=  $td_separator;
                    $buffy .=  '<span>' . td_excerpt($this->title, 13) . '</span>';
                }
            $buffy .= '</div>';
        }

        return $buffy;

    }

    function get_title($excerpt_lenght = '') {
        //just use h1 instead of h3
        $buffy = '';
        $buffy .= '<h1 itemprop="name" class="entry-title">';
        $buffy .='<a itemprop="url" href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';
        $buffy .= $this->title;
        $buffy .='</a>';
        $buffy .= '</h1>';
        return $buffy;
    }


    function get_author() {
        $buffy = '';
        $buffy .='<div class="td-clear-author"></div>';
        $buffy .= parent::get_author(false);
        return $buffy;
    }


    function get_image($thumbType) {
        if (td_get_option('tds_show_featured_image') == 'hide' and get_post_format($this->post->ID) != 'video') {
            return;
        }

        if (get_post_format($this->post->ID) == 'gallery') {
            return;
        }

        if (get_post_format($this->post->ID) == 'video') {
            //if it's a video post...
            $td_post_video = get_post_meta($this->post->ID, 'td_post_video', true);
            $td_video_support = new td_video_support();
            if (!empty($td_post_video['td_video'])) {
                return $td_video_support->renderVideo($td_post_video['td_video']);
            }
        } else {
            //if it's a normal post, show the default thumb

            //get the full url
            $attachment_id = get_post_thumbnail_id($this->post->ID);
            $td_temp_image_url = wp_get_attachment_image_src($attachment_id, 'full');


            if (!empty($td_temp_image_url[0])) { //if we have a full url, link the image to that
                return parent::get_image($thumbType, $td_temp_image_url[0]);
            } else {
                return parent::get_image($thumbType);
            }


        }
    }


    function get_category() {

        $buffy = '';

        $buffy .= '<ul class="td-category">';
        $categories = get_the_category($this->post->ID);
        $cat_array = array();

        if($categories){
            foreach($categories as $category) {
                if ($category->name != TD_FEATURED_CAT) { //ignore the featured category name
                    //get the parent of this cat
                    $td_parent_cat_obj = get_category($category->category_parent);

                    //if we have a parent, shot it first
                    if (!empty($td_parent_cat_obj->name)) {
                        $tax_meta__color_parent = get_tax_meta($td_parent_cat_obj->cat_ID,'tdc_color');
                        $cat_array[$td_parent_cat_obj->name] = array(
                            'color' => $tax_meta__color_parent,
                            'link' => get_category_link($td_parent_cat_obj->cat_ID)
                        );
                    }

                    //show the category, only if we didn't already showed the parent
                    $tax_meta_color = get_tax_meta($category->cat_ID,'tdc_color');
                    $cat_array[$category->name] = array(
                        'color' => $tax_meta_color,
                        'link' => get_category_link($category->cat_ID)
                    );
                }
            }
        }

        foreach ($cat_array as $td_cat_name => $td_cat_parms) {
            if (!empty($td_cat_parms['color'])) {
                $td_cat_color = ' style="color:' . $td_cat_parms['color'] . ';"';
            } else {
                $td_cat_color = '';
            }


            $buffy .= '<li class="entry-category"><span ' . $td_cat_color . '>■</span><a href="' . $td_cat_parms['link'] . '">' . $td_cat_name . '</a></li>';
        }
        $buffy .=  '</ul>';

        return $buffy;
    }






    function get_item_scope_meta() {
        $buffy = '';

        if (td_review::has_review($this->td_review)) {
            $td_article_date_unix = get_the_time('U', $this->post->ID);

            if (!empty($this->td_review['review'])) {
                $buffy .= '<meta itemprop="about" content = "' . $this->td_review['review'] . '">';
            } else {
                //we have no review :|
                $buffy .= '<meta itemprop="about" content = "' . $this->get_excerpt(25) . '">';
            }

            $buffy .= '<meta itemprop="datePublished" content="' . date(DATE_W3C, $td_article_date_unix) . '">';
            $buffy .= '<span class="td-page-meta" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">';
            $buffy .= '<meta itemprop="worstRating" content = "1">';
            $buffy .= '<meta itemprop="bestRating" content = "5">';
            $buffy .= '<meta itemprop="ratingValue" content = "' . td_review::calculate_total_stars($this->td_review) . '">';
            $buffy .= ' </span>';
        }
        return $buffy;
    }


    function get_content($show_excerpt = false) {

        //show excerpt instead of content in the loop :|
        if ($show_excerpt and !is_singular()) {
            $td_excerpt_content = get_the_excerpt();
            $td_excerpt_content = '<p>' . $td_excerpt_content . '</p>';
            $td_excerpt_content .= '<div class="more-link-wrap wpb_button wpb_btn-danger clearfix">';
            $td_excerpt_content .= '<a href="' . $this->href . '">' . __td('Continue', TD_THEME_NAME) . '</a>';
            $td_excerpt_content .= '</div>';
            return $td_excerpt_content;
        }


        $content = get_the_content(__td('Continue', TD_THEME_NAME));
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);


        $tds_inline_ad = td_get_option('tds_inline_ad');
        $tds_inline_ad_spot = td_get_option('tds_inline_ad_spot');



        if (!empty($tds_inline_ad_spot)) {


            $tds_inline_ad_paragraph = td_get_option('tds_inline_ad_paragraph');
            if (empty($tds_inline_ad_paragraph)) {
                $tds_inline_ad_paragraph = 0;
            }

            $cnt = 0;
            $content_buffer = '';
            $content_parts = explode('<p>', $content);
            foreach ($content_parts as $content_part) {
                if (!empty($content_part)) {
                    if ($tds_inline_ad_paragraph == $cnt) {
                        //show ad
                        //echo 'rarara';

                        if (!empty($tds_inline_ad))       {
                            $content_buffer .= td_ad_box(array(
                                'spot_name' => td_get_option('tds_inline_ad_spot'),
                                'align_left' => 'left'
                            ));
                        } else {
                            $content_buffer .= td_ad_box(array(
                                'spot_name' => td_get_option('tds_inline_ad_spot')
                            ));
                        }


                    }
                    $content_buffer .= '<p>' . $content_part;
                    $cnt++;
                }

            }

            $content = $content_buffer;
        }



        return $content;
    }


/*  ----------------------------------------------------------------------------
    Single page
 */
    function get_review() {
        if (!$this->is_single) {
            return;
        }

        if (td_review::has_review($this->td_review)) {
            //print_r($this->td_review);
            $buffy = '';
            $buffy .= td_review::render_table($this->td_review);



            return $buffy;
        }
    }

    function get_source_and_via() {
        if (!$this->is_single) {
            return;
        }


        $buffy ='';
        $buffy .= '<div class="clearfix"></div>';

        //via and source
        if (!empty($this->td_post_theme_settings['td_source']) or !empty($this->td_post_theme_settings['td_via'])) {
            $buffy .= '<div class="post-source-via">';
            if (!empty($this->td_post_theme_settings['td_source'])) {
                $buffy .= '<div class="post-source">' . __td('source') . ': <a rel="nofollow" href="' . $this->td_post_theme_settings['td_source_url'] . '">' . $this->td_post_theme_settings['td_source'] . '</a></div>';
            }

            if (!empty($this->td_post_theme_settings['td_via'])) {
                $buffy .= '<div class="post-via">' . __td('via') . ': <a rel="nofollow" href="' . $this->td_post_theme_settings['td_via_url'] . '">' . $this->td_post_theme_settings['td_via'] . '</a></div>';
            }
            $buffy .= '</div>';
        }


        return $buffy;
    }


    function get_the_tags() {
        if (!$this->is_single) {
            return;
        }

        if (td_get_option('tds_show_tags') == 'hide') {
            return;
        }


        $buffy = '';

        $td_post_tags = get_the_tags();
        if ($td_post_tags) {
            $buffy .= '<ul class="td-tags clearfix">';
            foreach ($td_post_tags as $tag) {
                $buffy .=  '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
            }
            $buffy .= '</ul>';
        }

        return $buffy;
    }

    function get_next_prev_posts() {
        if (!$this->is_single) {
            return;
        }

        if (td_get_option('tds_show_next_prev') == 'hide') {
            return;
        }

        $buffy = '';

        $next_post = get_next_post();
        $prev_post = get_previous_post();

        if (!empty($next_post) or !empty($prev_post)) {
            $buffy .= '<div class="wpb_row row-fluid next-prev">';
                if (!empty($prev_post)) {
                    $buffy .= '<div class="span6 prev-post">';
                        $buffy .= '<div><img width="5" class="td_retina" src="' . get_template_directory_uri()  . '/images/icons/similar-left.png" alt=""/>' . __td('Previous article', TD_THEME_NAME) . '</div>';
                        $buffy .= '<a href="' . get_permalink($prev_post->ID) . '">' . $prev_post->post_title . '</a>';
                    $buffy .= '</div>';
                } else {
                    $buffy .= '<div class="span6 prev-post">';
                    $buffy .= '</div>';
                }

                if (!empty($next_post)) {
                    $buffy .= '<div class="span6 next-post">';
                        $buffy .= '<div>' . __td('Next article', TD_THEME_NAME) . '<img width="5" class="td_retina" src="' . get_template_directory_uri()  . '/images/icons/similar-right.png" alt=""/></div>';
                        $buffy .= '<a href="' . get_permalink($next_post->ID) . '">' . $next_post->post_title . '</a>';
                    $buffy .= '</div>';
                }
            $buffy .= '</div>'; //end fluid row
        }

        return $buffy;
    }

    function get_author_box($author_id = '') {

        if (!$this->is_single and !is_author()) {
            return;
        }

        if (td_get_option('tds_show_author_box') == 'hide') {
            return;
        }

        if (empty($author_id)) {
            $author_id = $this->post->post_author;
        }


        $buffy = '';

        $authorDescription = get_the_author_meta('description');
        $hideAuthor = td_get_option('hide_author');

        if (!empty($authorDescription) and empty($hideAuthor)) {

            $buffy .= '<div class="author-box-wrap">';
                $buffy .= '<h5 class="h5-caps-title">' . __td('Author') . '</h5>';
                $buffy .= get_avatar(get_the_author_meta('email', $author_id), '106');
                $buffy .= '<div class="desc">';
                    $buffy .= '<div>';
                        $buffy .= '<a itemprop="author" href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>' ;
                    $buffy .= '</div>';



                    $buffy .= '<div>';
                    $buffy .=  get_the_author_meta('description', $author_id);
                    $buffy .= '</div>';


                    $buffy .= '<div class="td-author-social">';
                        foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                            //echo get_the_author_meta($td_social_id) . '<br>';
                            $authorMeta = get_the_author_meta($td_social_id);
                            if (!empty($authorMeta)) {
                                $buffy .= td_social_icons::get_icon($authorMeta, $td_social_id, 4, 16);
                            }
                        }
                    $buffy .= '</div>';

                    //do not show more articles by this author on author pages
                    if (!is_author()) {
                        $buffy .= '<div class="more-articles">';
                            $buffy .=  '<a href="' . get_author_posts_url($author_id) . '">' . __td('More articles from author', TD_THEME_NAME) . '</a>';
                        $buffy .= '</div>';
                    }

                    $buffy .= '<div class="clearfix"></div>';

                $buffy .= '</div>';
            $buffy .= '</div>';
        }


        return $buffy;
    }


    function related_posts() {
        global $post; //this is used by the loop down

        if (!$this->is_single) {
            return;
        }


        if (td_get_option('tds_similar_articles') == 'hide') {
            return;
        }

        if (td_get_option('tds_similar_articles_count') == '') {
            $tds_similar_articles_count = 2;
        } else {
            $tds_similar_articles_count = td_get_option('tds_similar_articles_count');
        }



        $buffy = '';
        $buffy .= '<div class="art-img-text-down similar-articles">';


        switch (td_get_option('tds_similar_articles_type')) {

            //by tag
            case 'by_tag':
                $tags = wp_get_post_tags($this->post->ID);
                if ($tags) {
                    $taglist = array();
                    for ($i = 0; $i <= 4; $i++) {
                        if (!empty($tags[$i])) {
                            $taglist[] = $tags[$i]->term_id;
                        } else {
                            break;
                        }
                    }
                    $args = array(
                        'tag__in' => $taglist,
                        'post__not_in' => array($this->post->ID),
                        'showposts' => $tds_similar_articles_count,
                        'ignore_sticky_posts' => 1
                    );
                }
                break;


            //by title
            case 'by_auth':
                $args = array(
                    'author' => $this->post->post_author,
                    'post__not_in' => array($this->post->ID),
                    'showposts' => $tds_similar_articles_count,
                    'ignore_sticky_posts' => 1
                );
                break;


            //by category
            default:
                $args = array(
                    'category__in' => wp_get_post_categories($this->post->ID),
                    'post__not_in' => array($this->post->ID),
                    'showposts' => $tds_similar_articles_count,
                    'ignore_sticky_posts' => 1
                );
                break;
        }




        //do the query
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            $buffy .= '<h5>' . __td('Similar articles') . '</h5>';

            $td_template_layout = new td_template_layout();

            $td_template_layout->set_columns(2);

            while ($my_query->have_posts()) : $my_query->the_post();

                $buffy .= $td_template_layout->layout_open_element();
                $buffy .= td_modules::mod6_render($post);
                $buffy .=  $td_template_layout->layout_close_element();

                $td_template_layout->layout_next();
            endwhile;

            $buffy .= $td_template_layout->close_all_tags();
        }
        wp_reset_query();



        $buffy .= '</div>';

        return $buffy;
    }




}
?>
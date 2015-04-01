<?php
class td_module_parts {
    var $post;

    var $title_attribute;
    var $title;
    var $href;


    var $td_review; //review meta


    //constructor
    function td_module_parts($post) {
        $this->post = $post;

        $this->title = get_the_title($post->ID);
        $this->title_attribute = esc_attr(strip_tags($this->title));
        $this->href = get_permalink($post->ID);

        if (has_post_thumbnail($this->post->ID)) {
            $this->post_has_thumb = true;
        } else {
            $this->post_has_thumb = false;
        }

        //get the review metadata
        $this->td_review = get_post_meta($this->post->ID, 'td_review', true);
    }



    function get_item_scope() {
        if (td_review::has_review($this->td_review)) {
            //return 'itemprop="review" itemscope itemtype="http://schema.org/Review"';
            return 'itemscope itemtype="http://schema.org/Review"';
        } else {
            return 'itemscope itemtype="http://schema.org/Article"';
        }
    }

    function get_item_scope_meta() {
        $buffy = ''; //the vampire slayer

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

    function get_no_thumb_class() {
        return td_util::if_not_show($this->post_has_thumb, 'td_mod_no_thumb');
    }



    function get_category() {
        $buffy = '';

        $buffy .= '<div class="entry-category">';

        //read the post meta to get the custom primary category
        $td_post_theme_settings = get_post_meta($this->post->ID, 'td_post_theme_settings', true);
        if (!empty($td_post_theme_settings['td_primary_cat'])) {
            //we have a custom category selected
            $selected_category_obj = get_category($td_post_theme_settings['td_primary_cat']);
        } else {
            //get one auto
            $categories = get_the_category($this->post->ID);
            if (!empty($categories[0])) {
                if ($categories[0]->name === TD_FEATURED_CAT and !empty($categories[1])) {
                    $selected_category_obj = $categories[1];
                } else {
                    $selected_category_obj = $categories[0];
                }
            }
        }


            if (!empty($selected_category_obj)) { //@todo catch error here
                $tdc_color = get_tax_meta($selected_category_obj->cat_ID, 'tdc_color');
                if (!empty($tdc_color)) {
                    $tdc_color = ' style="color:' . $tdc_color . ';"';
                }
                $buffy .= '<span ' . $tdc_color . '>■</span>' . '<a href="' . get_category_link($selected_category_obj->cat_ID) . '">'  . $selected_category_obj->name . '</a>' ;
            }


        $buffy .= '</div>';

        //return print_r($post, true);
        return $buffy;
    }

    function get_author($show_stars_on_review = true) {
        $buffy = '';
        if (td_review::has_review($this->td_review) and $show_stars_on_review === true) {
            $buffy .= '<div class="entry-review-stars">';
            $buffy .=  td_review::render_stars($this->td_review);
            $buffy .= '</div>';
        } else {
            $td_article_date_unix = get_the_time('U', $this->post->ID);


            $buffy .= '<div class="entry-author-date author">';
            $buffy .= '<span>';
                $buffy .= __td('by', TD_THEME_NAME);
                $buffy .= ' ';
                $buffy .= '<a itemprop="author" href="' . get_author_posts_url($this->post->post_author) . '">' . get_the_author_meta('display_name', $this->post->post_author) . '</a>' ;
                $buffy .= ' - ';
            $buffy .= '</span>';
                $buffy .= '<time  itemprop="dateCreated" class="entry-date updated" datetime="' . date(DATE_W3C, $td_article_date_unix) . '" >' . get_the_time(get_option('date_format'), $this->post->ID) . '</time>';


            $buffy .= '</div>';
            $buffy .= '<meta itemprop="interactionCount" content="UserComments:' . get_comments_number($this->post->ID) . '"/>';
            //$buffy .= '<meta itemprop="dateCreated" content="' . get_the_time(get_option('date_format'), $this->post->ID) . '"/>';
        }
        return $buffy;
    }

    function get_commentsAndViews() {
        $buffy = '';

        $buffy .= '<div class="entry-comments-views">';
        $buffy .= '<span class="td-comments-counter">';
            $buffy .= '<span class="td-sp td-sp-ico-comments"></span>';
            $buffy .= get_comments_number($this->post->ID);
        $buffy .= '</span>';

        $buffy .= ' ';
        $buffy .= '<span class="td-view-counter">';
            $buffy .= '<span class="td-sp td-sp-ico-view"></span>';
            $buffy .= td_page_generator::get_page_views($this->post->ID);
        $buffy .= '</span>';

        $buffy .= '</div>';

        return $buffy;
    }

    function get_image($thumbType, $image_link = '') {
        $buffy = ''; //the output buffer


        $show_colorbox_class = false;
        if ($this->post_has_thumb) {

            if ($image_link == '') {
                $image_link = $this->href;

            } else {
                //we are in post, only posts use $image_link
                if (td_get_option('tds_featured_image_view_setting') == '') {
                    $show_colorbox_class = true;
                }

                if (td_get_option('tds_featured_image_view_setting') == 'no_link') {
                    $image_link = '#'; //remove the link if we have that option
                }
            }



            $attachment_id = get_post_thumbnail_id($this->post->ID);
            $td_temp_image_url = wp_get_attachment_image_src($attachment_id, $thumbType);


            $attachment_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true );
            $attachment_alt = 'alt="' . esc_attr(strip_tags($attachment_alt)) . '"';

            $attachment_raw = get_post($attachment_id);
            $attachment_title = $attachment_raw->post_title;
            if (!empty($attachment_title)) {
                $attachment_title = ' title="' . esc_attr(strip_tags($attachment_title)) . '"';
            }


            if (empty($td_temp_image_url[1])) {
                $td_temp_image_url[1] = '';
            }

            if (empty($td_temp_image_url[2])) {
                $td_temp_image_url[2] = '';
            }


            $buffy .= '<div class="thumb-wrap">';
            $buffy .='<a ' . td_util::if_show($show_colorbox_class, 'class="td-featured-img"') . ' href="' . $image_link . '" rel="bookmark" title="' . $this->title_attribute . '">';
            $buffy .= '<img width="' . $td_temp_image_url[1] . '" height="' . $td_temp_image_url[2] . '" itemprop="image" class="entry-thumb" src="' . $td_temp_image_url[0] . '" ' . $attachment_alt . $attachment_title . '/>';

            if (get_post_format($this->post->ID) == 'video') {
                if ($thumbType == 'art-thumb') {
                    $buffy .= '<img width="20" class="video-play-icon td-retina" src="' . get_template_directory_uri() . '/images/icons/video-small.png' . '" alt="video"/>';
                } else {
                    $buffy .= '<img width="40" class="video-play-icon-big td-retina" src="' . get_template_directory_uri() . '/images/icons/ico-video-large.png' . '" alt="video"/>';
                }
            }

            $buffy .= '</a>';
            $buffy .= '</div>';

            return $buffy;
        }
    }

    function get_title($excerpt_lenght = '') {
        $buffy = '';
        $buffy .= '<h3 itemprop="name" class="entry-title">';
        $buffy .='<a itemprop="url" href="' . $this->href . '" rel="bookmark" title="' . $this->title_attribute . '">';
        if (!empty($excerpt_lenght)) {
            $buffy .= td_excerpt($this->title, $excerpt_lenght, 'show_shortcodes');
        } else {
            $buffy .= $this->title;
        }
        $buffy .='</a>';
        $buffy .= '</h3>';
        return $buffy;
    }


    function get_excerpt($lenght = 25, $show_shortcodes = '') {
        if (empty($lenght)) {
            $lenght = 25;
        }

        $buffy = '';
        //print_r($this->post);
        $buffy .= td_excerpt($this->post->post_content, $lenght, $show_shortcodes);
        return $buffy;
    }
}

?>
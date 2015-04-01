<?php


class td_modules {

    //big picture + text down - used in block 1
    static function mod2_render($post) {
        $td_module_builder = new td_module_parts($post);

        $buffy = '';
        $buffy .= '<div class="td_mod2 td_mod_wrap" ' . $td_module_builder->get_item_scope() . '>';
            $buffy .= $td_module_builder->get_image('art-big-1col');
            $buffy .= '<div class="meta-info">';
                $buffy .= $td_module_builder->get_category();
                $buffy .= $td_module_builder->get_commentsAndViews();
            $buffy .= '</div>';
            $buffy .= $td_module_builder->get_title(td_get_option('tds_mod2_title_excerpt'));
            $buffy .= $td_module_builder->get_author();
            $buffy .= $td_module_builder->get_excerpt(td_get_option('tds_mod_content_excerpt'));

            $buffy .= $td_module_builder->get_item_scope_meta();
        $buffy .= '</div>';
        return $buffy;
    }

    //small thumb + text - used in block 1 + many others
    static function mod3_render($post) {
        $td_module_builder = new td_module_parts($post);

        $buffy = '';
        $buffy .= '<div class="td_mod3 td_mod_wrap' . $td_module_builder->get_no_thumb_class() . '" ' . $td_module_builder->get_item_scope() . '>';
            $buffy .= $td_module_builder->get_image('art-thumb');
            $buffy .= '<div class="item-details">';
                $buffy .= $td_module_builder->get_title(td_get_option('tds_mod3_title_excerpt'));
                $buffy .= $td_module_builder->get_author();
                $buffy .= $td_module_builder->get_category();
            $buffy .= '</div>';
            $buffy .= $td_module_builder->get_item_scope_meta();
        $buffy .= '</div>';

        return $buffy;
    }

    //small thumb + text - used in block 1 + many others
    static function mod4_render($post) {
        $td_module_builder = new td_module_parts($post);

        $buffy = '';
        $buffy .= '<div class="td_mod4 td_mod_wrap' . $td_module_builder->get_no_thumb_class() . '" ' . $td_module_builder->get_item_scope() . '>';
        $buffy .= $td_module_builder->get_image('art-thumb');
        $buffy .= '<div class="item-details">';
        $buffy .= $td_module_builder->get_title(td_get_option('tds_mod4_title_excerpt'));
        $buffy .= $td_module_builder->get_author();
        $buffy .= $td_module_builder->get_category();
        $buffy .= '</div>';
        $buffy .= $td_module_builder->get_item_scope_meta();
        $buffy .= '</div>';

        return $buffy;
    }



    //big picture + text down - used in block 2
    static function mod5_render($post) {
        $td_module_builder = new td_module_parts($post);
        $buffy = '';
        $buffy .= '<div class="td_mod5 td_mod_wrap" ' . $td_module_builder->get_item_scope() . '>';
        $buffy .= $td_module_builder->get_image('art-big-2col');
        $buffy .= '<div class="meta-info">';
        $buffy .= $td_module_builder->get_category();
        $buffy .= $td_module_builder->get_commentsAndViews();
        $buffy .= '</div>';
        $buffy .= $td_module_builder->get_title(td_get_option('tds_mod5_title_excerpt'));
        $buffy .= $td_module_builder->get_author();
        $buffy .= $td_module_builder->get_excerpt(td_get_option('tds_mod_content_excerpt'));

        $buffy .= $td_module_builder->get_item_scope_meta();
        $buffy .= '</div>';
        return $buffy;
    }


    //small height picture + text down, used in sidebar
    static function mod6_render($post) {
        $td_module_builder = new td_module_parts($post);
        $buffy = '';
        $buffy .= '<div class="td_mod6 td_mod_wrap" ' . $td_module_builder->get_item_scope() . '>';
        $buffy .= $td_module_builder->get_image('side');
        $buffy .= '<div class="meta-info">';
        $buffy .= $td_module_builder->get_category();
        $buffy .= $td_module_builder->get_commentsAndViews();
        $buffy .= '</div>';
        $buffy .= $td_module_builder->get_title(td_get_option('tds_mod6_title_excerpt'));
        $buffy .= $td_module_builder->get_author();
        //$buffy .= $td_module_builder->get_excerpt(25);

        $buffy .= $td_module_builder->get_item_scope_meta();
        $buffy .= '</div>';
        return $buffy;
    }


    static function mod_slide_render($post, $td_column_number, $td_post_count) {
        $td_module_builder = new td_module_parts($post);

        $buffy = '';

        $buffy .= '<div class = "item" ' . $td_module_builder->get_item_scope()  . '>';
            switch ($td_column_number) {
                case '1': //one column layout
                    $buffy .= $td_module_builder->get_image('art-slide');
                    break;
                case '2': //two column layout
                    $buffy .= $td_module_builder->get_image('art-slide-med');
                    break;
                case '3': //three column layout
                    $buffy .= $td_module_builder->get_image('art-slide-big');
                    break;
            }

            if ($td_post_count == 0) { //first post
                $slideWrapActive = ' slide-wrap-active-first';
            } else {
                $slideWrapActive = '';
            }

            $buffy .= '<div class="slide-info-wrap' . $slideWrapActive . '">';
                $buffy .= '<div class="slide-title">' . $td_module_builder->get_title() . '</div>';
                $buffy .= '<div class="slide-line"></div>';
                $buffy .= '<div class="slide-meta">';
                    $buffy .= '<div class="slide-meta-author">';
                        $buffy .= $td_module_builder->get_author();
                    $buffy .= '</div>';
                    $buffy .= '<div class="slide-meta-cat">';
                        $buffy .= $td_module_builder->get_category();
                    $buffy .= '</div>';
                $buffy .= '</div>';
                $buffy .= '</div>';
        $buffy .= '</div>';

        return $buffy;
    }



    function mod_gallery_render($post, $td_post_count) {
        $td_module_builder = new td_module_parts($post);
        $buffy = '';

        if ($td_post_count == 0) {
            $td_carousel_item_class = ' class="td_flex_first"';
        } else {
            $td_carousel_item_class = '';
        }

            if (has_post_thumbnail($post->ID)) {

                $buffy .= '<li ' . $td_carousel_item_class . ' ' . $td_module_builder->get_item_scope() . '>';
                    $buffy .= '<div class="flex-slide-wrap">';
                        $buffy .= $td_module_builder->get_image('art-gal');
                        $buffy .= '<span class="flex-caption">' . td_excerpt(get_the_title($post->ID), 6) . '</span>';
                    $buffy .= '</div>';
                $buffy .= '</li>';
            }
        return $buffy;
    }
}







?>
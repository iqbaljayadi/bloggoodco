<?php

function td_text_with_title($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'title' => '',
            'style' => '',
            'class' => ''
        ), $atts));


    $buffy = '';
    if ($class == 'category-title') {
        //text without line
        $buffy .= '<div class="td_block_wrap td_text_with_title td_text_title_style2 ' . $class . '">';
        $buffy .= '<div class="text_title_style2"><h1>' . $title . '</h1></div>';
        if (!empty($content)) {
            $buffy .= '<div class="td_block_inner">';
            $buffy .= wpb_js_remove_wpautop($content);
            $buffy .= '</div>';
        }
        $buffy .= '</div>';
        return $buffy;
    }



    if ($style == 'style_2') {
        //text without line
        $buffy .= '<div class="td_block_wrap td_text_with_title td_text_title_style2 ' . $class . '">';
            $buffy .= '<div class="text_title_style2"><span>' . $title . '</span></div>';
            if (!empty($content)) {
                $buffy .= '<div class="td_block_inner">';
                    $buffy .= wpb_js_remove_wpautop($content);
                $buffy .= '</div>';
            }
        $buffy .= '</div>';
    } elseif ($style == 'style_3') {
        $buffy .= '<div class="td_block_wrap td_text_with_title td_text_title_style3 ' . $class . '">';
        $buffy .= '<div class="text_title_style2"><span>' . $title . '</span></div>';
        if (!empty($content)) {
            $buffy .= '<div class="td_block_inner">';
            $buffy .= wpb_js_remove_wpautop($content);
            $buffy .= '</div>';
        }
        $buffy .= '</div>';
    } else {
        //normal text + line
        $buffy .= '<div class="td_block_wrap td_text_with_title ' . $class . '">';
            $buffy .= '<div class="block-title"><span>' . $title . '</span></div>';

            if (!empty($content)) {
                $buffy .= '<div class="td_block_inner">';
                    $buffy .= wpb_js_remove_wpautop($content);
                $buffy .= '</div>';
            }
        $buffy .= '</div>';
    }

    return $buffy;
}

add_shortcode('td_text_with_title', 'td_text_with_title');



wpb_map (
    array(
        "name" => __("Text with title", TD_THEME_NAME),
        "base" => "td_text_with_title",
        "class" => "",
        "controls" => "full",
        "category" => __('Content', TD_THEME_NAME),
		'icon' => 'icon-pagebuilder-title',
        "params" => array(
            array(
                "param_name" => "title",
                "type" => "textfield",
                "heading" => __("Title", TD_THEME_NAME),
                "value" => "Title text"
            ),
            array(
                "param_name" => "content",
                "type" => "textarea_html",
                "holder" => "div",
                "class" => "",
                "heading" => __("Text", TD_THEME_NAME),
                "value" => "",
                "description" => __("Enter your content.", TD_THEME_NAME)
            ),
            array(
                "param_name" => "style",
                "type" => "dropdown",
                "value" => array('- Style 1 (with line) -' => '', 'Style 2' => 'style_2', 'Style 3' => 'style_3'),
                "heading" => __("Title style:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            )
        )
    )
);
?>
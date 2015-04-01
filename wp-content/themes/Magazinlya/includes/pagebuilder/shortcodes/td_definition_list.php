<?php

function td_definition_list($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'title' => '',
            'style' => '',
            'class' => '',
            'term1' => '',
            'term1_d' => '',
            'term2' => '',
            'term2_d' => '',
            'term3' => '',
            'term3_d' => '',
            'term4' => '',
            'term4_d' => '',
            'term5' => '',
            'term5_d' => '',
            'term6' => '',
            'term6_d' => '',
            'term7' => '',
            'term7_d' => ''
        ), $atts));

    $buffy = '';


    $buffy_inner = '';
    $buffy_inner .= '<dl class="dl-horizontal">';
    if (!empty($term1)) {
        $buffy_inner .= '<dt>' . $term1 . '</dt>';
        $buffy_inner .= '<dd>' . $term1_d . '</dd>';
    }

    if (!empty($term2)) {
        $buffy_inner .= '<dt>' . $term2 . '</dt>';
        $buffy_inner .= '<dd>' . $term2_d . '</dd>';
    }

    if (!empty($term3)) {
        $buffy_inner .= '<dt>' . $term3 . '</dt>';
        $buffy_inner .= '<dd>' . $term3_d . '</dd>';
    }

    if (!empty($term4)) {
        $term4 = str_replace('-', '&nbsp;', $term4);
        $term4_d = str_replace('-', '&nbsp;', $term4_d);
        $buffy_inner .= '<dt>' . $term4 . '</dt>';
        $buffy_inner .= '<dd>' . $term4_d . '</dd>';
    }

    if (!empty($term5)) {
        $buffy_inner .= '<dt>' . $term5 . '</dt>';
        $buffy_inner .= '<dd>' . $term5_d . '</dd>';
    }

    if (!empty($term6)) {
        $buffy_inner .= '<dt>' . $term6 . '</dt>';
        $buffy_inner .= '<dd>' . $term6_d . '</dd>';
    }
    if (!empty($term7)) {
        $buffy_inner .= '<dt>' . $term7 . '</dt>';
        $buffy_inner .= '<dd>' . $term7_d . '</dd>';
    }

    $buffy_inner .= '</dl>';




    if ($style == 'style_2') {

        //text without line
        $buffy .= '<div class="td_block_wrap td_text_with_title td_text_title_style2 ' . $class . '">';
        $buffy .= '<div class="text_title_style2"><span>' . $title . '</span></div>';

            $buffy .= '<div class="td_block_inner">';
                $buffy .= $buffy_inner;
            $buffy .= '</div>';
        $buffy .= '</div>';
    } elseif ($style == 'style_3') {
        //page title + text
        $buffy .= '<div class="td_block_wrap td_text_with_title td_text_title_style3 ' . $class . '">';
        $buffy .= '<div class="text_title_style2"><span>' . $title . '</span></div>';

        $buffy .= '<div class="td_block_inner">';
            $buffy .= $buffy_inner;
        $buffy .= '</div>';

        $buffy .= '</div>';
    } else {
        //normal text + line
        $buffy .= '<div class="td_block_wrap td_text_with_title ' . $class . '">';
        $buffy .= '<div class="block-title"><span>' . $title . '</span></div>';

        $buffy .= '<div class="td_block_inner">';
            $buffy .= $buffy_inner;
        $buffy .= '</div>';

        $buffy .= '</div>';
    }

    return $buffy;
}

add_shortcode('td_definition_list', 'td_definition_list');



wpb_map (
    array(
        "name" => __("Definition list", TD_THEME_NAME),
        "base" => "td_definition_list",
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
                "param_name" => "style",
                "type" => "dropdown",
                "value" => array('- Style 1 (with line) -' => '', 'Style 2' => 'style_2', 'Style 3' => 'style_3'),
                "heading" => __("Title style:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term1",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 1:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term1_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 1 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term2",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 2:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term2_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 2 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term3",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 3:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term3_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 3 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term4",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 4:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term4_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 4 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term5",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 5:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term5_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 5 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term6",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 6:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term6_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 6 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term7",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 7:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            ),
            array(
                "param_name" => "term7_d",
                "type" => "textfield",
                "value" => '',
                "heading" => __("Term 7 definition:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            )
        )
    )
);
?>
<?php
function td_social( $atts ) {
    //print_r($atts);
    //die;
    extract(shortcode_atts(
        array(
            'icon_style' => '1',
            'icon_size' => '32',
            'open_in_new_window' => '',
            'custom_title' => ''
        ), $atts));


    if (empty($open_in_new_window)) {
        $open_in_new_window = false;
    } else {
        $open_in_new_window = true;
    }

    $buffy = '';

    $buffy .= '<div class="td_block_wrap td-social-wrap td-social-wrap-' . $icon_size . '">';
    if (!empty($custom_title)) {
        $buffy .= '<div class="block-title"><span>' . $custom_title . '</span></div>';
    }


        $buffy .= '<div class="td_mod_wrap">';
            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                if (!empty($atts[$td_social_id])) {
                    $buffy .= td_social_icons::get_icon($atts[$td_social_id], $td_social_id, $icon_style, $icon_size, $open_in_new_window);
                    //echo $td_social_name . ' - ' . $td_social_id;
                }
            }
        $buffy .= '</div>';
    $buffy .= '</div>';

    //print_r($atts);




    return $buffy;

}
add_shortcode('td_social', 'td_social');



$td_pb_social_fields = array();


$td_pb_social_fields[]= array(
    "param_name" => "custom_title",
    "type" => "textfield",
    "value" => "",
    "heading" => __("Optional - custom title for this block:", TD_THEME_NAME),
    "description" => "",
    "holder" => "div",
    "class" => ""
);

$td_pb_social_fields[]= array(
    "param_name" => "icon_style",
    "type" => "dropdown",
    "value" => array('- Style 1 -' => '1', 'Style 2' => '2', 'Style 3' => '3', 'Style 4' => '4'),
    "heading" => __("Icon style:", TD_THEME_NAME),
    "description" => "",
    "holder" => "div",
    "class" => ""
);

$td_pb_social_fields[]= array(
    "param_name" => "icon_size",
    "type" => "dropdown",
    "value" => array('- 32 px -' => '32', '16 px' => '16', '64 px' => '64'),
    "heading" => __("Icon size:", TD_THEME_NAME),
    "description" => "",
    "holder" => "div",
    "class" => ""
);


$td_pb_social_fields[]= array(
    "param_name" => "open_in_new_window",
    "type" => "dropdown",
    "value" => array('- Same window -' => '', 'New window' => 'y'),
    "heading" => __("Open in:", TD_THEME_NAME),
    "description" => "",
    "holder" => "div",
    "class" => ""
);



foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
    $td_pb_social_fields[]= array(
        "param_name" => $td_social_id,
        "type" => "textfield",
        "value" => "",
        "heading" => $td_social_name . ' profile URL:',
        "description" => "",
        "holder" => "div",
        "class" => ""
    );
}


wpb_map(
    array(
        "name" => __("Social icons", TD_THEME_NAME),
        "base" => "td_social",
        "class" => "",
        "controls" => "full",
        "category" => __('Social', TD_THEME_NAME),
		'icon' => 'icon-pagebuilder-social',
        "params" => $td_pb_social_fields
    )
);

?>
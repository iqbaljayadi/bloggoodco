<?php

class td_social_widget extends WP_Widget {

    var $td_widget_builder;


    function __construct() {
        $this->td_widget_builder = new td_widget_builder($this);
        $td_pb_social_fields = array();


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


        $this->td_widget_builder->td_map(
            array(
                "name" => __("Social icons", TD_THEME_NAME),
                "base" => "td_social",
                "class" => "",
                "controls" => "full",
                "category" => __('Social', TD_THEME_NAME),
                "params" => $td_pb_social_fields
            )
        );

    }

    function form($instance) {
        $currentSidebars = td_get_option('sidebars'); //read the sidebars
        $this->td_widget_builder->form($instance);
    }

    function update($new_instance, $old_instance) {
        return $this->td_widget_builder->update($new_instance, $old_instance);
    }

    function widget($args, $instance) {
        echo td_social($instance);
    }



}

add_action('widgets_init', create_function('', 'return register_widget("td_social_widget");'));

?>
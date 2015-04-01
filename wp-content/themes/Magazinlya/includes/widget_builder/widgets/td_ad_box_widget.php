<?php

class td_ad_box_widget extends WP_Widget {

    var $td_widget_builder;


    function __construct() {
        //read the adspots
        $td_ad_spots = td_get_option('td_ad_spots');



        //read the adspots
        $td_ad_spots = td_get_option('td_ad_spots');
        $td_pb_ad_spots = array();
        if (!empty($td_ad_spots)) {
            foreach ($td_ad_spots as $td_ad_spot) {
                $td_pb_ad_spots['Ad spot -- ' . $td_ad_spot['name']] = 'Ad spot -- ' . $td_ad_spot['name'];
            }
        }

        //read the google adspots
        $td_adsense_spots = td_get_option('td_adsense_spots');
        if (!empty($td_adsense_spots)) {
            foreach ($td_adsense_spots as $td_ad_spot) {
                $td_pb_ad_spots['Adsense spot -- ' . $td_ad_spot['name']] = 'Adsense spot -- ' . $td_ad_spot['name'];
            }
        }


        $this->td_widget_builder = new td_widget_builder($this);
        $this->td_widget_builder->td_map(
            array(
                "name" => __("Ad box", TD_THEME_NAME),
                "base" => "td_ad_box",
                "class" => "",
                "controls" => "full",
                "category" => __('Content', TD_THEME_NAME),
				'icon' => 'icon-pagebuilder-ads',
                "params" => array(
                    array(
                        "param_name" => "spot_name",
                        "type" => "dropdown",
                        "value" => $td_pb_ad_spots,
                        "heading" => __("Sort order:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    )
                )
            )
        );

    }

    function form($instance) {
        $this->td_widget_builder->form($instance);
    }

    function update($new_instance, $old_instance) {
        return $this->td_widget_builder->update($new_instance, $old_instance);
    }

    function widget($args, $instance) {

        echo td_ad_box($instance);
    }



}

add_action('widgets_init', create_function('', 'return register_widget("td_ad_box_widget");'));

?>
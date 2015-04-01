<?php

class td_block6_widget extends WP_Widget {

    var $td_widget_builder;


    function __construct() {
        $this->td_widget_builder = new td_widget_builder($this);
        $this->td_widget_builder->td_map(
            array(
                "name" => __("Block 6", TD_THEME_NAME),
                "base" => "td_block6",
                "class" => "td_block6",
                "controls" => "full",
                "category" => __('Blocks', TD_THEME_NAME),
                'icon' => 'icon-pagebuilder-block1',
                "params" => array(
                    array(
                        "param_name" => "category_id",
                        "type" => "dropdown",
                        "value" => td_get_category2id_array(),
                        "heading" => __("Category filter:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "category_ids",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => __("Multiple categories filter:", TD_THEME_NAME),
                        "description" => "To filter multiple categories, enter here the category IDs separated by commas (example: 13,23,18)",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "tag_slug",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => __("Filter by tag slug:", TD_THEME_NAME),
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "limit",
                        "type" => "textfield",
                        "value" => __("5", TD_THEME_NAME),
                        "heading" => __("Limit post number:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "sort",
                        "type" => "dropdown",
                        "value" => array('- Latest -' => '', 'Popular' => 'popular', 'Featured' => 'featured'),
                        "heading" => __("Sort order:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "custom_title",
                        "type" => "textfield",
                        "value" => "",
                        "heading" => __("Optional - custom title for this block:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "custom_url",
                        "type" => "textfield",
                        "value" => "",
                        "heading" => __("Optional - custom url for this block (when the module title is clicked):", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "hide_title",
                        "type" => "dropdown",
                        "value" => array('- Show title -' => '', 'Hide title' => 'hide_title'),
                        "heading" => __("Hide block title:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "show_child_cat",
                        "type" => "dropdown",
                        "value" => array('- Hide -' => '', 'Show 1 category' => '1', 'Show 2 categories' => '2', 'Show 3 categories' => '3', 'Show 4 categories' => '4', 'Show 5 categories' => '5', 'Show 6 categories' => '6', 'Show 7 categories' => '7', 'Show 8 categories' => '8', 'Show all' => 'all'),
                        "heading" => __("Show child categories menu:", TD_THEME_NAME),
                        "description" => "This will show a menu at the top of the block that contains the child categories of the selected category. It only works when you're using a single category filter form the dropdown. It doss't work with multiple categories IDs",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "sub_cat_ajax",
                        "type" => "dropdown",
                        "value" => array('- Use ajax -' => '', 'Do not use ajax' => 'n'),
                        "heading" => __("Use ajax in child categories menu:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    array(
                        "param_name" => "ajax_pagination",
                        "type" => "dropdown",
                        "value" => array('- No pagination -' => '', 'Next Prev ajax' => 'next_prev', 'Load More button' => 'load_more', 'Infinite load' => 'infinite'),
                        "heading" => __("Pagination:", TD_THEME_NAME),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    )

                )
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
        echo td_block6($instance);
    }



}

add_action('widgets_init', create_function('', 'return register_widget("td_block6_widget");'));

?>
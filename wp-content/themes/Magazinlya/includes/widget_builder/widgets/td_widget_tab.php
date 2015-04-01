<?php

class td_tab extends WP_Widget {

    var $numberOfPosts = 10;
    
    function __construct() {
        $widget_ops = array('classname' => 'td_tab_widget', 'description' => '[tagDiv] Tab widget');
        $this->WP_Widget('td_tab_widget', '[tagDiv] Tab widget', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'tab1' => '',
            'tab1_text' => '',
            'tab2'=>'',
            'tab2_text' => '',
            'tab3'=>'',
            'tab3_text' => ''
        ));

        $currentSidebars = td_get_option('sidebars'); //read the sidebars

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('tab1'); ?>"><?php _e('Tab 1 - sidebar:', TD_THEME_NAME); ?></label>
                <select name="<?php echo $this->get_field_name('tab1'); ?>" id="<?php echo $this->get_field_id('tab1'); ?>" class="widefat">
                    <option value=""<?php selected( $instance['tab1'], '' ); ?>><?php _e('No content', TD_THEME_NAME); ?></option>
                    <?php
                    foreach ($currentSidebars as $sidebar) {
                        ?>
                        <option value="<?php echo($sidebar); ?>"<?php selected( $instance['tab1'], $sidebar ); ?>>Sidebar: <?php echo($sidebar); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('tab1_text'); ?>"><?php _e('Tab 1 - caption:', TD_THEME_NAME); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab1_text'); ?>" name="<?php echo $this->get_field_name('tab1_text'); ?>" type="text" value="<?php echo $instance['tab1_text']; ?>" />
            </p>

            <br>

            <p>
                <label for="<?php echo $this->get_field_id('tab2'); ?>"><?php _e('Tab 2 - sidebar:', TD_THEME_NAME); ?></label>
                <select name="<?php echo $this->get_field_name('tab2'); ?>" id="<?php echo $this->get_field_id('tab2'); ?>" class="widefat">
                    <option value=""<?php selected( $instance['tab2'], '' ); ?>><?php _e('No content', TD_THEME_NAME); ?></option>
                    <?php
                    foreach ($currentSidebars as $sidebar) {
                        ?>
                        <option value="<?php echo($sidebar); ?>"<?php selected( $instance['tab2'], $sidebar ); ?>>Sidebar: <?php echo($sidebar); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('tab2_text'); ?>"><?php _e('Tab 2 - caption:', TD_THEME_NAME); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab2_text'); ?>" name="<?php echo $this->get_field_name('tab2_text'); ?>" type="text" value="<?php echo $instance['tab2_text']; ?>" />
            </p>

            <br>
            <p>
                <label for="<?php echo $this->get_field_id('tab3'); ?>"><?php _e('Tab 3 - sidebar:', TD_THEME_NAME); ?></label>
                <select name="<?php echo $this->get_field_name('tab3'); ?>" id="<?php echo $this->get_field_id('tab3'); ?>" class="widefat">
                    <option value=""<?php selected( $instance['tab3'], '' ); ?>><?php _e('No content', TD_THEME_NAME); ?></option>
                    <?php
                    foreach ($currentSidebars as $sidebar) {
                        ?>
                        <option value="<?php echo($sidebar); ?>"<?php selected( $instance['tab3'], $sidebar ); ?>>Sidebar: <?php echo($sidebar); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('tab3_text'); ?>"><?php _e('Tab 3 - caption:', TD_THEME_NAME); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab3_text'); ?>" name="<?php echo $this->get_field_name('tab3_text'); ?>" type="text" value="<?php echo $instance['tab3_text']; ?>" />
            </p>

        <?php
    }

    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['tab1'] = $new_instance['tab1'];
        $instance['tab2'] = $new_instance['tab2'];
        $instance['tab3'] = $new_instance['tab3'];

        $instance['tab1_text'] = $new_instance['tab1_text'];
        $instance['tab2_text'] = $new_instance['tab2_text'];
        $instance['tab3_text'] = $new_instance['tab3_text'];
        return $instance;

    }

    function widget($args, $instance) {
        $td_unique_id = uniqid();

        if (empty($instance['tab1'])) {
            $instance['tab1'] = '';
        }

        if (empty($instance['tab2'])) {
            $instance['tab2'] = '';
        }

        if (empty($instance['tab3'])) {
            $instance['tab3'] = '';
        }

        if (empty($instance['tab1_text'])) {
            $instance['tab1_text'] = $instance['tab1'];
        }

        if (empty($instance['tab2_text'])) {
            $instance['tab2_text'] = $instance['tab2'];
        }

        if (empty($instance['tab3_text'])) {
            $instance['tab3_text'] = $instance['tab3'];
        }
?>
        <div class="wpb_tabs wpb_content_element " data-interval="0">
            <div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs clearfix ui-widget ui-widget-content ui-corner-all">
                <ul class="clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <?php if (!empty($instance['tab1'])) { ?>
                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="td_tab_1_<?php echo $td_unique_id ?>" aria-selected="true">
                            <a href="#td_tab_1_<?php echo $td_unique_id ?>" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-7"><?php echo $instance['tab1_text']?></a>
                        </li>
                    <?php } ?>

                    <?php if (!empty($instance['tab2'])) { ?>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="td_tab_2_<?php echo $td_unique_id ?>" aria-selected="false">
                            <a href="#td_tab_2_<?php echo $td_unique_id ?>" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-9"><?php echo $instance['tab2_text']?></a>
                        </li>
                    <?php } ?>

                    <?php if (!empty($instance['tab3'])) { ?>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="td_tab_3_<?php echo $td_unique_id ?>" aria-selected="false">
                            <a href="#td_tab_3_<?php echo $td_unique_id ?>" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-9"><?php echo $instance['tab3_text']?></a>
                        </li>
                    <?php } ?>
                </ul>


                <div id="td_tab_1_<?php echo $td_unique_id ?>" class="wpb_tab wpb_row vc_row-fluid ui-tabs-panel wpb_ui-tabs-hide clearfix ui-widget-content ui-corner-bottom" role="tabpanel" style="display: block;" aria-expanded="true" aria-hidden="false">
                    <?php dynamic_sidebar($instance['tab1']); ?>
                </div>
                <div id="td_tab_2_<?php echo $td_unique_id ?>" class="wpb_tab wpb_row vc_row-fluid ui-tabs-panel wpb_ui-tabs-hide clearfix ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
                    <?php dynamic_sidebar($instance['tab2']); ?>
                </div>
                <div id="td_tab_3_<?php echo $td_unique_id ?>" class="wpb_tab wpb_row vc_row-fluid ui-tabs-panel wpb_ui-tabs-hide clearfix ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
                    <?php dynamic_sidebar($instance['tab3']); ?>
                </div>
            </div>
        </div>
<?php
    }
    
    

}

add_action('widgets_init', create_function('', 'return register_widget("td_tab");'));

?>
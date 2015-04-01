<?php
class td_widget_builder {

    var $WP_Widget_this;
    var $map_array;

    var $map_param_default_array;


    function __construct(&$WP_Widget_object_ref) {
        $this->WP_Widget_this = $WP_Widget_object_ref;






    }

    function td_map ($map_array) {
        //print_r($map_array);
        $this->map_array = $map_array;
        $widget_ops = array('classname' => 'td_pb_widget', 'description' => '[tagDiv] ' . $map_array['name']);
        $this->WP_Widget_this->WP_Widget($map_array['base'] . '_widget', '[tagDiv] ' . $map_array['name'], $widget_ops);

        $this->map_param_default_array = $this->build_param_default_values();
    }

    function build_param_name_value() {
        foreach ($this->map_array['params'] as $param) {
            $buffy_array[$param['param_name']] = $param['value'];
        }
        return $buffy_array;
    }

    function build_param_default_values() {
        foreach ($this->map_array['params'] as $param) {
            if ($param['type'] == 'dropdown'){
                $buffy_array[$param['param_name']] = '';
            } else {
                $buffy_array[$param['param_name']] = $param['value'];
            }

        }
        return $buffy_array;
    }


    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->map_param_default_array);

        //print_r($instance);
        foreach ($this->map_array['params'] as $param) {
            switch ($param['type']) {
                case 'textfield':
                    //print_r($param);
                    ?>
                    <p>
                        <label for="<?php echo $this->WP_Widget_this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>
                        <input class="widefat" id="<?php echo $this->WP_Widget_this->get_field_id($param['param_name']); ?>"
                               name="<?php echo $this->WP_Widget_this->get_field_name($param['param_name']); ?>" type="text"
                               value="<?php echo $instance[$param['param_name']]; ?>" />
                    </p>
                    <?php
                    break;
                case 'dropdown':


                    ?>
                    <p>
                        <label for="<?php echo $this->WP_Widget_this->get_field_id($param['param_name']); ?>"><?php echo $param['heading']; ?></label>
                        <select name="<?php echo $this->WP_Widget_this->get_field_name($param['param_name']); ?>" id="<?php echo $this->WP_Widget_this->get_field_id($param['param_name']); ?>" class="widefat">
                            <?php
                            foreach ($param['value'] as $param_name => $param_value) {
                                ?>
                                <option value="<?php echo $param_value; ?>"<?php selected($instance[$param['param_name']], $param_value); ?>><?php echo $param_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </p>
                    <?php
                    break;
            }
        }
    }


    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        foreach ($this->map_param_default_array as $param_name => $param_value) {
            //if we need aditional procesing, we will do it here
            $instance[$param_name] = $new_instance[$param_name];
        }

        return $instance;
    }
}

?>
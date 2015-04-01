<?php
add_action('widgets_init', create_function('', 'register_widget("wpInsertAdWidget");'));
class wpInsertAdWidget extends WP_Widget {
	public function __construct() {
		parent::__construct('wp_insert_ad_widget', 'Wp-Insert Ad Widget', array('description' => 'Wp-Insert Ad Widget'));
	}

	public function widget($args, $instance) {
		global $wpInsertAdInstance;
		global $wpInsertGeoLocation;
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		if($instance['instance'] <= 10) {
			$options = get_option('wp_insert_adwidgets_options');
		} else {
			$options = get_option('wp_insert_more_adwidgets_options');
		}
		if(wp_insert_get_ad_status($options['adwidgets-'.$instance['instance']])) {
			echo $before_widget;
			if (!empty($title)) { echo $before_title.$title.$after_title; }		
			
			if(($options['adwidgets-'.$instance['instance']]['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['adwidgets-'.$instance['instance']]['country_1'])))) {
				echo '<div class="wpInsert wpInsertAdWidget"'.(($options['adwidgets-'.$instance['instance']]['styles'] != '')?' style="'.$options['adwidgets-'.$instance['instance']]['styles'].'"':'').'>'.do_shortcode($options['adwidgets-'.$instance['instance']]['country_code_1']).'</div>';
			} else {
				echo '<div class="wpInsert wpInsertAdWidget"'.(($options['adwidgets-'.$instance['instance']]['styles'] != '')?' style="'.$options['adwidgets-'.$instance['instance']]['styles'].'"':'').'>'.do_shortcode($options['adwidgets-'.$instance['instance']]['ad_code_'.$wpInsertAdInstance]).'</div>';
			}
			echo $after_widget;
		}
	}

	public function update($new_opts, $old_opts) {
		$opts = array();
		$opts['title'] = $new_opts['title'];
		$opts['instance'] = $new_opts['instance'];
		return $opts;
	}

	public function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('instance'); ?>">Widget Instance:</label> 
			<select class="widefat" id="<?php echo $this->get_field_id('instance'); ?>" name="<?php echo $this->get_field_name('instance'); ?>">
				<?php
				for($i = 1; $i <= 20; $i++) {
					echo '<option value="'.$i.'" '.selected($i, $instance['instance'], false).'>Ad Widget : '.$i.'</option>';
				}
				?>
			</select>
		</p>
	<?php 
	}
}
?>
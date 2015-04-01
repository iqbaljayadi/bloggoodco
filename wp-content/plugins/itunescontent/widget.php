<?php
if (!class_exists("iTunesContentWidget")) {
class iTunesContentWidget extends WP_Widget {

	function __construct() {
		parent::__construct(false, 'iTunes Content', array('description'=>__('Easily add iTunes content to your website.')));
	}
	
	function widget($args, $instance) {
		// Widget output
		extract($args);
		
		$itunes_content = new iTunesContent();
		
		$title = apply_filters('widget_title', $instance['title']);
		
		$id = $instance['id'];
		$country = $instance['country'];
		$feed = $instance['feed'];
		$limit = $instance['limit'];
		$genre = $instance['genre'];
		
		echo $before_widget;
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		
		echo $itunes_content->get_widget($id, $country, $feed, esc_attr($limit), $genre);
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		// Save widget options
		$instance = array();
		$instance['title'] = $new_instance['title'];
		
		$instance['id'] = $new_instance['id'];
		$instance['country'] = $new_instance['country'];
		$instance['feed'] = $new_instance['feed'];
		$instance['limit'] = $new_instance['limit'];	
		$instance['genre'] = $new_instance['genre'];
		
		$instance['saved'] = 1;
		
		return $instance;
	}
	
	function form( $instance ) {
	
		$instance['saved'] = (isset($instance['saved']) ? $instance['saved'] : NULL);
		
		if( $instance['saved']=='1' ){
		
		$itunes_content = new iTunesContent();
		$options = $itunes_content->get_options();
		// Output admin widget options form
		$title = (isset($instance['title']) ? $instance['title'] : __('iTunes', 'text_domain'));
		
		$id = (isset($instance['id']) ? $instance['id'] : NULL);
		$country = (isset($instance['country']) ? $instance['country'] : $options['default_country']);
		$feed = (isset($instance['feed']) ? $instance['feed'] : $options['default_feed_type']);
		$limit = (isset($instance['limit']) ? $instance['limit'] : __('5', 'text_domain'));
		$genre = (isset($instance['genre']) ? $instance['genre'] : __('', 'text_domain'));
		
		$feed_dd = $this->get_field_id('feed');
		$genre_dd = $this->get_field_id('genre');
		
		$script = '<script type="text/javascript">';
		$script.= 'var $ = jQuery.noConflict();';
		$script.= '$(document).ready(function() {';
		$script.= '$(\'select#'.$feed_dd.'\').change(function() {';
		$script.= '$(\'select#'.$genre_dd.'\').html(\'<option value="" selected="selected">All (Click save for more options)</option>\').attr(\'disabled\', \'disabled\');';
		$script.= '});';
		$script.= '});';
		$script.= '</script>';
		
		echo $script;
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('iTunes ID:'); ?></label>
		<input id="<?php echo $this->get_field_id('id'); ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo esc_attr($id); ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('country'); ?>"><?php _e('Country:'); ?></label>
		<select id="<?php echo $this->get_field_id('country'); ?>" name="<?php echo $this->get_field_name('country'); ?>">
        	<option value="<?php echo $country; ?>" selected="selected"><?php echo $itunes_content->itunes['countries'][$country]; ?></option>
            <?php foreach($itunes_content->itunes['countries'] as $key=>$value){ ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select></p>
        
        <p><label for="<?php echo $this->get_field_id('feed'); ?>"><?php _e('Feed:'); ?></label>
		<select id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>">
        	<option value="<?php echo $feed; ?>" selected="selected"><?php echo $itunes_content->itunes['feed_types'][$feed]; ?></option>
            <?php foreach($itunes_content->itunes['feed_types'] as $key=>$value){ ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select></p>
        
        <?php if( isset($feed) && !empty($itunes_content->itunes['genres'][$feed]) ){ ?>
        <p><label for="<?php echo $this->get_field_id('genre'); ?>"><?php _e('Genre:'); ?></label>
		<select id="<?php echo $this->get_field_id('genre'); ?>" name="<?php echo $this->get_field_name('genre'); ?>">
        	<?php if( isset($genre) && $itunes_content->itunes['genres'][$feed][$genre] ){ ?>
        	<option value="<?php echo $genre; ?>" selected="selected"><?php echo $itunes_content->itunes['genres'][$feed][$genre]; ?></option>
            <?php } ?>
            <?php foreach($itunes_content->itunes['genres'][$feed] as $key=>$value){ ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select></p>
        <?php } ?>
        
        <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:'); ?></label>
		<input id="<?php echo $this->get_field_id('limit'); ?>" type="text" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo esc_attr($limit); ?>" size="3" /></p>
        <?php
		}else{
			echo '<p>Please click save to access options</p>';
		}
    }
}
}
?>
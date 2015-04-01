<?php

class Fb_wpress_send_button extends WP_Widget {
	
	//Register widget
	public function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget( "Fb_wpress_send_button" );' ) );
		parent::__construct(
	 		'Fb_wpress_send_button', // Base ID
			'Facebook Send Button', // Name
			array( 'description' => 'Facebook Send Button (Facebook WPress plugin)' ) // Args
		);
	}
	
	//Display
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = apply_filters( 'widget_title', $instance['url'] );
		$colorscheme = apply_filters( 'widget_title', $instance['colorscheme'] );
		
		add_action( 'wp_footer', array('Fb_wpress_plugins', 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		echo $before_widget;
		if ( !empty($title) ) echo $before_title . $title . $after_title;
		
		$criteria = array('url'=>$url, 'colorscheme'=>$colorscheme);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_send_button($criteria);
		echo $content;
		
		echo $after_widget;
	}
	
	//Update
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['colorscheme'] = strip_tags( $new_instance['colorscheme'] );
		return $instance;
	}
	
	//Form
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ];
		if ( isset( $instance[ 'url' ] ) ) $url = $instance[ 'url' ];
		if ( isset( $instance[ 'colorscheme' ] ) ) $colorscheme = $instance[ 'colorscheme' ];
		else $colorscheme='light';
		
		$colorscheme_tab = array('light'=>'Light', 'dark'=>'Dark');
		
		?>
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Widget title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'URL to share: (leave empty to use the current URL)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Color scheme:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'colorscheme' ); ?>" name="<?php echo $this->get_field_name( 'colorscheme' ); ?>" ><option></option>
			<?php
			foreach($colorscheme_tab as $ind=>$value) {
				if($ind==$colorscheme) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<?php 
	}

}

new Fb_wpress_send_button();

?>
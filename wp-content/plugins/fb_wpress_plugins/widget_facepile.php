<?php

class Fb_wpress_facepile extends WP_Widget {
	
	//Register widget
	public function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget( "Fb_wpress_facepile" );' ) );
		parent::__construct(
	 		'Fb_wpress_facepile', // Base ID
			'Facebook Facepile', // Name
			array( 'description' => 'Facebook Facepile (Facebook WPress plugin)' ) // Args
		);
	}
	
	//Display
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = apply_filters( 'widget_title', $instance['url'] );
		$width = apply_filters( 'widget_title', $instance['width'] );
		$max_rows = apply_filters( 'widget_title', $instance['max_rows'] );
		$size = apply_filters( 'widget_title', $instance['size'] );
		$colorscheme = apply_filters( 'widget_title', $instance['colorscheme'] );
		
		add_action( 'wp_footer', array('Fb_wpress_plugins', 'enqueue_js_sdk') );
		
		echo $before_widget;
		if ( !empty($title) ) echo $before_title . $title . $after_title;
		
		$criteria = array('url'=>$url, 'width'=>$width, 'max_rows'=>$max_rows, 'size'=>$size, 'colorscheme'=>$colorscheme);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_facepile($criteria);
		echo $content;
		
		echo $after_widget;
	}
	
	//Update
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['max_rows'] = strip_tags( $new_instance['max_rows'] );
		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['colorscheme'] = strip_tags( $new_instance['colorscheme'] );
		return $instance;
	}

	//Form
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ];
		if ( isset( $instance[ 'url' ] ) ) $url = $instance[ 'url' ];
		if ( isset( $instance[ 'width' ] ) ) $width = $instance[ 'width' ];
		else $width='250';
		if ( isset( $instance[ 'max_rows' ] ) ) $max_rows = $instance[ 'max_rows' ];
		if ( isset( $instance[ 'size' ] ) ) $size = $instance[ 'size' ];
		else $size='medium';
		if ( isset( $instance[ 'colorscheme' ] ) ) $colorscheme = $instance[ 'colorscheme' ];
		else $colorscheme='light';
		
		$colorscheme_tab = array('light'=>'Light', 'dark'=>'Dark');
		$size_tab = array('small'=>'Small', 'medium'=>'Medium', 'large'=>'Large');
		
		?>
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Widget title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Width: (ex: 250)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Max rows: (ex: 2)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'max_rows' ); ?>" name="<?php echo $this->get_field_name( 'max_rows' ); ?>" type="text" value="<?php echo esc_attr( $max_rows ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Size:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" ><option></option>
			<?php
			foreach($size_tab as $ind=>$value) {
				if($ind==$size) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
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

new Fb_wpress_facepile();

?>
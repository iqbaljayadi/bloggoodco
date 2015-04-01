<?php

class Fb_wpress_like_box extends WP_Widget {
	
	//Register widget
	public function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget( "Fb_wpress_like_box" );' ) );
		parent::__construct(
	 		'Fb_wpress_like_box', // Base ID
			'Facebook Like Box', // Name
			array( 'description' => 'Facebook Like Box (Facebook WPress plugin)' ) // Args
		);
	}
	
	//Display
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = apply_filters( 'widget_title', $instance['url'] );
		$width = apply_filters( 'widget_title', $instance['width'] );
		$height = apply_filters( 'widget_title', $instance['height'] );
		$colorscheme = apply_filters( 'widget_title', $instance['colorscheme'] );
		$header = apply_filters( 'widget_title', $instance['header'] );
		$show_faces = apply_filters( 'widget_title', $instance['show_faces'] );
		$stream = apply_filters( 'widget_title', $instance['stream'] );
		$border = apply_filters( 'widget_title', $instance['border'] );
		
		add_action( 'wp_footer', array('Fb_wpress_plugins', 'enqueue_js_sdk') );
		
		echo $before_widget;
		if ( !empty($title) ) echo $before_title . $title . $after_title;
		
		$criteria = array('url'=>$url, 'width'=>$width, 'height'=>$height, 'colorscheme'=>$colorscheme, 'header'=>$header, 'show_faces'=>$show_faces, 'stream'=>$stream, 'border'=>$border);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_like_box($criteria);
		echo $content;
		
		echo $after_widget;
	}
	
	//Update
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['colorscheme'] = strip_tags( $new_instance['colorscheme'] );
		$instance['header'] = strip_tags( $new_instance['header'] );
		$instance['show_faces'] = strip_tags( $new_instance['show_faces'] );
		$instance['stream'] = strip_tags( $new_instance['stream'] );
		$instance['border'] = strip_tags( $new_instance['border'] );
		return $instance;
	}

	//Form
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ];
		if ( isset( $instance[ 'url' ] ) ) $url = $instance[ 'url' ];
		if ( isset( $instance[ 'width' ] ) ) $width = $instance[ 'width' ];
		else $width='250';
		if ( isset( $instance[ 'height' ] ) ) $height = $instance[ 'height' ];
		else $height='400';
		if ( isset( $instance[ 'colorscheme' ] ) ) $colorscheme = $instance[ 'colorscheme' ];
		else $colorscheme='light';
		if ( isset( $instance[ 'header' ] ) ) $header = $instance[ 'header' ];
		else $header='true';
		if ( isset( $instance[ 'show_faces' ] ) ) $show_faces = $instance[ 'show_faces' ];
		else $show_faces='true';
		if ( isset( $instance[ 'stream' ] ) ) $stream = $instance[ 'stream' ];
		else $stream='false';
		if ( isset( $instance[ 'border' ] ) ) $border = $instance[ 'border' ];
		else $border='false';
		
		$colorscheme_tab = array('light'=>'Light', 'dark'=>'Dark');
		$true_false_tab = array('true'=>'True', 'false'=>'False');
		
		?>
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Widget title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Facebook page URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Width: (ex: 200)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Height: (ex: 400)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
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
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Header display:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'header' ); ?>" name="<?php echo $this->get_field_name( 'header' ); ?>" ><option></option>
			<?php
			foreach($true_false_tab as $ind=>$value) {
				if($ind==$header) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Show faces:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'show_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" ><option></option>
			<?php
			foreach($true_false_tab as $ind=>$value) {
				if($ind==$show_faces) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Show stream:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" ><option></option>
			<?php
			foreach($true_false_tab as $ind=>$value) {
				if($ind==$stream) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Show border:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'border' ); ?>" name="<?php echo $this->get_field_name( 'border' ); ?>" ><option></option>
			<?php
			foreach($true_false_tab as $ind=>$value) {
				if($ind==$border) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<?php 
	}

}

new Fb_wpress_like_box();

?>
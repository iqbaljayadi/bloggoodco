<?php

class Fb_wpress_like_button extends WP_Widget {
	
	//Register widget
	public function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget( "Fb_wpress_like_button" );' ) );
		parent::__construct(
	 		'Fb_wpress_like_button', // Base ID
			'Facebook Like Button', // Name
			array( 'description' => 'Facebook Like Button (Facebook WPress plugin)' ) // Args
		);
	}
	
	//Display
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = apply_filters( 'widget_title', $instance['url'] );
		$share = apply_filters( 'widget_title', $instance['share'] );
		$layout = apply_filters( 'widget_title', $instance['layout'] );
		$width = apply_filters( 'widget_title', $instance['width'] );
		$colorscheme = apply_filters( 'widget_title', $instance['colorscheme'] );
		$show_faces = apply_filters( 'widget_title', $instance['show_faces'] );
		$action = apply_filters( 'widget_title', $instance['action'] );
		
		add_action( 'wp_footer', array('Fb_wpress_plugins', 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		echo $before_widget;
		if ( !empty($title) ) echo $before_title . $title . $after_title;
		
		$criteria = array('url'=>$url, 'share_button'=>$share, 'layout'=>$layout, 'width'=>$width, 'colorscheme'=>$colorscheme, 'show_faces'=>$show_faces, 'action'=>$action);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_like_button($criteria);
		echo $content;
		
		echo $after_widget;
	}
	
	//Update
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['share'] = strip_tags( $new_instance['share'] );
		$instance['layout'] = strip_tags( $new_instance['layout'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['colorscheme'] = strip_tags( $new_instance['colorscheme'] );
		$instance['show_faces'] = strip_tags( $new_instance['show_faces'] );
		$instance['action'] = strip_tags( $new_instance['action'] );
		return $instance;
	}
	
	//Form
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ];
		if ( isset( $instance[ 'url' ] ) ) $url = $instance[ 'url' ];
		if ( isset( $instance[ 'share' ] ) ) $share = $instance[ 'share' ];
		else $share='false';
		if ( isset( $instance[ 'layout' ] ) ) $layout = $instance[ 'layout' ];
		else $layout='standard';
		if ( isset( $instance[ 'width' ] ) ) $width = $instance[ 'width' ];
		else $width='250';
		if ( isset( $instance[ 'colorscheme' ] ) ) $colorscheme = $instance[ 'colorscheme' ];
		else $colorscheme='light';
		if ( isset( $instance[ 'show_faces' ] ) ) $show_faces = $instance[ 'show_faces' ];
		else $show_faces='true';
		if ( isset( $instance[ 'action' ] ) ) $action = $instance[ 'action' ];
		else $action='like';
		
		$colorscheme_tab = array('light'=>'Light', 'dark'=>'Dark');
		$true_false_tab = array('true'=>'True', 'false'=>'False');
		$layout_tab = array('standard'=>'Standard', 'button_count'=>'Button count', 'box_count'=>'Box count', 'button'=>'Button');
		$action_tab = array('like'=>'Like', 'recommend'=>'Recommend');
		
		?>
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Widget title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'URL: (leave empty to use the current URL - recommended)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Share button:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'share' ); ?>" name="<?php echo $this->get_field_name( 'share' ); ?>" ><option></option>
			<?php
			foreach($true_false_tab as $ind=>$value) {
				if($ind==$share) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Layout:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" ><option></option>
			<?php
			foreach($layout_tab as $ind=>$value) {
				if($ind==$layout) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<div style="margin-bottom:5px;">
			<label><?php _e( 'Width: (ex: 250)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
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
			<label><?php _e( 'Action:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'action' ); ?>" name="<?php echo $this->get_field_name( 'action' ); ?>" ><option></option>
			<?php
			foreach($action_tab as $ind=>$value) {
				if($ind==$action) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			?>
			</select>
		</div>
		
		<?php 
	}

}

new Fb_wpress_like_button();

?>
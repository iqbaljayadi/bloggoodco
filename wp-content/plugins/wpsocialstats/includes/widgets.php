<?php

if( class_exists('WP_Widget') ){

	class social_media_most_shared_posts extends WP_Widget {

		function __construct(){

			$widget_ops = array(
				'classname' => 'widget_most_shared_posts', 
				'description' => __( "Widget that displays most shared in social media posts." ) 
			);

			parent::__construct('most-shared-posts', __('Most Shared Posts'), $widget_ops);
			$this->alt_option_name = 'widget_most_shared_posts';

			add_action( 'switch_theme', array($this, 'flush_widget_cache') );
		}

		function widget($args, $instance){

			$cache = wp_cache_get('statistics_most_shared_posts', 'widget');

			if ( !is_array($cache) )
				$cache = array();

			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();

			extract($args);

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : "" ;
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$posts_numm = ( !empty( $instance['posts_numm'] ) ) && intval( $instance['posts_numm'] ) >= 0 ? intval( $instance['posts_numm'] ) : 0 ;
			$display_thumb = ( !empty( $instance['display_thumb'] ) ) && $instance['display_thumb'] ? true : false ;

		 	if( class_exists('WP_Social_Stats_Dashboard') && $posts_numm > 0 ){

				echo $before_widget;
		    	
		    	if ( $title ){

		    		echo $before_title . $title . $after_title;
		    	}

		    	?>

				<div class="mshared-wrapper">

				<?php

				$args = array(
					'order' => 'DESC',
					'orderby' => 'meta_value_num',
					'meta_key' => 'WSS_DATA_TOTAL',
					'posts_per_page' => $posts_numm,
				    'posts_per_archive_page' => $posts_numm,
				    'nopaging' => false
				);

				$msQuery = new WP_Query( $args );

				while( $msQuery->have_posts()): $msQuery->the_post();

					$shares_meta = get_post_meta( get_the_ID(), 'WSS_DATA_TOTAL', true );

					if( has_post_format('video') || has_post_format('audio') || has_post_format('gallery') )  {
						
						$format_icon = 'class="' . get_post_format() . '-format-icon"';
					}
					else {
						
						$format_icon = 'class="standard-format-icon"';
					}

					?>

					<div class="mshared-post-block">

						<?php 
						
						$descArea_classes = array( 'mshared-description' );

						if( $display_thumb && has_post_thumbnail() ){ ?>
							
								<div class="mshared-image">
									<a <?php echo $format_icon; ?> href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
										<?php the_post_thumbnail( 'thumbnail' ); ?>
									</a>
								</div><?php
						}
						else{

							$descArea_classes[] = 'no-thumb';
						} ?>

						<div class="<?php echo implode( ' ', $descArea_classes ); ?>">

							<h3><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
							<div class="mshared-meta">
							<?php echo $shares_meta . ' ' . __( 'Shares' ); ?>
							</div><!--/ .mshared-meta -->

						</div><!--/ .mshared-description -->

						<br class="mshared-cl" />

					</div><!--/ .mshared-post-block -->

				<?php endwhile; ?>

				</div><!--/ .mshared-wrapper --> <?php

		    	echo $after_widget;

			}

		    $cache[$args['widget_id']] = ob_get_flush();

			wp_cache_set('statistics_most_shared_posts', $cache, 'widget');
		}

		function update( $new_instance, $old_instance ){
			
			$instance = $old_instance;  

			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['posts_numm'] = strip_tags(stripslashes($new_instance['posts_numm']));
			$instance['display_thumb'] = strip_tags(stripslashes($new_instance['display_thumb']));
			
			$this->flush_widget_cache();
			
			$alloptions = wp_cache_get( 'alloptions', 'options' );

			if ( isset($alloptions['widget_most_shared_posts']) ){
			
				delete_option('widget_most_shared_posts');
			}

			return $instance;
		}

		function flush_widget_cache(){

			wp_cache_delete('statistics_most_shared_posts', 'widget');
		}

		function form( $instance ){
			
			$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$posts_numm = isset( $instance['posts_numm'] ) && intval( $instance['posts_numm'] ) >= 0 ? intval( $instance['posts_numm'] ) : 0;
			$display_thumb = isset( $instance['display_thumb'] ) && $instance['display_thumb'] ? 'checked' : '';

			?>

			<div class="widgets_form_container">

				<br/>

				<label class="" for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
				<br/>
				<br/>

				<label class="" for="<?php echo $this->get_field_id( 'posts_numm' ); ?>"><?php _e( 'Number of posts to display' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'posts_numm' ); ?>" name="<?php echo $this->get_field_name( 'posts_numm' ); ?>" type="text" value="<?php echo $posts_numm; ?>" />
				<br/>
				<br/>

				<input class="" id="<?php echo $this->get_field_id( 'display_thumb' ); ?>" name="<?php echo $this->get_field_name( 'display_thumb' ); ?>" type="checkbox" <?php echo $display_thumb; ?> />&nbsp;
				<label class="" for="<?php echo $this->get_field_id( 'display_thumb' ); ?>"><?php _e( 'Display posts thumbnails' ); ?></label>			
				<br/>
				<br/>

			</div><!-- end of .widgets_form_container -->

			<?php
		}

	}

	function register_social_statistics_widgets() {

		return register_widget( 'social_media_most_shared_posts' );
	}

	add_action( 'widgets_init', 'register_social_statistics_widgets' );

}

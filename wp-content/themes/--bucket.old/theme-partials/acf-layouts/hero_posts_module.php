<?php
global $showed_posts_ids;
/**
 * Hero Posts Module
 * Fields available:
 * @posts_source select (featured / latest / latest_by_cat / latest_by_format / latest_by_reviews)
 * @number_of_posts number
 */

$number_of_posts = get_sub_field('number_of_posts');

$query_args = array(
	'posts_per_page' => $number_of_posts,
	'ignore_sticky_posts' => true,
);

if (get_post_meta(wpgrade::lang_post_id(get_the_ID()), '_bucket_prevent_duplicate_posts', true) == 'on') {
	//exclude the already showed posts from the current block loop
	if (!empty($showed_posts_ids)) {
		$query_args['post__not_in'] = $showed_posts_ids;
	}
}

$posts_source = get_sub_field('posts_source');

$offset = get_sub_field('offset');

if ( is_numeric($offset) && $offset > 0 ) {
	$query_args['offset'] = $offset;
}

switch ( $posts_source ) :

	case 'featured' :
		/** In this case return only posts marked as featured */
		$query_args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key' => wpgrade::prefix() . 'featured_post',
				'value' => 'on',
				'compare' => '='
			)
		);
		break;
	
	case 'latest' :
		/** Return the latest posts only */
		$query_args['order'] = 'DESC';
		$query_args['orderby'] = 'date';
		break;
	
	case 'latest_by_cat' :
		/** Return posts from selected categories */
		$categories = get_sub_field('posts_source_category');
		$catarr = array();
		foreach ($categories as $key => $value) {
			$catarr[] = (int) $value;
		}
		
		$query_args['category__in'] = $catarr;
		break;
		
	case 'latest_by_format' :
		/** Return posts with the selected post format */
		$formats = get_sub_field('posts_source_post_formats');

		if ( !empty($formats) ) {
			$terms = array();
			if (!isset($query_args['tax_query'])) {
				$query_args['tax_query'] = array();
			}
			foreach ( $formats as $key => &$format) {
				if ($format == 'standard') {
					//if we need to include the standard post formats
					//then we need to include the posts that don't have a post format set
					$all_post_formats = get_theme_support('post-formats');
					if (!empty($all_post_formats[0]) && count($all_post_formats[0])) {
						$allterms = array();
						foreach ($all_post_formats[0] as $format2) {
							$allterms[] = 'post-format-'.$format2;
						}

						$query_args['tax_query']['relation'] = 'AND';
						$query_args['tax_query'][] = array(
							'taxonomy' => 'post_format',
							'terms' => $allterms,
							'field' => 'slug',
							'operator' => 'NOT IN'
						);
					}
				} else {
					$terms[] = 'post-format-' . $format;
				}
			}/** end foreach( $formats ) */

			if ( !empty($terms) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
				);
			}
		} /** endif !empty( $formats ) */
		break;

	case 'latest_by_reviews':
		$query_args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key' => 'enable_review_score',
				'value' => '1',
				'compare' => '='
			)
		);
		break;
	default : ;
endswitch;

$slides = new WP_Query( $query_args );

if ($slides->have_posts()): ?>

    <div class="featured-area"><!--
        <?php if($slides->have_posts()): $slides->the_post(); 
			//first let's remember the post id
			$showed_posts_ids[] = wpgrade::lang_post_id(get_the_ID());
		?>
            --><div class="featured-area__article  article--big">
                <?php
                if (has_post_thumbnail()):
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-big');
					$image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
					if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
						$image_ratio = $image[2] * 100/$image[1]; 
					} ?>
                    <a href="<?php the_permalink(); ?>" class="image-wrap" style="padding-top: <?php echo $image_ratio; ?>%">
                        <img class="lazy" data-src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" />
                        <div class="article__title">
                            <h3 class="hN"><?php the_title(); ?></h3>
                        </div>
                    </a>
	            <?php else : ?>
	                <a href="<?php the_permalink(); ?>" class="image-wrap no-image" >
		                <div class="article__title">
			                <h3 class="hN"><?php the_title(); ?></h3>
		                </div>
	                </a>
                <?php endif;
	            post_format_icon('post-format-icon--featured'); ?>
            </div><!--
        <?php endif; ?>
     --><div class="featured-area__aside">
            <ul class="block-list  block-list--alt">
                <?php
                if ($slides->have_posts()):
                    while($slides->have_posts()): $slides->the_post(); 
					//first let's remember the post id
					$showed_posts_ids[] = wpgrade::lang_post_id(get_the_ID());
					?>
	                    <li class="hard--sides">
	                        <article class="article  article--thumb  media  flush--bottom">
	                            <div class="media__img--rev  four-twelfths">
	                                <?php
                                    if (has_post_thumbnail()):
                                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-small');
										$image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
										if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
											$image_ratio = $image[2] * 100/$image[1];
										} ?>
                                        <a href="<?php the_permalink(); ?>" class="image-wrap" style="padding-top: <?php echo $image_ratio; ?>%">
                                            <img class="lazy" data-src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" />
                                        </a>
	                                <?php endif; ?>
	                            </div>
	                            <div class="media__body">
	                                <?php
                                    $categories = get_the_category();
                                    if ($categories) {
                                        $category = $categories[0];
                                        echo '<div class="article__category">
                                                <a class="small-link" href="'. get_category_link($category->term_id) .'" title="'. esc_attr(sprintf(__("View all posts in %s", wpgrade::textdomain()), $category->name)) .'">'. $category->cat_name.'</a>
                                              </div>';
                                    } ?>
	                                <div class="article__title  article--thumb__title">
	                                      <a href="<?php the_permalink(); ?>"><h3 class="hN"><?php the_title(); ?></h3></a>
	                                </div>
	                                <ul class="nav  article__meta-links">
	                                    <li class="xpost_date"><i class="icon-time"></i> <?php the_time('j M') ?></li>
										<?php /*if ( comments_open() ): ?>
	                                    <li class="xpost_comments"><i class="icon-comment"></i>  <?php //comments_number('0', '1', '%'); ?></li>
										<?php endif; */ ?>
										<?php
											$post_url = get_permalink();
											$socialstats = new SocialStats( $post_url );
											
											if($socialstats->valid_url() == "valid") {
												$tw_count = $socialstats->get_twitter();
												$fb_count = $socialstats->get_facebook_share();
												$fb_total = $socialstats->get_facebook_total();
												$fb_likes = $socialstats->get_facebook_likes();
												$li_count = $socialstats->get_linkedin();
												$gp_count = $socialstats->get_google_plus();
												$pi_count = $socialstats->get_pinterest();
												
												$social_total = array( $tw_count, $li_count, $gp_count, $pi_count );
												$wo_fb = array_sum($social_total);
												

											}
											else {
												echo $socialstats->valid_url();
											}
											
										?>
										<li class="xpost_comments"><i class="icon-comment"></i><span class="totalsharedpost"><?php echo ($fb_total+$wo_fb); ?></span></li>
										
										<?php if ( wpgrade::option('blog_single_show_share_links') && function_exists('get_pixlikes')) : ?>
	                                    <li class="xpost_likes"><i class="icon-heart"></i> <?php echo get_pixlikes(wpgrade::lang_original_post_id(get_the_ID())); ?></li>
										<?php endif; ?>
	                                </ul>
	                            </div>
	                        </article>
	                    </li>
                <?php endwhile; 
			endif;
			wp_reset_postdata(); ?>
            </ul>
        </div>
    </div>
<?php endif;

<?php
/**
 * Template to display the article in archives in a clasic way
 */
?>
<article <?php post_class('article  article--thumb media flush--bottom grid'); ?>>
	<div class="media__img--rev grid__item five-twelfths palm-one-whole">
		<?php
		if (has_post_thumbnail()):
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-medium');
			$image_ratio = 70; //some default aspect ratio in case something has gone wrong and the image has no dimensions - it happens
        	if (isset($image[1]) && isset($image[2]) && $image[1] > 0) {
				$image_ratio = $image[2] * 100/$image[1];
			} ?>
			<a href="<?php the_permalink(); ?>" class="image-wrap" style="padding-top: <?php echo $image_ratio; ?>%">
				<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>"/>
			</a>
		<?php endif; ?>
		<?php post_format_icon();
			if ( bucket::has_average_score() ) { ?>
			<div class="badge  badge--article"><?php echo bucket::get_average_score();?> <span class="badge__text"><?php __('score', wpgrade::textdomain()) ?></span></div>
		<?php } ?>
	</div>
	<div class="media__body grid__item seven-twelfths palm-one-whole">
		<?php
		$categories = get_the_category();
		if ($categories) {
			echo '<div class="article__category">';
			foreach ($categories as $category):
	                    echo '<a class="small-link" href="'. get_category_link($category->term_id) .'" title="'. esc_attr(sprintf(__("View all posts in %s", wpgrade::textdomain()), $category->name)) .'">'. $category->cat_name.'</a>';
            endforeach;
	        echo '</div>';
		} ?>
		<div class="article__title  article--thumb__title">
			<a href="<?php the_permalink(); ?>"><h3 class="hN"><?php the_title(); ?></h3></a>
		</div>
		<div class="article--grid__body">
	        <div class="article__content">
	            <?php echo wpgrade_better_excerpt(); ?>
	        </div>
	    </div>
	    <ul class="nav  article__meta-links">
			<li class="xpost_date"><i class="icon-time"></i> <?php the_time('j M') ?></li>
			<?php /* if ( comments_open() ): ?>
			<li class="xpost_comments"><i class="icon-comment"></i>  <?php comments_number('0', '1', '%'); ?></li>
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
		</ul>
	</div>
</article>
<hr class="separator  separator--subsection">

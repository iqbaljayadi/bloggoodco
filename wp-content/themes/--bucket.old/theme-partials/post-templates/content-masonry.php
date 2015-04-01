<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<article <?php post_class('article  article--grid'); ?>>
	<?php get_template_part('theme-partials/post-templates/header-blog', get_post_format()); ?>
    <div class="article--grid__body">
        <div class="article__content">
            <?php echo wpgrade_better_excerpt(); ?>
        </div>
    </div>
    <div class="article__meta  article--grid__meta">
        <div class="split">
            <div class="split__title  article__category">
                <?php
                    $categories = get_the_category();
                    if ($categories) {
                        $category = $categories[0];
                        echo '<a class="small-link" href="'. get_category_link($category->term_id) .'" title="'. esc_attr(sprintf(__("View all posts in %s", wpgrade::textdomain()), $category->name)) .'">'. $category->cat_name.'</a>';
                    }
                ?>
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
    </div>

</article><!-- .article -->
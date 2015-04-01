<?php
if ( wpgrade::option('blog_single_show_share_links')) : ?>
	<div id="share-box">
		<ul class="nav">
			<?php
			if ( wpgrade::option('blog_single_share_links_twitter')) { ?>
			<li class="sbt_twitter share-item" data-url="<?php the_permalink() ?>" data-text="<?php echo get_the_title(); ?>" data-title="Tweet" <?php if (wpgrade::option('twitter_card_site')) echo 'data-via="'.wpgrade::option('twitter_card_site').'"' ?>></li>
			<?php }
			if ( wpgrade::option('blog_single_share_links_facebook')) { ?>
				<li class="sbt_facebook share-item" data-url="<?php the_permalink() ?>" data-text="<?php the_excerpt_rss() ?>" data-title="Like"></li>
			<?php }
			if ( wpgrade::option('blog_single_share_links_googleplus')) {?>
				<li class="sbt_gplus share-item" data-url="<?php the_permalink() ?>" data-text="<?php the_excerpt_rss() ?>" data-title="+1"></li>
			<?php } ?>
			<li class="sbt_linkedin share-item" data-url="<?php the_permalink() ?>" data-text="<?php the_excerpt_rss() ?>" data-title="LinkedIn It"></li>
			<?php if ( wpgrade::option('blog_single_share_links_pinterest')) {?>
				<li class="sbt_pinterest share-item" data-url="<?php the_permalink() ?>" data-text="<?php the_excerpt_rss() ?>" data-title="PinIt"></li>
			<?php } ?>
			<li class="share-item share-total">
				<span class="share-total__value">0</span> <?php _e('Shares', wpgrade::textdomain()); ?>
			</li>
		</ul>
	</div>
<?php endif;

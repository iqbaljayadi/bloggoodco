<?php
	$post_url = get_permalink();
	$socialstats = new SocialStats( $post_url );
	
		if ( false === ( $twitter_stat = get_transient( 'twitter_stat_'.get_the_ID() ) ) ) {
			$twitter_stat = update_post_meta( get_the_ID(), '_share_twitter', $socialstats->get_twitter() );
			set_transient( 'twitter_stat_'.get_the_ID(), $twitter_stat, 300 ); // 5 minutes
		}
		
		$facebook = $socialstats->get_facebook_total();
		if ( false === ( $facebook_stat = get_transient( 'facebook_stat_'.get_the_ID() ) ) ) {
			$facebook_stat = update_post_meta( get_the_ID(), '_share_facebook', intval($facebook) );
			set_transient( 'facebook_stat_'.get_the_ID(), $facebook_stat, 300 ); // 5 minutes
		}
		
		if ( false === ( $linkedin_stat = get_transient( 'linkedin_stat_'.get_the_ID() ) ) ) {
			$linkedin_stat = update_post_meta( get_the_ID(), '_share_linkedin', $socialstats->get_linkedin() );
			set_transient( 'linkedin_stat_'.get_the_ID(), $linkedin_stat, 600 ); // 10 minutes
		}
		
		if ( false === ( $gplus_stat = get_transient( 'gplus_stat_'.get_the_ID() ) ) ) {
			$gplus_stat = update_post_meta( get_the_ID(), '_share_gplus', $socialstats->get_google_plus() );
			set_transient( 'gplus_stat_'.get_the_ID(), $gplus_stat, 600 ); // 10 minutes
		}
		
		if ( false === ( $pinterest_stat = get_transient( 'pinterest_stat_'.get_the_ID() ) ) ) {
			$pinterest_stat = update_post_meta( get_the_ID(), '_share_pinterest', $socialstats->get_pinterest() );
			set_transient( 'pinterest_stat_'.get_the_ID(), $pinterest_stat, 1200 ); // 20 minutes
		}
		
		// Get twitter value from database
		$share_twitter 		= get_post_meta( get_the_ID(), '_share_twitter', true );
		$share_facebook		= get_post_meta( get_the_ID(), '_share_facebook', true );
		$share_linkedin		= get_post_meta( get_the_ID(), '_share_linkedin', true );
		$share_gplus		= get_post_meta( get_the_ID(), '_share_gplus', true );
		$share_pinterest	= get_post_meta( get_the_ID(), '_share_pinterest', true );
				
		$social_array = array( $share_twitter, $share_facebook, $share_linkedin, $share_gplus, $share_pinterest );
		$social_total = array_sum( $social_array );
	
?>
<li class="xpost_comments"><i class="icon-comment"></i><span class="totalsharedpost"><?php echo $social_total; ?></span></li>
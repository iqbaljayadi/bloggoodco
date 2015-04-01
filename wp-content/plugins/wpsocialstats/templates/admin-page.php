<div class="wrap">

	<div class="socnet_wrap">

		
		<div class="socnet-header-left" style="height:auto;padding:30px 0px;">
			<img class="socnet-logo" src="<?php echo SOCIAL_STATISTICS_PLUGIN_URL; ?>/icon/Icon-32-px.png" />
	                <span style="font-size:16px;font-weight:bold;">WPsocialstats by <a href="http://www.powerwp.com">Powerwp</a></span>
		</div>

		<div class="tablefilter">
			<div style="float:left;margin:5px 5px 5px 0px;vertical-align: middle;">
				<form method="get" action="admin.php">
					<span> Show: </span>
					<select name="post_type" id="post_type">
			 			<option value="post" <?php if( 'post' == $options["post_type"] ) echo ' selected="selected"'; ?> >Posts</option>
			 			<option value="page" <?php if( 'page' == $options["post_type"] ) echo ' selected="selected"'; ?> >Pages</option>
					</select>

					<?php echo $category_dropdown; ?>

					<select name="date">
						<option value="default">All time</option>
						<?php echo $date_options; ?>
					</select>

					<select name="per_page">
						<option value="10" <?php if( '10' == $options["per_page"]) echo ' selected="selected" '; ?> >10 items</option>
						<option value="25" <?php if( '25' == $options["per_page"]) echo ' selected="selected" '; ?> >25 items</option>
					</select>
					<input type='hidden' name='page' value='<?php echo self::SOCIAL_STATS_ADMIN_MENU_SLUG; ?>' />
					<input type="submit" class="button" value="Filter"/>
				</form>
			</div>
			<div class="socnet-creds">Learn more at <a href="http://www.powerwp.com/wpsocialstats">www.powerwp.com/wpsocialstats</a><br />
			Give us feedback at <a href="http://www.fluidsurveys.com/surveys/wpsocialstats/feedback/">www.fluidsurveys.com/surveys/wpsocialstats/feedback/</a>
	    </div>

	    <div class="clear"></div>
	    		
	    <div class='updated below-h2 below-h2' ><p>Last update <?php 
	 if( $last_update == "n/a" ) 
		 echo "n/a"; 
	 else 
		 echo $this->_ago( $last_update )." ago"; 
/* added by GenLEE Begin */
	/* $mytime = time(); */
        /* $update_policy = get_option('phynuchs-auto-save-options'); */
	/* if ($update_policy !== false) { */
	/* 	$update_hour = $update_policy['hour']; */
	/* 	$update_minute = $update_policy['minute']; */

	/* 	if ($update_policy['type'] == 'everyday') { */
	/* 		$mytime = mktime($update_hour, $update_minute, 0,  */
	/* 				 date('m', $mytime), date('d', $mytime), date('Y', $mytime)); */
	/* 	} else if ($update_policy['type'] == 'everyweek') { */
	/* 		$weekday = $update_policy['weekday']; */
	/* 		for ($i  = 0; $i < 7; $i++) { */
	/* 			$mytime = $mytime + $i * 3600 * 24; */
	/* 			if (strtolower(date('l', $mytime)) == $weekday) { */
	/* 				break; */
	/* 			} */
	/* 		} */
	/* 		$mytime = mktime($update_hour, $update_minute, 0,  */
	/* 				 date('m', $mytime), date('d', $mytime), date('Y', $mytime)); */
	/* 	} else { */
	/* 		$monthday = $update_policy['monthday']; */

	/* 		if (date('t', $mytime) < $monthday) */
	/* 			$monthday = date('t', $mytime); */

	/* 		$mytime = mktime($update_hour, $update_minute, 0,  */
	/* 				 date('m', $mytime), $montday, date('Y', $mytime)); */
	/* 	} */
	/* } */
/* added by GenLEE End */
?></p></div>

	    <div id='wss_progress' >
	    	<div id='wss_progress_content' >

	   		 <?php if( count( $options["all_data"] ) == 0 ){ ?>

	   		<div id='wss_message' class='below-h2' ></div>
	   		
	   		 <?php } else if( !$options["sortable"] ) { ?>

	    		<div style="" id='wss_message' class="error below-h2"><p><span style="display:none">Sorting is disabled..</span><?php echo count( $options["old_data"] );?> entr<?php if( count( $options["old_data"] ) !== 1 ) echo "ies"; else echo "y"; ?> <?php if( count( $options["old_data"] ) !== 1 ) echo "have"; else echo "has"; ?> missing social stats.. <input type='button' value='Update missing social stats' class="button" id='wss_update_missing' /></p></div>
	   
	    		<div id='wss_progressbar_text' ></div>
	    		<div id='ws_buttons' >
	    			<div id='ws_update_buttons' >
			    		<input type='button' value='Update stats manually' class="button" id='wss_update_all' />
			    		<span style="display:none;" class='description' >&nbsp;&nbsp; updates all stats in current selection</span>
                                                                                <a href="<?php menu_page_url(WP_Social_Stats_Dashboard::SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_SLUG); ?>"><input type='button' value='Update stats automatically' class="button" id='phynuchs_enable_auto_update' /></a>
			    		<br/>
			    	</div>
		    	</div>
	    	<?php } else { ?>
	   		<div id='wss_message' class='below-h2' ></div>
	    		<div id='wss_progressbar_text' ></div>
	    		<div id='ws_buttons' >
	    			<div id='ws_update_buttons' >
			    		<input type='button' value='Update stats manually' class="button" id='wss_update_all' />
                                        <a href="<?php menu_page_url(WP_Social_Stats_Dashboard::SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_SLUG); ?>"><input type='button' value='Update stats automatically' class="button" id='phynuchs_enable_auto_update' /></a>
			    	</div>
		    	</div>
	    	<?php } ?>
	    	
	    	</div>
	    </div>
	    		

	    <div class="clear"></div>

		<?php $table->display(); ?>

		<div class="socnet_nav" style="margin-top:7px;float:left"><?php //echo $page_links; ?></div>
		<div class="socialmedia-buttons" style="float:right !important;margin-top:7px;display:none;">
			<span style="position:relative;bottom:2px">Follow Us! We Rock!</span>&nbsp;&nbsp;&nbsp;
			<a href="http://twitter.com/share" class="twitter-share-button" data-text="WP Social Stats is an advanced social media analytics plugin that analyzes how your posts perform on Social Networks" data-count="horizontal" data-url="http://www.twitter.com/wpsocialstats">Tweet</a>
			<g:plusone size="medium" href="http://www.wpsocialstats.com"></g:plusone>
			<iframe src="http://www.facebook.com/plugins/like.php?href=http://www.wpsocialstats.com&send=false&layout=button_count&width=100&show_faces=false&action=like&colorscheme=light&locale=en_US" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
		</div>
	</div>
</div>

<script type='text/javascript' >
	var WSS_MISSING = <?php echo json_encode( $options["old_data"] ); ?>;
	var WSS_ALL = <?php echo json_encode( $options["all_data"] ); ?>;
</script>

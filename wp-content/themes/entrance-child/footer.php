			</main>

		</div>

		<div id="footer-area">
			<?php if (get_theme_mod('footer_widget')) : ?>
			<div id="footer-widget">
				<div class="container">
					<div class="row">
						<div class="col-md-4 border-top blue">
							<?php dynamic_sidebar('footer1'); ?>
						</div>
						<div class="col-md-4 border-top purple">
							<?php dynamic_sidebar('footer2'); ?>
						</div>
						<div class="col-md-4 border-top green">
							<?php dynamic_sidebar('footer3'); ?>
						</div>
						<div class="col-md-4 border-top yellow">
							<?php dynamic_sidebar('footer4'); ?>
						</div>
						<div class="col-md-4 border-top red">
							<?php dynamic_sidebar('footer5'); ?>
						</div>
					</div>
					<div class="row">
					<div class="col-md-12" style="border-top: 1px solid #353540;">
						<div id="copyright">Copyright &#169; 2015 Good.Co, Inc. All Rights Reserved. FitEngine&#8482;, FitScore&#8482; and Good.Co&#8482; are all trademarks of Good.Co, Inc.</div>
					</div>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<footer id="bottom">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 footer1"><?php echo get_theme_mod('footer_text_1'); ?></div>
						<div class="col-sm-6 footer2"><?php echo get_theme_mod('footer_text_2'); ?></div>
					</div>
				</div>
			</footer>
		</div>

	</div>

<?php wp_footer(); ?>

<script type="text/javascript">
jQuery(document).ready(function() {
	/**
     * Mixpanel Library with token
     */
	(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
	for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
	mixpanel.init("f066dffcb4be5632db4457211964fa60");

	/**
     * Mixpanel Event Tag
     */
    mixpanel.track_links(".download-button", "Clicked to download - any");		
	 	
	mixpanel.track_links("#download-button-ios-blog-header", "Clicked to download - ios - any (Header)", {
		"App click OS": "iOS" 
	});
	 	
	mixpanel.track_links("#download-button-ios-blog-sidebar-button-3", "Clicked to download - ios - any (Sidebar)", {
		"App click OS": "iOS" 
	});

	mixpanel.track_links("#download-button-android-blog-header", "Clicked to download - android - any (Header)", {
		"App click OS": "android"
	});

	mixpanel.track_links("#download-button-android-blog-sidebar-button-3", "Clicked to download - android - any (Sidebar)", {
		"App click OS": "android"
	});

	mixpanel.track_links("#science-button-homepage-section5", "Clicked science button - Homepage section 5");
		
	mixpanel.track_links("#corp-button-homepage-section6", "Clicked corp contact button - Homepage section 6", {
	    "Commercial interest": "yes",
	});

/*
	mixpanel.track_links(".download-button a", "URL contains /blog", "Clicked to download - any blog page");
	
 	mixpanel.track_links(".download-button-ios a", "URL contains /blog", "Clicked to download - ios - any blog page", {
    	"App click OS": "ios",
	});

 	mixpanel.track_links(".download-button-android a", "URL contains /blog", "Clicked to download - android - any blog page", {
	    "App click OS": "android",
	});
	
 	mixpanel.track_links(".download-button a", "URL doesn't contain /blog", "Clicked to download - any non-blog page");
	
 	mixpanel.track_links(".download-button-ios a", "URL doesn't contain /blog", "Clicked to download - ios - any non-blog page", {
	    "App click OS": "ios",
	});

 	mixpanel.track_links(".download-button-android a", "URL doesn't contain /blog", "Clicked to download - android - any -non-blog page", {
	    "App click OS": "android",
	});

 	mixpanel.track_links("#download-button-ios-homepage-hero a", "Clicked to download - ios - Homepage hero", {
	    "App click OS": "ios",
	});

	mixpanel.track_links(".blog-sidebar-button a", "Clicked on blog sidebar banner - Any banner");

	mixpanel.track("Viewed blog page", {
		"Blog viewer": "yes",
	});

	mixpanel.track("Views page", "Viewed non-blog page");

	mixpanel.track("Views page", "Viewed corporate contact page", {
	    "Commercial interest": "yes",
	});
*/
});
</script>

</body>
</html>

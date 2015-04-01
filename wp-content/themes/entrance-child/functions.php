<?php

//require_once get_template_directory_uri() . '/includes/widgets.php';

/**
 * Enqueue all css files used in public
 */
/*if (!function_exists('g7_styles')) {
	function g7_styles() {
		wp_enqueue_style('main-style', get_stylesheet_directory_uri().'/style.css');
	}
	add_action('wp_enqueue_scripts', 'g7_styles');
}*/

/**
 * Logo / site title & description
 */
if (!function_exists('g7_site_title')) {
	function g7_site_title() {
		if (get_theme_mod('main_logo')) {
			$title = sprintf(
				'<img src="%s" alt="%s">',
				get_theme_mod('main_logo'),
				get_bloginfo('name')
			);
			$id = 'logo';
			$site_desc = '';
		} else {
			$title = get_bloginfo('name');
			$id = 'site-title';
			$site_desc = sprintf(
				'<h2 id="site-description">%s</h2>',
				get_bloginfo('description')
			);
		}

		$link = sprintf(
			'<a href="%s" rel="home">%s</a>',
			home_url('/'),
			$title
		);

		if (is_front_page() || is_home()) {
			$site_title = '<h1 id="' . $id . '">' . $link . '<span class="logo-separator">|</span><span class="tag-line">career insights</span></h1>';
		} else {
			$site_title = '<p id="' . $id . '">' . $link . '</p>';
		}

		return $site_title . $site_desc;
	}
}

add_filter('widget_text', 'do_shortcode');

/**
 * Social media types
 * used in widgets and user profile
 */
if (!function_exists('g7_social_icons')) {
	function g7_social_icons() {
		return array(
			// icon name => type
			'dribbble'     => 'dribbble',
			'facebook'     => 'facebook',
			'flickr'       => 'flickr',
			'foursquare'   => 'foursquare',
			'google-plus'  => 'google',
			'instagram'    => 'instagram',
			'angellist'     => 'angellist',
			'linkedin'     => 'linkedin',
			'envelope-o'   => 'mail',
			'pinterest'    => 'pinterest',
			'rss'          => 'rss',
			'skype'        => 'skype',
			'tumblr'       => 'tumblr',
			'twitter'      => 'twitter',
			'vimeo-square' => 'vimeo',
			'youtube'      => 'youtube',
		);
	}
}

/**
 * Twitter card
 */
add_action('wp_head', 'add_twitter_cards');
function add_twitter_cards() {

	global $post;

    if(is_single()) {
        $tc_url    = get_permalink();

		$tc_title  = get_the_title();
		$tc_description   = get_the_excerpt();
		$tc_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
		$tc_image_thumb  = $tc_image[0];
		$tc_author   = str_replace('@', '', get_the_author_meta('twitter'));
// sample twitter card
// <meta name="twitter:card" content="app">
// <meta name="twitter:site" content="@TwitterDev">
// <meta name="twitter:description" content="Cannonball is the fun way to create and share stories and poems on your phone. Start with a beautiful image from the gallery, then choose words to complete the story and share it with friends.">
// <meta name="twitter:app:country" content="US">
// <meta name="twitter:app:name:iphone" content="Cannonball">
// <meta name="twitter:app:id:iphone" content="929750075">
// <meta name="twitter:app:url:iphone" content="cannonball://poem/5149e249222f9e600a7540ef">
// <meta name="twitter:app:name:ipad" content="Cannonball">
// <meta name="twitter:app:id:ipad" content="929750075">
// <meta name="twitter:app:url:ipad" content="cannonball://poem/5149e249222f9e600a7540ef">
// <meta name="twitter:app:name:googleplay" content="Cannonball">
// <meta name="twitter:app:id:googleplay" content="io.fabric.samples.cannonball">
// <meta name="twitter:app:url:googleplay" content="http://cannonball.fabric.io/poem/5149e249222f9e600a7540ef">

		?>
		<meta name="twitter:card" content="app">
		<meta name="twitter:site" value="@ingoodco" />
		<meta name="twitter:description" value="NEW! Discover your personality type and receive custom, in-depth career advice based on your personality results. Download the free Good.Co app! " />
		<meta name="twitter:app:id:iphone" value="892559034" />
		<meta name="twitter:app:id:ipad" value="892559034" />
		<meta name="twitter:app:id:googleplay" value="co.good.android" />
		
		<meta name="twitter:app:url:iphone" value="https://itunes.apple.com/us/app/good.co-match-your-personality/id892559034?utm_source=web&utm_medium=web&utm_campaign=App%20Store%20From%20Web" />
		<meta name="twitter:app:url:ipad" value="https://itunes.apple.com/us/app/good.co-match-your-personality/id892559034?utm_source=web&utm_medium=web&utm_campaign=App%20Store%20From%20Web" />
		<meta name="twitter:app:url:googleplay" value="https://play.google.com/store/apps/details?id=co.good.android" />
	<?php
    }
}

/**
 * register_nav_menus
 */
register_nav_menus(array(
	'header_socmed' => 'Header Socmed',
	'header_download' => 'Header Download Pernalink'
));

/**
 * Proper way to enqueue scripts and styles
 */
add_action( 'admin_enqueue_scripts', 'fontello' );
add_action( 'wp_enqueue_scripts', 'fontello' );
function fontello() {
	wp_enqueue_style( 'fontello-css', get_stylesheet_directory_uri()."/css/fontello.css" );
}


/**
 * Shortcode
 */
add_shortcode('content_banner', 'content_banner_print');
function content_banner_print()
{
	$style_dir = get_stylesheet_directory_uri();

	$return = '<style>@import url(http://fonts.googleapis.com/css?family=Raleway:800,400);

.goodco-content-banner * {
	font-family: Raleway;
}

.goodco-content-banner {
	margin-top: 20px;
	margin-bottom: 20px;
}

.goodco-content-banner #banner-title {
	font-weight: 800;
	font-size: 1.7em;
	color: #fff;
	padding: 15px 10px 0 10px;
	margin-bottom: 5px;
}

.goodco-content-banner p {
	font-size: 1em;
	line-height: 1.2;
	color: #fff;
	padding: 5px 10px 15px 10px;
}

.goodco-content-banner .top-content {
	background-color: #56C0F0;
	display: inline-block;
}

.goodco-content-banner .bottom-content {
	background-color: #2E5366;
	padding: 15px 20px;
}

.goodco-content-banner .bottom-content .divider-content {
	border-right: 1px solid #497C96;
	height: 35px;
	width: 1px;
	padding: 0px 5px;
}

.goodco-content-banner .btn {
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	background-color: #fff;
	color: #FF6364;
	padding: 8px 15px;
	margin-right: 7px;
	width: 100%;
	display: block;
}

.goodco-content-banner .right-content .btn {
	padding: 0px;
}

.goodco-content-banner .right-content .btn > img {
	margin-top: 7px;
	margin-left: 10px;
	position: absolute;
}

.goodco-content-banner .right-content .btn > span {
	display: inline-block;
	font-weight: bold;
	padding: 8px 0 6px 35px;
}


.goodco-content-banner .btn-linktexting {
	background-color: #FF6364;
	color: #fff;
	padding: 0px;
	width: 100%;
}

.goodco-content-banner input[type="text"] {
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	background-color: #fff;
	color: #333;
	width: 100%;
}

.goodco-content-banner .exp-linktexting-box > div {
	margin: 0px;
	height: 36px;
}

.goodco-content-banner .exp-linktexting-box > div > div {
	width: 100%;
}

.goodco-content-banner .exp-linktexting-box > div > div > div {
	width: 100%;
	margin-top: 0px;
}

.goodco-content-banner .linkTextingError {
	height: initial;
	background-color: #fff;
}

@media only screen and (min-width: 480px) {
	.goodco-content-banner .bottom-content .btn-submit {
		padding-left:0px;
		padding-right: 15px;
	}

	.goodco-content-banner .right-content > .row > .left {
		padding-right:7px;
	}

	.goodco-content-banner .right-content > .row > .right {
		padding-left:7px;
	}
}

@media only screen and (max-width: 767px) {	/* if max width, use 479px instead */
	.phone-image {
		display: none;
	}
}

@media only screen and (max-width: 479px) {	/* if max width, use 479px instead */
	.goodco-content-banner .exp-linktexting-box {
		margin-bottom: 15px;
	}

	.goodco-content-banner .right-content .btn {
		margin-bottom: 15px;
	}
}</style>';

	$return.= '<div class="container-fluid goodco-content-banner">
					<div class="row top-content">
						<div class="col-sm-5 phone-image">
							<img class="img-responsive" src="'.$style_dir.'/content_banner/widget-popup-phone.png">
						</div>
						<div class="col-sm-7">
							<p id="banner-title">What Job Fits You Best?</p>
							<p>
								<b>Download</b> our new (free!) mobile app that helps you <span class="exp-text-blue">discover</span> 
								your personality type and career strengths, <span class="exp-text-yellow">unlock</span> 
								your fit with 1,000+ companies, and <span class="exp-text-green">thrive</span> in your career.
							</p>
						</div>
						<div class="col-sm-12 bottom-content">
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-6 right-content">
									<div class="row">
										<div class="col-xs-6 left">								
											<a href="https://itunes.apple.com/us/app/good.co-match-your-personality/id892559034" class="btn"><img src="'.$style_dir.'/content_banner/icon_ios.png"><span>iOS</span></a>
										</div>
										<div class="col-xs-6 right">								
											<a href="https://play.google.com/store/apps/details?id=co.good.android" class="btn"><img src="'.$style_dir.'/content_banner/icon_android.png"><span>Android</span></a>
										</div>
									</div>
								</div>
								<div class="col-sm-3"></div>
							</div>
						</div>
					</div>		
				</div>';

	return $return;
}
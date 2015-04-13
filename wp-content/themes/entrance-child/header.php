<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->


<head>

	<script src="//cdn.optimizely.com/js/307710382.js"></script>

	<meta charset="<?php bloginfo('charset'); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<!--[if lt IE 9]>

		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

		<![endif]-->

		<?php wp_head(); ?>
		<?php if(is_home() || is_front_page() ) { ?>
		<style>
			.wrapper_adding_plane{display:none !important;}
			.wrapper_adding{display:block !important;}
		</style>
		<?php }else{ ?>
		<style>
			.wrapper_adding_plane{display:block !important;}
			.wrapper_adding{display:none !important;}
		</style>
		<?php } ?>

		<!-- Go to www.addthis.com/dashboard to customize your tools -->

		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53caa39f4ef31fe0"></script>
		<script async='async' type='text/javascript' src='https://sensortower.com/widget/ios/US/good-dot-co/app/good-dot-co-find-your-culture-fit/892559034/298/rating/current/date/install/js'></script>
   <!-- <script>
		var images = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg'];
		jQuery('.shuffle').css({'background-image': 'url(http://204.197.244.110/~dex/goodcoblog/wp-content/themes/entrance-child/images/' + images[Math.floor(Math.random() * images.length)] + ')'});

	</script>-->

	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> -->
	<script>
// Fix $ to Jquery
function randomFromTo(from, to) {
	return Math.floor(Math.random() * (to - from + 1) + from);
}

function displayRandomJob() {
	var r = randomFromTo(1, jQuery('div.wraper_item').length);
	jQuery('div.wraper_item').hide().eq(r - 1).show();
}

jQuery(document).ready(function() {
	displayRandomJob();
	jQuery('#jobchanger').click(function() {
		displayRandomJob();
	});
});



function randomFromTo(from, to) {
	return Math.floor(Math.random() * (to - from + 1) + from);
}

function displayRandomJob1() {
	var r = randomFromTo(1, jQuery('div.wraper_item2').length);
	jQuery('div.wraper_item2').hide().eq(r - 1).show();
}

jQuery(document).ready(function() {
	displayRandomJob1();
	jQuery('#jobchanger').click(function() {
		displayRandomJob1();
	});
});

</script>

</head>



<body <?php body_class(); ?>>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5QQQGJ"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-5QQQGJ');</script><!-- End Google Tag Manager -->

	<div id="wrapper">

		<!-- navbar fixed -->
		<nav id="navbar-fixed" class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-3 col-md-5 col-sm-5 col-xs-12 navbar-fixed-logo" style="padding-right:0px;">
						<div class="navbar-header">
							<div id="logo"><a rel="home" href="<?php bloginfo('url') ?>"><img class="nopin" alt="Good.Co" src="<?php echo get_stylesheet_directory_uri() ?>/images/GoodCo-Logo-TM-upper-right.png"></a><span class="logo-separator">|</span><span class="tag-line">career insights</span></div>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-7 col-sm-7 hidden-xs" style="padding-left:0px;padding-right:0px;">
						<?php
					// download button			
						class wp_link_only_navwalker extends Walker
						{
							public function walk( $elements, $max_depth )
							{
								$download_btn_class = array('download-button-iOS', 'download-button-Android');
								$list = array ();
								$i = 0;

								foreach ( $elements as $item ) {
									$list[] = "<a href='$item->url' class='".$download_btn_class[$i]." download-button'>$item->title</a>";
									$i++;
								}

								return join( "\n", $list );
							}
						}

						wp_nav_menu(
							array (
								'theme_location' => 'header_download',
								'walker'         => new wp_link_only_navwalker(),
								'items_wrap'     => '<p class="nav-centered">%3$s</p>'
								)
							);
							?>		
						</div>
						<div class="col-lg-3 hidden-md hidden-sm hidden-xs socmed-container">
							<?php
					// sosmed
							require_once(get_stylesheet_directory().'/lib/wp_bootstrap_navwalker.php');

							wp_nav_menu(
								array( 
									'menu' => 'header_socmed', /* menu name */
									'theme_location' => 'header_socmed',
									'menu_class' => 'nav navbar-nav navbar-right',
									)
								)
								?>		
							</div>
						</div>
					</div>
				</nav>


				<div class="container">

					<nav id="mainnav">

						<?php echo g7_menu('mainmenu'); ?>

					</nav>
				</div>

				<?php get_template_part('featured'); ?>
				<div class="container" style="padding-top:0">
					<main>

						<?php g7_breadcrumb(); ?>

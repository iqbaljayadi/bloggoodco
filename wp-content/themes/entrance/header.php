<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53caa39f4ef31fe0"></script>
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">
		<div class="container">
			
			<header id="top">
				<div class="header-icons">
					<div id="g7_social-3" class="widget widget_g7_social"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Header right sidebar') ) : ?>
				<?php endif; ?></div></div>
				<?php echo g7_site_title(); ?>
			</header>

			<nav id="mainnav">
				<?php echo g7_menu('mainmenu'); ?>
			</nav>

			<?php get_template_part('featured'); ?>

			<main>
				<?php g7_breadcrumb(); ?>
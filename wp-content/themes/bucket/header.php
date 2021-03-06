<?php //this is just for the doctype and <head> section
get_template_part('theme-partials/header/head');

$class_name = '';
if(is_page() && get_page_template_slug(wpgrade::lang_original_post_id(get_the_ID())) == 'template-journal.php') {
	$class_name .= ' blog';
}

$schema_org = '';
if (is_single()) {
	$schema_org .= 'itemscope itemtype="http://schema.org/Article"';
} else {
	$schema_org .= 'itemscope itemtype="http://schema.org/WebPage"';
}

if(wpgrade::option('nav_inverse_top') == 1) $class_name .= " nav-inverse-top";
if(wpgrade::option('nav_inverse_main') == 1) $class_name .= " nav-inverse-main";
if(wpgrade::option('layout_boxed') == 1) $class_name .= " layout--boxed";

// woocommerce hotfix
// prevent class product to overwrite our css but keep javascript dependencies
if ( wpgrade::option('enable_woocommerce_support') == 1 && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if (is_product())
		$class_name .= " product";
}

?>

<body <?php body_class($class_name); ?> <?php echo $schema_org ?> >
    <div class="pace">
        <div class="pace-activity"></div>
    </div>    
    <div id="page">
        <nav class="navigation  navigation--mobile">
            <h2 class="accessibility"><?php _e('Primary Mobile Navigation', wpgrade::textdomain()) ?></h2>
            <div class="search-form  push-half--top  push--bottom  soft--bottom">
                <?php get_search_form(); ?>
            </div>            
            <?php 
                wpgrade_main_nav_mobile();
                wpgrade_top_nav_left('nav--stacked', true);
                wpgrade_top_nav_right('nav--stacked', true);
            ?>
        </nav>    
        <div class="wrapper">
            <?php //get the main header section - logo, nav, footer
			get_template_part('theme-partials/header/site', wpgrade::option('header_type')); ?>
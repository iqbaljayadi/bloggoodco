<?php

include_once get_template_directory()  . '/wp-admin/external/wpalchemy/MetaBox.php';

// global styles for the meta boxes
if (is_admin()) add_action('admin_enqueue_scripts', 'metabox_style');

function metabox_style() {
	wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/wp-admin/content-metaboxes/meta.css');
}

/*  ----------------------------------------------------------------------------
    load our custom meta
 */


$td_metabox_product_rating = new WPAlchemy_MetaBox(array(
    'id' => 'td_review',
    'title' => 'Product settings',
    'types' => array('post'),
    'priority' => 'high',
    'template' => get_template_directory() . '/wp-admin/content-metaboxes/product-rating-meta.php',
));

$td_metabox_theme_settings = new WPAlchemy_MetaBox(array(
    'id' => 'td_post_theme_settings',
    'title' => 'Post settings',
    'types' => array('post'),
    'priority' => 'high',
    'template' => get_template_directory() . '/wp-admin/content-metaboxes/theme-settings-meta.php',
));

$td_metabox_vide_meta = new WPAlchemy_MetaBox(array(
    'id' => 'td_post_video',
    'title' => 'Featured Video',
    'types' => array('post'),
    'priority' => 'low',
    'context' => 'side',
    'template' => get_template_directory() . '/wp-admin/content-metaboxes/video-meta.php',
));



$td_metabox_pagebuilder_help = new WPAlchemy_MetaBox(array(
    'id' => 'td_pagebuilder_helppp',
    'title' => 'Page builder help',
    'types' => array('page'),
    'priority' => 'low',
    'view' => WPALCHEMY_VIEW_ALWAYS_OPENED,
    'template' => get_template_directory() . '/wp-admin/content-metaboxes/pagebuilder-help-meta.php',
));

?>
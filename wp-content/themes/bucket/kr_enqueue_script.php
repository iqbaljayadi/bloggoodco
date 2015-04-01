<?php

function kr_scripts() {
	//wp_enqueue_style( 'bucket-fa', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '1.0' );
	wp_enqueue_style( 'bucket-font', get_template_directory_uri().'/theme-content/css/font.css', false, '1.0' );
	wp_enqueue_style( 'bucket-style', get_template_directory_uri().'/theme-content/css/style.css', false, '1.0' );
	
	wp_register_script ( 'bucket-async', get_template_directory_uri().'/theme-content/js/async.js', array('jquery'), '1.0', true );
	wp_register_script ( 'bucket-tabs', get_template_directory_uri().'/theme-content/js/tabs.js', array('jquery'), '1.0', true );
	wp_register_script ( 'bucket-single', get_template_directory_uri().'/theme-content/js/single.js', array('jquery'), '1.0', true );
	wp_register_script ( 'bucket-archive', get_template_directory_uri().'/theme-content/js/archive.js', array('jquery'), '1.0', true );

	if( !is_front_page() && is_single() ) {
		wp_enqueue_script('bucket-single');
	}
	
	if( !is_front_page() && is_archive() ) {
		wp_enqueue_script('bucket-archive');
	}

	wp_enqueue_script('bucket-async');
	wp_enqueue_script('bucket-tabs');
	
}

add_action( 'wp_enqueue_scripts', 'kr_scripts' );

// Remove query string from static files
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

add_action('wp_enqueue_scripts', create_function(null, "wp_dequeue_script('devicepx');"), 20);
?>
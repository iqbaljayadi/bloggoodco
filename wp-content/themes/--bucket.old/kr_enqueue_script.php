<?php

function kr_scripts() {
	wp_enqueue_style( 'bucket-fa', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '1.0' );
	wp_enqueue_style( 'bucket-font', get_template_directory_uri().'/theme-content/css/font.css', false, '1.0' );
	wp_enqueue_style( 'bucket-style', get_template_directory_uri().'/theme-content/css/style.css', false, '1.0' );
	
	wp_register_script ( 'bucket-main-inner', get_template_directory_uri().'/theme-content/js/main-inner.js', array('jquery'), '1.0', true );
	wp_register_script ( 'bucket-main-defer', get_template_directory_uri().'/theme-content/js/main-defer.js', array('jquery'), '1.0', true );

	if( !is_front_page() ) {
		wp_enqueue_script('bucket-main-inner');
	}

	wp_enqueue_script('bucket-main-defer');

}

add_action( 'wp_enqueue_scripts', 'kr_scripts' );


?>
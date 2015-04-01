<?php

	/*
	  Plugin Name: Attention Grabber, by Conversion Insights
	  Plugin URI: http://conversioninsights.net/attention-grabber/
	  Version: 1.4
	  Author: Conversion Insights, Inc.
	  Author URI: http://conversioninsights.net/
	  Description: Attention Grabber is designed to make sure all your visitors know about the things most important to you. Grab your visitor’s attention and get them to sign up for your email list, or tell them about a specific page they should visit.
	  Text Domain: attention-grabber-hello-bar-alternative
	  Domain Path: /languages
	  License: GPL3
	 */

	// Include Sunrise Plugin Framework class
	require_once 'classes/sunrise.class.php';

	// Create plugin instance
	$sunrise = new Sunrise_Plugin_Framework;

	$sunrise->add_settings_page( array(
		'parent' => 'options-general.php',
		'page_title' => 'Attention Grabber',
		'menu_title' => 'Attention Grabber',
		'capability' => 'manage_options',
		'settings_link' => true
	) );

    function plugin_add_settings_link( $links ) {
        $settings_link = '<a href="options-general.php?page=attention-grabber-hello-bar-alternative">Settings</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
    $plugin = plugin_basename( __FILE__ );
    add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

	// Include plugin actions
	require_once 'inc/plugin-actions.php';

	// Make plugin meta translatable
	__( 'Author Name', $sunrise->textdomain );
	__( 'Conversion Insights, Inc.', $sunrise->textdomain );
	__( "The Attention Grabber is designed to make sure all your visitors know about the things most important to you. Grab your visitor’s attention and get them to sign up for your email list, or tell them about a specific page they should visit.", $sunrise->textdomain );
?>
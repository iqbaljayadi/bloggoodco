<?php
/*
 *Plugin Name: Simple Cache and Uncache Script
 *Plugin URI: http://www.tonjoo.com/uncache-script/
 *Description: Uncache your script / css after plugin update.
 *Version: 1
 *Author: Todi
 *Author URI: http://todiadiyatmo.com/
 *License: GPLv2
 * 
*/
defined( 'ABSPATH' ) OR exit;
define('UNCACHE_SCRIPT_DIR',plugin_dir_path( __FILE__ ) );

add_filter( 'script_loader_src', 'tonjoo_scu_script', 100, 1 );
add_filter( 'style_loader_src', 'tonjoo_scu_script', 100, 1 );

function tonjoo_scu_script($src)
{
    preg_match('/ver=([^&#]*)/',$src,$ver);

    $version = get_option('tonjoo_uncache_script_version');

    if(!$version)
    {
       $version = 1;
    }

    $query = parse_url($src, PHP_URL_QUERY);

    // Returns a string if the URL has parameters or NULL if not
    if ($query) {
        $src .= '&scu_ver='.$version;
    } else {
        $src .= '?scu_ver='.$version;
    }

    return $src;
}

function tonjoo_scu_activated()
{
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "activate-plugin_{$plugin}" );

    # Uncomment the following line to see the function in action
    // exit( var_dump( $_GET ) );
}

register_activation_hook(   __FILE__, 'tonjoo_scu_activated' );

function tonjoo_scu_deactivated()
{
    if ( ! current_user_can( 'activate_plugins' ) )
        return;
    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "deactivate-plugin_{$plugin}" );

    # Uncomment the following line to see the function in action
    # exit( var_dump( $_GET ) );
}

register_deactivation_hook( __FILE__, 'tonjoo_scu_deactivated' );

function tonjoo_scu_uninstall()
{
   if ( ! current_user_can( 'activate_plugins' ) )
        return;
    check_admin_referer( 'bulk-plugins' );

    // Important: Check if the file is the one
    // that was registered during the uninstall hook.
    if ( __FILE__ != WP_UNINSTALL_PLUGIN )
        return;

    # Uncomment the following line to see the function in action
    # exit( var_dump( $_GET ) );
}

register_uninstall_hook( __FILE__, 'tonjoo_scu_uninstall' );

include UNCACHE_SCRIPT_DIR.'/theme-options.php';
<?php
/*  
 * This script makes possible publish missed scheduled posts (need to be added to crontab)
 *  *[with no space]/5 * * * * /usr/local/bin/php /Path/to/Docroot/scheduled_posts_cron_fix.php
 */
define('DOING_AJAX', true);
define('WP_USE_THEMES', false);

    $_SERVER = array(
    "HTTP_HOST"     => "good.co/blog",
    "SERVER_NAME"   => "good.co/blog",
    "REQUEST_URI"   => "/scheduled_posts_cron_fix.php",
    "REQUEST_METHOD"=> "GET"
    );

require_once( 'wp-load.php' );
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
ini_set('memory_limit', '3000m');
set_time_limit(0);
global $wpdb;
$timezone_format = _x('Y-m-d G:i:s', 'timezone date format');
$date_now = date_i18n($timezone_format);
$scheduledIDs=$wpdb->get_results("SELECT `ID` FROM`{$wpdb->posts}` WHERE `post_date`>0 AND `post_date`<='$date_now' AND `post_status` = 'future'");
if(!count($scheduledIDs)){
	echo "\n--Script ends--\n";
	return;
}
echo "\n".count($scheduledIDs)." posts found\n";

foreach($scheduledIDs as $scheduledID){
        $scheduledID = intval($scheduledID->ID);
        if(!$scheduledID)
            continue;
        wp_publish_post($scheduledID);
        echo "Post ID #".$scheduledID." Published!\n";
}
 echo "\n--Script ends--\n";
?>

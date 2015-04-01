<?php 

function enqueue_plugin_styles(){

    wp_register_style( 'widgets-style', plugins_url('widgets.css', __FILE__) );

    wp_enqueue_style( 'widgets-style' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_plugin_styles' );

//Putting this in for the future
function wordpress_social_stats_init() {
	
	load_plugin_textdomain('wpcnp', 'wp-content/plugins/wp-social-stats', 'WP Social stats');
}

add_action('phynuchs-update-stats_event','phynuchs_cron_update_stat');

function phynuchs_get_update_time($run){
	$mytime = time();
	if ($run === true)
		$mytime += 24*3600;

	$update_policy = get_option('phynuchs-auto-save-options');
	if ($update_policy === false) {
		$update_policy = array('hour'=>'0', 'minute'=>'0', 'type'=>"everyday");
	}
		
	$update_hour = $update_policy['hour'];
	$update_minute = $update_policy['minute'];
		
	if ($update_policy['type'] == 'everyday') {
		$mytime = mktime($update_hour, $update_minute, 0, 
				 date('m', $mytime), date('d', $mytime), date('Y', $mytime));
	} else if ($update_policy['type'] == 'everyweek') {
		$weekday = $update_policy['weekday'];
		for ($i  = 0; $i < 7; $i++) {
			$mytime = $mytime + $i * 3600 * 24;
			if (strtolower(date('l', $mytime)) == $weekday) {
				break;
			}
		}
		$mytime = mktime($update_hour, $update_minute, 0, 
				 date('m', $mytime), date('d', $mytime), date('Y', $mytime));
	} else {
		$monthday = $update_policy['monthday'];

		if (date('t', $mytime) < $monthday)
			$monthday = date('t', $mytime);

		$mytime = mktime($update_hour, $update_minute, 0, 
				 date('m', $mytime), $montday, date('Y', $mytime));
	}

	return $mytime;
}

function phynuchs_cron_update_stat($run=true){
	if (!(get_option('enable-auto-phynuchs')==='yes'))
		return;
 
	global $social_stats_admin_menu_instance;
	if (!isset($social_stats_admin_menu_instance))
		$social_stats_admin_menu_instance = new WP_Social_Stats_Dashboard();

	$mytime = phynuchs_get_update_time($run);
	if ($run===false){
		if ($mytime < time()) {
			$mytime = phynuchs_get_update_time(true);
		}
	}

	if (!wp_next_scheduled('phynuchs-update-stats_event'))
		wp_schedule_single_event($mytime, 'phynuchs-update-stats_event'); 
	

	if ($run === false)
		return;
	
	$table = new Social_Stats_Table();
	$table->prepare_items();
	$options = $table->get_options();
	$all = $options['all_data'];

	foreach ($all as $index => $id) {
		if ($index == count($all) - 1) {
			$social_stats_admin_menu_instance->phynuchs_update_item($id, '100');
		} else {
			$social_stats_admin_menu_instance->phynuchs_update_item($id);
		}
	}
}

function phynuchs_casual_loop($int=false, $myflag="1"){
	if (!(get_option('enable-auto-phynuchs')==='yes'))
		return;
		
	if ($int===false) {
		$flag = get_option('phynuchs-casual-flag');
		$rflag = $_POST['flag'];
		if ($flag != $rflag)
			die();
	} else {
		$flag = $myflag;
	}
       

	wp_remote_post(admin_url( 'admin-ajax.php' ), 
		       array('method'=>'POST', 
			     'timeout'=>45, 
			     'redirection'=>5, 
			     'httpversion'=>'1.0', 
			     'blocking'=>false, 
			     'headers'=>array(),
			     'body'=>array('action'=>'phynuchs-casual-loop', 'flag'=>$flag),
			     'cookies'=>array()
			     )
		       );
}

?>
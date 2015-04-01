<?php 
//dashboard constructor
class WP_Social_Stats_Dashboard{	
	private $admin_page;
	private $page_main;
	private $page_stats;
	private $facebook_count;
	private $twitter_count;
	private $inshare_count;
	private $gplus_count;
	private $stumble_count;
	private $pinit_count;
	
	const SOCIAL_STATS_ADMIN_PAGE_CAPACIBILITY = 'manage_options';
	
	const SOCIAL_STATS_ADMIN_PAGE_TITLE = 'Social Analytics';
	const SOCIAL_STATS_ADMIN_MENU_TITLE = 'Social Analytics';
	const SOCIAL_STATS_ADMIN_MENU_SLUG = 'wp_social_stats_main';
	const SOCIAL_STATS_ADMIN_MAIN_PAGE_FUNCTION = 'wordpress_social_stats_display_admin_page';
	
	const SOCIAL_STATS_SETTINGS_PAGE_TITLE = 'Social Media Tips';
	const SOCIAL_STATS_SETTINGS_MENU_TITLE = 'Social Media Tips';
	const SOCIAL_STATS_ADMIN_SETTINGS_PAGE_SLUG = 'wp_social_media_tips';
	const SOCIAL_STATS_ADMIN_SETTINGS_PAGE_FUNCTION = 'wordpress_social_stats_display_media_tips_page';

	
	// added by GENLEE Begin
	const SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_TITLE = 'Social Analytics | Settings';
	const SOCIAL_STATS_AUTO_UPDATE_STATE_MENU_TITLE = 'Settings';
	const SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_SLUG = 'auto-update-state-options';
	const SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_FUNCTION = 'wordpress_phynuchs_update_state_page';
	
	private $phynuchs_update_options = "";

	function phynuchs_update_state_page(){
		include SOCIAL_STATISTICS_PLUGIN_DIR."/templates/phynuchs-update-state-option-page.php";
	}

	function phynuchs_social_stats_scripts(){
		wp_register_script( 'phynuchs_script', SOCIAL_STATISTICS_PLUGIN_URL."/scripts/jquery.phynuchs.js");
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'phynuchs_script' );
	}

	function phynuchs_ajax_save_options(){
		$data = stripslashes($_POST['phy-ajax-data']);
		$data = json_decode($data, true);


		if (get_option('phynuchs-auto-save-options') === false)
			add_option('phynuchs-auto-save-options', $data);
		else
			update_option('phynuchs-auto-save-options', $data);


		if ($data['enable']=='yes') {
			$phy_enable = get_option('enable-auto-phynuchs');
			if ($phy_enable === false)
				add_option('enable-auto-phynuchs', 'yes');
			else
				update_option('enable-auto-phynuchs', 'yes');

			$flag = get_option('phynuchs-casual-flag');
			if ($flag === false)
				add_option('phynuchs-casual-flag', 1);
			else
				add_option('phynuchs-casual-flag', $flag *(-1));

			phynuchs_casual_loop(true, get_option('phynuchs-casual-flag'));
		} else {
			$phy_enable = get_option('enable-auto-phynuchs');
			if ($phy_enable === false)
				add_option('enable-auto-phynuchs', 'no');
			else
				update_option('enable-auto-phynuchs', 'no');
		}

		wp_clear_scheduled_hook('phynuchs-update-stats_event');
		phynuchs_cron_update_stat(false);

		die('yes');
	}

	function phynuchs_ajax_get_options(){
		$options = get_option('phynuchs-auto-save-options');
		if ($options === false) {
			
			print json_encode( array('hour'=>'0', 'minute'=>'0', 'type'=>"everyday") );
		}
		else{
			
			print json_encode($options);
		}
		die();
	}

	function phynuchs_update_item($id, $percent = '100'){
		$current_time = time();
		$permalink = get_permalink( $id );
		$ch =curl_init();

		$google_count = $this->google_plus_counter( $permalink , $ch );
		$stumbleupon_count = $this->stumbleupon_counter( $permalink );
		$twitter_count = $this->twitter_counter( $permalink , $ch );
		$facebook_count = $this->facebook_counter( $permalink , $ch );
		$linkedin_count = $this->linkedin_counter( $permalink , $ch );
		$pinterest_count = $this->pinterest_counter( $permalink , $ch );

		curl_close( $ch );

		$total = $google_count  + $facebook_count + $twitter_count + $linkedin_count + $stumbleupon_count + $pinterest_count ;

		add_post_meta( $id, "WSS_DATA_GOOGLE", $google_count , true ) or update_post_meta( $id, "WSS_DATA_GOOGLE", $google_count);
		add_post_meta( $id, "WSS_DATA_FACEBOOK", $facebook_count, true ) or update_post_meta( $id, "WSS_DATA_FACEBOOK", $facebook_count);
		add_post_meta( $id, "WSS_DATA_STUMBLEUPON", $stumbleupon_count, true ) or update_post_meta( $id, "WSS_DATA_STUMBLEUPON", $stumbleupon_count);
		add_post_meta( $id, "WSS_DATA_TWITTER", $twitter_count, true ) or update_post_meta( $id, "WSS_DATA_TWITTER", $twitter_count);
		add_post_meta( $id, "WSS_DATA_LINKEDIN", $linkedin_count, true ) or update_post_meta( $id, "WSS_DATA_LINKEDIN", $linkedin_count);
		add_post_meta( $id, "WSS_DATA_PINTEREST", $pinterest_count, true  ) or update_post_meta( $id, "WSS_DATA_PINTEREST", $pinterest_count );
		add_post_meta( $id, "WSS_DATA_TOTAL", $total, true  ) or update_post_meta( $id, "WSS_DATA_TOTAL", $total );

		$data = array(
			      "google" => $google_count,
			      "facebook" => $facebook_count,
			      "stumbleupon" => $stumbleupon_count,
			      "twitter" => $twitter_count,
			      "linkedin" => $linkedin_count,
			      "pinterest" => $pinterest_count,
			      "total" => $total
			      );

		$serialized_data = serialize( $data );
		add_post_meta( $id, "WSS_DATA", $serialized_data , true ) or update_post_meta( $id, "WSS_DATA", $serialized_data);

		if( $percent == "100" ){
			update_option( 'wp_social_stats_last_update_'.get_post_type( $id ), current_time( 'timestamp', 0 ) );
			$this->log_stats();
		}

		//		die();
	}

	// added by GENLEE End
	
	//constructor
	function __construct(){
		add_option( 'wp_social_stats_show_per_page', 10 );
		add_option( 'wp_social_stats_show', 'post' );
		add_option( 'wp_social_stats_cat_id', '-1' );
		add_option( 'wp_social_stats_show_date', '0' );
		add_action( 'admin_init', array( &$this, 'wordpress_social_stats_init' ) );
		register_activation_hook( SOCIAL_STATISTICS_PLUGIN_FILE , array("WP_Social_Stats_Dashboard","log_activation") );
		register_deactivation_hook( SOCIAL_STATISTICS_PLUGIN_FILE , array("WP_Social_Stats_Dashboard","log_deactivation") );
	}

	public function log_activation(){

		/*		
		$response = wp_remote_post( SOCIAL_STATISTICS_TRACKING_URL , array(
			'method' => 'POST',
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => false,
			'body' => array( 'site' => get_bloginfo("url"), 'title' => get_bloginfo() , "action" => "social_statistics_tracker" ,"method" => "activate")
		    )
		);
		*/

		/* added by GenLEE Begin*/
		phynuchs_cron_update_stat(false);
		/* added by GenLEE End */
	}

	public function log_deactivation(){
		/*
		$response = wp_remote_post( SOCIAL_STATISTICS_TRACKING_URL , array(
			'method' => 'POST',
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => false,
			'body' => array( 'site' => get_bloginfo("url"), 'title' => get_bloginfo() , "action" => "social_statistics_tracker" ,"method" => "deactivate")
		    )
		);
		*/

		/* added by GenLEE Begin*/
		wp_clear_scheduled_hook('phynuchs-update-stats_event');
		/* added by GenLEE End */
	}

	function log_stats(){

		$twitter = 0;
		$google = 0;
		$facebook = 0;
		$pinterest = 0;
		$linkedin = 0;
		$stumbleupon = 0;
		$total = 0;

		$entries = get_posts( array(
			"numposts" => -1 ,
			"posts_per_page" => -1,
			"post_type" => array("post","page")
		) );

		//echo count( $entries );

		// The Loop
		foreach ( $entries as $entry ) :

			$count_data = get_post_meta( $entry->ID, "WSS_DATA", true);

			if( $count_data ){

				$count_data  = unserialize( $count_data );

				foreach( $count_data as $key=>$value ){

					$$key += $value;
				}
			}

		endforeach;
		/*
		$response = wp_remote_post( SOCIAL_STATISTICS_TRACKING_URL , array(
			'method' => 'POST',
			'timeout' => 15,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'body' => array( 
				'site' => get_bloginfo("url"), 
				'title' => get_bloginfo() , 
				"action" => "social_statistics_tracker" ,
				"method" => "report",
				'twitter' => $twitter,	
				'google' => $google,	
				'facebook' => $facebook,	
				'pinterest' => $pinterest,	
				'linkedin' => $linkedin,	
				'stumbleupon' => $stumbleupon,	
				'total' => $total)
		    )
		);
		*/

	}

	function signup(){

		/*
		$response = wp_remote_post( SOCIAL_STATISTICS_TRACKING_URL , array(
			'method' => 'POST',
			'timeout' => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'body' => array( 
				"action" => "social_statistics_tracker" ,
				"method" => "signup",
				"email" => $_POST["email"],
				"name" => $_POST["name"]
				)
		    )
		);
		*/

		//print_r($response);

		die();

	}
	
	//php4 constructor
	function WP_Social_Stats_Dashboard(){    
		$this->__construct();
	}	
	
	//adding plugin menus
	function add_menus(){
		$this->page_main = add_menu_page( self::SOCIAL_STATS_ADMIN_PAGE_TITLE, self::SOCIAL_STATS_ADMIN_MENU_TITLE, self::SOCIAL_STATS_ADMIN_PAGE_CAPACIBILITY, self::SOCIAL_STATS_ADMIN_MENU_SLUG, self::SOCIAL_STATS_ADMIN_MAIN_PAGE_FUNCTION, SOCIAL_STATISTICS_PLUGIN_URL . '/icon/Favicon-16-px.png' );
		add_submenu_page( self::SOCIAL_STATS_ADMIN_MENU_SLUG, self::SOCIAL_STATS_ADMIN_PAGE_TITLE . " | Dashboard", "Dashboard", self::SOCIAL_STATS_ADMIN_PAGE_CAPACIBILITY, self::SOCIAL_STATS_ADMIN_MENU_SLUG, self::SOCIAL_STATS_ADMIN_MAIN_PAGE_FUNCTION );

		// $this->page_stats = add_submenu_page( self::SOCIAL_STATS_ADMIN_MENU_SLUG, self::SOCIAL_STATS_SETTINGS_PAGE_TITLE, self::SOCIAL_STATS_SETTINGS_MENU_TITLE, self::SOCIAL_STATS_ADMIN_PAGE_CAPACIBILITY, self::SOCIAL_STATS_ADMIN_SETTINGS_PAGE_SLUG, self::SOCIAL_STATS_ADMIN_SETTINGS_PAGE_FUNCTION );

		// added by GENLEE Begin

		$this->phynuchs_update_options = add_submenu_page( self::SOCIAL_STATS_ADMIN_MENU_SLUG, self::SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_TITLE, self::SOCIAL_STATS_AUTO_UPDATE_STATE_MENU_TITLE, self::SOCIAL_STATS_ADMIN_PAGE_CAPACIBILITY, self::SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_SLUG, self::SOCIAL_STATS_AUTO_UPDATE_STATE_PAGE_FUNCTION );
		add_action('admin_print_scripts-' . $this->phynuchs_update_options, 
			   array( &$this, 'phynuchs_social_stats_scripts' ) );

		// added by GENLEE End

		add_action('admin_print_scripts-' . $this->page_main, array( &$this, 'wordpress_social_stats_scripts' ) );
		// add_action('admin_print_scripts-' . $this->page_stats, array( &$this, 'wordpress_social_stats_scripts' ) );
	}

	public function _ago($tm,$rcs = 0) {
	   $cur_tm = current_time( "timestamp" , 0 ); $dif = $cur_tm-$tm;
	   $pds = array('second','minute','hour','day','week','month','year','decade');
	   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

	   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
	   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
	   return $x;
	}
	
	function wordpress_social_stats_init(){

		wp_register_script( 'wss_progressbar', SOCIAL_STATISTICS_PLUGIN_URL."/scripts/jquery.progressbar.js",array("jquery") );

		wp_register_script( 'wss_main', SOCIAL_STATISTICS_PLUGIN_URL."/scripts/jquery.main.js",array("jquery","wss_progressbar") );

		wp_localize_script( 'wss_main', 'wss_main', array(
			"ajaxurl" => admin_url("admin-ajax.php") ,
			"pluginurl" => SOCIAL_STATISTICS_PLUGIN_URL
		) );

		wp_register_script( 'pinterest', 'http://assets.pinterest.com/js/pinit.js' );

		wp_register_script( 'twitter', 'http://platform.twitter.com/widgets.js' );

		wp_register_script( 'linkedin', 'http://platform.linkedin.com/in.js' );

		wp_register_script( 'plusone', 'http://apis.google.com/js/plusone.js' );

		wp_enqueue_style( "wss" , SOCIAL_STATISTICS_PLUGIN_URL."/style.css" );

        add_action('wp_ajax_wss_refresh', array($this,"wordpress_social_stats_refresh"));
        add_action('wp_ajax_wss_update_stats', array($this,"wordpress_social_stats_update"));
        add_action('wp_ajax_wss_stats_log', array($this,"log_stats"));
        add_action('wp_ajax_wss_signup', array($this,"signup"));

	// added by GeNLEE Begin
	add_action('wp_ajax_save-auto-update-stat-options', array($this,"phynuchs_ajax_save_options"));
	add_action('wp_ajax_get-auto-update-stat-options', array($this,"phynuchs_ajax_get_options"));
	// added by GenLEE End
	}
	
	function wordpress_social_stats_scripts(){
		wp_enqueue_script( 'twitter' );
		wp_enqueue_script( 'plusone' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wss_progressbar' );
		wp_enqueue_script( 'wss_main' );
	}

	function wordpress_social_stats_refresh(){

		$this->admin_page();

		die();
	}

	function wordpress_social_stats_update(){

		$id = (int)$_POST['id'];

		$current_time = time();

		$permalink = get_permalink( $id );

		$ch =curl_init();

	    $google_count = $this->google_plus_counter( $permalink , $ch );

	    $stumbleupon_count = $this->stumbleupon_counter( $permalink );

	    $twitter_count = $this->twitter_counter( $permalink , $ch );

	    $facebook_count = $this->facebook_counter( $permalink , $ch );

	    $linkedin_count = $this->linkedin_counter( $permalink , $ch );

	    $pinterest_count = $this->pinterest_counter( $permalink , $ch );

	    curl_close( $ch );

	    $total = $google_count  + $facebook_count + $twitter_count + $linkedin_count + $stumbleupon_count + $pinterest_count ;

	    add_post_meta( $id, "WSS_DATA_GOOGLE", $google_count , true ) or update_post_meta( $id, "WSS_DATA_GOOGLE", $google_count);
		add_post_meta( $id, "WSS_DATA_FACEBOOK", $facebook_count, true ) or update_post_meta( $id, "WSS_DATA_FACEBOOK", $facebook_count);
		add_post_meta( $id, "WSS_DATA_STUMBLEUPON", $stumbleupon_count, true ) or update_post_meta( $id, "WSS_DATA_STUMBLEUPON", $stumbleupon_count);
		add_post_meta( $id, "WSS_DATA_TWITTER", $twitter_count, true ) or update_post_meta( $id, "WSS_DATA_TWITTER", $twitter_count);
		add_post_meta( $id, "WSS_DATA_LINKEDIN", $linkedin_count, true ) or update_post_meta( $id, "WSS_DATA_LINKEDIN", $linkedin_count);
		add_post_meta( $id, "WSS_DATA_PINTEREST", $pinterest_count, true  ) or update_post_meta( $id, "WSS_DATA_PINTEREST", $pinterest_count );
		add_post_meta( $id, "WSS_DATA_TOTAL", $total, true  ) or update_post_meta( $id, "WSS_DATA_TOTAL", $total );

		$data = array(
			"google" => $google_count,
			"facebook" => $facebook_count,
			"stumbleupon" => $stumbleupon_count,
			"twitter" => $twitter_count,
			"linkedin" => $linkedin_count,
			"pinterest" => $pinterest_count,
			"total" => $total
		);

		$serialized_data = serialize( $data );

		add_post_meta( $id, "WSS_DATA", $serialized_data , true ) or update_post_meta( $id, "WSS_DATA", $serialized_data);

		if( $_POST["percent"] == "100" ){
			if (isset($_POST["all"]) && $_POST["all"] == "yes" ){

				update_option( 'wp_social_stats_last_update_'.get_post_type( $id ), current_time( 'timestamp', 0 ) );
			}
			$this->log_stats();

		}

	    die();
	}
	
	//main plugin page
	function admin_page(){

		global $wpdb;

		global $wp_locale;

	    $table = new Social_Stats_Table();

	    $table->prepare_items();

	    $options = $table->get_options();

		$category_dropdown = "";

		if ( 'post' == $options["post_type"] ) {
			$dropdown = array( 'show_option_none' => __('All Categories'), 'hide_empty' => 0, 'hierarchical' => 1,'show_count' => 0, 'orderby' => 'name', 'selected' => $options["category"], 'echo' => 0, 'name' => 'cat', 'id' => 'categories' );
			$category_dropdown = wp_dropdown_categories($dropdown);
		} 

		$date_options = "";

		$date_query = $wpdb->prepare( "SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM $wpdb->posts WHERE post_type = %s ORDER BY post_date DESC", $options["post_type"] );
		
		$date_result = $wpdb->get_results( $date_query );

		foreach( $date_result as $date ):

			if ( $date->yyear == 0 ) continue;
			
			$date->mmonth = zeroise( $date->mmonth, 2 );

			$date_options .= "<option ".( $date->yyear . $date->mmonth == $options["show_date"] ? " selected='selected'" : "" )." value='".esc_attr("$date->yyear$date->mmonth")."'>".$wp_locale->get_month($date->mmonth) . " ".$date->yyear."</option>";
			
		 endforeach;

		$last_update = get_option("wp_social_stats_last_update_".$options["post_type"],"n/a");

		include SOCIAL_STATISTICS_PLUGIN_DIR."/templates/admin-page.php";
	}
	
	//'Social Media Tips' page
	function social_media_tips_page(){

		include SOCIAL_STATISTICS_PLUGIN_DIR."/templates/social-media-tips-page.php";
		
	}
	
	//feeds from our blog
	function wp_social_stats_get_feeds(){
		if ( file_exists(ABSPATH . WPINC . '/feed.php') ) {
			@require_once (ABSPATH . WPINC . '/feed.php');
		} else {
			die (__('Error in file: ' . __FILE__ . ' on line: ' . __LINE__ . '.<br />The Wordpress file "feed.php" could not be included.'));
		}

		$rss = fetch_feed('http://www.thewebcitizen.com/feed/');

		$items = $rss->get_items(0, 5);

		foreach( $items as $item ){
			$feeds.='&nbsp&nbsp<a href="'.$item->get_permalink.'">'.$item->get_title().'</a><br/>';
			$feeds.= '&nbsp&nbspPosted: <span>'.$item->get_date('j F Y | g:i a').'</span><br/><br/>';
		}		
		return $feeds;
	}
	
	//get google plus count result/cUrl
	function google_plus_counter( $url ,$existing_ch = false){		
		
 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$url = "https://plusone.google.com/u/0/_/+1/fastbutton?url=".urlencode($url)."&count=true";

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 3,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 1,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);

		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);

		if(  $existing_ch === false )
			curl_close($ch);

		if ($errmsg != '' || $err != '') {
		//print_r($errmsg);
		//print_r($errmsg);
			return 0;
		}
		else {
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			@$dom->loadHTML($content);
			$domxpath = new DOMXPath($dom);
			$newDom = new DOMDocument;
			$newDom->formatOutput = true;

			$filtered = $domxpath->query("//div[@id='aggregateCount']");

			if( count( $filtered ) == 0 ){
				return 0;
			}

			return (int)$filtered->item(0)->nodeValue;
		}

		return 0;
	
	}
    
	//get stumbleupon count result/cUrl
	function stumbleupon_counter( $url ,$existing_ch = false ){
		
		$url = "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=".$url;
 	
 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 3,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 1,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);
		
		$responseJSON = curl_exec($ch);

		if(  $existing_ch === false )
			curl_close($ch);

		$response = json_decode( $responseJSON, true );
		
		if( !isset( $response['result'] ) || !isset( $response['result']['views']) ){
			return 0;
		}

		return (int)$response['result']['views'];
	}

	//get twitter count result/cUrl
	function twitter_counter( $url , $existing_ch = false){

		$url = "http://urls.api.twitter.com/1/urls/count.json?url=".urlencode(preg_replace("#https?\:\/\/#","",$url));

 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 3,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 1,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);

		$responseJSON = curl_exec($ch);

		if(  $existing_ch === false )
			curl_close($ch);
 	
 		if( empty( $responseJSON ) ) {
 			return 0;
 		}

		$response = @json_decode( $responseJSON, true );

		if( empty($response) || !isset( $response["count"] ) ){
			return 0;
		}

		return (int)$response['count'];
	}

	//get facebook count result/cUrl
	function facebook_counter( $url , $existing_ch = false){

		$url = "https://api.facebook.com/method/fql.query?query=SELECT%20total_count%20FROM%20link_stat%20WHERE%20url=%20\"".$url."\"";

 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 3,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 1,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);

		$responseXML = curl_exec($ch);

		if(  $existing_ch === false )
			curl_close($ch);

		if( empty( $responseXML ) ){
			return 0;
		}

		$response = @simplexml_load_string( $responseXML );

		if( !isset( $response->link_stat ) ){
			return 0;
		}

		return (int)$response->link_stat->total_count;

	}

	//get linkedin count result/cUrl
	function linkedin_counter( $url , $existing_ch = false ){

		$url = "http://www.linkedin.com/countserv/count/share?url=".$url."&lang=en_US&callback=?";
		
 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 3,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 1,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);

		$responseJSON = curl_exec($ch);

		if(  $existing_ch === false )
			curl_close($ch);
 
		if( empty( $responseJSON ) ){
			return 0;
		}

 		$responseJSON = preg_replace("#(^\?\()|(\);$)#","",trim($responseJSON));

		$response = @json_decode( $responseJSON, true );

		if( !isset( $response['count'] )){
			return 0;
		}

		return (int)$response['count'] ;
	}


	function pinterest_counter($url, $existing_ch = false) {
		$url = empty($url) ? get_permalink() : $url;
		$json_string = file_get_contents( 'http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.$url);
		$raw_json = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $json_string);
		$json = json_decode($raw_json, true);
	   
		return intval( $json['count'] );
	}
/*
	function pinterest_counter( $url , $existing_ch = false ){

		$url = "http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url=".$url;

 		if( $existing_ch === false )
			$ch = curl_init();
		else {
			$ch = $existing_ch;
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => true,	 // return web page
			CURLOPT_HEADER	 => false,	// don't return headers
			CURLOPT_FOLLOWLOCATION => true,	 // follow redirects
			CURLOPT_ENCODING	 => "",	 // handle all encodings
			CURLOPT_USERAGENT	 => 'spider', // who am i
			CURLOPT_AUTOREFERER	=> true,	 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 5,	 // timeout on connect
			CURLOPT_TIMEOUT	 => 10,	 // timeout on response
			CURLOPT_MAXREDIRS	 => 3,	 // stop after 10 redirects
			CURLOPT_URL	 => $url,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => false
		);

		curl_setopt_array($ch, $options);

		$responseJSON = curl_exec($ch);

		if(  $existing_ch === false )
			curl_close($ch);
 
		if( empty( $responseJSON ) ){
			return 0;
		}

 		$responseJSON = preg_replace("#(^\?\()|(\)$)#","",trim($responseJSON));

		$response = @json_decode( $responseJSON, true );

		if( !isset( $response['count'] )){
			return 0;
		}

		return (int)$response['count'];
	}*/


	//update db options
	function wp_social_stats_update_admin_options(){
		update_option( 'wp_social_stats_show_per_page', $_POST['wp_social_stats_show_per_page'] );
		update_option( 'wp_social_stats_show', $_POST['wp_social_stats_show'] );
		update_option( 'wp_social_stats_cat_id', $_POST['wp_social_stats_cat_id'] );
		update_option( 'wp_social_stats_show_date', $_POST['wp_social_stats_show_date'] );
		update_option( 'wp_social_stats_expiry', $_POST['wp_social_stats_expiry'] );
		wp_redirect( admin_url("admin.php?page=wp_social_stats_main") );
		exit;
	}
}

?>

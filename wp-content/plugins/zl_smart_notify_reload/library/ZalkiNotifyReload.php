<?php
class ZalkiNotifyReload{
	public $version = '2.2.2';
	public $option_gen_name = 'zl_notify_reload_gen';

	function __construct(){
		$this->create_table();
		add_shortcode('zl_notify_reload', array( $this, 'build_shortcode' ));
		add_shortcode('zl_custom_notify', array( $this, 'build_custom' ));
		add_action('wp_enqueue_scripts', array( $this, 'notify_load_scripts' ));
		// ADD IN FOOTER
		add_action('wp_footer', array( $this, 'send_audio' ));
		add_action('wp_footer', array( $this, 'send_overlay' ));
		add_action('wp_footer', array( $this, 'send_notify' ));

		if(is_admin()){
		add_action('admin_menu', array( $this, 'add_admin_page' ));
		}; // if close
	} // construct close

/********************
* PROTECT
********************/
	function protect($form){
		if (function_exists('current_user_can') && !current_user_can('manage_options') )
			die ( _e('Hacker?', 'zalki_notify_reload') );

		if (function_exists('check_admin_referer') ){
				check_admin_referer($form);
			}
	} // protect close

	function protect_field($form){
		if (function_exists ('wp_nonce_field') ){
			wp_nonce_field($form);
		};
	} // protect_field close
/********************
* DATABASE
********************/
	function create_table(){

		// general settings
		$general = array(
						'version'			=> $this->version,
						'vertical'			=> 'top',
						'v_margin'			=> '30px',
						'horizontal'		=> 'right',
						'h_margin'			=> '20px',
						'sound'				=> 'on',
						'over_bg'			=> '#000000',
						'over_opacity'		=> '0.5'
						);

		if( !get_option( $this->option_gen_name ) ){
			add_option($this->option_gen_name, $general );
		} // end if

		global $wpdb;

	$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";

	// if table exist, dont create
	if($wpdb->get_var("show tables like '$zl_notify_reloaddb_name'") != $zl_notify_reloaddb_name) {
		 $sql = "CREATE TABLE " . $zl_notify_reloaddb_name . "(
					id bigint(20) NOT NULL AUTO_INCREMENT,
					settings longtext NOT NULL,
					title longtext NOT NULL,
					main longtext NOT NULL,
					hidden longtext NOT NULL,
					UNIQUE KEY  id (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);


 	}// if close
	} // create table close

	function save_rows(){
		// default settings
		$settings = array(		
						'wrap_width' 			=> '300px',
						'box_width' 			=> '70%',
						'btn_faid'				=> '0.5', //
						'head_height'			=> '40px',
						'head_bg' 				=> '#6DBCDB',
						'head_icon' 			=> plugin_dir_url(__FILE__).'img/mail.png',
						'title_font_size' 		=> '18px',
						'title_color' 			=> '#ffffff',
						'title_weight' 			=> 'bold',
						'cm_color' 				=> '#C1DDFF',
						'cm_font_size' 			=> '18px',
						'toggle_height' 		=> '40px',
						'toggle_bg' 			=> '#4F889E',
						'toggle_color' 			=> '#ffffff',
						'toggle_font_size' 		=> '16px',
						'body_bg' 				=> '#ffffff',
						'content_padding' 		=> '10px',
						'only_one' 				=> 'off',
						'toggle_mode' 			=> 'off',
						'show_now' 				=> 'off',
						'show_when' 			=> 'now',
						'timer_open_time' 		=> '2000',
						'close_timer' 			=> 'off',
						'timer_close_time' 		=> '5000',
						'scrolling' 			=> 'off',
						'scroll_coor' 			=> '200',
						'show_one' 				=> 'off',
						'expires_cookie' 		=> '1',
						'show_where' 			=> 'homepage',
						'hide_menu' 			=> 'off',
						//2.1
						'too_long' 				=> 'off',
						'too_long_height' 		=> '400px'

								);
		


		$settings = serialize($settings);
		// $items = serialize($items);

		// save this array to db
		$zl_array_data = array(
								'settings' 		=> $settings,
								'title' 		=> 'Your Title',
								'main' 			=> 'Main Content',
								'hidden' 		=> 'Hidden Content'
								);
		global $wpdb;
		$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";
		$wpdb->insert($zl_notify_reloaddb_name,$zl_array_data);
	} // save_rows close

	function get_rows(){
		global $wpdb;
		$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";
		$zl_notify_get_rows = $wpdb->get_results("SELECT id,settings,title,main,hidden FROM $zl_notify_reloaddb_name", ARRAY_A);
		return $zl_notify_get_rows;
	} // get_rows close

	function get_data_rows(){
		global $wpdb;
		$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";
		$zl_notify_get_rows = $wpdb->get_results("SELECT id,settings FROM $zl_notify_reloaddb_name", ARRAY_A);
		return $zl_notify_get_rows;
	} // get_data_rows close

	function update_rows($id,$all_arr,$content_arr){
		global $wpdb;
		$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";
		$zl_notify_get_id = $wpdb->get_row("SELECT settings,title,main,hidden FROM $zl_notify_reloaddb_name WHERE id = $id", ARRAY_A); 

	$zl_arr_data_settings = serialize($all_arr);
	$main = stripslashes( htmlspecialchars($content_arr['main'], ENT_QUOTES, 'UTF-8') );
	$hidden = stripslashes( htmlspecialchars($content_arr['hidden'], ENT_QUOTES, 'UTF-8') );
	$title = stripslashes( htmlspecialchars($content_arr['title'], ENT_QUOTES, 'UTF-8') );

	$zl_array_data = array(
							'settings' 	=> $zl_arr_data_settings,
							'title' 	=> $title,
							'main' 		=> $main,
							'hidden' 	=> $hidden
							);

	$zl_array_data_id = array('id' => $id
							);

	$wpdb->update($zl_notify_reloaddb_name,$zl_array_data,$zl_array_data_id);

	} // update_rows close

	function delete_rows($id){
		global $wpdb;
		$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";
		$wpdb->query("DELETE FROM $zl_notify_reloaddb_name WHERE id = $id");
	} // delete_rows close

/********************
* CREATE NOTIFY
********************/
 	function create_notify($id,$icon,$title,$main,$hidden){
 		?>
		<div style="display:none;" data-notifyrelo="wrapper" data-notifylabel="label#<?php echo $id;?>">
			<div data-notifyrelo="head">
				<div data-notifyrelo="logo">
					<?php if(!empty($icon)){
					echo '<img src="'.$icon.'" alt="logo">';
							}?>
				</div>
				<div data-notifyrelo="title"><?php echo do_shortcode($title)?></div>
				<div data-notifyrelo="panel">
					<div data-notifyrelo="btn-drop-down">
						<i class="fa fa-bars"></i>
					</div>
					<div data-notifyrelo="close">
						<i class="fa fa-times"></i>
					</div>
				</div>
			</div>
			<div data-notifyrelo="body">
				<div data-notifyrelo="toggle-panel">
					<i class="fa fa-arrows-alt" data-notifyrelo="btn-resizefull"></i>
					<i class="fa fa-arrows-v" data-notifyrelo="btn-resizevertical"></i>
				</div>
				<div data-notifyrelo="content">
					<?php echo do_shortcode(stripslashes(html_entity_decode($main, ENT_QUOTES, 'UTF-8')))?>
				</div>
				<div data-notifyrelo="hidden-content">
					<?php echo do_shortcode(stripslashes(html_entity_decode($hidden, ENT_QUOTES, 'UTF-8')))?>
				</div>
			</div>
		</div>	
		<?php
 	} // create_notify close

/********************
* SHOW OPTIONS
********************/
	function show_options(){

/********************
* UPDATE SQL
********************/
		if(isset($_POST['zl_notifyreload_save_btn'])){

	//------------------------------------ PROTECT -----------------------------------------//
	$this->protect('zl_notify_show_notify');
	//------------------------------------ PROTECT END -----------------------------------------//
			$all_arr = array();
			$content_arr = array();

			foreach ($_POST as $item_key => $item_value) {
				if($item_key == '_wpnonce' || $item_key == '_wp_http_referer' || $item_key == 'zl_notifyreload_save_btn') continue;
					if($item_key !== 'title' && $item_key !== 'main' && $item_key !== 'hidden' ){
						$all_arr[$item_key] = trim($item_value);
					}else{
						$content_arr[$item_key] = $item_value;
					} // if close
			} // foreach close

			$zl_notify_id = $_POST['id'];
			$this->update_rows($zl_notify_id,$all_arr,$content_arr);
	} // if post save btn end

/********************
* UPDATE GENERAL SQL
********************/
	if(isset($_POST['zl_notifyreload_gen_save_btn'])){

	//------------------------------------ PROTECT -----------------------------------------//
	$this->protect('zl_notify_show_general');
	//------------------------------------ PROTECT END -----------------------------------------//
			$all_arr2 = array();

			foreach ($_POST as $item_key2 => $item_value2) {
				if($item_key2 == '_wpnonce' || $item_key2 == '_wp_http_referer' || $item_key2 == 'zl_notifyreload_gen_save_btn') continue;
				$all_arr2[$item_key2] = trim($item_value2);
			} // foreach close

			// $this->update_general_rows($all_arr2);
			update_option($this->option_gen_name, $all_arr2 );
	} // if post save btn end

/********************
* DELETE ROWS
********************/
		if(isset($_POST['zl_notifyreload_remove_btn'])){

	//------------------------------------ PROTECT -----------------------------------------//
	$this->protect('zl_notify_show_notify');
	//------------------------------------ PROTECT END -----------------------------------------//

			$zl_notify_id = $_POST['id'];
			$this->delete_rows($zl_notify_id);
	} // if post delete btn end


		$zl_notify_get_rows = $this->get_rows();

		$zl_notify_get_general_rows = get_option( $this->option_gen_name );

		/* GENERAL SETTINGS */
		if(isset($zl_notify_get_rows[0]['id'])){
			
			?>
				<form method='post' action='<?php echo $_SERVER['PHP_SELF']."?page=notify-reload-".$this->version."";?>'>
					<?php
					//------------------------------------ PROTECT -----------------------------------------//
					$this->protect_field('zl_notify_show_general');
					//------------------------------------ PROTECT END -----------------------------------------//
					?>

				
				<ul class="zalki-admin-dash-wrap">
					<li class="zalki-admin-section" style="background-color:#323231;">GENERAL SETTINGS</li>
					
					<li class="zalki-admin-content">

						<!-- VERTICAL -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">VERTICAL</div>
								<input type='radio' value='top' name='vertical' <?php echo checked('top', $zl_notify_get_general_rows['vertical'], false);?>><em class="little_t">top</em>
								<input type='radio' value='bottom' name='vertical' <?php echo checked('bottom', $zl_notify_get_general_rows['vertical'], false);?>><em class="little_t">bottom</em>
						</div> <!-- cell close -->

						<!-- VERTICAL MARGIN -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">VERTICAL MARGIN</div>
								<input type='text' name='v_margin' value='<?php echo $zl_notify_get_general_rows['v_margin']?>'>
						</div> <!-- cell close -->

						<!-- HORIZONTAL -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">HORIZONTAL</div>
								<input type='radio' value='left' name='horizontal' <?php echo checked('left', $zl_notify_get_general_rows['horizontal'], false);?>><em class="little_t">left</em>
								<input type='radio' value='right' name='horizontal' <?php echo checked('right', $zl_notify_get_general_rows['horizontal'], false);?>><em class="little_t">right</em>
						</div> <!-- cell close -->
						
						<!-- HORIZONTAL MARGIN -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">HORIZONTAL MARGIN</div>
								<input type='text' name='h_margin' value='<?php echo $zl_notify_get_general_rows['h_margin']?>'>
						</div> <!-- cell close -->

						<!-- SOUND -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">SOUND</div>
								<input type='radio' value='on' name='sound' <?php echo checked('on', $zl_notify_get_general_rows['sound'], false);?>><em class="little_t">on</em>
								<input type='radio' value='off' name='sound' <?php echo checked('off', $zl_notify_get_general_rows['sound'], false);?>><em class="little_t">off</em>
						</div> <!-- cell close -->

						<!-- OVER BG -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">OVERLAY BACKGROUND COLOR</div>
								<input type='text' name='over_bg' value='<?php echo $zl_notify_get_general_rows['over_bg']?>' data-default-color="<?php echo $zl_notify_get_general_rows['over_bg']; ?>" class="wp-color-picker-field">
						</div> <!-- cell close -->

						<!-- OVER OPACITY -->
						<div class="zalki-options-cell">
							<div class="zalki-options-label">OVERLAY OPACITY</div>
								<select name='over_opacity'>
									<option value='0' <?php echo selected('0', $zl_notify_get_general_rows['over_opacity'], false);?>>0</option>
									<?php 
									$opacity_levels = str_split('0.10.20.30.40.50.60.70.80.9',3);
									foreach ($opacity_levels as $option_three) {
									?>

									<option value='<?php echo $option_three?>' <?php echo selected($option_three, $zl_notify_get_general_rows['over_opacity'], false);?>><?php echo $option_three?></option>

									<?php
									}
									?>
									<option value='1' <?php echo selected('1', $zl_notify_get_general_rows['over_opacity'], false);?>>1</option>
								</select>
						</div> <!-- cell close -->
						
						<div class="zl_clear_fix zalki-options-cell">
							<input type='submit' value='Save Changes' class='button-secondary' name='zl_notifyreload_gen_save_btn' style="margin-right: 20px;">
						</div> <!-- clear_fix close -->
					</li> <!-- content close -->
				</ul>
				</form>
			<?php
		} // if close
		//general settings close

		foreach ($zl_notify_get_rows as $item) {
			$zl_unserialize_settings = unserialize($item['settings']);
			?>

		<ul class="zalki-admin-dash-wrap">
			<li class="zalki-admin-section">NOTIFICATION "<?php echo $item['id']?>"</li>
					
			<li class="zalki-admin-content">

				<form method='post' action='<?php echo $_SERVER['PHP_SELF']."?page=notify-reload-".$this->version."";?>'>
					<?php
					//------------------------------------ PROTECT -----------------------------------------//
						$this->protect_field('zl_notify_show_notify');
					//------------------------------------ PROTECT END -----------------------------------------//
					?>
			
				<ul class="zalki-admin-dash-wrap zalki-dash-children">
					<li class="zalki-admin-section zalki-dash-children" style="background-color:#5BCCAE;">SHORTCODE FOR BUTTON</li>
							
					<li class="zalki-admin-content zalki-dash-children">
						[zl_notify_reload label="<?php echo $item['id']?>"]Button[/zl_notify_reload]
						<div class="zalki-options-label zalki_color">OTHER ATTRIBUTES:</div>
						<div class="zalki-options-label">who="div" or who="button"</div>
						<div class="zalki-options-label">style="color:#fec901;padding:10px;" any css attributes</div>
					</li>
				</ul>

				<!-- TITLE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TITLE</div>
						<input type='text' name='title' value='<?php echo $item['title']?>'>
				</div> <!-- cell close -->

				<!-- MAIN CONTENT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">MAIN CONTENT</div>
						<?php wp_editor( stripslashes(html_entity_decode($item['main'], ENT_QUOTES, 'UTF-8')), 'zlsmartreload'.$item['id'].'', $settings = array(
						'textarea_name' => 'main',
						'tinymce' => 1,
						'textarea_rows' => 20
						) );?>
				</div> <!-- cell close -->

				<!-- HIDDEN CONTENT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">HIDDEN CONTENT</div>
						<textarea rows='15' cols='50' name='hidden'><?php echo stripslashes(html_entity_decode($item['hidden'], ENT_QUOTES, 'UTF-8'))?></textarea>
				</div> <!-- cell close -->

				<!-- WIDTH -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">WIDTH</div>
						<input type='text' name='wrap_width' value='<?php echo $zl_unserialize_settings['wrap_width']?>'>
				</div> <!-- cell close -->

				<!-- BOX WIDTH -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">BOX WIDTH</div>
					<div class="zalki-options-label">Width in lightbox mode</div>
						<input type='text' name='box_width' value='<?php echo $zl_unserialize_settings['box_width']?>'>
				</div> <!-- cell close -->

				<!-- HEAD HEIGHT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">HEAD HEIGHT</div>
						<input type='text' name='head_height' value='<?php echo $zl_unserialize_settings['head_height']?>'>
				</div> <!-- cell close -->

				<!-- HEAD BG -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">HEAD BACKGROUND COLOR</div>
						<input type='text' name='head_bg' value='<?php echo $zl_unserialize_settings['head_bg'];?>' data-default-color="<?php echo $zl_unserialize_settings['head_bg']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- HEAD ICON -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">HEAD LOGO</div>
					<div class="zalki-options-label">Important: don't remove link url to image</div>
					<input id="upload_image<?php echo $item['id'];?>" type="text" name="head_icon" class="zl_reload_icon_upload" value="<?php if(!empty($zl_unserialize_settings['head_icon'])){echo $zl_unserialize_settings['head_icon'];}?>">
					<input id="upload_image_button<?php echo $item['id'];?>" type="button" value="Choose Image" class="zl_reload_upload_button">
					<span id="previewimg<?php echo $item['id'];?>" class='zl_reload_span' style='margin-right: 20px; display:block;'></span>
				</div> <!-- cell close -->


				<!-- TITLE FONT SIZE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TITLE FONT SIZE</div>
						<input type='text' name='title_font_size' value='<?php echo $zl_unserialize_settings['title_font_size']?>'>
				</div> <!-- cell close -->

				<!-- TITLE COLOR -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TITLE COLOR</div>
						<input type='text' name='title_color' value='<?php echo $zl_unserialize_settings['title_color']?>' data-default-color="<?php echo $zl_unserialize_settings['title_color']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- TITLE WEIGHT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TITLE WEIGHT</div>
						<input type='text' name='title_weight' value='<?php echo $zl_unserialize_settings['title_weight']?>'>
				</div> <!-- cell close -->

				<!-- CM COLOR -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">BUTTONS CLOSE & MENU: COLOR</div>
						<input type='text' name='cm_color' value='<?php echo $zl_unserialize_settings['cm_color']?>' data-default-color="<?php echo $zl_unserialize_settings['cm_color']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- CM SIZE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">BUTTONS CLOSE & MENU: SIZE</div>
						<input type='text' name='cm_font_size' value='<?php echo $zl_unserialize_settings['cm_font_size']?>'>
				</div> <!-- cell close -->

				<!-- TOOGLE HEIGHT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOGGLE PANEL: HEIGHT</div>
						<input type='text' name='toggle_height' value='<?php echo $zl_unserialize_settings['toggle_height']?>'>
				</div> <!-- cell close -->

				<!-- TOOGLE BG -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOGGLE PANEL: BACKGROUND COLOR</div>
						<input type='text' name='toggle_bg' value='<?php echo $zl_unserialize_settings['toggle_bg']?>' data-default-color="<?php echo $zl_unserialize_settings['toggle_bg']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- TOOGLE COLOR -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOGGLE PANEL: BUTTONS COLOR</div>
						<input type='text' name='toggle_color' value='<?php echo $zl_unserialize_settings['toggle_color']?>' data-default-color="<?php echo $zl_unserialize_settings['toggle_color']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- TOOGLE FONT SIZE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOGGLE PANEL: BUTTONS SIZE</div>
						<input type='text' name='toggle_font_size' value='<?php echo $zl_unserialize_settings['toggle_font_size']?>'>
				</div> <!-- cell close -->

				<!-- BODY BG -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">CONTAINER BACKGROUND COLOR</div>
						<input type='text' name='body_bg' value='<?php echo $zl_unserialize_settings['body_bg']?>' data-default-color="<?php echo $zl_unserialize_settings['body_bg']; ?>" class="wp-color-picker-field">
				</div> <!-- cell close -->

				<!-- CONTENT PADDING -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">CONTENT PADDING</div>
						<input type='text' name='content_padding' value='<?php echo $zl_unserialize_settings['content_padding']?>'>
				</div> <!-- cell close -->

				<!-- ONLY ONE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">ONLY ONE MODE</div>
					<div class="zalki-options-label">Duplicate notifications when you click on the button</div>
						<input type='radio' value='on' name='only_one' <?php echo checked('on', $zl_unserialize_settings['only_one'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='only_one' <?php echo checked('off', $zl_unserialize_settings['only_one'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- TOGGLE MODE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOGGLE MODE</div>
						<input type='radio' value='on' name='toggle_mode' <?php echo checked('on', $zl_unserialize_settings['toggle_mode'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='toggle_mode' <?php echo checked('off', $zl_unserialize_settings['toggle_mode'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- HIDE MENU -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">HIDE MENU BUTTON</div>
						<input type='radio' value='on' name='hide_menu' <?php echo checked('on', $zl_unserialize_settings['hide_menu'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='hide_menu' <?php echo checked('off', $zl_unserialize_settings['hide_menu'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- SHOW WHERE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">SHOW WHERE</div>
					<div class="zalki-options-label">Where you can show the notifications</div>
					<div class="zalki-options-label">If you want show the notification on the custom page, choose the "custom page" and  use shortcode:</div>
					<ul class="zalki-admin-dash-wrap zalki-dash-children">
					<li class="zalki-admin-section zalki-dash-children" style="background-color:#5BCCAE;">SHORTCODE FOR CUSTOM PAGE</li>
					<li class="zalki-admin-content zalki-dash-children">
						<div class="zalki-options-label"><p class="zl_big_letters">[zl_custom_notify label="<?php echo $item['id']?>"]</p></div>
					</li>
					</ul>
						
						<input type='radio' value='homepage' name='show_where' <?php echo checked('homepage', $zl_unserialize_settings['show_where'], false);?>><em class="little_t">home page</em>
						<input type='radio' value='everywhere' name='show_where' <?php echo checked('everywhere', $zl_unserialize_settings['show_where'], false);?>><em class="little_t">everywhere</em>
						<input type='radio' value='custom_page' name='show_where' <?php echo checked('custom_page', $zl_unserialize_settings['show_where'], false);?>><em class="little_t">custom page</em>
						
				</div> <!-- cell close -->

				<!-- SHOW MODE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">SHOW MODE</div>
					<div class="zalki-options-label">Show notifications without having to press a button</div>
						<input type='radio' value='on' name='show_now' <?php echo checked('on', $zl_unserialize_settings['show_now'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='show_now' <?php echo checked('off', $zl_unserialize_settings['show_now'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- SHOW WHEN -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">SHOW WHEN</div>
						<input type='radio' value='now' name='show_when' <?php echo checked('now', $zl_unserialize_settings['show_when'], false);?>><em class="little_t">now</em>
						<input type='radio' value='timer' name='show_when' <?php echo checked('timer', $zl_unserialize_settings['show_when'], false);?>><em class="little_t">timer</em>
				</div> <!-- cell close -->

				<!-- TIMER OPEN TIME -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TIME</div>
					<div class="zalki-options-label">milliseconds</div>
						<input type='text' name='timer_open_time' value='<?php echo $zl_unserialize_settings['timer_open_time']?>'>
				</div> <!-- cell close -->

				<!-- CLOSE TIMER -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">CLOSE TIMER</div>
						<input type='radio' value='on' name='close_timer' <?php echo checked('on', $zl_unserialize_settings['close_timer'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='close_timer' <?php echo checked('off', $zl_unserialize_settings['close_timer'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- TIMER CLOSE TIME -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TIME</div>
					<div class="zalki-options-label">milliseconds</div>
						<input type='text' name='timer_close_time' value='<?php echo $zl_unserialize_settings['timer_close_time']?>'>
				</div> <!-- cell close -->

				<!-- SCROLLING MODE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">SCROLLING MODE</div>
						<input type='radio' value='on' name='scrolling' <?php echo checked('on', $zl_unserialize_settings['scrolling'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='scrolling' <?php echo checked('off', $zl_unserialize_settings['scrolling'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- SCROLL COOR -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">COORDINATES</div>
						<input type='text' name='scroll_coor' value='<?php echo $zl_unserialize_settings['scroll_coor']?>'>
				</div> <!-- cell close -->

				<!-- TOO LONG MODE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOO LONG MODE</div>
					<div class="zalki-options-label">If your notification window too long, you can use this mode. </div>
						<input type='radio' value='on' name='too_long' <?php echo checked('on', $zl_unserialize_settings['too_long'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='too_long' <?php echo checked('off', $zl_unserialize_settings['too_long'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- TOO LONG HEIGHT -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">TOO LONG HEIGHT</div>
					<div class="zalki-options-label">Height for notification. (scrolling set automatically)</div>
						<input type='text' name='too_long_height' value='<?php echo $zl_unserialize_settings['too_long_height']?>'>
				</div> <!-- cell close -->

				<!-- SHOW ONE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">SHOW ONCE (cookie)</div>
					<div class="zalki-options-label">Show notification once</div>
						<input type='radio' value='on' name='show_one' <?php echo checked('on', $zl_unserialize_settings['show_one'], false);?>><em class="little_t">on</em>
						<input type='radio' value='off' name='show_one' <?php echo checked('off', $zl_unserialize_settings['show_one'], false);?>><em class="little_t">off</em>
				</div> <!-- cell close -->

				<!-- EXPIRIES COOKIE -->
				<div class="zalki-options-cell">
					<div class="zalki-options-h zalki_color">COOKIE EXPIRES</div>
					<div class="zalki-options-label">After how many days the notification to show again ( 0 for session)</div>
						<input type='text' name='expires_cookie' value='<?php echo $zl_unserialize_settings['expires_cookie']?>'>
				</div> <!-- cell close -->


			<div class="zl_clear_fix zalki-options-cell">
				<input type='hidden' name='id' value='<?php echo $item['id']?>'>
				<input type='submit' value='Save Changes' class='button-secondary' name='zl_notifyreload_save_btn' style="margin-right: 20px;">
				<input type='submit' value='Remove' class='button-secondary' name='zl_notifyreload_remove_btn'>
			</div> <!-- clear fix close -->
		
		</li> <!-- content close -->
		</form>
		</ul>

			<?php
		} // foreach close

	} // show_options close

/********************
* CREATE ADMIN PAGE
********************/
	function add_admin_page(){
		$page = add_options_page('Settings | Smart Notify Reload', 'Smart Notification '.$this->version, 'administrator', 'notify-reload-'.$this->version, array( $this, 'create_admin_page' ));
		add_action( 'admin_print_styles-' . $page, array( $this, 'load_admin_scripts' ));

		// REGISTER STYLE AND SCRIPTS
		wp_register_style('zl_notifyreload_admin_theme', plugin_dir_url(__FILE__).'css/notify.reload.admin_style.css');
		wp_register_script('zl_notifyreload_admin_script', plugin_dir_url(__FILE__).'js/notify.reload.admin_scripts.js');
		wp_register_script('zl_notifyreload_admin_script_load', plugin_dir_url(__FILE__).'js/notify.reload.admin_scripts_load.js');
		
	} // add_admin_page_close

	// BUILD ADMIN PAGE
	function create_admin_page(){
		?>
		<?php 
			if(isset($_POST['zl_notifyreload_add_btn'])){
				echo '<div class="zl_create_messages">Notification Created</div>';
			}else if(isset($_POST['zl_notifyreload_remove_btn'])){
				echo '<div class="zl_remove_messages">Notification Removed</div>';
			}else if(isset($_POST['zl_notifyreload_save_btn']) || isset($_POST['zl_notifyreload_gen_save_btn'])){
				echo '<div class="zl_update_messages">Updated</div>';
			}
		?>
		<div class="notify-reload-logo-wrap">
			<div class="notify-reload-logo">SMART NOTIFICATION <?php echo $this->version;?></div>

			<form style="margin-bottom:50px;" method='post' action='<?php echo $_SERVER['PHP_SELF']."?page=notify-reload-".$this->version."";?>'>

	<?php
	//------------------------------------ PROTECT -----------------------------------------//
		$this->protect_field('zl_notifyreload_add_form');
	//------------------------------------ PROTECT END -----------------------------------------//
	?>
				<input id="notify-reload-add" type='submit' value='ADD NOTIFY' class='button-secondary' name='zl_notifyreload_add_btn'>
			</form>

	<?php
	//------------------------------------ PROTECT -----------------------------------------//
		if(isset($_POST['zl_notifyreload_add_btn'])){
			$this->protect('zl_notifyreload_add_form');
	//------------------------------------ PROTECT END -----------------------------------------//
					// ACTION HERE
		$this->save_rows();
		} // if close
		$this->show_options();
	?>
		</div> <!-- notify-reload-wrap close -->
		<?php
	} // create_admin_page close

	function load_admin_scripts(){
		if(is_admin()){
			wp_enqueue_script('jquery');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker-script', plugins_url('js/notify.reload.admin_scripts_load.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_style('zl_notifyreload_admin_theme');
			wp_enqueue_script('zl_notifyreload_admin_script');
			wp_enqueue_script('zl_notifyreload_admin_script_load');
		} // is admin close
	} // close load_admin_style

/********************
* LOAD PLUGIN SCRIPTS
********************/
	function notify_load_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('zl_notifyreload_script_easing', plugin_dir_url(__FILE__).'js/jquery.easing.1.3.js');
		wp_enqueue_script('zl_notifyreload_script_cookie', plugin_dir_url(__FILE__).'js/jquery.cookie.js');
		wp_enqueue_style('zl_notify_reload_styles', plugin_dir_url(__FILE__).'css/smart.notify.reload.css');
		wp_enqueue_style('zl_font_awesome_notify', plugin_dir_url(__FILE__).'css/font-awesome.min.css');
		wp_enqueue_script('zl_notifyreload_script_custom', plugin_dir_url(__FILE__).'js/notify.reload.custom.js');
		wp_enqueue_script('zl_notifyreload_script_base', plugin_dir_url(__FILE__).'js/jquery.smart.notify.reload.js');
		$this->send_data();
	} // mate_load_scripts close

/********************
* SEND DATA
********************/
	function send_data(){
		$zl_notify_get_rows = $this->get_data_rows();
		$count = 0;
		foreach($zl_notify_get_rows as $v) {
	 		$zl_notify_get_rows[$count]['settings'] = unserialize($v['settings']);
	 		// $zl_notify_get_rows[$count]['general'] = unserialize($v['general']);
 			$count++;
		}

		$zl_notify_get_gen = get_option( $this->option_gen_name );

	wp_localize_script( 'zl_notifyreload_script_custom', 'zl_notifyreload_obj_data', $zl_notify_get_rows);
	wp_localize_script( 'zl_notifyreload_script_custom', 'zl_notifyreload_gen_obj_data', $zl_notify_get_gen);
	} // send_data close

/********************
* SEND AUDIO
********************/
	function send_audio(){
		
		$audio = get_option($this->option_gen_name);
		
		if($audio['sound'] === 'on'){
			echo '<audio data-notifyrelo="sound" style="display:none;"><source src="'.plugins_url('sound/3beeps.ogg', __FILE__).'" type="audio/ogg" style="display:none;"><source src="'.plugins_url('sound/3beeps.mp3', __FILE__).'" type="audio/mp3" style="display:none;"></audio>';
		} // if close

	} // send audio close
	
/********************
* SEND OVERLAY
********************/
	function send_overlay(){
		echo '<div data-notifyrelo="main-overlay"></div>';
	} // send overlay close

/********************
* SEND NOTIFY
********************/
	function send_notify(){
		$zl_notify_get_rows = $this->get_rows();

		foreach ($zl_notify_get_rows as $item) {
			$zl_unserialize_settings = unserialize($item['settings']);
			if($zl_unserialize_settings['show_where'] === 'homepage'){
				if(is_front_page()){
					$this->create_notify($item['id'],$zl_unserialize_settings['head_icon'],$item['title'],$item['main'],$item['hidden']);
				} // if close
			}else if($zl_unserialize_settings['show_where'] === 'everywhere'){
				$this->create_notify($item['id'],$zl_unserialize_settings['head_icon'],$item['title'],$item['main'],$item['hidden']);
			} // if homepage close
		
		} // foreach close
	} // send notify close

/********************
* BUILD SHORTCODE
********************/
	function build_shortcode($zl_notify_atts, $zl_notify_content_bb = null){
		$zl_notify_get_rows = $this->get_rows();
		$zl_notify_atts = shortcode_atts(
			array(
			'label' => '',
			'who' => 'button',
			'style' => ''
			), $zl_notify_atts);

		$label = $zl_notify_atts['label'];
		$who = $zl_notify_atts['who'];
		$style = $zl_notify_atts['style'];
		$zl_notify_content_bb = do_shortcode($zl_notify_content_bb);

		if($who === 'button'){
			$output = "<button style='".$style."' data-btnlabel='label#".$label."'>".$zl_notify_content_bb."</button>";
		}else{
			$output = "<div style='".$style."' data-btnlabel='label#".$label."'>".$zl_notify_content_bb."</div>";
		} // if close

		return $output;

	} // build_shortcode close

/********************
* BUILD CUSTOM
********************/
	function build_custom($zl_notify_atts){

		$zl_notify_atts = shortcode_atts(
			array(
			'label' => ''
			), $zl_notify_atts);

		$label = $zl_notify_atts['label'];

		$zl_notify_get_rows = $this->get_rows();

		foreach ($zl_notify_get_rows as $item) {
			$zl_unserialize_settings = unserialize($item['settings']);

			if($item['id'] === $label){
					$output = $this->create_notify($item['id'],$zl_unserialize_settings['head_icon'],$item['title'],$item['main'],$item['hidden']);
			} // if id close
			
		} // foreach close

		return $output;

	} // build_custom close

} // ZalkiNotifyReload close	
?>
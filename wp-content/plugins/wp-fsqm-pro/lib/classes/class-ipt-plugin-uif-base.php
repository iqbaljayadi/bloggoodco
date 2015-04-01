<?php
/**
 * iPanelThemes User Interface for Plugin's Framework
 * Base Class
 *
 * Generates all user interface/form elements
 * It needs to have the ipt-plugin-uif.css and ipt-plugin-uif.js file
 *
 * @depends jQuery, jQueryUI{core, widget, tabs, slider, spinner, dialog, mouse, datepicker, draggable, droppable, sortable, progressbar}
 *
 * @version 1.0.2
 */
if ( !class_exists( 'IPT_Plugin_UIF_Base' ) ) :
	class IPT_Plugin_UIF_Base {
	/**
	 * Store all the instances
	 *
	 * @static
	 * @var array
	 */
	static $instance = array();

	public $text_domain;

	public $version;

	public $static_location;

	public $ui_theme_location;

	/*==========================================================================
	 * FILE DEPENDENCIES
	 *========================================================================*/
	public function enqueue( $static_location, $version, $ignore_css = array(), $ignore_js = array() ) {
		global $wp_locale;
		$datetime_l10n = array(
			'closeText'         => __( 'Done', $this->text_domain ),
			'currentText'       => __( 'Today', $this->text_domain ),
			'tcurrentText' => __( 'Now', $this->text_domain ),
			'monthNames'        => array_values( $wp_locale->month ),
			'monthNamesShort'   => array_values( $wp_locale->month_abbrev ),
			'monthStatus'       => __( 'Show a different month', $this->text_domain ),
			'dayNames'          => array_values( $wp_locale->weekday ),
			'dayNamesShort'     => array_values( $wp_locale->weekday_abbrev ),
			'dayNamesMin'       => array_values( $wp_locale->weekday_initial ),
			// get the start of week from WP general setting
			'firstDay'          => get_option( 'start_of_week' ),
			// is Right to left language? default is false
			'isRTL'             => $wp_locale->is_rtl(),
			'amNames' => array( __( 'AM', $this->text_domain ), __( 'A', $this->text_domain ) ),
			'pmNames' => array( __( 'PM', $this->text_domain ), __( 'P', $this->text_domain ) ),
			/* translators: Change %s to the time suffix. %s is always replaced by an empty string */
			'timeSuffix' => sprintf( _x( '%s', 'timeSuffix', $this->text_domain ), '' ),
			'timeOnlyTitle' => __( 'Choose Time', $this->text_domain ),
			'timeText' => __( 'Time', $this->text_domain ),
			'hourText' => __( 'Hour', $this->text_domain ),
			'minuteText' => __( 'Minute', $this->text_domain ),
			'secondText' => __( 'Second', $this->text_domain ),
			'millisecText' => __( 'Millisecond', $this->text_domain ),
			'microsecText' => __( 'Microsecond', $this->text_domain ),
			'timezoneText' => __( 'Timezone', $this->text_domain ),
		);
		$static_location = trailingslashit( $static_location );
		$this->static_location = $static_location;
		$this->version = $version;
		global $wp_version;
		$ui_theme_location = 'css/jquery.ui.ipt-uif';
		if ( version_compare( $wp_version, '3.6' ) == -1 ) {
			$ui_theme_location .= '.1.9';
		} else {
			$ui_theme_location .= '.1.10';
		}
		$this->ui_theme_location = $ui_theme_location;
		//Styles
		$styles = array(
			'ipt-plugin-uif-jquery-ui' => array( $static_location . $ui_theme_location . '/ipt-uif.min.css', array() ),
			'ipt-plugin-uif-fonts' => array( $static_location . 'fonts/fonts.css', array() ),
		);
		foreach ( $styles as $style_id => $style_prop ) {
			if ( ! in_array( $style_id, $ignore_css ) ) {
				if ( empty( $style_prop ) ) {
					wp_enqueue_style( $style_id );
				} else {
					wp_enqueue_style( $style_id, $style_prop[0], $style_prop[1], $version );
				}
			}
		}

		//Scripts
		$scripts = array(
			'jquery-ui-core' => array(),
			'jquery-ui-widget' => array(),
			'jquery-ui-mouse' => array(),
			'jquery-ui-draggable' => array(),
			'jquery-ui-droppable' => array(),
			'jquery-ui-sortable' => array(),
			'jquery-ui-datepicker' => array(),
			'jquery-ui-dialog' => array(),
			'jquery-ui-tabs' => array(),
			'jquery-ui-slider' => array(),
			'jquery-ui-spinner' => array(),
			'jquery-ui-progressbar' => array(),
			'ipt-plugin-uif-js-dtp' => array( $static_location . 'js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-datepicker' ) ),
			'ipt-plugin-uif-js-pe' => array( $static_location . 'js/jquery.printElement.min.js', array( 'jquery' ) ),
			'ipt-plugin-uif-js-mwheelIntent' => array( $static_location . 'js/mwheelIntent.js', array( 'jquery' ) ),
			'ipt-plugin-uif-js-mousewheel' => array( $static_location . 'js/jquery.mousewheel.js', array( 'jquery' ) ),
		);
		$scripts_localize = array(
			'ipt-plugin-uif-js-dtp' => array(
				'object_name' => 'iptPluginUIFDTPL10n',
				'l10n' => $datetime_l10n,
			),
		);
		foreach ( $scripts as $script_id => $script_prop ) {
			if ( ! in_array( $script_id, $ignore_js ) ) {
				if ( empty( $script_prop ) ) {
					wp_enqueue_script( $script_id );
				} else {
					wp_enqueue_script( $script_id, $script_prop[0], $script_prop[1], $version );
				}
				if ( isset( $scripts_localize[$script_id] ) && is_array( $scripts_localize[$script_id] ) && isset( $scripts_localize[$script_id]['object_name'] ) && isset( $scripts_localize[$script_id]['l10n'] ) ) {
					wp_localize_script( $script_id, $scripts_localize[$script_id]['object_name'], $scripts_localize[$script_id]['l10n'] );
				}
			}
		}
		// wp_enqueue_script( 'jquery-ui-core' );
		// wp_enqueue_script( 'jquery-ui-widget' );
		// wp_enqueue_script( 'jquery-ui-mouse' );
		// wp_enqueue_script( 'jquery-ui-draggable' );
		// wp_enqueue_script( 'jquery-ui-droppable' );
		// wp_enqueue_script( 'jquery-ui-sortable' );
		// wp_enqueue_script( 'jquery-ui-datepicker' );
		// wp_enqueue_script( 'jquery-ui-dialog' );
		// wp_enqueue_script( 'jquery-ui-tabs' );
		// wp_enqueue_script( 'jquery-ui-slider' );
		// wp_enqueue_script( 'jquery-ui-spinner' );
		// wp_enqueue_script( 'jquery-ui-progressbar' );

		// wp_enqueue_script( 'ipt-plugin-uif-js-dtp', $static_location . 'js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-datepicker' ), $version );
		// wp_localize_script( 'ipt-plugin-uif-js-dtp', 'iptPluginUIFDTPL10n', $datetime_l10n );
		// wp_enqueue_script( 'ipt-plugin-uif-js-pe', $static_location . 'js/jquery.printElement.min.js', array( 'jquery' ), $version );
		// wp_enqueue_script( 'ipt-plugin-uif-js-mwheelIntent', $static_location . 'js/mwheelIntent.js', array( 'jquery' ), $version );
		// wp_enqueue_script( 'ipt-plugin-uif-js-mousewheen', $static_location . 'js/jquery.mousewheel.js', array( 'jquery' ), $version );

		do_action( 'ipt_plugin_ui_enqueue', $this );
	}

	/*==========================================================================
	 * IcoMoon Data and File Names
	 *========================================================================*/
	 public function get_icon_image_names() {
		return apply_filters( 'ipt_uif_valid_icons_image', array(
			0xe017 => 'list.png',
			0xe04b => 'tree.png',
			0xe0d4 => 'cloud.png',
			0xe0d5 => 'cloud-download.png',
			0xe0d6 => 'cloud-upload.png',
			0xe0d7 => 'download2.png',
			0xe0d8 => 'upload2.png',
			0xe0db => 'globe.png',
			0xe0dc => 'earth.png',
			0xe0dd => 'link.png',
			0xe045 => 'html5.png',
			0xe176 => 'css3.png',
			0xe196 => 'embed.png',
			0xe195 => 'code.png',
			0xe021 => 'table.png',
			0xe050 => 'checkbox-unchecked.png',
			0xe192 => 'checkbox-checked.png',
			0xe14e => 'checkbox-partial.png',
			0xe191 => 'radio-unchecked.png',
			0xe190 => 'radio-checked.png',
			0xe0d1 => 'switch.png',
			0xe154 => 'bold.png',
			0xe155 => 'underline.png',
			0xe156 => 'italic.png',
			0xe157 => 'strikethrough.png',
			0xe19a => 'paragraph-justify.png',
			0xe19b => 'paragraph-right.png',
			0xe19c => 'paragraph-center.png',
			0xe19d => 'paragraph-left.png',
			0xe198 => 'indent-decrease.png',
			0xe199 => 'indent-increase.png',
			0xe075 => 'support.png',
			0xe09a => 'bubbles2.png',
			0xe09d => 'bubbles4.png',
			0xe011 => 'users.png',
			0xe09f => 'users2.png',
			0xe09c => 'bubbles3.png',
			0xe0a0 => 'user2.png',
			0xe0a1 => 'user3.png',
			0xe054 => 'newspaper.png',
			0xe053 => 'office.png',
			0xe0b9 => 'pie.png',
			0xe0ba => 'stats.png',
			0xe015 => 'bars.png',
			0xe06f => 'qrcode.png',
			0xe06e => 'barcode.png',
			0xe01c => 'scissors.png',
			0xe009 => 'copy2.png',
			0xe066 => 'paste.png',
			0xe187 => 'settings.png',
			0xe119 => 'enter.png',
			0xe11a => 'exit.png',
			0xe184 => 'disk.png',
			0xe0c8 => 'remove2.png',
			0xe01b => 'crop.png',
			0xe186 => 'expand2.png',
			0xe01d => 'console.png',
			0xe071 => 'cart.png',
			0xe00a => 'cart2.png',
			0xe072 => 'coin.png',
			0xe073 => 'credit.png',
			0xe074 => 'calculate.png',
			0xe06c => 'tag.png',
			0xe10e => 'warning.png',
			0xe10f => 'notification.png',
			0xe110 => 'question.png',
			0xe111 => 'info.png',
			0xe112 => 'info2.png',
			0xe113 => 'blocked.png',
			0xe115 => 'checkmark-circle.png',
			0xe002 => 'image.png',
			0xe049 => 'images.png',
			0xe003 => 'headphones.png',
			0xe004 => 'play.png',
			0xe005 => 'camera.png',
			0xe04a => 'camera2.png',
			0xe177 => 'film.png',
			0xe014 => 'equalizer.png',
			0xe11b => 'play2.png',
			0xe11c => 'pause.png',
			0xe11d => 'stop.png',
			0xe11e => 'backward.png',
			0xe11f => 'forward2.png',
			0xe181 => 'music.png',
			0xe12a => 'volume-high.png',
			0xe12b => 'volume-medium.png',
			0xe12c => 'volume-low.png',
			0xe12d => 'volume-mute.png',
			0xe12e => 'volume-mute2.png',
			0xe12f => 'volume-increase.png',
			0xe130 => 'volume-decrease.png',
			0xe078 => 'address-book.png',
			0xe079 => 'notebook.png',
			0xe07a => 'envelop.png',
			0xe07f => 'map.png',
			0xe080 => 'map2.png',
			0xe07e => 'compass.png',
			0xe07c => 'location.png',
			0xe07d => 'location2.png',
			0xe000 => 'home.png',
			0xe051 => 'home2.png',
			0xe052 => 'home3.png',
			0xe082 => 'clock.png',
			0xe083 => 'clock2.png',
			0xe084 => 'alarm.png',
			0xe088 => 'calendar.png',
			0xe089 => 'calendar2.png',
			0xe087 => 'stopwatch.png',
			0xe081 => 'history.png',
			0xe08a => 'print.png',
			0xe08b => 'keyboard.png',
			0xe00b => 'laptop.png',
			0xe08c => 'mobile.png',
			0xe17d => 'screen.png',
			0xe17f => 'tablet.png',
			0xe00c => 'tv.png',
			0xe0b3 => 'wrench.png',
			0xe04c => 'cogs.png',
			0xe0b4 => 'cog.png',
			0xe0b5 => 'hammer.png',
			0xe056 => 'pen.png',
			0xe001 => 'pencil.png',
			0xe0b6 => 'wand.png',
			0xe059 => 'paint-format.png',
			0xe0c5 => 'lab.png',
			0xe0ae => 'key.png',
			0xe0af => 'key2.png',
			0xe0b0 => 'lock.png',
			0xe0b1 => 'lock2.png',
			0xe0b2 => 'unlocked.png',
			0xe14f => 'filter.png',
			0xe150 => 'filter2.png',
			0xe01e => 'share.png',
			0xe023 => 'google-plus.png',
			0xe025 => 'google-plus3.png',
			0xe026 => 'google-drive.png',
			0xe027 => 'facebook.png',
			0xe028 => 'facebook2.png',
			0xe029 => 'instagram.png',
			0xe02a => 'twitter.png',
			0xe02b => 'twitter2.png',
			0xe02c => 'feed2.png',
			0xe02d => 'feed3.png',
			0xe02e => 'youtube.png',
			0xe02f => 'vimeo.png',
			0xe030 => 'vimeo2.png',
			0xe15d => 'picassa.png',
			0xe164 => 'steam.png',
			0xe034 => 'github.png',
			0xe165 => 'github2.png',
			0xe166 => 'github3.png',
			0xe167 => 'github4.png',
			0xe035 => 'wordpress.png',
			0xe03f => 'pinterest.png',
			0xe037 => 'tumblr.png',
			0xe169 => 'tumblr2.png',
			0xe16a => 'yahoo.png',
			0xe03c => 'lastfm.png',
			0xe1ba => 'lastfm2.png',
			0xe1b4 => 'linkedin.png',
			0xe03d => 'stumbleupon.png',
			0xe1b8 => 'stumbleupon2.png',
			0xe168 => 'blogger.png',
			0xe1af => 'blogger2.png',
			0xe03a => 'soundcloud.png',
			0xe16c => 'soundcloud2.png',
			0xe03b => 'reddit.png',
			0xe03e => 'stackoverflow.png',
			0xe170 => 'yelp.png',
			0xe1b0 => 'apple.png',
			0xe1b1 => 'android.png',
			0xe042 => 'paypal.png',
			0xe16b => 'tux.png',
			0xe038 => 'finder.png',
			0xe039 => 'windows.png',
			0xe1b2 => 'windows8.png',
			0xe1b3 => 'skype.png',
			0xe1be => 'chrome.png',
			0xe1bf => 'firefox.png',
			0xe1c0 => 'IE.png',
			0xe1c1 => 'safari.png',
			0xe1c2 => 'opera.png',
			0xe036 => 'joomla.png',
			0xe06a => 'folder.png',
			0xe06b => 'folder-open.png',
			0xe006 => 'file.png',
			0xe17a => 'file4.png',
			0xe172 => 'file-pdf.png',
			0xe173 => 'file-openoffice.png',
			0xe043 => 'file-zip.png',
			0xe174 => 'file-xml.png',
			0xe175 => 'file-css.png',
			0xe1bb => 'file-word.png',
			0xe1bc => 'file-excel.png',
			0xe171 => 'libreoffice.png',
			0xe044 => 'file-powerpoint.png',
			0xe0be => 'mug.png',
			0xe0bf => 'food.png',
			0xe0e8 => 'star.png',
			0xe0e9 => 'star2.png',
			0xe0ea => 'star3.png',
			0xe0cb => 'truck.png',
			0xe0ca => 'airplane.png',
			0xe0eb => 'heart.png',
			0xe0ed => 'heart-broken.png',
			0xe0ee => 'thumbs-up.png',
			0xe0ef => 'thumbs-up2.png',
			0xe065 => 'library.png',
			0xe063 => 'book.png',
			0xe064 => 'books.png',
			0xe0f0 => 'happy.png',
			0xe0f2 => 'smiley.png',
			0xe0f4 => 'tongue.png',
			0xe0f6 => 'sad.png',
			0xe0f8 => 'wink.png',
			0xe0fa => 'grin.png',
			0xe0fc => 'cool.png',
			0xe0fe => 'angry.png',
			0xe100 => 'evil.png',
			0xe102 => 'shocked.png',
			0xe104 => 'confused.png',
			0xe106 => 'neutral.png',
			0xe108 => 'wondering.png',
			0xe0f1 => 'happy2.png',
			0xe0f3 => 'smiley2.png',
			0xe0f5 => 'tongue2.png',
			0xe0f7 => 'sad2.png',
			0xe0f9 => 'wink2.png',
			0xe0fb => 'grin2.png',
			0xe0fd => 'cool2.png',
			0xe0ff => 'angry2.png',
			0xe101 => 'evil2.png',
			0xe103 => 'shocked2.png',
			0xe105 => 'confused2.png',
			0xe107 => 'neutral2.png',
			0xe109 => 'wondering2.png',
			0xe135 => 'arrow-up-left.png',
			0xe136 => 'arrow-up.png',
			0xe137 => 'arrow-up-right.png',
			0xe138 => 'arrow-right.png',
			0xe139 => 'arrow-down-right.png',
			0xe13a => 'arrow-down.png',
			0xe13b => 'arrow-down-left.png',
			0xe13c => 'arrow-left.png',
			0xe145 => 'arrow-up-left3.png',
			0xe146 => 'arrow-up3.png',
			0xe147 => 'arrow-up-right3.png',
			0xe148 => 'arrow-right3.png',
			0xe149 => 'arrow-down-right3.png',
			0xe14a => 'arrow-down3.png',
			0xe14b => 'arrow-down-left3.png',
			0xe14c => 'arrow-left3.png',
		) );
	}

	public function get_icon_image_name( $hex ) {
		$icons = $this->get_icon_image_names();
		if ( isset( $icons[$hex] ) ) {
			return $icons[$hex];
		} else {
			return false;
		}
	}

	public function get_valid_icons() {
		return apply_filters( 'ipt_uif_valid_icons_hex', array(
			//Web Elements
			array(
				'id' => 'web_elements',
				'label' => 'Web Elements',
				'elements' => array(
					0xe017 => 'List', 0xe04b => 'Sitemap', 0xe0d4 => 'Cloud', 0xe0d5 => 'Cloud Download', 0xe0d6 => 'Cloud Upload',
					0xe0d7 => 'Download', 0xe0d8 => 'Upload', 0xe0db => 'WWW', 0xe0dc => 'Globe', 0xe0dd => 'Anchor Link', 0xe045 => 'HTML 5', 0xe176 => 'CSS 3',
					0xe196 => 'Embed', 0xe195 => 'Code', 0xe021 => 'Table',
					0xe050 => 'Checkbox Unchecked', 0xe192 => 'Checkbox Checked', 0xe14e => 'Checkbox Partial',
					0xe191 => 'Radio Unchecked', 0xe190 => 'Radio Checked', 0xe0d1 => 'Toggle',
					0xe154 => 'Bold', 0xe155 => 'Underline', 0xe156 => 'Italic', 0xe157 => 'Strike Through',
					0xe19a => 'Align Justify', 0xe19b => 'Align Right', 0xe19c => 'Align Center', 0xe19d => 'Align Left',
					0xe198 => 'Indent Decrease.png', 0xe199 => 'Indent Increase.png',
				),
			),
			//Business
			array(
				'id' => 'business',
				'label' => 'Business',
				'elements' => array(
					0xe075 => 'Support', 0xe09a => 'Testimonials', 0xe09d => 'Testimonials 2', 0xe011 => 'Members',
					0xe09f => 'Members 2', 0xe09c => 'Comment', 0xe0a0 => 'User', 0xe0a1 => 'Corporate', 0xe054 => 'Visiting Card', 0xe053 => 'Office',
				),
			),
			//Charts and Codes
			array(
				'id' => 'charts',
				'label' => 'Charts and Codes',
				'elements' => array(
					0xe0b9 => 'Pie Chart', 0xe0ba => 'Line Chart', 0xe015 => 'Column Chart', 0xe06f => 'QR Code', 0xe06e => 'Bar Code',
				),
			),
			//User Actions
			array(
				'id' => 'actions',
				'label' => 'User Actions',
				'elements' => array(
					0xe01c => 'Cut', 0xe009 => 'Copy', 0xe066 => 'Paste',
					0xe187 => 'Settings', 0xe119 => 'Enter', 0xe11a => 'Exit', 0xe184 => 'Save', 0xe0c8 => 'Trash',
					0xe01b => 'Crop', 0xe186 => 'Resize', 0xe01d => 'Console'
				),
			),
			//eCommerce
			array(
				'id' => 'ecommerce',
				'label' => 'eCommerce',
				'elements' => array(
					0xe071 => 'Shopping Cart', 0xe00a => 'Shopping Cart 2', 0xe072 => 'USD', 0xe073 => 'Card',
					0xe074 => 'Calculator', 0xe06c => 'Tag',
				),
			),
			//Attentions
			array(
				'id' => 'attentive',
				'label' => 'Attentive',
				'elements' => array(
					0xe10e => 'Warning', 0xe10f => 'Information', 0xe110 => 'Help', 0xe111 => 'Information 2', 0xe112 => 'Information 3',
					0xe113 => 'Not allowed', 0xe115 => 'Allowed',
				),
			),
			//Multimedia
			array(
				'id' => 'multimedia',
				'label' => 'Multimedia',
				'elements' => array(
					0xe002 => 'Image', 0xe049 => 'Gallery',
					0xe003 => 'Headphone', 0xe004 => 'Video Play', 0xe005 => 'Video Recorder',
					0xe04a => 'Camera', 0xe177 => 'Video Play 2',
					0xe014 => 'Equalizer', 0xe11b => 'Play', 0xe11c => 'Pause', 0xe11d => 'Stop', 0xe11e => 'Previous', 0xe11f => 'Next', 0xe181 => 'Music',
					0xe12a => 'Volume High', 0xe12b => 'Volume Medium', 0xe12c => 'Volume Low', 0xe12d => 'Volume Mute', 0xe12e => 'Volume Mute 2', 0xe12f => 'Volume Increase', 0xe130 => 'Volume Decrease',
				),
			),
			//Location & Address
			array(
				'id' => 'location',
				'label' => 'Location and Contact',
				'elements' => array(
					0xe078 => 'Phone Book', 0xe079 => 'Phone Book Empty', 0xe07a => 'Email',
					0xe07f => 'Map', 0xe080 => 'Map 2', 0xe07e => 'Compass', 0xe07c => 'Location Marker',
					0xe07d => 'Location Marker 2', 0xe000 => 'Home', 0xe051 => 'Home 2', 0xe052 => 'Home 3',
				),
			),
			//Date & Time
			array(
				'id' => 'datetime',
				'label' => 'Date and Time',
				'elements' => array(
					0xe082 => 'Clock', 0xe083 => 'Solid Clock', 0xe084 => 'Alarm Clock', 0xe088 => 'Month Calendar', 0xe089 => 'Day Calendar',
					0xe087 => 'Stopwatch', 0xe081 => 'History',
				),
			),
			//Devices
			array(
				'id' => 'devices',
				'label' => 'Devices',
				'elements' => array(
					0xe08a => 'Printer', 0xe08b => 'Keyboard', 0xe00b => 'Laptop', 0xe08c => 'Phone', 0xe17d => 'Desktop', 0xe17f => 'Tablet', 0xe00c => 'Television',
				),
			),
			//Tools
			array(
				'id' => 'tools',
				'label' => 'Tools',
				'elements' => array(
					0xe0b3 => 'Wrench', 0xe04c => 'Cogs', 0xe0b4 => 'Cog',
					0xe0b5 => 'Hammer', 0xe056 => 'Pen', 0xe001 => 'Pencil', 0xe0b6 => 'Wand', 0xe059 => 'Paint Brush',
					0xe0c5 => 'Lab', 0xe0ae => 'Key', 0xe0af => 'Key 2',
					0xe0b0 => 'Lock', 0xe0b1 => 'Lock 2', 0xe0b2 => 'Unlocked',
					0xe14f => 'Filter', 0xe150 => 'Filter 2',
				),
			),
			//Social
			array(
				'id' => 'social',
				'label' => 'Social and Networking',
				'elements' => array(
					0xe01e => 'Share',
					0xe023 => 'Google Plus', 0xe025 => 'Google Plus Solid', 0xe026 => 'Google Drive', 0xe027 => 'Facebook', 0xe028 => 'Facebook Solid',
					0xe029 => 'Instagram', 0xe02a => 'Twitter', 0xe02b => 'Twitter Solid', 0xe02c => 'RSS', 0xe02d => 'RSS Solid', 0xe02e => 'YouTube',
					0xe02f => 'Vimeo', 0xe030 => 'Vimeo Solid', 0xe15d => 'Picasa', 0xe164 => 'Steam',
					0xe034 => 'Github', 0xe165 => 'Github 2', 0xe166 => 'Github 3', 0xe167 => 'Github Text',
					0xe035 => 'WordPress', 0xe03f => 'Pinterest', 0xe037 => 'Tumblr', 0xe169 => 'Tumblr Solid', 0xe16a => 'Yahoo',
					0xe03c => 'Last FM', 0xe1ba => 'Last FM Solid', 0xe1b4 => 'LinkedIN', 0xe03d => 'StumbleUpon', 0xe1b8 => 'StumbleUpon Solid',
					0xe168 => 'Blogger', 0xe1af => 'Blogger Solid', 0xe03a => 'SoundCloud', 0xe16c => 'SoundCloud Solid', 0xe03b => 'Reddit', 0xe03e => 'Stack Overflow', 0xe170 => 'Yelp',
				),
			),
			//Brands
			array(
				'id' => 'brands',
				'label' => 'Brands',
				'elements' => array(
					0xe1b0 => 'Apple', 0xe1b1 => 'Android', 0xe042 => 'PayPal', 0xe16b => 'Linux', 0xe038 => 'Finder',
					0xe039 => 'Windows 7', 0xe1b2 => 'Windows 8', 0xe1b3 => 'Skype',
					0xe1be => 'Chrome', 0xe1bf => 'FireFox', 0xe1c0 => 'Internet Explorer',
					0xe1c1 => 'Safari', 0xe1c2 => 'Opera', 0xe036 => 'Joomla',
				),
			),
			//Documents
			array(
				'id' => 'documents',
				'label' => 'Files & Documents',
				'elements' => array(
					0xe06a => 'Folder Closed', 0xe06b => 'Folder Open', 0xe006 => 'Empty File', 0xe17a => 'Non Empty File',
					0xe172 => 'PDF', 0xe173 => 'Open Office', 0xe043 => 'ZIP', 0xe174 => 'HTML / XML', 0xe175 => 'Source Code / CSS',
					0xe1bb => 'Word Document', 0xe1bc => 'Excel Sheet', 0xe171 => 'Libre Office', 0xe044 => 'PowerPoint',
				),
			),
			//Travel & Living
			array(
				'id' => 'travel',
				'label' => 'Travel and Living',
				'elements' => array(
					0xe0be => 'Coffee', 0xe0bf => 'Knife & Fork',
					0xe0e8 => 'Empty Star', 0xe0e9 => 'Half Star', 0xe0ea => 'Full Star',
					0xe0cb => 'Truck', 0xe0ca => 'Flight', 0xe0eb => 'Heart', 0xe0ed => 'Broken Heart',
					0xe0ee => 'Like', 0xe0ef => 'Dislike',
					0xe065 => 'Library', 0xe063 => 'Book', 0xe064 => 'Books',
				),
			),
			//Emoticons
			array(
				'id' => 'emoticons',
				'label' => 'Emoticons',
				'elements' => array(
					0xe0f0 => 'Happy', 0xe0f2 => 'Smiley', 0xe0f4 => 'Tease', 0xe0f6 => 'Sad', 0xe0f8 => 'Wink',
					0xe0fa => 'Grin', 0xe0fc => 'Cool', 0xe0fe => 'Angry', 0xe100 => 'Evil', 0xe102 => 'Shocked',
					0xe104 => 'Confused', 0xe106 => 'Neutral', 0xe108 => 'Wondering',

					0xe0f1 => 'Happy - 2', 0xe0f3 => 'Smiley - 2', 0xe0f5 => 'Tease - 2', 0xe0f7 => 'Sad - 2', 0xe0f9 => 'Wink - 2',
					0xe0fb => 'Grin - 2', 0xe0fd => 'Cool - 2', 0xe0ff => 'Angry - 2', 0xe101 => 'Evil - 2', 0xe103 => 'Shocked - 2',
					0xe105 => 'Confused - 2', 0xe107 => 'Neutral - 2', 0xe109 => 'Wondering - 2',
				),
			),
			//Arrows
			array(
				'id' => 'arrow',
				'label' => 'Arrows',
				'elements' => array(
					0xe135 => 'Top Left', 0xe136 => 'Top', 0xe137 => 'Top Right', 0xe138 => 'Right', 0xe139 => 'Bottom Right', 0xe13a => 'Bottom', 0xe13b => 'Bottom Left', 0xe13c => 'Left',
					0xe145 => 'Top Left Circular', 0xe146 => 'Top Circular', 0xe147 => 'Top Right Circular', 0xe148 => 'Right Circular', 0xe149 => 'Bottom Right Circular', 0xe14a => 'Bottom Circular', 0xe14b => 'Bottom Left Circular', 0xe14c => 'Left Circular',
				),
			),
		) );
	}

	/*==========================================================================
	 * ICON MENU
	 *========================================================================*/
	public function iconmenu( $items, $alignment = 'center' ) {
?>
<ul class="ipt_uif_ul_menu ipt_uif_align_<?php echo esc_attr( 'center' ); ?>">
	<?php foreach ( $items as $item ) : ?>
	<?php
			$href = '' == $item['url'] ? 'javascript:;' : esc_attr( $item['url'] );
		$text = '' == trim( $item['text'] ) ? '&nbsp;' : $item['text'];
?>
	<li>
		<a<?php if ( $item['icon'] != 'none' ) : ?><?php if ( is_numeric( $item['icon'] ) ) : ?> data-icon="&#x<?php echo dechex( $item['icon'] ) ?>;"<?php else : ?> class="icon-<?php echo esc_attr( $item['icon'] ); ?>"<?php endif; endif; ?> href="<?php echo $href; ?>"><?php echo $text; ?></a>
	</li>
	<?php endforeach; ?>
</ul>
		<?php
	}

	/*==========================================================================
	 * SYSTEM API
	 *========================================================================*/
	/**
	 * Returns an instance object.
	 *
	 * Creates one if not already instantiated.
	 *
	 * @return IPT_Plugin_UIF_Base
	 */
	public static function instance( $text_domain = 'default', $classname = __CLASS__ ) {
		if ( !isset( self::$instance[$classname . $text_domain] ) || !is_array( self::$instance[$classname . $text_domain] ) || empty( self::$instance[$classname . $text_domain] ) ) {
			self::$instance[$classname . $text_domain] = array();
			new $classname( $text_domain, $classname );
		}
		return self::$instance[$classname . $text_domain][count( self::$instance[$classname . $text_domain] ) - 1];
	}

	public function __construct( $text_domain = 'default', $classname = __CLASS__ ) {
		self::$instance[$classname . $text_domain][] = $this;
		$this->text_domain = $text_domain;
	}

	/*==========================================================================
	 * INTERNAL HTML FORM ELEMENTS METHODS
	 * Can also be used publicly
	 *========================================================================*/
	/**
	 * Create a div
	 *
	 * @param mixed   (array|string) $styles The HTML style. Can be a single string when only one div will be produced,
	 * or array in which case the 0th style will be used to create the main div
	 * and other styles will be nested inside as individual divs.
	 * @param mixed   (array|string) $callback The callback function to populate.
	 * @param int     $scroll  The scroll height value in pixels. 0 if no scroll.
	 * @param string  $id      HTML ID
	 * @param array   $classes HTML classes
	 */
	public function div( $styles, $callback, $scroll = 0, $id = '', $classes = array() ) {
		if ( !$this->check_callback( $callback ) ) {
			$this->msg_error( 'Invalid Callback supplied' );
			return;
		}
		if ( !is_array( $classes ) ) {
			$classes = (array) $classes;
		}

		if ( is_array( $styles ) && count( $styles ) > 1 ) {
			$classes = array_merge( $classes, (array) $styles[0] );
		} else {
			$classes[] = (string) $styles;
		}
		$style_attr = '';
		if ( (int) $scroll != 0 ) {
			$style_attr = ' style="max-height: ' . (int) $scroll . 'px; overflow: auto;"';
			$classes[] = 'ipt_uif_scroll';
		}
		$id_attr = '';
		if ( trim( $id ) != '' ) {
			$id_attr = ' id="' . esc_attr( trim( $id ) ) . '"';
		}
?>
<div class="<?php echo implode( ' ', $classes ); ?>"<?php echo $id_attr . $style_attr; ?>>
	<?php if ( is_array( $styles ) && count( $styles ) > 1 ) : ?>
	<?php for ( $i = 1; $i < count( $styles ); $i++ ) : ?>
	<div class="<?php echo implode( ' ', (array) $styles[$i] ); ?>">
	<?php endfor; ?>
	<?php endif; ?>

	<?php call_user_func_array( $callback[0], $callback[1] ); ?>

	<?php if ( is_array( $styles ) && count( $styles ) > 1 ) : ?>
	<?php for ( $i = 1; $i < count( $styles ); $i++ ) : ?>
	</div>
	<?php endfor; ?>
	<?php endif; ?>
</div>
		<?php
	}

	public function clear() {
		echo '<div class="clear"></div>';
	}

	/**
	 * Convert a valid state of HTML form elements to proper attribute="value" pair
	 *
	 * @param string  $state The state of the HTML item
	 * @return string
	 */
	public function convert_state_to_attribute( $state ) {
		$output = '';
		switch ( $state ) {
		case 'disable' :
		case 'disabled' :
			$output = ' disabled="disabled"';
			break;
		case 'readonly' :
		case 'noedit' :
			$output = ' readonly="readonly"';
			break;
		}
		return $output;
	}

	/**
	 * Converts valid size string to proper HTML class value
	 *
	 * @param string  $size Valid size string
	 * @return string
	 */
	public function convert_size_to_class( $size ) {
		$class = '';
		switch ( $size ) {
		case 'regular' :
		case 'medium' :
			$class = 'regular-text';
			break;
		case 'large' :
		case 'big' :
			$class = 'large-text';
			break;
		case 'small' :
		case 'tiny' :
			$class = 'small-text';
			break;
		case 'fit' :
			$class = 'fit-text';
			break;
		default :
			$class = esc_attr( $size );
		}
		return $class;
	}

	/**
	 * Generate Label for an element
	 *
	 * @param string  $name The name of the element
	 * @param type    $text
	 */
	public function generate_label( $name, $text, $id = '', $classes = array() ) {
		if ( !is_array( $classes ) ) {
			$classes = (array) $classes;
		}
		$classes[] = 'ipt_uif_label';
?>
<label class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" for="<?php echo $this->generate_id_from_name( $name, $id ); ?>"><?php echo $text; ?></label>
		<?php
	}

	public function generate_id_from_name( $name, $id = '' ) {
		if ( '' == trim( $id ) ) {
			return esc_attr( str_replace( array( '[', ']' ), array( '_', '' ), trim( $name ) ) );
		} else {
			return esc_attr( trim( $id ) );
		}
	}

	public function convert_data_attributes( $data ) {
		if ( false == $data || !is_array( $data ) || empty( $data ) ) {
			return '';
		}

		$data_attr = '';
		foreach ( $data as $d_key => $d_val ) {
			$data_attr .= ' data-' . esc_attr( $d_key ) . '="' . esc_attr( $d_val ) . '"';
		}

		return $data_attr;
	}

	public function convert_html_attributes( $atts ) {
		if ( false == $atts || ! is_array( $atts ) || empty( $atts ) ) {
			return '';
		}

		$html_atts = '';
		foreach ( $atts as $attr => $val ) {
			$html_atts .= ' ' . $attr . '="' . esc_attr( $val ) . '"';
		}

		return $html_atts;
	}


	public function convert_validation_class( $validation = false ) {
		if ( $validation == false || !is_array( $validation ) || empty( $validation ) ) {
			return '';
		}

		$classes = array();

		//check if required
		if ( true == $validation['required'] ) {
			$classes[] = 'required';
		}

		//check for any custom regex
		if ( isset( $validation['filters'] ) && is_array( $validation['filters'] ) ) {
			if ( isset( $validation['filters']['type'] ) ) {
				if ( 'all' != $validation['filters']['type'] ) {
					$classes[] = 'custom[' . esc_attr( $validation['filters']['type'] ) . ']';
				}
			}

			//check for others
			foreach ( $validation['filters'] as $f_key => $f_val ) {
				if ( 'type' == $f_key ) {
					continue;
				}

				if ( $f_val != '' ) {
					$classes[] = esc_attr( $f_key ) . '[' . esc_attr( $f_val ) . ']';
				}
			}
		}

		if ( isset( $validation['funccall'] ) && is_string( $validation['funccall'] ) ) {
			$classes[] = 'funcCall[' . $validation['funccall'] . ']';
		}


		$added = implode( ',', $classes );

		if ( $added != '' ) {
			return ' check_me validate[' . $added . ']';
		} else {
			return '';
		}
	}

	/**
	 * Get the first image from a string
	 *
	 * @param string  $html
	 * @return mixed string|bool The src value on success or boolean false if no src found
	 */
	public function get_first_image( $html ) {
		$matches = array();
		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $html, $matches );
		if ( !$output ) {
			return false;
		}
		else {
			$src = $matches[1][0];
			return trim( $src );
		}
	}


	/**
	 * Shortens a string to a specified character length.
	 * Also removes incomplete last word, if any
	 *
	 * @param string  $text The main string
	 * @param string  $char Character length
	 * @param string  $cont Continue character(…)
	 * @return string
	 */
	public function shorten_string( $text, $char, $cont = '…' ) {
		$text = strip_tags( strip_shortcodes( $text ) );
		$text = substr( $text, 0, $char ); //First chop the string to the given character length
		if ( substr( $text, 0, strrpos( $text, ' ' ) )!='' ) $text = substr( $text, 0, strrpos( $text, ' ' ) ); //If there exists any space just before the end of the chopped string take upto that portion only.
		//In this way we remove any incomplete word from the paragraph
		$text = $text.$cont; //Add continuation ... sign
		return $text; //Return the value
	}

	/**
	 * Wrap a RAW JS inside <script> tag
	 *
	 * @param String  $string The JS
	 * @return String The wrapped JS to be used under HTMl document
	 */
	public function js_wrap( $string ) {
		return "\n<script type='text/javascript'>\n" . $string . "\n</script>\n";
	}

	/**
	 * Wrap a RAW CSS inside <style> tag
	 *
	 * @param String  $string The CSS
	 * @return String The wrapped CSS to be used under HTMl document
	 */
	public function css_wrap( $string ) {
		return "\n<style type='text/css'>\n" . $string . "\n</style>\n";
	}

	/*==========================================================================
	 * OTHER INTERNAL METHODS
	 *========================================================================*/

	protected function standardize_items( $items ) {
		$new_items = array();
		if ( !is_array( $items ) ) {
			$items = (array) $items;
		}
		foreach ( $items as $i_key => $item ) {
			if ( is_array( $item ) ) {
				if ( isset( $item['value'] ) ) {
					$new_items[] = array(
						'label' => isset( $item['label'] ) ? $item['label'] : ucfirst( $item['value'] ),
						'value' => esc_attr( (string) $item['value'] ),
						'data' => isset( $item['data'] ) ? $item['data'] : array(),
					);
				}
			} elseif ( is_string( $item ) ) {
				if ( is_numeric( $i_key ) ) {
					$new_items[] = array(
						'label' => ucfirst( $item ),
						'value' => esc_attr( (string) $item ),
					);
				} else {
					$new_items[] = array(
						'label' => $item,
						'value' => esc_attr( (string) $i_key ),
					);
				}
			}
		}

		return $new_items;
	}

	public function convert_old_items( $ops, $inner = false ) {
		$items = array();
		foreach ( $ops as $o_key => $op ) {
			if ( !is_array( $op ) ) {
				if ( !$inner ) {
					$items[] = array(
						'label' => ucfirst( $op ),
						'value' => $op,
					);
				} else {
					$items[] = array(
						'label' => $op,
						'value' => $o_key,
					);
				}
			} else {
				$items[] = array(
					'label' => $op['label'],
					'value' => $op['val'],
				);
			}
		}
		return $items;
	}

	/**
	 * Check the validity of the callback function.
	 * Also appends null variable as argument which is passed by default.
	 *
	 * @param mixed   string|array $callback Callback function
	 * @return boolean TRUE if valid callback, FALSE otherwise
	 */
	public function check_callback( &$callback ) {
		//var_dump($callback);
		//can not be callback if not string or array
		if ( !is_array( $callback ) && !is_string( $callback ) ) {
			return false;
		}
		$callback_backup = $callback;
		//Standardize the variable
		if ( is_string( $callback ) ) {
			//Possibility of single function name
			$callback = array( $callback_backup, array() );
		} else if ( is_array( $callback ) ) {
				//Possibility of object,method or array(array(object,method),arguments) or function,argument
				if ( is_array( $callback[0] ) ) {
					//Definitely array(array(object,method),arguments)
					//Just append null arguments if not present
					if ( !isset( $callback[1] ) ) {
						$callback[1] = array();
					} else {
						$callback[1] = (array) $callback[1];
					}
				} else {
					//Can be either object,method or function,argument
					$callback[0] = $callback_backup;
					$callback[1] = array();
				}
			}

		//Final check for arguments
		if ( !is_array( $callback[1] ) ) {
			$callback[1] = (array) $callback[1];
		}

		//Check for validity
		if ( is_string( $callback[0] ) ) {
			if ( function_exists( $callback[0] ) ) {
				return true;
			} else {
				return false;
			}
		} else if ( is_array( $callback[0] ) ) {
				if ( method_exists( $callback[0][0], $callback[0][1] ) ) {
					return true;
				} else {
					return false;
				}
			} else {
			return false;
		}
	}

	/**
	 * stripslashes gpc
	 * Strips Slashes added by magic quotes gpc thingy
	 *
	 * @access protected
	 * @param string  $value
	 */
	protected function stripslashes_gpc( &$value ) {
		$value = stripslashes( $value );
	}

	protected function htmlspecialchar_ify( &$value ) {
		$value = htmlspecialchars( $value );
	}
}
endif;

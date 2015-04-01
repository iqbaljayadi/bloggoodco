<?php
add_action('admin_init', 'wp_insert_support_admin_init');
function wp_insert_support_admin_init() {
	if(isset($_POST['is_showcase_submission']) && ($_POST['is_showcase_submission'] == 'true')) {
		$data = 'site_name='.(string)$_POST['site_name'].'&site_description='.(string)$_POST['site_description'].'&site_category='.(string)$_POST['site_category'].'&site_url='.(string)$_POST['site_url'].'&admin_email='.(string)$_POST['admin_email'];
		try {
			$post_results = wp_insert_httpPost('wp-insert.smartlogix.co.in','80', '/wp-content/plugins/wp-insert-directory/request-handler.php', $data);
			if(($post_results != false) && (strpos($post_results, 'SUBMISSION SUCCESSFUL') !== false)) {
				update_option('wp_insert_showcase_submission', 'PENDING');
			} else {
				echo '<div id="message" class="error">A error occurred while submitting the request.  Please try again later.</div>';
			}
		} catch(Exception $e) {
			echo '<div id="message" class="error">A error occurred while submitting the request.  Please try again later.</div>';
		}
	}
    add_settings_section('wp-insert-support-top', '', 'wp_insert_support_section', 'wp-insert-support');
	add_meta_box('wp_insert_facebook', 'Like Us On Facebook', 'wp_insert_facebook_content', 'wp-insert-support-top', 'advanced', 'high');
	add_meta_box('wp_insert_donate', 'Donate and Support Free Plugins', 'wp_insert_donate_content', 'wp-insert-support-top', 'advanced', 'high');
	add_meta_box('wp_insert_hate_campaign', 'Save Wp-Insert', 'wp_insert_hate_campaign_content', 'wp-insert-support-top', 'advanced', 'high');
	delete_option('wp_insert_showcase_submission');
	if(get_option('wp_insert_showcase_submission') != 'SUBMITTED') {
		add_meta_box('wp_insert_showcase', 'Showcase your Site', 'wp_insert_showcase_content', 'wp-insert-support-bottom', 'advanced', 'high');
	}
}

function wp_insert_support_section() {
	do_meta_boxes('wp-insert-support-top', 'advanced', null);
	echo '<p class="submit"><input type="submit" name="Submit" class="button-primary submit" value="Save Changes" /></p>';
	do_meta_boxes('wp-insert-support-bottom', 'advanced', null);
}

function wp_insert_facebook_content() {
	echo '<a href="https://www.facebook.com/SmartLogix"><img src="'.WP_INSERT_URL.'/includes/common/images/fb_like_btn.png" style="margin-top: 5px;" /></a>';
}

function wp_insert_donate_content() {
	echo '<a href="http://www.wp-insert.smartlogix.co.in/support/"><img src="'.WP_INSERT_URL.'/includes/common/images/donate_btn.png" style="margin-top: 5px;" /></a><br /><small style="display: block; text-align: center;"><a href="http://wordpress.org/extend/plugins/wp-insert/">Rate the plugin in Wordpress Plugin Repository</a></small>';
}

function wp_insert_hate_campaign_content() {
	echo '<p>Some users (most likely sponsored by some premium plugin) are spreading a Hate Campaign against Wp-Insert churning away Forum Posts and Negative reviews about the plugin on different sites.</p>';
	echo '<p>Please help us defend these unscrupulous activities by writing a honest <a href="http://wordpress.org/support/view/plugin-reviews/wp-insert">review</a> about the plugin and <a href="http://wordpress.org/plugins/wp-insert">rating</a> the plugin in the  Plugin Repository.</p>';
	echo '<p>Most of you will think about leaving a rating or visiting the forum only when something goes wrong while thousands are using the plugin satisfactorily which  unfortunately is not Reported OR Documented.</p>';
	echo '<p style="font-weight: bold; color: #FF0000;"">IF YOU FIND THIS PLUGIN USEFUL DO LEAVE A HONEST <a href="http://wordpress.org/plugins/wp-insert">RATING</a> AND <a href="http://wordpress.org/support/view/plugin-reviews/wp-insert">REVIEW</a> IN THE REPOSITORY AND HELP US AGAINST THE MARKETING CAMPAIGN AIMED TO TARNISH A HIGHLY USEFUL, FREE, FEATURE RICH PLUGIN.</p>';
}

function wp_insert_showcase_content() {
	if(get_option('wp_insert_showcase_submission') == 'PENDING') {
		echo '<div id="message" class="updated" style="margin-top: 15px;"><p>Thank you for submitting your site to the Wp-Insert user directory.  You will receive a notification Email when the site is published in the Directory</p></div>';
		update_option('wp_insert_showcase_submission', 'SUBMITTED');
	} else {
		echo '<div id="showcaseForm">';
			echo '<p style="text-align: justify;">Showcase your site in the Wp-Insert User Directory and get a free backlink and targeted visitors.  A screenshot of the site will be automatically generated and the site will appear in the selected category in our <a href="http://www.wp-insert.smartlogix.co.in/directory/">user directory</a> within a couple of hours.</p>';
			echo '<p><label for="site_url">Site URL:</label></br /><input type="text" readonly="readonly" class="widefat" id="site_url" name="site_url" value="'.get_bloginfo('url').'" /></p>';
			echo '<p><label for="site_name">Site Name:</label></br /><input type="text" class="widefat" id="site_name" name="site_name" value="'.get_bloginfo('name').'" /><small>Site Name will be Cropped at 40 Characters</small></p>';
			echo '<p><label for="site_description">Site Description</label></br /><textarea class="widefat" id="site_description" name="site_description" >'.get_bloginfo('description').'</textarea><small>Site Description will be Cropped at 300 Characters</small></p>';
			echo '<p><label for="site_category">Site Category</label></br />';
				echo '<select id="site_category" name="site_category" class="widefat">';
					echo '<option value="529">Accounting & Auditing</option>';
					echo '<option value="530">Advertising & Marketing</option>';
					echo '<option value="531">Antivirus & Malware</option>';
					echo '<option value="532">Apparel</option>';
					echo '<option value="533">Arts & Entertainment</option>';
					echo '<option value="534">Auctions</option>';
					echo '<option value="535">Banking</option>';
					echo '<option value="536">Baseball</option>';
					echo '<option value="537">Blogging Resources & Services</option>';
					echo '<option value="538">Broadcast & Network News</option>';
					echo '<option value="539">Business Plans & Presentations</option>';
					echo '<option value="540">Cartoons</option>';
					echo '<option value="541">Casual Games</option>';
					echo '<option value="542">Celebrities & Entertainment News</option>';
					echo '<option value="543">Classifieds</option>';
					echo '<option value="544">Clip Art & Animated GIFs</option>';
					echo '<option value="545">Computer & Video Games</option>';
					echo '<option value="546">Computer Hardware</option>';
					echo '<option value="547">Consumer Electronics</option>';
					echo '<option value="548">Coupons & Discount Offers</option>';
					echo '<option value="549">Credit Cards</option>';
					echo '<option value="550">Dating & Personals</option>';
					echo '<option value="551">Dictionaries & Encyclopedias</option>';
					echo '<option value="552">Directories & Listings</option>';
					echo '<option value="553">DVD & Video Rentals</option>';
					echo '<option value="554">E-Commerce Services</option>';
					echo '<option value="555">Email & Messaging</option>';
					echo '<option value="556">Entertainment Media</option>';
					echo '<option value="557">Fantasy Sports</option>';
					echo '<option value="558">Fashion & Style</option>';
					echo '<option value="559">File Sharing & Hosting</option>';
					echo '<option value="560">Flash-Based Entertainment</option>';
					echo '<option value="561">Freeware & Shareware</option>';
					echo '<option value="562">Games</option>';
					echo '<option value="563">General Reference</option>';
					echo '<option value="564">Health</option>';
					echo '<option value="565">Home Furnishings</option>';
					echo '<option value="566">Hotels & Accommodations</option>';
					echo '<option value="567">How-To‚ DIY & Expert Content</option>';
					echo '<option value="568">Import & Export</option>';
					echo '<option value="569">Internet & Telecom</option>';
					echo '<option value="570">Internet Clients & Browsers</option>';
					echo '<option value="571">Investing</option>';
					echo '<option value="572">ISPs</option>';
					echo '<option value="573">Java</option>';
					echo '<option value="574">Jobs</option>';
					echo '<option value="575">Local News</option>';
					echo '<option value="576">Mac OS</option>';
					echo '<option value="577">Mail & Package Delivery</option>';
					echo '<option value="578">Maps</option>';
					echo '<option value="579">Marketing Services</option>';
					echo '<option value="580">Mass Merchants & Department Stores</option>';
					echo '<option value="581">Merchant Services & Payment Systems</option>';
					echo '<option value="582">Movie Reference</option>';
					echo '<option value="583">Movies</option>';
					echo '<option value="584">Multimedia Software</option>';
					echo '<option value="585">Music & Audio</option>';
					echo '<option value="586">Music Streams & Downloads</option>';
					echo '<option value="5">News</option>';
					echo '<option value="587">Newspapers</option>';
					echo '<option value="588">Online Communities</option>';
					echo '<option value="589">Online Games</option>';
					echo '<option value="590">Online Journals & Personal Sites</option>';
					echo '<option value="591">Online Media</option>';
					echo '<option value="592">Online Video</option>';
					echo '<option value="593">Open Source</option>';
					echo '<option value="594">Phone Service Providers</option>';
					echo '<option value="595">Photo & Image Sharing</option>';
					echo '<option value="596">Photo & Video Sharing</option>';
					echo '<option value="597">Radio</option>';
					echo '<option value="598">Real Estate</option>';
					echo '<option value="599">Search Engine Optimization & Marketing</option>';
					echo '<option value="600">Search Engines</option>';
					echo '<option value="601">Service Providers</option>';
					echo '<option value="602">Shopping</option>';
					echo '<option value="603">Shopping Portals & Search Engines</option>';
					echo '<option value="604">Social Network Apps & Add-Ons</option>';
					echo '<option value="605">Social Networks</option>';
					echo '<option value="606">Software</option>';
					echo '<option value="607">Sports News</option>';
					echo '<option value="608">Translation Tools & Resources</option>';
					echo '<option value="609">Travel</option>';
					echo '<option value="610">TV Networks & Stations</option>';
					echo '<option value="611">Vehicle Shopping</option>';
					echo '<option value="612">Video Sharing</option>';
					echo '<option value="613">Voice & Video Chat</option>';
					echo '<option value="614">Weather</option>';
					echo '<option value="615">Web Apps & Online Tools</option>';
					echo '<option value="616">Web Design & Development</option>';
					echo '<option value="617">Web Hosting & Domain Registration</option>';
					echo '<option value="618">Web Portals</option>';
					echo '<option value="619">Web Services</option>';
					echo '<option value="620">Webcams & Virtual Tours</option>';
					echo '<option value="621">Windows OS</option>';
					echo '<option value="622">World News</option>';
				echo '</select>';
			echo '</p>';
			echo '<p><label for="admin_email">Admin Email</label></br /><input type="email" class="widefat" id="admin_email" name="admin_email" value="" /><br /><small style="text-align: justify; display: block">Your Email wont be shared with any third party and will only be used to sent notifications about SmartLogix Services related to WordPress.  All data provided to SmartLogix is bound by our <a href="http://smartlogix.co.in/privacy-policy/">privacy policy</a></small></p>';
			echo '<p><input type="hidden" id="is_showcase_submission" name="is_showcase_submission" value="false" /><input type="button" class="button-secondary" value="Submit" style="float: right" onclick="showcase_submit()" /></p><div style="clear: both;"></div>';
			echo '<script type="text/javascript">';
				echo 'function showcase_submit() {';
					echo 'jQuery("#is_showcase_submission").val("true");';
					echo 'jQuery("#wp_insert_form").submit();';
				echo '}';
			echo '</script>';
		echo '</div>';
	}
}
?>
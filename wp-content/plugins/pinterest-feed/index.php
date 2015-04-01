<?php
/*
Plugin Name: Pinterest Feed
Plugin URI: http://playground.beeks.me/wp/
Description: Add a responsive Pinterest feed to any page or post.
Version: 1.0
Author: Brandon Beeks
Author URI: http://beeks.me/
*/

//First we're going to create the plugin settings menu item and page
function feed_admin_actions() {
    add_options_page('Pinterest Feed','Pinterest Feed','manage_options','pinterest-feed','feed_admin');
}
add_action('admin_menu', 'feed_admin_actions');

//Next, let's add content to the plugin settings page
function feed_admin() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    $options = get_option('feed-options');
    ?>

	<div class="wrap">
        <div id="icon-options-general" class="icon32"><br></div>
        <h2>Pinterest Feed Options</h2>

        <?php if (empty($options['p_username'])) { ?>
            <div class="error settings-error">
                <p><strong>Username is required here, or when adding a shortcode.</strong></p>
            </div>
        <?php } ?>
        
        <form action="options.php" method="post">
            <?php settings_fields('feed-options-group'); ?>
            <?php do_settings_sections('pinterest-feed'); ?>
     
            <?php submit_button(); ?>
        </form>
    </div>
<?php }

//Now we're going to register all of the plugin setttings
function register_feed_settings() {
    register_setting( 'feed-options-group', 'feed-options', 'validate_feed_options');
    add_settings_section( 'feed_main', 'Default Settings', 'feed_main_callback', 'pinterest-feed' );
    add_settings_field('p_username', 'Username', 'feed_username_callback', 'pinterest-feed', 'feed_main');
    add_settings_field('p_board', 'Board', 'feed_board_callback', 'pinterest-feed', 'feed_main');
    add_settings_field('p_limit', 'Number of Posts', 'feed_limit_callback', 'pinterest-feed', 'feed_main');

    function feed_main_callback() {
        echo '';
    }

    function feed_username_callback() {
        $options = get_option('feed-options');
        echo '<input name="feed-options[p_username]" id="p_username" type="text" value="' . $options['p_username'] . '"/>';
    }

    function feed_board_callback() {
        $options = get_option('feed-options');
        echo '<input name="feed-options[p_board]" id="p_board" type="text" value="' . $options['p_board'] . '"/>';
    }

    function feed_limit_callback() {
        $options = get_option('feed-options');
        echo '<input name="feed-options[p_limit]" id="p_limit" type="text" value="' . $options['p_limit'] . '"/>';
    }

    function validate_feed_options($dirty_input) {
        $clean_output = array();
        foreach($dirty_input as $key => $value) {
            if (isset($dirty_input[$key])) {
                $clean_output[$key] = strip_tags(stripslashes($dirty_input[$key]));
            }
        }
        return apply_filters( 'validate_feed_options', $clean_output, $dirty_input);
    }
}
add_action('admin_init', 'register_feed_settings'); 

//Include the stylesheet/scripts for the pin formatting
//TODO find a good way to include this only if the shortcode is on the page
add_action('wp_enqueue_scripts', 'feed_add_stylescripts');
function feed_add_stylescripts() {
    wp_register_style('feed-styles', plugins_url('style.css', __FILE__));
    wp_enqueue_style('feed-styles');

    wp_enqueue_script('jquery');

    wp_register_script('feed-masonry', plugins_url('js/jquery.masonry.min.js', __FILE__), 'jquery', true);
    wp_enqueue_script('feed-masonry');
    
    wp_register_script('feed-main', plugins_url('js/main.js', __FILE__), 'feed-masonry', true);
    wp_enqueue_script('feed-main');

}

//Time for the short code [pinterest username='' board='' count='']
function feed_create_shortcode($atts){
    $options = get_option('feed-options');
    extract( shortcode_atts( array(
        'username' => $options['p_username'],
        'board' => $options['p_board'],
        'count' => $options['p_limit'],
    ), $atts ) );

    if (empty($username)) {
        return '<div class="pfeed-error">Enter a username with your shortcode or in the plugin settings</div>';
    }

    //Get the pinterest feed
    if (!empty($board)) {
        $content = wp_remote_get("http://pinterest.com/" . $username . "/" . $board . ".rss");
    } else {
        $content = wp_remote_get("http://pinterest.com/" . $username . "/feed.rss");
    }

    if (is_wp_error($content) || $content === false) {
        return 'No pinterest feed found.';
    } else {
        $html = '';
        $pinfeed = new SimpleXmlElement($content['body']);
        $pins = $pinfeed->channel->item;
        $limit = ($count > 0) ? $count : count($pins);

        $html .= '<div id="pfeed">';
        foreach ($pins as $pin) {
            if ($limit > 0) {
                $image_array = explode('"', $pin->description);
                $image = $image_array[3];

                $description_array = explode('</a>', $pin->description);
                $description = $description_array[1];

                $html .= '<div class="pfeed-pin">';
                    $html .= '<div class="pfeed-image"><a href="' . $pin->link . '" target="_blank"><img src="' . $image . '" /></a></div>';
                    $html .= '<div class="pfeed-description">' . $description . '</div>';
                $html .= '</div>';
                $limit--;
            }
        }
        $html .= '</div>';
        return $html;
    }
}
add_shortcode( 'pinterest', 'feed_create_shortcode' );

?>
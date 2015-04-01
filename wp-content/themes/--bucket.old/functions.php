<?php

// ensure EXT is defined
if ( ! defined('EXT')) {
	define('EXT', '.php');
}

#
# See: wpgrade-config.php -> include-paths for additional theme specific
# function and class includes
#

// Theme specific settings
// -----------------------

// add theme support for post formats
// child themes note: use the after_setup_theme hook with a callback
$formats = array('video', 'audio', 'gallery', 'image', 'link');
add_theme_support('post-formats', $formats);

// Initialize system core
// ----------------------

require_once 'wpgrade-core/bootstrap'.EXT;
require_once 'includes/class.socialstats.php';
#
# Please perform any initialization via options in wpgrade-config and
# calls in wpgrade-core/bootstrap. Required for testing.
#

/**
 * http://codex.wordpress.org/Content_Width
 */
if ( ! isset($content_width)) {
	$content_width = 960;
}

function post_format_icon($class_name = '') {
	$post_format = get_post_format();

	if ($post_format):
		$icon_class = "";
		switch ($post_format) {
			case "video":
				$icon_class = "icon-play";
				break;
			case "audio":
				$icon_class = "icon-music";
				break;
			case "image":
			case "gallery":
				$icon_class = "icon-camera";
				break;
			case "quote":
				$icon_class = "icon-quotes";
				break;
			case "link":
				$icon_class = "icon-link";
				break;
			default:
				break;
		}
		/* ?>
		<div class="post-format-icon <?php echo $class_name; ?> post-format-icon__background"></div>
		<div class="post-format-icon <?php echo $class_name; ?> post-format-icon__border"></div><?php */ ?>
		<div class="post-format-icon <?php echo $class_name; ?> post-format-icon__icon">
			<i class="<?php echo $icon_class; ?>"></i>
		</div>
<?php
	endif;
}
add_filter('widget_tag_cloud_args', 'tag_widget_limit');
function tag_widget_limit($args){
	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
	 $args['number'] = 15; 
	}
	return $args;	
}	

	
function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}


/* Remove action */
remove_action('wp_head','stats_hide_smile_css');

// Directly disabled in 'wpgrade-core/hooks.php'
//remove_action('wp_head','wpgrade_callback_load_custom_js');
//remove_action('wp_footer','wpgrade_callback_load_custom_js_footer');


// ------------------------- PLUGIN RELATED --------------------------------


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// DISQUS Plugin is active, unload the enqueued script and re enqueue it only in singular post
if ( is_plugin_active('disqus-comment-system/disqus.php') && !is_single() ) {

	remove_action('wp_footer', 'dsq_output_footer_comment_js');

};
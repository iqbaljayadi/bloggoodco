<?php


class Facebook_wpress_plugins_filters {
	
	function Facebook_wpress_plugins_filters() {
		add_filter('the_content', array(__CLASS__, 'auto_like_button'));
		add_filter('the_content', array(__CLASS__, 'auto_comments'));
		
		add_filter('comments_open', array(__CLASS__, 'remove_add_comment'));
		add_filter('comments_array', array(__CLASS__, 'remove_comments_list'));
	}
	
	function get_display_comments() {
		$options = $GLOBALS['fb_wpress_plugins']['comments'];
		$url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		add_action( 'wp_footer', array(Fb_wpress_plugins, 'enqueue_js_sdk') );
		
		if($options['width']=='') $options['width'] = '100%';
		
		$criteria = array('url'=>$url, 'width'=>$options['width'], 'num_posts'=>$options['num_posts'], 'colorscheme'=>$options['colorscheme']);
		$f1 = new Facebook_plugins_class();
		$d .= $f1->get_comments($criteria);
		
		if($options['title']!='') $d = '<b>'.$options['title'].'</b>'.$d;
		$d = '<p>'.$d.'</p>';
		
		return $d;
	}
	
	function auto_comments($content) {
		
		//Pages
		if(is_page()) {
			$pages = $GLOBALS['fb_wpress_plugins']['comments_pages']; //Line to customize !
			$exceptions = $pages['exceptions'];
			if($exceptions!='') $exceptions = json_decode($exceptions, true);
			else $exceptions=array();
			$id = get_the_ID();
			//display in all, except for
			if($pages['display']==1) {
				if(!in_array($id, $exceptions)) {
					$content = $content.self::get_display_comments();
				}
			}
			//display no where except in...
			else if($pages['display']==2) {
				if(in_array($id, $exceptions)) {
					$content = $content.self::get_display_comments();
				}
			}
		}
		
		//Posts
		else if(is_single()) {
			$pages = $GLOBALS['fb_wpress_plugins']['comments_posts']; //Line to customize !
			$exceptions = $pages['exceptions'];
			if($exceptions!='') $exceptions = json_decode($exceptions, true);
			else $exceptions=array();
			$id = get_the_ID();
			//display in all, except for
			if($pages['display']==1) {
				if(!in_array($id, $exceptions)) {
					$content = $content.self::get_display_comments();
				}
			}
			//display no where except in...
			else if($pages['display']==2) {
				if(in_array($id, $exceptions)) {
					$content = $content.self::get_display_comments();
				}
			}
		}
		
		return ''.$content.'';
	}
	
	/*
	Like button
	*/
	
	function get_display_like_button() {
		
		$options = $GLOBALS['fb_wpress_plugins']['like_button'];
		$url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		add_action( 'wp_footer', array(Fb_wpress_plugins, 'enqueue_js_sdk') );
		
		$criteria = array('url'=>$url, 'send'=>$options['send'], 'layout'=>$options['layout'], 'width'=>$options['width'], 'colorscheme'=>$options['colorscheme'], 'show_faces'=>$options['show_faces'], 'action'=>$options['action_verb'], 'font'=>$options['font']);
		$f1 = new Facebook_plugins_class();
		$d = $f1->get_like_button($criteria);
		
		return ''.$d.'';
	}
	
	function auto_like_button($content) {
		
		//Pages
		if(is_page()) {
			$pages = $GLOBALS['fb_wpress_plugins']['like_button_pages']; //Line to customize !
			$exceptions = $pages['exceptions'];
			if($exceptions!='') $exceptions = json_decode($exceptions, true);
			else $exceptions=array();
			$id = get_the_ID();
			//display in all, except for
			if($pages['display']==1) {
				if(!in_array($id, $exceptions)) {
					//empty means display on top
					if($pages['position']=='') {
						$content = self::get_display_like_button().$content;
					}
					else {
						$content = $content.self::get_display_like_button();
					}
				}
			}
			//display no where except in...
			else if($pages['display']==2) {
				if(in_array($id, $exceptions)) {
					//empty means display on top
					if($pages['position']=='') {
						$content = self::get_display_like_button().$content;
					}
					else {
						$content = $content.self::get_display_like_button();
					}
				}
			}
		}
		
		//Posts
		else if(is_single()) {
			$pages = $GLOBALS['fb_wpress_plugins']['like_button_posts']; //Line to customize !
			$exceptions = $pages['exceptions'];
			if($exceptions!='') $exceptions = json_decode($exceptions, true);
			else $exceptions=array();
			$id = get_the_ID();
			//display in all, except for
			if($pages['display']==1) {
				if(!in_array($id, $exceptions)) {
					//empty means display on top
					if($pages['position']=='') {
						$content = self::get_display_like_button().$content;
					}
					else {
						$content = $content.self::get_display_like_button();
					}
				}
			}
			//display no where except in...
			else if($pages['display']==2) {
				if(in_array($id, $exceptions)) {
					//empty means display on top
					if($pages['position']=='') {
						$content = self::get_display_like_button().$content;
					}
					else {
						$content = $content.self::get_display_like_button();
					}
				}
			}
		}
		
		return $content;
	}
	
	function remove_add_comment() {
		if($GLOBALS['fb_wpress_plugins']['comments']['disable_wp_comments']=='true') return false;
		else return true;
	}
	
	function remove_comments_list($comments) {
		if($GLOBALS['fb_wpress_plugins']['comments']['disable_wp_comments']=='true') return array();
		else return $comments;
	}
	
}

new Facebook_wpress_plugins_filters();

?>
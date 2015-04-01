<?php
/*
Created by Yougapi Technology - http://yougapi.com
Last update: 2 June 2014
*/

class Facebook_plugins_class
{
	var $app_id = '';
	var $lang = 'en_US'; //en_US, fr_FR, es_LA, ko_KR, ja_JP, de_DE
	var $fb_sdk = '1';
	
	function Facebook_plugins_class($criteria=array()) {
		static $witness;
		if($criteria['app_id']!='') $this->app_id = $criteria['app_id'];
		if($criteria['lang']!='') $this->lang = $criteria['lang'];
		if($criteria['fb_sdk']!='') $this->fb_sdk = $criteria['fb_sdk'];
		
		if($witness=='') {
			if($this->fb_sdk=='1') {
				?>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/<?php echo $this->lang; ?>/sdk.js#xfbml=1&appId=<?php echo $this->app_id; ?>&version=v2.0";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<?php
			}
			$witness=1;
		}
	}
	
	/*
	Like button
	https://developers.facebook.com/docs/plugins/like-button
	*/
	function get_like_button($criteria=array()) {
		$url = $criteria['url'];
		$layout = $criteria['layout'];
		$width = $criteria['width'];
		$colorscheme = $criteria['colorscheme'];
		$show_faces = $criteria['show_faces'];
		$action = $criteria['action'];
		$share_button = $criteria['share_button'];
		
		if($url=='') $url = '';
		if($layout=='') $layout = 'standard'; //standard, button_count, box_count, button
		if($width=='') $width = '450';
		if($colorscheme=='') $colorscheme = 'dark'; //light, dark
		if($show_faces=='') $show_faces = 'true'; //true, false
		if($action=='') $action = 'like'; //like, recommend
		if($share_button=='') $share_button = 'false'; //true, false
		
		$content = '<fb:like href="'.$url.'" width="'.$width.'" layout="'.$layout.'" action="'.$action.'" show_faces="'.$show_faces.'" share="'.$share_button.'" colorscheme="'.$colorscheme.'"></fb:like>';
		//$content = '<div class="fb-like" data-href="'.$url.'" data-width="'.$width.'" data-layout="'.$layout.'" data-action="'.$action.'" data-show-faces="'.$show_faces.'" data-share="'.$share_button.'" data-colorscheme="'.$colorscheme.'"></div>';
		
		return $content;
	}
	
	/*
	Send button
	https://developers.facebook.com/docs/plugins/send-button
	*/
	function get_send_button($criteria=array()) {
		$url = $criteria['url'];
		$colorscheme = $criteria['colorscheme'];
		
		if($url=='') $url = '';
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		
		$content = '<div class="fb-send" data-href="'.$url.'" data-colorscheme="'.$colorscheme.'"></div>';
		
		return $content;
	}
	
	/*
	Follow button
	https://developers.facebook.com/docs/plugins/follow-button
	*/
	function get_follow_button($criteria=array()) {
		$url = $criteria['url'];
		$layout = $criteria['layout'];
		$width = $criteria['width'];
		$colorscheme = $criteria['colorscheme'];
		$show_faces = $criteria['show_faces'];
		
		if($url=='') $url = '';
		if($layout=='') $layout = 'standard'; //standard, button_count, box_count, button
		if($width=='') $width = '450';
		if($colorscheme=='') $colorscheme = 'dark'; //light, dark
		if($show_faces=='') $show_faces = 'true'; //true, false
		
		$content = '<div class="fb-follow" data-href="'.$url.'" data-colorscheme="'.$colorscheme.'" data-layout="'.$layout.'" data-width="'.$width.'" data-show-faces="'.$show_faces.'"></div>';
		
		return $content;
	}
	
	/*
	Share button
	https://developers.facebook.com/docs/plugins/share-button
	*/
	function get_share_button($criteria=array()) {
		$url = $criteria['url'];
		$layout = $criteria['layout'];
		$width = $criteria['width'];
		
		if($url=='') $url = '';
		if($layout=='') $layout = 'button_count'; //button_count, box_count, button, icon
		if($width=='') $width = '450';
		
		$content = '<div class="fb-share-button" data-href="'.$url.'" data-type="'.$layout.'" data-width="'.$width.'"></div>';
		
		return $content;
	}
	
	/*
	Embedded Posts
	https://developers.facebook.com/docs/plugins/embedded-posts
	*/
	function get_embedded_post($criteria=array()) {
		$url = $criteria['url'];
		$width = $criteria['width'];
		
		if($url=='') $url = '';
		if($width=='') $width = '450';
		
		$content = '<div class="fb-post" data-href="'.$url.'" data-width="'.$width.'"></div>';
		//$content = '<fb:post href="'.$url.'" width="'.$width.'"></fb:post>';
		
		return $content;
	}
	
	/*
	Activity feed
	http://developers.facebook.com/docs/reference/plugins/activity/
	*/
	function get_activity_feed($criteria=array()) {
		$domain = $criteria['domain'];
		$width = $criteria['width'];
		$height = $criteria['height'];
		$colorscheme = $criteria['colorscheme'];
		$header = $criteria['header'];
		$recommendations = $criteria['recommendations'];
		
		if($domain=='') $domain = '';
		if($width=='') $width = '300';
		if($height=='') $height = '300';
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		if($header=='') $header = 'true';
		if($recommendations=='') $recommendations = 'false';
		
		$content = '<div class="fb-activity" data-site="'.$domain.'" data-action="likes, recommends" data-width="'.$width.'" data-height="'.$height.'" data-colorscheme="'.$colorscheme.'" data-header="'.$header.'" data-recommendations="'.$recommendations.'"></div>';
		
		return $content;
	}
	
	/*
	Recommendations
	https://developers.facebook.com/docs/plugins/recommendations
	*/
	function get_recommendations($criteria=array()) {
		$domain = $criteria['domain'];
		$width = $criteria['width'];
		$height = $criteria['height'];
		$colorscheme = $criteria['colorscheme'];
		$header = $criteria['header'];
		$max_age = $criteria['max_age'];
		
		if($domain=='') $domain = '';
		if($width=='') $width = '300';
		if($height=='') $height = '300';
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		if($header=='') $header = true;
		if($max_age=='') $max_age = 180; //1 to 180 (represent the days)
		
		$content = '<div class="fb-recommendations" data-site="'.$domain.'" data-width="'.$width.'" data-height="'.$height.'" data-action="likes, recommends" data-colorscheme="'.$colorscheme.'" data-header="'.$header.'" data-max-age="'.$max_age.'"></div>';
		
		return $content;
	}
	
	/*
	Like box
	https://developers.facebook.com/docs/plugins/like-box-for-pages
	*/
	function get_like_box($criteria=array()) {
		$url = $criteria['url'];
		$width = $criteria['width'];
		$height = $criteria['height'];
		$colorscheme = $criteria['colorscheme'];
		$header = $criteria['header'];
		$show_faces = $criteria['show_faces'];
		$stream = $criteria['stream'];
		$border = $criteria['border'];
		
		if($url=='') $url = '';
		if($width=='') $width = '292';
		if($height=='') $height = '427';
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		if($header=='') $header = 'true';
		if($show_faces=='') $show_faces = 'true';
		if($stream=='') $stream = 'true';
		if($border=='') $border = 'true';
		
		$content = '<div class="fb-like-box" data-href="'.$url.'" data-colorscheme="'.$colorscheme.'" data-show-faces="'.$show_faces.'" data-header="'.$header.'" data-stream="'.$stream.'" data-show-border="'.$border.'" data-width="'.$width.'" data-height="'.$height.'"></div>';
		
		return $content;
	}
	
	/*
	Facepile
	http://developers.facebook.com/docs/reference/plugins/facepile/
	*/
	function get_facepile($criteria=array()) {
		$url = $criteria['url'];
		$app_id = $criteria['app_id'];
		$width = $criteria['width'];
		$max_rows = $criteria['max_rows'];
		$size = $criteria['size'];
		$colorscheme = $criteria['colorscheme'];
		
		if($url=='') $url = '';
		if($app_id=='' && $url=='') $app_id = $this->app_id;
		if($width=='') $width = 200;
		if($max_rows=='') $max_rows = 2;
		if($size=='') $size = 'medium'; //small, medium, large
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		$show_count = 'true';
		
		$content = '<div class="fb-facepile" data-href="'.$url.'" data-app-id="'.$app_id.'" data-width="'.$width.'" data-max-rows="'.$max_rows.'" data-colorscheme="'.$colorscheme.'" data-size="'.$size.'" data-show-count="'.$show_count.'"></div>';
		
		return $content;
	}
	
	/*
	Comments
	https://developers.facebook.com/docs/plugins/comments
	*/
	function get_comments($criteria=array()) {
		$url = $criteria['url'];
		$width = $criteria['width'];
		$num_posts = $criteria['num_posts'];
		$colorscheme = $criteria['colorscheme'];
		$order_by = $criteria['order_by'];
		
		if($url=='') $url = '';
		if($width=='') $width = '500';
		if($num_posts=='') $num_posts = '10';
		if($colorscheme=='') $colorscheme = 'light'; //light, dark
		if($order_by=='') $order_by = 'social'; //social, reverse_time, time
		
		$content = '<div class="fb-comments" data-href="'.$url.'" data-width="'.$width.'" data-numposts="'.$num_posts.'" data-colorscheme="'.$colorscheme.'" data-order-by="'.$order_by.'"></div>';
		
		return $content;
	}
	
	/*
	Status update
	http://developers.facebook.com/docs/reference/javascript/fb.ui/
	*/
	function display_status_update($criteria=array()) {
		$app_id = $criteria['app_id'];
		$title = $criteria['title'];
		$message = $criteria['message'];
		$name = $criteria['name'];
		$link = $criteria['link'];
		$picture = $criteria['picture'];
		$caption = $criteria['caption'];
		$description = $criteria['description'];
		
		if($app_id=='') $app_id = $this->app_id;
		if($title=='') $title = '';
		if($message=='') $message = '';
		if($name=='') $name = '';
		if($link=='') $link = '';
		if($picture=='') $picture = '';
		if($caption=='') $caption = '';
		if($description=='') $description = '';
		
		$random = rand(9999,9999999).rand(9999,9999999).rand(9999,9999999);
		
		$js = '
		<script>
		function fc_post_fb_update_'.$random.'() {
			FB.ui({ 
				method: \'feed\',
				message: \''.$message.'\',
				name: \''.$name.'\',
     			link: \''.$link.'\',
     			picture: \''.$picture.'\',
     			caption: \''.$caption.'\',
     			description: \''.$description.'\',
			});
		}
		</script>
		';
		
		$content = '<a href="javascript:" onclick="fc_post_fb_update_'.$random.'()">'.$title.'</a>';
		
		return $content.$js;
	}
	
	/*
	Add friend dialog
	http://developers.facebook.com/docs/reference/dialogs/friends/
	*/
	
	function display_add_friend_dialog($criteria=array()) {
		$app_id = $criteria['app_id'];
		$id = $criteria['id'];
		$title = $criteria['title']; //link title
		
		if($app_id=='') $app_id = $this->app_id;
		if($id=='') $id = '';
		if($title=='') $title = '';
		
		$js = '
		<script>
		function fc_add_friend_'.$random.'() {
			FB.ui({ 
				method: \'friends\',
				id: \''.$id.'\',
			});
		};
		
		</script>
		';
		
		$content = '<a href="javascript:" onclick="fc_add_friend_'.$random.'()">'.$title.'</a>';
		
		return $content.$js;
	}
}

?>
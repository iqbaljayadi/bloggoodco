<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="True">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="MobileOptimized" content="320">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<!-- W3TC-include-css -->
<?php
/**
 * One does not simply remove this and walk away alive!
 */
wp_head(); ?>
<!-- W3TC-include-js-head -->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/theme-content/js/jquery-ui-1.10.4.custom.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".slider-container img").draggable({ 
			 axis: "x", 
			 cursor: "pointer",
			 drag : function(e,ui){
					if(ui.position.left >= -1 && ui.position.left <= 1){
					s1
						jQuery("#m1").css("margin-top", "6px");
						jQuery("#w2").css("margin-top", "6px");
						jQuery("#m3").css("margin-top", "6px");
						jQuery("#m4").css("margin-top", "6px");
						jQuery("#w5").css("margin-top", "6px");
						jQuery("#w6").css("margin-top", "6px");
					}else if(ui.position.left >= 1 && ui.position.left <= 85){
						jQuery("#m3").css("margin-top", "6px");
						jQuery("#m4").css("margin-top", "-50px");
						jQuery("#w5").css("margin-top", "6px");
					}else if(ui.position.left >= 85 && ui.position.left <= 170){
						jQuery("#m4").css("margin-top", "6px");
						jQuery("#w5").css("margin-top", "-50px");
						jQuery("#w6").css("margin-top", "6px");
					}else if(ui.position.left >= 170 && ui.position.left <= 260){
						jQuery("#w5").css("margin-top", "6px");	
						jQuery("#w6").css("margin-top", "-50px");
					}
					
					if(ui.position.left >= -85 && ui.position.left <= -1){
						jQuery("#m4").css("margin-top", "6px");
						jQuery("#m3").css("margin-top", "-50px");
						jQuery("#m4").css("margin-top", "6px");
						jQuery("#w2").css("margin-top", "6px");						
					}else if(ui.position.left >= -170 && ui.position.left <= -85){
						jQuery("#m3").css("margin-top", "6px");
						jQuery("#w2").css("margin-top", "-50px");
						jQuery("#m1").css("margin-top", "6px");
					}else if(ui.position.left >= -260 && ui.position.left <= -171){
						jQuery("#w2").css("margin-top", "6px");
						jQuery("#m1").css("margin-top", "-50px");
					}
					
					if(ui.position.left >= 260 || ui.position.left <= -260 ){
						return false;
					}
				},					
			});				 
	});
</script>


</head>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $listfusion_szpg_seo_title; ?></title>
<!-- Basic metas -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="<?php echo $listfusion_szpg_seo_meta_dec; ?>">
<meta name="Keywords" content="<?php echo $listfusion_szpg_seo_meta_key; ?>" /> 
<meta name="author" content="">
<?php echo $meta_robots; ?>
<!-- Mobile Special Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- google font css -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light|Impact|Myriad+Pro|Pacifico|Arizonia|Cookie|Great+Vibes|Leckerli+One" rel="stylesheet" type="text/css">
<!-- Css Group -->
<link rel="stylesheet" type="text/css" href="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/css/boot-lib/css/bootstrap.css'; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/css/style.css'; ?>"/>
<style>
.btn-sone {
    background: #<?php echo $btm_from_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_color; ?>), color-stop(100%, #<?php echo $btm_to_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_color; ?>', endColorstr='#<?php echo $btm_to_color; ?>', GradientType=0 );
    padding: 8px 15px;
	border: 2px solid #<?php echo $btm_border_color; ?>;
    border-radius: 3px;
    font-weight: bold;
    font-size: <?php echo $submit_font_size; ?>px;
    color: #<?php echo $submit_btm_text_color; ?>;
    font-family: "Open Sans", Georgia, Times, serif;
}
.btn-sone:hover {
    background: #<?php echo $btm_from_hover_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_hover_color; ?>), color-stop(100%, #<?php echo $btm_to_hover_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_hover_color; ?>', endColorstr='#<?php echo $btm_to_hover_color; ?>', GradientType=0 );
}
body {
	background: #C0DEED url(<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/'; ?>images/sq3.png) repeat;
}
</style>
<script type="text/javascript">
	var listfusion_item_squeezepg = <?php echo json_encode($op_arr); ?>;
</script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/'; ?>js/html5shiv.js"></script>
      <script src="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/'; ?>js/respond.min.js"></script>
<![endif]-->
<?php //wp_head(); ?>
</head>
<body style=" <?php if( $option_value['background_img_url'] != '' ) { ?>
			 background:url(<?php echo $option_value['background_img_url']; ?>); 
             <?php if( $option_value['field_img_url_repeat_cover'] == 2 ) { ?> background-size:cover; 
			 <?php } else { ?> background-repeat:repeat; <?php } } ?>">
<div class="wrapper-seven">
  <div class="container">
    <div class="outer-wrap">
      <div class="wrapper-seven-inner">
       <?php echo $row['video_code']; ?>	
        <div class="row">
          <div class="clearfix margin-top col-md-12 margin-bottom" style="padding:0px 75px;">
            <div class="arrow-11" style="left: -44px;top: -125px;"> <img src="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/'; ?>images/arrow-11.png" alt="arrow"> </div>
            <?php 
				global $ListFusionPlugin;
				$ListFusionPlugin->__listfusion_arpForm( $arpID, 'form-control input-lg', 'form-control input-lg', 'btn-sone btn-block', 1, $display_squeeze_page_ID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$display_squeeze_page_ID);
			?>
            <div class="condition-wrap-six margin-top">
              <p><span class="signing-up"> 
			  <span> <img src="<?php echo LIST_FUSION_LIBPATH.'user-lib/squeeze-pg/'; ?>images/privacy-ico.png" alt="privacy"> </span> 
			  <span style="color:#999; font-size:14px;"><?php echo $row['security_note']; ?></span> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
echo $listfusion_szpg_seo_footer_code; 
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$display_squeeze_page_ID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
wp_footer(); ?>
</body>
</html>
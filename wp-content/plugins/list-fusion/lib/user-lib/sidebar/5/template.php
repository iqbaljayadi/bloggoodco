<style>
<?php echo stripslashes($item_display['custom_css_code']); ?>
#listfusion-sidebar-five .af-img{
	background-image: url("<?php echo $item_display_options['field_img_url']; ?>");
}
#listfusion-sidebar-five .af-body input[type="submit"].listfusion-submit-btn {
    background: #<?php echo $template_btmbg_from; ?>;
    background: -moz-linear-gradient(top, #<?php echo $template_btmbg_from; ?> 0%, #<?php echo $template_btmbg_to; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $template_btmbg_from; ?>), color-stop(100%, #<?php echo $template_btmbg_to; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $template_btmbg_from; ?> 0%, #<?php echo $template_btmbg_to; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $template_btmbg_from; ?> 0%, #<?php echo $template_btmbg_to; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $template_btmbg_from; ?> 0%, #<?php echo $template_btmbg_to; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $template_btmbg_from; ?> 0%, #<?php echo $template_btmbg_to; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $template_btmbg_from; ?>', endColorstr='#<?php echo $template_btmbg_to; ?>', GradientType=0 );
	padding: 0px 25px;
	border-radius: 2px;
	font-weight: bold;
    color: #<?php echo $template_btm_txt_color; ?>;
	font-family: "Open Sans", Georgia, Times, serif;	
    font-size: <?php echo ($template_submit_text_size?$template_submit_text_size:'') ?>px;
}
#listfusion-sidebar-five .af-body input[type="submit"].listfusion-submit-btn:hover {
    background: #<?php echo $template_btm_hoverbg_from; ?>;
    background: -moz-linear-gradient(top, #<?php echo $template_btm_hoverbg_from; ?> 0%, #<?php echo $template_btm_hoverbg_to; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $template_btm_hoverbg_from; ?>), color-stop(100%, #<?php echo $template_btm_hoverbg_to; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $template_btm_hoverbg_from; ?> 0%, #<?php echo $template_btm_hoverbg_to; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $template_btm_hoverbg_from; ?> 0%, #<?php echo $template_btm_hoverbg_to; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $template_btm_hoverbg_from; ?> 0%, #<?php echo $template_btm_hoverbg_to; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $template_btm_hoverbg_from; ?> 0%, #<?php echo $template_btm_hoverbg_to; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $template_btm_hoverbg_from; ?>', endColorstr='#<?php echo $template_btm_hoverbg_to; ?>', GradientType=0 );
}
</style>
<div id="listfusion-sidebar-five" class="af-form">
  <div class="af-header">
    <div class="bodyText">
      <p> 
	  <span style="font-size:<?php echo ($item_display_options['field_header_size']?$item_display_options['field_header_size']:'20'); ?>px;font-weight:400;font-family:Gudea;line-height:26px;"> 
	  <?php echo $item_display['title']; ?>
	  </span> </p>
    </div>
  </div>
  <div class="af-img"></div>
  <div align="center" class="af-body af-standards">
    <?php if( $item_display['item_type'] == 'sidebarad' ) { ?>
	  <a onclick="return listfusion_sidebar_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>', '<?php echo $this->template_data_sessionID; ?>');" style="text-decoration:none;" id="listfusion_count_sidebar_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
	<?php
	} else {
		global $ListFusionPlugin;
		$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
	}	
	?>
    <div class="af-element privacyPolicy" style="text-align:center;width:100%; overflow:hidden; padding:0px; margin:0px;">
	  <?php if($item_display['security_note'] != '') { ?><p style="margin-bottom:0px;font-size: 11px; padding-top:5px;"><?php echo $item_display['security_note']; ?></p><?php } ?>
      <div class="af-clear"></div>
    </div>
  </div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
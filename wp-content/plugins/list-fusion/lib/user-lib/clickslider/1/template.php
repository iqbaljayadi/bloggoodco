<?php if( $item_display_options['slider_display_screen_placement'] == 1 ) { ?>
<style>
<?php echo stripslashes($item_text_custom_css); ?>
.listfusion-click-top-left-slider #top-left.scroller-wrap .expand-wrap.active { margin-left: <?php echo $slider_gap_margin; ?>px; }
.listfusion-click-top-left-slider #top-left.scroller-wrap .control, .listfusion-click-top-left-slider #top-left.scroller-wrap .expand-wrap {
    background: #<?php echo $slider_from_bg_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $slider_from_bg_color; ?>), color-stop(100%, #<?php echo $slider_to_bg_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $slider_from_bg_color; ?>', endColorstr='#<?php echo $slider_to_bg_color; ?>', GradientType=0 );
}
.listfusion-click-top-left-slider input[type="submit"].listfusion-submit-clcikslider-btn {
    background: #<?php echo $btm_from_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_color; ?>), color-stop(100%, #<?php echo $btm_to_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_color; ?>', endColorstr='#<?php echo $btm_to_color; ?>', GradientType=0 );
    padding: 20px 15px;
	border: 2px solid #<?php echo $btm_border_color; ?>;
    border-radius: 3px;
    font-weight: bold;
    font-size: <?php echo $submit_font_size; ?>px;
    color: #<?php echo $submit_btm_text_color; ?>;
    font-family: "Open Sans", Georgia, Times, serif;
}
.listfusion-click-top-left-slider input[type="submit"].listfusion-submit-clcikslider-btn:hover {
    background: #<?php echo $btm_from_hover_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_hover_color; ?>), color-stop(100%, #<?php echo $btm_to_hover_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_hover_color; ?>', endColorstr='#<?php echo $btm_to_hover_color; ?>', GradientType=0 );
}
</style>
<div class="listfusion-click-top-left-slider">
  <div id="top-left" class="scroller-wrap">
    <div class="control">
      <p> <a href="#" class="top-left-link"> <span class="click-text" style="font-family:Open Sans; font-weight:bold;"><?php echo $item_display_options['slider_clickmessage']; ?></span> <i class="top-left-icon glyphicon glyphicon-chevron-right"> </i> </a> </p>
    </div>
    <div class="expand-wrap" style="display:none;">
      <div class="expaind-container">
	    <?php if( $upload_img != '' ) { ?>
        <div class="subscribe-image-br pull-left"> <img src="<?php echo $upload_img; ?>" width="" height="auto"> </div>
		<?php } ?>
        <div class="subscribe-content-br pull-right">
          <h3 style="font-size:<?php echo $title_text_size; ?>px; color:#<?php echo $title_text_color; ?>;"><?php echo $item_display['title']; ?></h3>
          <p style="color:#<?php echo $msg_text_color; ?>;"><?php echo $item_display['msg']; ?></p>
          <div style="padding:5px 0px;">
			  <?php
			  if( $item_display['item_type'] == 'clicksliderad' ) {
			  ?>
	  <a onclick="return listfusion_clickslider_red('<?php echo $ad_redirecturl; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_clickslider_adclick">
	  <input type="submit" class="listfusion-submit-clcikslider-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
			  </a>
			  <?php 
			  } else { 
				global $ListFusionPlugin;
				$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-clcikslider-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
			  }	
			  ?>
          </div> 
		  <?php if( $item_display['security_note'] != '' ) { ?>
		  <div style="float:left;color:#<?php echo $security_note_color; ?>; padding:5px 0px;font-size: 12px;"><?php echo $item_display['security_note']; ?> </div>	
		  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
<style>
<?php echo stripslashes($item_text_custom_css); ?>
.listfusion-click-bottom-left-slider #bottom-left.scroller-wrap-left .expand-wrap-left-btn.active-left { margin-left: <?php echo $slider_gap_margin; ?>px; }
.listfusion-click-bottom-left-slider #bottom-left.scroller-wrap-left .control, .listfusion-click-bottom-left-slider #bottom-left.scroller-wrap-left .expand-wrap-left-btn {
    background: #<?php echo $slider_from_bg_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $slider_from_bg_color; ?>), color-stop(100%, #<?php echo $slider_to_bg_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $slider_from_bg_color; ?> 0%, #<?php echo $slider_to_bg_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $slider_from_bg_color; ?>', endColorstr='#<?php echo $slider_to_bg_color; ?>', GradientType=0 );
}
.listfusion-click-bottom-left-slider input[type="submit"].listfusion-submit-clcikslider-btn {
    background: #<?php echo $btm_from_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_color; ?>), color-stop(100%, #<?php echo $btm_to_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_color; ?> 0%, #<?php echo $btm_to_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_color; ?>', endColorstr='#<?php echo $btm_to_color; ?>', GradientType=0 );
    padding: 20px 15px;
	border: 2px solid #<?php echo $btm_border_color; ?>;
    border-radius: 3px;
    font-weight: bold;
    font-size: <?php echo $submit_font_size; ?>px;
    color: #<?php echo $submit_btm_text_color; ?>;
    font-family: "Open Sans", Georgia, Times, serif;
}
.listfusion-click-bottom-left-slider input[type="submit"].listfusion-submit-clcikslider-btn:hover {
    background: #<?php echo $btm_from_hover_color; ?>;
    background: -moz-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #<?php echo $btm_from_hover_color; ?>), color-stop(100%, #<?php echo $btm_to_hover_color; ?>));
    background: -webkit-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -o-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: -ms-linear-gradient(top, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    background: linear-gradient(to bottom, #<?php echo $btm_from_hover_color; ?> 0%, #<?php echo $btm_to_hover_color; ?> 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $btm_from_hover_color; ?>', endColorstr='#<?php echo $btm_to_hover_color; ?>', GradientType=0 );
}
</style>
<div class="listfusion-click-bottom-left-slider">
  <div id="bottom-left" class="scroller-wrap-left">
    <div class="control">
      <p> <a href="#"class="btn-left-link"> <span class="click-text" style="font-family:Open Sans; font-weight:bold;"> <?php echo $item_display_options['slider_clickmessage']; ?> </span> <i class="bottom-left glyphicon glyphicon-chevron-right"> </i> </a> </p>
    </div>
    <div class="expand-wrap-left-btn" style="display:none;">
      <div class="expaind-container">
	    <?php if( $upload_img != '' ) { ?>
        <div class="subscribe-image-br pull-left"> <img src="<?php echo $upload_img; ?>" width="" height="auto"> </div>
		<?php } ?>
        <div class="subscribe-content-br pull-left">
          <h3 style="font-size:<?php echo $title_text_size; ?>px; color:#<?php echo $title_text_color; ?>;"><?php echo $item_display['title']; ?></h3>
          <p style="color:#<?php echo $msg_text_color; ?>;"><?php echo $item_display['msg']; ?></p>
          <div style="padding:5px 0px; clear:both; display: table-footer-group;">
			  <?php
			  if( $item_display['item_type'] == 'clicksliderad' ) {
			  ?>
			  <a onclick="return listfusion_clickslider_red('<?php echo $ad_redirecturl; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_clickslider_adclick">
	  <input type="submit" class="listfusion-submit-clcikslider-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
			  </a>
			  <?php 
			  } else { 
				global $ListFusionPlugin;
				$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-clcikslider-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
			  }	
			  ?>
          </div>
		  <?php if( $item_display['security_note'] != '' ) { ?>
		  <div style="float:left;color:#<?php echo $security_note_color; ?>; padding:5px 0px;font-size: 12px;"><?php echo $item_display['security_note']; ?> </div>	
		  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
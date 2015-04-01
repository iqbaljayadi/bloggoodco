<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
<div class="lightbox-overlay"></div>
<div class="listfusion-lightbox-main-div">
<a href="#" class="listfusion-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
<div class="lightbox-video"> 
	<?php 
	if( $item_text_video_code == '' ) {  
		echo '<img src="'.LIST_FUSION_LIBPATH.'user-lib/popup/4/images/video-panel.png">';
	} else { 
		echo html_entity_decode($item_text_video_code); 
	}
	?> 
</div>
<div class="lightbox-bottom">
  <div class="lightbox-signup-panel">
    <div class="form">
        <div class="lightbox-top">
          <div class="lightbox-top">
            <p class="heading">
			<?php 
			if( $item_display['item_type'] == 'adpopup' ) {
				echo $item_text_ad_msg;	
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
				echo $item_text_social_msg;
			} else {
				echo $item_text_optin_msg; 
			}
			?></p>
          </div>
        </div>
		 <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					?><br>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
      <?php 
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<br>';
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
			} else {
						global $ListFusionPlugin;
						$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
						?>
					 <p class="secure">
					 <img src="<?php echo LIST_FUSION_LIBPATH ?>user-lib/popup/4/images/lightbox-secure.png" width="16" height="15" /> <?php echo $template_security_note; ?>
					 </p>
      <?php } ?>		
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>  
<?php echo $item_text_dntshowmeagain; ?>
</div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
<style><?php echo stripslashes($item_text_custom_css); ?></style>
<?php if( $item_fld_img != '' ) { $bgimg = $item_fld_img;  } else { $bgimg =  LIST_FUSION_FULLPATH.'lib/user-lib/popup/15/images/bg.jpg'; } ?>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
    <div class="lightbox-overlay"></div>
    <div class="listfusion-lightbox-main-div">
        <a href="#" class="listfusion-lightbox-close" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
        <div class="popup-dom-border">
            <div class="lightbox-top" style="background-image:url(<?php echo $bgimg; ?>);background-size: cover;">
                <div class="lightbox-top-content"></div>
                    <div class="lightbox-bottom">
					<div class="heading" style="font-size:<?php echo $item_text_title_fontsize; ?>;">
					  <?php 
					  if( $item_display['item_type'] == 'optinpopup' ) {
						  echo $item_text_optin_msg; 
					  } else if( $item_display['item_type'] == 'adpopup' ) {
					  	  echo $item_text_ad_msg;
					  } else {
					  	  echo $$item_text_social_msg;
					  }
					  
					  ?></div>
                        <div class="lightbox-signup-panel"> 
						<?php 
							if( $item_display['item_type'] == 'adpopup' ) {
						  ?>
	  <div align="center" style="padding:15px;">
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
	  </div>
					  <?php 
							} else if( $item_display['item_type'] == 'socialpopup' ) {
								echo ' <div align="center" style="padding:15px;">';
								$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
								echo '</div><div style="clear:both"></div>';
								
							} else {
								global $ListFusionPlugin;
								$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
								echo '<p class="secure">'.$template_security_note.'</p>';
							}	
						?>
                        </div>
                    </div>
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
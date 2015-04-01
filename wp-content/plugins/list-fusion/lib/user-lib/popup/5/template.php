<style>
<?php echo stripslashes($item_text_custom_css); ?>
<?php if( $item_display['item_type'] == 'adpopup' || $item_display['item_type'] == 'socialpopup' ) { ?>   
.listfusion-lightbox-start .listfusion-lightbox-main-div .lightbox-top .lightbox-bottom {min-height: 80px;}
<?php  } ?>
</style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
    <div class="lightbox-overlay"></div>
    <div class="listfusion-lightbox-main-div">
        <a href="#" class="listfusion-lightbox-close" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
        <div class="popup-dom-border">
            <div class="lightbox-top">
                <div class="lightbox-top-content">
                    <div class="heading"><p><?php echo $item_text_title; ?></p>
                    </div>
                    <div class="bullet-listx">
                        <p><?php echo nl2br($item_text_msg) ?></p>
                    </div>
                </div>
                    <div class="lightbox-bottom">
	  <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					?>
					<div align="center">
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
	  </div>
      <?php 
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<div align="center" style="padding-left:35px;">';
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
						echo '</div>';
			} else {
						global $ListFusionPlugin;
						$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
						?>
					  <p class="secure"><?php echo $template_security_note; ?></p>
      <?php } ?>
                        </div>
                    </div>
            </div>
			<?php echo $item_text_dntshowmeagain; ?>
        </div>
    </div>
</div>	
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
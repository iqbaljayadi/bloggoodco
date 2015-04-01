<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="lightbox-overlay"></div>
  <div class="listfusion-lightbox-main-div lightbox-color-<?php echo $popup_change_bg_theme ?>">
  <a href="#" class="listfusion-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
    <div class="popup-dom-border">
      <div class="lightbox-top">
        <div class="lightbox-top-content">
          <div class="lightbox-heading">
            <p><?php echo $item_text_title; ?></p>
          </div>
          <div class="lightbox-subheading"> </div>
        </div>
      </div>
      <div class="lightbox-bottom">
        <div class="lightbox-left-content">
          <div class="bullet-listx">
            <ul class="bullet-list">
              <?php foreach( (array) $item_text_list_points as $value  ) {  
						if( $value != '' ) {
						?>
            <li><?php echo $value; ?></li>
            <?php } } ?>
            </ul>
            <div class="clear"></div>
          </div>
        </div>
        <div class="lightbox-right-content">
          <div class="lightbox-signup-panel">
            <div class="wait" style="display:none;"><img src="<?php echo $this->plugin_url . 'css/images/wait.gif'; ?>" /></div>
            <div class="form">
              <div>
      <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					echo '<div align="center" style="padding-left: 25px;">';
					echo '<div style="color:#666; line-height:19px;">';
					echo $item_text_ad_msg;
					echo '<br><br>'; 
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
	  				</div>
      <?php 
					echo '</div>';
			
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<div align="center" style="padding-left: 25px;">';
					    echo '<div style="color:#666; line-height:19px;">';
						echo $item_text_social_msg;
						echo '</div>';
						echo '<br><br>'; 
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

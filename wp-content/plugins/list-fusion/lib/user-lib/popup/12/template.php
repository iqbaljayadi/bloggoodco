<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="lightbox-overlay"></div>
  <div class="listfusion-lightbox-main-div"> <a href="#" class="listfusion-lightbox-close" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
    <div class="lightbox-grey-panel">
      <div class="lightbox-inner">
        <p class="heading" style="font-size:<?php echo $item_text_title_fontsize; ?>;"><?php echo $item_text_title; ?></p>
        <div class="bullet-listx">
          <p class="small-para"> <?php echo nl2br($item_text_msg) ?> </p>
          <ul class="bullet-list">
            <?php foreach( (array) $item_text_list_points as $value  ) {  
						if( $value != '' ) {
						?>
            <li><?php echo $value; ?></li>
            <?php } } ?>
          </ul>
          <div class="lightbox-clear"></div>
        </div>
        <div class="lightbox-signup-panel">
		   <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					echo '<p class="heading2">';
					echo $item_text_ad_msg;
					echo '</p>'; 
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
      <?php 
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<p class="heading2">';
						echo $item_text_social_msg;
						echo '</p>';
						echo '<br>'; 
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
			} else {
						echo '<p class="heading2">';
						echo $item_text_optin_msg;
						echo '</p>';
						global $ListFusionPlugin;
						$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
						?>
      <?php } ?>
        </div>
        <div class="lightbox-clear"></div>
        <p class="secure"><?php echo $template_security_note; ?></p>
      </div>
      <div class="lightbox-clear"></div>
    </div>
    <div class="lightbox-clear"></div>
  </div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
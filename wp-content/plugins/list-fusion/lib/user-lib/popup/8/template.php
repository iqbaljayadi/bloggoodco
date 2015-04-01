<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="listfusion-lightbox-main-div elbpro-bg-theme-<?php echo $popup_change_bg_theme; ?>"> <a href="#" class="listfusion-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
    <div class="elbpro-main-body-panel">
      <p class="heading" style="font-size:<?php echo $item_text_title_fontsize; ?>;"><?php echo $item_text_title; ?></p>
      <div class="elbpro-display-images">
        <?php 
	   if( $item_fld_img != '' ) { 
			echo '<img src="'.$item_fld_img.'" width="100%" >'; 
		} 
	   ?>
      </div>
      <div class="elbpro-left-content">
        <p id="arrowimg" style="margin: 0px -45px 0px 0px;"> 
		<img src="<?php echo LIST_FUSION_FULLPATH.'lib/user-lib/popup/8/images/arrow-big.png'; ?>" align="top" style="float:right;" /> <?php echo $item_text_msg; ?> 
		</p>
        <div class="bullet-listx">
          <ul class="bullet-list">
            <?php foreach( (array) $item_text_list_points as $value  ) {  
						if( $value != '' ) {
						?>
            <li><?php echo $value; ?></li>
            <?php } } ?>
          </ul>
          <div class="lightbox-clear"></div>
        </div>
      </div>
      <div class="lightbox-clear"></div>
      <!--Footer Pwd by link-->
      <div class="powered" style="vertical-align:bottom;">
        <div  style="float:right"> <?php echo $dontShowMeAgainTmpPopup; ?> </div>
        <?php echo $pwdbyLinkPopupTmp; ?> </div>
    </div>
    <div class="elbpro-right-panel">
      <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					echo '<p class="heading2">';
					echo $item_text_ad_msg;
					echo '</p><br>'; 
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
      <?php 
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<p class="heading2">';
						echo $item_text_social_msg;
						echo '<br>'; 
						echo '</p>';
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
			} else {
						echo '<p class="heading2">';
						echo $item_text_optin_msg;
						echo '<br>'; 
						echo '</p>';
						global $ListFusionPlugin;
						$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
						?>
					  <p class="secure"><?php echo $template_security_note; ?></p>
      <?php } ?>
    </div>
    <div class="lightbox-clear"></div>
    <?php echo $item_text_dntshowmeagain; ?> </div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>

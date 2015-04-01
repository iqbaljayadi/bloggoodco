<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="listfusion-lightbox-main-div elbpro-theme-<?php echo $popup_change_bg_theme; ?>" > <a href="#" class="aplbpop-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?> ><span>Close</span></a>
    <div class="lightbox-top">
      <div class="lightbox-top-content">
        <div class="lightbox-top-text">
         <!-- <p class="heading" style="font-size:<?php //echo $item_text_title_fontsize; ?>;"><?php //echo $item_text_title; ?></p>-->
          <?php 
			if( $item_text_video_code != '' ) {
				echo stripcslashes(html_entity_decode($item_text_video_code));
			} 
		 ?>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="lightbox-middle-bar">
       <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					echo '<div align="center" style="padding-left: 300px;">';
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
      <?php 
					echo '</div>';
			
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<div align="center" style="padding-left: 200px;">';
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
						echo '</div>';
			} else {
					global $ListFusionPlugin;
					$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
			} 
		?>
    </div>
    <div class="powered" style="vertical-align:bottom;">
      <div  style="float:right"> <?php echo $item_text_dntshowmeagain; ?> </div>
    </div>
    <div class="lightbox-bottom">
      <p class="secure"><?php echo $template_security_note; ?></p>
    </div>
  </div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>

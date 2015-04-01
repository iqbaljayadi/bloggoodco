<style><?php echo stripslashes($item_text_custom_css); ?></style>
<?php if( $item_fld_img == '' ) { ?>
<style> .listfusion-lightbox-start .listfusion-lightbox-main-div .listfusion-left-content { width: 527px; } </style>
<?php } ?>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="listfusion-lightbox-main-div listfusion-bg-theme-<?php echo $popup_change_bg_theme; ?>"> 
  <a href="#" class="listfusion-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>><span>Close</span></a>
    <div class="listfusion-main-body-panel">
      <p class="heading" style="font-size:<?php echo $item_text_title_fontsize; ?>;"><?php echo $item_text_title; ?></p>
		<!--video or image handle -->
      <?php if( $item_fld_img != '' ) { ?>
      <div align="center" class="elbpro-display-images">
        <?php echo '<img src="'.$item_fld_img.'" width="100%" >'; ?>
      </div>
      <?php } ?>
		<!--eof video or image handle -->
      <div class="listfusion-left-content">
        <p id="bodymsg_content"><?php echo $item_text_msg; ?></p>
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
      <div class="powered" style="vertical-align:bottom;">
        <div style="float:right"> <?php echo $item_text_dntshowmeagain; ?> </div>
      </div>
    </div>
    <div class="elbpro-right-panel">
      <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
					echo '<div class="heading2">';
					echo $item_text_ad_msg;
					echo '<br><br>'; 
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" />
	  </a>
      <?php 
					echo '</div>';
			
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
						echo '<div class="heading2">';
						echo $item_text_social_msg;
						echo '<br>'; 
						echo '</div>';
						$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
			} else {
						echo '<div class="heading2">';
						echo $item_text_optin_msg;
						echo '<br>'; 
						echo '</div>';
						echo '<div>';
						global $ListFusionPlugin;
						$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
						echo '</div>';
						?>
					  <p class="secure"><?php echo $template_security_note; ?></p>
      <?php } ?>
    </div>
    <div class="lightbox-clear"></div>
  </div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
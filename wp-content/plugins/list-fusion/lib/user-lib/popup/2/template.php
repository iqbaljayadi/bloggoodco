<style><?php echo stripslashes($item_text_custom_css); ?></style>
<?php if( $item_fld_img == '' ) { ?>
<style> .listfusion-lightbox-start .listfusion-lightbox-main-div .lightbox-top .lightbox-top-text { width: 720px; } </style>
<?php }
if( $item_text_dntshowmeagain != '' || $template_security_note != '' ) {
 ?>
<style> .listfusion-lightbox-start .lightbox-bottom { min-height: 15px;  } </style>
<?php } ?> 
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
  <div class="listfusion-lightbox-main-div elbpro-theme-<?php echo $popup_change_bg_theme; ?>" > 
  <a href="#" class="aplbpop-close-lightbox" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?> ><span>Close</span></a>
    <div class="lightbox-top">
      <div class="lightbox-top-content">
        <div class="lightbox-top-text">
          <p class="heading" style="font-size:<?php echo $item_text_title_fontsize; ?>;"><?php echo $item_text_title; ?></p>
          <p id="elbpro_mobbody_txt" style="width:90%;"><?php echo $item_text_msg; ?></p>
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
		<!--video or image handle -->
       <?php if( $item_fld_img != '' ) { ?>
        <p style="width:265px;float:right;">
        <?php echo '<img src="'.$item_fld_img.'" width="100%" >'; ?>
        </p>
		<?php } ?>
		<!--eof video or image handle -->
        <div class="clear"></div>
      </div>
    </div>
    <div class="lightbox-middle-bar">
      <?php 
			if( $item_display['item_type'] == 'adpopup' ) {
			
					echo '<div align="center" style="padding:12px 0px 0px 0px; margin:-10px;" >';
					echo '<span>';
					echo ucwords($item_text_ad_msg); 
					echo '&nbsp;&nbsp;</span>';
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" style="float:none;" />
	  </a>
      <?php 
					echo '</div>';
			}  else if( $item_display['item_type'] == 'socialpopup' ) {
				echo '<div align="center">';
				if( $item_text_social_msg != '' ) {
					echo '<div style="padding-bottom:15px;">';
					echo $item_text_social_msg;
					echo '&nbsp;&nbsp;</div>';
				}
				$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
				echo '</div>';
			} else {
				echo '<div>';
				global $ListFusionPlugin;
				$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 2, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
				echo '</div>';
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
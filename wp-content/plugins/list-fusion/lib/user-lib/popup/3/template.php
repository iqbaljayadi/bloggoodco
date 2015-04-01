<style><?php echo stripslashes($item_text_custom_css); ?></style>
<div class="listfusion-lightbox-start" id="listfusion_popup_lightbox_main" <?php echo $popup_delay_hide; ?>>
	<div class="lightbox-overlay"></div>
	<div class="listfusion-newsletter listfusion-lightbox-main-div lightbox-color-<?PHP echo $color ?>">
		<a href="#" class="listfusion-close-popup" id="listfusion_item_close_btm" <?php echo $popupclosebtmCss; ?>></a>
		<span class="listfusion-title"><?PHP echo $item_text_title; ?></span>
		<span class="listfusion-body_msg"><?PHP echo $item_text_msg; ?></span>
		 <?php 
		if( $item_display['item_type'] == 'adpopup' ) {
					echo '<div align="center" style="padding:8px 0px 20px; margin:-10px;" >';
					echo '<span>';
					echo ucwords($item_text_ad_msg); 
					echo '&nbsp;&nbsp;</span>';
					?>
	  <a onclick="return listfusion_red('<?php echo $ad_redirectURL; ?>', '<?php echo $ad_openIN; ?>');" style="text-decoration:none;" id="listfusion_count_adclick">
	  <input type="submit" class="listfusion-submit-btn" value="<?php echo $this->template_submit_btm_txt; ?>" style="float:none;" />
	  </a>
      <?php 
					echo '</div>';
		} else if( $item_display['item_type'] == 'socialpopup' ) {
					echo '<div style="padding:8px 0px 20px 11px; margin:-10px;">';
					echo $item_text_social_msg;
					echo '<br><br>'; 
					$this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
					echo '</div>';
		}   else {
		global $ListFusionPlugin;
		$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID);
		}
		?>
		<div class="listfusion-clearfx"></div>
		<div style="float:left;width:100%;">
			<span class="listfusion-span">
				<?PHP echo $template_security_note ?>
			</span>
			<span class="listfusion-span pwd" style="float:right; padding-top:0px;"><?php echo $item_text_dntshowmeagain; ?></span>
		</div>
	</div>
</div>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
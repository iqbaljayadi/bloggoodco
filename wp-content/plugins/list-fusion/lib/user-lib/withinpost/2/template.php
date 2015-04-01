<?php 
global $ListFusionPlugin;

$optin_form  = '<style>';
$optin_form .= stripslashes($item_display['custom_css_code']);
if( $template_submit_text_size != '' ) { $optin_form .= '#listfusion-withinpost-two .af-body input[type="submit"] {font-size: '.$template_submit_text_size.'px!important;}'; }
if( $template_background != '' ) { $optin_form .= '#listfusion-withinpost-two .af-body { background-image: url("'.$template_background.'"); }'; }
$optin_form .= '#listfusion-withinpost-two .af-body input[type="submit"].listfusion-submit-btn {
    background: #'.$template_btmbg_from.';
    background: -moz-linear-gradient(top, #'.$template_btmbg_from.'0%, #'.$template_btmbg_to.' 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #'.$template_btmbg_from.'), color-stop(100%, #'.$template_btmbg_to.'));
    background: -webkit-linear-gradient(top, #'.$template_btmbg_from.' 0%, #'.$template_btmbg_to.' 100%);
    background: -o-linear-gradient(top, #'.$template_btmbg_from.' 0%, #'.$template_btmbg_to.' 100%);
    background: -ms-linear-gradient(top, #'.$template_btmbg_from.' 0%, #'.$template_btmbg_to.' 100%);
    background: linear-gradient(to bottom, #'.$template_btmbg_from.' 0%, #'.$template_btmbg_to.' 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr=#'.$template_btmbg_from.', endColorstr=#'.$template_btmbg_to.', GradientType=0 );
	padding: 0px 25px;
	border-radius: 2px;
	font-weight: bold;
    color: #'.$template_btm_txt_color.';
	font-family: "Open Sans", Georgia, Times, serif;
}
#listfusion-withinpost-two .af-body input[type="submit"].listfusion-submit-btn:hover {
    background: #'. $template_btm_hoverbg_from.';
    background: -moz-linear-gradient(top, #'. $template_btm_hoverbg_from.' 0%, #'. $template_btm_hoverbg_to.' 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #'. $template_btm_hoverbg_from.'), color-stop(100%, #'. $template_btm_hoverbg_to.'));
    background: -webkit-linear-gradient(top, #'. $template_btm_hoverbg_from.' 0%, #'. $template_btm_hoverbg_to.' 100%);
    background: -o-linear-gradient(top, #'. $template_btm_hoverbg_from.' 0%, #'. $template_btm_hoverbg_to.' 100%);
    background: -ms-linear-gradient(top, #'. $template_btm_hoverbg_from.' 0%, #'. $template_btm_hoverbg_to.' 100%);
    background: linear-gradient(to bottom, #'. $template_btm_hoverbg_from.' 0%, #'. $template_btm_hoverbg_to.' 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr=#'. $template_btm_hoverbg_from.', endColorstr=#'. $template_btm_hoverbg_to.', GradientType=0 );
}
';
$optin_form .= '</style>';

$optin_form .= '
<div id="listfusion-withinpost-two" class="af-form">
  <div class="af-header">
    <div class="bodyText">
      <p align="center"> <span style="font-family:Gudea;font-size:'.($template_title_text_size?$template_title_text_size:'24').'px;text-shadow: 0px 0px 3px #807474;line-height: 36px;">'.$item_display['title'].'</span> </p>
    </div>
  </div>
  <div align="center" class="af-body af-standards">
    <div style="background-color: rgba(51, 34, 28, 0.2);padding-bottom: 60px;padding-top: 40px;">';
	
if( $item_display['item_type'] == 'withinpostad' ) { 

	 $optin_form .= " <a onclick=\"return listfusion_sidebar_red('".$ad_redirectURL."', '".$ad_openIN."', '".$this->template_data_sessionID."');\" style=\"text-decoration:none;\" id=\"listfusion_count_sidebar_adclick\">
	  <input type=\"submit\" class=\"listfusion-submit-btn\" value='".$this->template_submit_btm_txt."' />
	  </a>";

}  else if( $item_display['item_type'] == 'withinpostsocial' ) {
	
	$optin_form .='<div style="padding: 0px 5%;">';  
	$optin_form .= $this->__listfusion_social_display($item_display_options['social_show_facebook'], $item_display_options['social_show_twitter'], $item_display_options['social_show_google'], $item_display_options['social_show_pinterest'], $item_display_options['social_show_linkedin'], $listfusionSocial_curPageURL, $item_display_options['social_facebook_url'], $item_display_options['soical_twitter_url'], $item_display['item_social_twtter_txt'], $item_display_options['social_google_url'], $item_display_options['social_pinterest_url'], $item_display_options['social_pinterest_img_url'], $item_display['item_social_pinterest_txt'], $item_display_options['social_linkedin_url'] );
	$optin_form .='</div><div style="clear:both"></div>';  

} else {
		
$optin_form .= ''.$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID).'';

}

$optin_form .= ' <div class="af-element privacyPolicy" style="text-align: center;padding-top: 8px;">
        <p>'.$item_display['security_note'].'</p>
        <div class="af-clear"></div>
      </div>
    </div>
  </div>
  <div class="af-footer">
    <div class="bodyText"> </div>
  </div>
</div>
';
?>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
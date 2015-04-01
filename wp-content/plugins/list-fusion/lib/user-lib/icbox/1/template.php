<?php 
global $ListFusionPlugin;

$insideCommentBox  = '<style>';
$insideCommentBox .= stripslashes($item_display->custom_css_code);
if( $template_submit_text_size != '' ) { $insideCommentBox .= '#listfusion-insidecmtbox-one .af-body input[type="submit"] {font-size: '.$template_submit_text_size.'px!important;}'; }
$insideCommentBox .= '#listfusion-insidecmtbox-one .af-body input[type="submit"].listfusion-submit-btn {
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
#listfusion-insidecmtbox-one .af-body input[type="submit"].listfusion-submit-btn:hover {
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
$insideCommentBox .= '</style>';

$insideCommentBox .= '<div id="listfusion-insidecmtbox-one" class="af-form">
  <div class="af-header">
    <div class="bodyText">
      <p align="left" style="padding-left:4%; padding-right:4%;"> <span style="font-size:'.($template_title_text_size?$template_title_text_size:'20').'px; font-weight:400; font-family:Gudea;line-height: 30px;">'.$item_display->title.'</span> </p>
    </div>
  </div>
  <div align="center" class="af-body af-standards">';
	
if( $item_display->item_type == 'icboxad' ) { 

	 $insideCommentBox .= " <a onclick=\"return listfusion_sidebar_red('".$ad_redirectURL."', '".$ad_openIN."', '".$this->template_data_sessionID."');\" style=\"text-decoration:none;\" id=\"listfusion_count_sidebar_adclick\">
	  <input type=\"submit\" class=\"listfusion-submit-btn\" value='".$this->template_submit_btm_txt."' />
	  </a>";

} else {	
	
$insideCommentBox .= ''.$ListFusionPlugin->__listfusion_arpForm( $arpID, 'name', 'email', 'listfusion-submit-btn', 1, $item_ROOTID, $popupDontShowMeAfterSubCOOKIE, $once_subscribe_disable_for, $chk_sub_disable, 'emailItem'.$item_ROOTID).'';

}
	
$insideCommentBox .= '<div class="af-element privacyPolicy" style="text-align:center;padding-top: 5px;">
      <p>'.$item_display->security_note.'</p>
      <div class="af-clear"></div>
    </div>
  </div>
</div>';
?>
<?php
if ( !is_admin() && !is_feed() ) {
echo '<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>';
}
?>
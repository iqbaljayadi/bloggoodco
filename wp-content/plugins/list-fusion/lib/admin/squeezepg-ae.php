<script type="text/javascript" src="<?php echo LIST_FUSION_FULLPATH; ?>lib/js/jscolor.js"></script>
<script type="text/javascript" src="<?php echo LIST_FUSION_FULLPATH; ?>lib/js/list-fld.js"></script>
<?php 
if( LIST_FUSION_WP_VERSION < "3.5" ) {  
	wp_enqueue_script( 'listfusion-upload-js', LIST_FUSION_LIBPATH . 'js/upload/field_upload_3_4.js', array('jquery', 'thickbox', 'media-upload'), time(), true );
	wp_enqueue_style('thickbox');
} else {  
	wp_enqueue_script( 'listfusion-upload-js', LIST_FUSION_LIBPATH . 'js/upload/field_upload.js', array('jquery'), time(), true );
	wp_enqueue_media();
}
wp_localize_script('listfusion-upload-js', 'listfusion_upload', array('url' => LIST_FUSION_LIBPATH . 'js/upload/blank.png'));

if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'squeezepg' ) {
	$image_preview_type = 'squeezepg'.$this->process_dec_options['preview_type'];
	$display_fieldID = 1;
} else {
	$image_preview_type = 'squeezepg1';
}

?>

<h2 style="padding-bottom:10px; font-weight:bold;">
  <?php if(isset($_GET['id'])) { ?>
  Edit
  <?php } else { ?>
  Add New
  <?php } ?>
  Squeeze Page</h2>
<div style="padding:5px 0px 10px 0px;"> <a href="<?php echo $this->listfusion_page; ?>">
  <input name="" type="button" class="button button-primary"  value="<< Back To DashBoard" />
  </a> </div>
  
<?php
$filename = LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template().'/template-listfusion-squeezepg.php';
if ( !file_exists( $filename ) ) { 
	echo '<div style="background-color:#FFFFAA; height:24px; padding:15px 20px 6px 20px; width:780px; font-weight:bold; font-size:15px;">
				<span style="color:red"><strong>Squeeze page is NOT ACTIVATED yet</strong></span>, Please <a style="color:#0066FF;" href="'.LIST_FUSION_SITEURL.'/wp-admin/admin.php?page=listfusion-settings">CLICK HERE</a> to activate. <br><br> 

	</div>';
} else {
	echo '<div style="height:24px; padding:15px 20px 6px 0px; width:780px; font-weight:bold; font-size:15px;">
				<span style="color:green"><strong>How to display a squeeze page?</strong></span> (<a style="color:#0066FF;" href="'.LIST_FUSION_SITEURL.'/wp-admin/admin.php?page=listfusion-settings" target="_blank">Getting Started Guide</a>). <br><br> 

	</div>';
}
?> 
  
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  <div id="listfusion-nav">
    <ul>
      <li class="current" onclick="__listfusionSelectTab(1,'squeezepg')"><a id="listfusionHead-1"><strong>Squeeze Page</strong></a></li>
    </ul>
  </div>
  <div class="listfusion-content">
    <div class="listfusion-section">
      <!--Start squeeze page-->
      <form action="" method="post" name="squeezepg" onsubmit="return __listfusion_sqpg_chk();">
        <input type="hidden" value="squeezepg" id="listFusionType" name="listfusion[fusionType]" >
        <!--ARP CHECK-->
        <?php if( $displayARPMessage == 1 ) { ?>
        <div style="font-size:11px; background-color:#FFFBCC; padding:17px 6px 0px 6px;font-family: Open Sans,sans-serif;">
          <div style="text-align:center"> <span class="listfusion-placementLinks" style="font-weight:bold;"> WARNING: <a href="?page=listfusion-arp">Click To Connect</a> With Your AutoResponder Service Before Using Squeeze Page </span> </div>
          <div>&nbsp;</div>
        </div>
        <?php } ?>
        <!--EOF ARP CHECK-->
        <div id="squeezepg_lookNfeel_normal">
          <h3 class="listfusion_heading" style="border-bottom:none; padding-bottom:10px;"> <span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Look and feel: &nbsp;&nbsp;
            <select name="listfusion[preview_type]" id="theme_preview_type" style="width:180px; background-color:#FDECE9" onchange="listfusion_demo_graber('imgpreview', this.value, '<?php echo LIST_FUSION_ADMIN_URL; ?>', 'listFusionType')" >
              <?php for( $i=1; $i<=10; $i++ ) { ?>
              <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['preview_type'] == $i ) { echo 'selected'; } ?> >Theme <?php echo $i; ?></option>
              <?php } ?>
            </select>
            &nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
          <span id="loaddemo_previewimg" style="display:none;"><img src="<?php echo LIST_FUSION_FULLPATH; ?>lib/images/spinner.gif"></span>
          <!--preview-->
          <div id="ajx-preview-sqpg" style="background-color:#F9F8F3; padding:20px 5px;-moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;display:block; text-align:center;"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/squeezepg/<?php echo $image_preview_type; ?>.png" style="border:none;" /></div>
        </div>
		
		<!--Background Design-->
		        <h3 id="squeezepg_background_design" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_sqpg_background_design', 'listfusion_sqpg_background_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_sqpg_btm_design_img" border="0" title="Click to collapse" align="top" />Design Page Background</a>&nbsp;&nbsp;</h3>
        <div id="listfusion_sqpg_background_design" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
              <tbody>
                <tr valign="top">
                  <th width="20%">Page Background Color</th>
                  <td><input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['page_background_color']:'FFFFFF'); ?>'; name="listfusion[page_background_color]"  /><span style="color:#c4c4c4; padding-left:5px;"> (Default: FFFFFF) </span><br><br>
				  <span style="color:#c4c4c4; padding-left:5px; font-size:12px;"> Backround color will not work for theme number 4,5,7,10 </span>
				  </td>
                </tr>
				
				<tr valign="top">
                  <th width="20%">&nbsp;</th>
                  <td>- OR -</td>
                </tr>

				
			 <tr valign="top" id="preview_uploadimg">
              <th scope="row">Page Background Image</th>
              <td>
			    <input type="hidden" id="img_bg" name="listfusion[background_img_url]" value="<?php echo $this->process_dec_options['background_img_url']; ?>" class="regular-text">
				<?php if( isset($_GET['id']) && $this->process_dec_options['background_img_url'] != '' ) { ?>
					<div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="<?php echo $this->process_dec_options['background_img_url']; ?>" style="display: block; width:50%;"> </div>
					<a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display:inline-block;" rel-id="img_bg">Remove Upload</a>
					<a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img_bg" style="display:none;">Upload</a> 
				<?php } else { ?>
					<div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="" style="display: none;width:50%;"> </div>
					<a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display: none;" rel-id="img_bg">Remove Upload</a>
					<a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img_bg" style="display: inline-block;">Upload</a> 
				<?php } ?>
				</td>
            </tr>
			
			
                <tr valign="top">
                  <th width="20%">Background Image Display</th>
                  <td>
				  <input name="listfusion[field_img_url_repeat_cover]" type="radio" value="1" 
				  <?php echo ( $_GET['id'] ? (($this->process_dec_options['field_img_url_repeat_cover'] == 1 ) ? 'checked' :'' ): '' ); ?> /> Repeat  &nbsp;&nbsp;&nbsp;  
				  <input name="listfusion[field_img_url_repeat_cover]" type="radio" value="2" 
				  <?php echo ( $_GET['id'] ? (($this->process_dec_options['field_img_url_repeat_cover'] == 2 ) ? 'checked':'' ) : 'checked' ); ?> /> Cover
				  </td>
                </tr>
				
				
                <tr valign="top">
                  <th width="20%">IMPORTANT NOTE:</th>
                  <td>If, you have upload backgound image then system will give more priority to uploaded background image rather then backgound color</td>
                </tr>

              </tbody>
            </table>		
		</div>
		<!--Eof Background Design-->
		
		
		
		
		
        <!--Submit Btm Design-->
        <h3 id="squeezepg_submitbtm_design" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_sqpg_btm_design', 'listfusion_sqpg_btm_design_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_sqpg_btm_design_img" border="0" title="Click to collapse" align="top" />Design submit button</a>&nbsp;&nbsp;</h3>
        <div id="listfusion_sqpg_btm_design" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
          <div style="padding:3px 4px 4px 4px; ">
            <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
              <tbody>
                <tr valign="top">
                  <th width="20%">Button Background - Gradient</th>
                  <td>from
                    <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_from_color']:'FDC32A'); ?>'; name="listfusion[btm_from_color]" style="width:120px;" />
                    to
                    <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_to_color']:'FF6A00'); ?>'; name="listfusion[btm_to_color]" style="width:120px;" />
                    <br>
                    <br>
                    <span style="color:#c4c4c4; padding-left:5px;"> (Default: FDC32A, FF6A00) </span> </td>
                </tr>
                <tr valign="top">
                  <th width="20%">Button Background:hover - Gradient</th>
                  <td>from
                    <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_from_hover_color']:'FDC32A'); ?>'; name="listfusion[btm_from_hover_color]" style="width:120px;" />
                    to
                    <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_to_hover_color']:'FDC32A'); ?>'; name="listfusion[btm_to_hover_color]" style="width:120px;" />
                    <br>
                    <br>
                    <span style="color:#c4c4c4; padding-left:5px;"> (Default: FDC32A, FDC32A) </span> </td>
                </tr>
                <tr valign="top">
                  <th width="20%">Button Border Color</th>
                  <td><input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_border_color']:'FF6A00'); ?>'; name="listfusion[btm_border_color]" style="width:120px;" />
                    <span style="color:#c4c4c4; padding-left:5px;"> (Default: FF6A00) </span> </td>
                </tr>
                <tr valign="top">
                  <th width="20%">Submit Button Text Color:</th>
                  <td><input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['submit_btm_text']:'222222'); ?>'; name="listfusion[submit_btm_text]" style="width:120px;" />
                    <span style="color:#c4c4c4; padding-left:5px;"> (Default: 222222) </span> </td>
                </tr>
                <tr valign="top">
                  <th width="20%">Submit Button Font Size:</th>
                  <td><select name="listfusion[submit_font_size]" rows="6">
                      <?php 
				  if( $this->process_dec_options['submit_font_size'] ) $chk_submit_font_size = $this->process_dec_options['submit_font_size'];
				  else $chk_submit_font_size = 24;
				  for( $submitfont=12; $submitfont<=40; $submitfont++ ) { ?>
                      <option value="<?php echo $submitfont; ?>" <?php if( $chk_submit_font_size == $submitfont ) { echo 'selected';  } ?> ><?php echo $submitfont; ?>px</option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
		
		
        <!--arp connection-->
        <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">4</span>&nbsp;&nbsp;Connect template with your autoresponder service&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (OPTIN)</span> </h3>
        <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
          <?php $this->__listfusion_autoresponderComboBox( 'listfusion[selected_arp]',''.$this->listfusionShow_placement_arp_id.'', 'sqpg_arpJs' ,'popup_dropdownResponsebk', 'sqpg_SplitName','sqpg_OnlyName_arp','sqpg_selected_onlyEmail','sqpg_arp_trackingcode' ); ?>
          <span id="popup_dropdownResponsebk" style="display:none;"><img src="<?php echo LIST_FUSION_FULLPATH; ?>lib/images/spinner.gif"></span> </div>
        <div id="displayARPajxResult"  style="display:<?php echo ($_GET['id']?$this->listfusionShow_TrackingFldSH:'none'); ?>;padding:2px 4px 2px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
          <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
            <tbody>
              <tr valign="top">
                <th width="20%">Tracking Code:</th>
                <td width="80%"><input type="text" name="listfusion[arp_trackingcode]"  style="width:180px;width:280px; background-color:#FFFBCC;" value="<?php echo $this->listfusionShow_placement_arp_trackingcode; ?>" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--Content Fill Up Section-->
        <h3 id="contentfillup" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">5</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_sqpg_content', 'listfusion_sqpg_content_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_sqpg_content_img" border="0" title="Click to collapse" align="top" />Content fill-up section</a>&nbsp;&nbsp;</h3>
        <div id="listfusion_sqpg_content" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
          <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
            <tbody>
              <tr valign="top" id="sqpg_auto_warning">
                <th width="20%">Warning text</th>
                <td width="80%"><input type="text" value="<?php echo ($_GET['id']?$this->process_dec_options['field_warningtxt']:'WARNING'); ?>" name="listfusion[field_warningtxt]" /></td>
              </tr>
              <tr valign="top" id="sqpg_auto_optinmsg">
                <th width="20%">Optin Message </th>
                <td width="80%"><textarea name="listfusion[field_optinmsg]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_optinmsg; ?></textarea>
				 <input type="text" class="color" id="change_text_msg_color"  value='<?php echo ($_GET['id']?$this->process_dec_options['text_msg_color']:'000000'); ?>'; name="listfusion[text_msg_color]" style="width:120px;" /> <span id="span_change_text_msg_color" style="color:#F02121; padding-left:5px;"> (Default: 000000) </span>
                </td>
              </tr>
              <tr valign="top" id="sqpg_auto_title">
                <th width="20%">Bold Title</th>
                <td width="80%"><textarea name="listfusion[field_header]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_title; ?></textarea>
                  <select name="listfusion[field_header_size]" class="colorSelectorInput" rows="6">
                    <option value="">--- Font Size ---</option>
                    <?php for( $i=26; $i<=73; $i++ ) { ?>
                    <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['field_header_size'] == $i ) { echo 'selected';  } ?> ><?php echo $i; ?>px</option>
                    <?php } ?>
                  </select>
				  
				  <input type="text" class="color" id="change_text_bold_color"  value='<?php echo ($_GET['id']?$this->process_dec_options['text_bold_msg_color']:'444444'); ?>'; name="listfusion[text_bold_msg_color]" style="width:120px;" /> <span id="span_text_bold_color" style="color:#c4c4c4; padding-left:5px;"> (Default: 444444) </span>
				  
                </td>
              </tr>
              <tr valign="top" id="sqpg_auto_msg">
                <th scope="row">Message</th>
                <td><textarea name="listfusion[field_main_msg]" class="large-text code" rows="10" cols="55"><?php echo $this->listfusionShow_placement_msg; ?></textarea>
                  <p><i><strong>Information</strong>: support HTML tags</i>
				  &nbsp;
				  <input id="text_bodymainmsg_color" type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['text_main_msg_color']:'333333'); ?>'; name="listfusion[text_main_msg_color]" style="width:120px;" /> <span id="span_text_bodymainmsg_color" style="color:#c4c4c4; padding-left:5px;font-size:12px;"> (Default: 333333) </span></p>
				  
				  </td>
              </tr>
              <tr valign="top">
                <th width="20%">Security note</th>
                <td width="80%"><input name="listfusion[field_security_note]" type="text" value="<?php echo $this->listfusionShow_placement_security_note; ?>" size="35px" class="regular-text" style="width:220px;" />
				  <input type="text" id="change_text_security_color" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['text_security_color']:'999999'); ?>'; name="listfusion[text_security_color]" style="width:120px;" /> <span id="span_text_security_color" style="color:#c4c4c4; padding-left:5px; font-size:12px;"> (Default: 999999) </span>
				
				</td>
              </tr>
              <tr valign="top">
                <th width="20%">Submit button text</th>
                <td width="80%"><input id="popup_submitbtn_txt" name="listfusion[field_button_text]" type="text" value="<?php echo $this->listfusionShow_placement_submit_txt; ?>" size="35px" class="regular-text" />
                  <!--Select Btm Text-->
                  <div class="listfusion-placementLinks"> <span style="font-size:11px; color:#999999;"><a onClick="__JS_listfustion_ShowHide('listfusion_popup_btm_pretext', 'listfusion_popup_btm_pretext_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer"><img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_btm_pretext_img" border="0"  align="top" />&nbsp;Pre-define button text</a></span> </div>
                  <div id="listfusion_popup_btm_pretext" style="display:none">
                    <table width="100%" border="0">
                      <tr>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Download Now');" style="text-decoration:none; color:#999999;">Download Now</a></td>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Get Access Now!');" style="text-decoration:none; color:#999999;">Get Access Now!</a></td>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Get Instant Access!');" style="text-decoration:none; color:#999999;">Get Instant Access!</a></td>
                      </tr>
                      <tr>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Yes! Let Me In Now');" style="text-decoration:none; color:#999999;">Yes! Let Me In Now</a></td>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Sign Up Now');" style="text-decoration:none; color:#999999;">Sign Up Now</a></td>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','YES! Let Me In!');" style="text-decoration:none; color:#999999;">YES! Let Me In!</a></td>
                      </tr>
                      <tr>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Get Early Bird Access');" style="text-decoration:none; color:#999999;">Get Early Bird Access</a></td>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Get On The Waiting List');" style="text-decoration:none; color:#999999;">Get On The Waiting List</a></td>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','YES! Let Me in Early');" style="text-decoration:none; color:#999999;">YES! Let Me in Early</a></td>
                      </tr>
                      <tr>
                        <td style="font-size:11px; color:#999999; padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Get On The List');" style="text-decoration:none; color:#999999;">Get On The List</a></td>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Send Me The Video');" style="text-decoration:none; color:#999999;">Send Me The Video</a></td>
                        <td style="font-size:11px; color:#999999;  padding:4px 0px;"><a href="javascript:void(0);" onmouseover="__listfusion_autofillin('popup_submitbtn_txt','Show Me The Video');" style="text-decoration:none; color:#999999;">Show Me The Video</a></td>
                      </tr>
                    </table>
                  </div>
                  <!--Eof Select Btm Text-->
                </td>
              </tr>
              <tr valign="top" id="sqpg_auto_listpoint">
                <th width="20%">List points</th>
                <td width="20%"><ul id="bulletlist-ul" style="padding-top:0px; margin-top:0px;">
                    <?php
				  if( $_GET['id'] &&  $this->listfusionShow_placement_list_points != '' ) { 
				  foreach( (array) $this->listfusionShow_placement_list_points as $key => $val ) {
				  if( $val == '' ) { 
				  	unset($key);
				  } else {	
				?>
                    <li>
                      <input type="text" id="bulletlist" name="listfusion[field_list_points][]" value="<?php echo $val; ?>" class="regular-text">
                      <input type="button" class="listfusion-multiTextRemove button" value="Remove">
                    </li>
                    <?php 
				   }
				  }
				  }
				  ?>
                    <li style="display:none;">
                      <input type="text" id="bulletlist" name="listfusion[field_list_points][]" value="" class="regular-text">
                      <input type="button" class="listfusion-multiTextRemove button" value="Remove">
                    </li>
                  </ul>
                  <input type="button" class="listfusion-multiTextAdd button" rel-id="bulletlist-ul" rel-name="listfusion[field_list_points][]" value="Add List">
				 <input id="text_listpoint_color" type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['listpoint_color']:'333333'); ?>'; name="listfusion[listpoint_color]" style="width:120px;" /> <span id="span_text_listpoint_color" style="color:#c4c4c4; padding-left:5px;font-size:12px;"> (Default: 333333) </span>

                </td>
              </tr>
              <tr valign="top" id="sqpg_auto_img">
                <th scope="row">Image</th>
                <td><input type="hidden" id="img" name="listfusion[field_img_url]" value="<?php echo $this->process_dec_options['field_img_url']; ?>" class="regular-text">
                  <?php if( isset($_GET['id']) && $this->process_dec_options['field_img_url'] != '' ) { ?>
                  <div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="<?php echo $this->process_dec_options['field_img_url']; ?>" style="display: block; width:50%;"> </div>
                  <a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display:inline-block;" rel-id="img">Remove Upload</a> <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img" style="display:none;">Upload</a>
                  <?php } else { ?>
                  <div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="" style="display: none;width:50%;"> </div>
                  <a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display: none;" rel-id="img">Remove Upload</a> <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img" style="display: inline-block;">Upload</a>
                  <?php } ?>
                </td>
              </tr>
            </tbody>
          </table>
          <div id="sqpg_auto_video" style="display:block;">
            <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
              <tbody>
                <tr valign="top">
                  <th scope="row" width="20%">Video embed code</th>
                  <td width="80%"><textarea name="listfusion[field_video_code]" class="large-text code" rows="4" cols="55"><?php echo $this->listfusionShow_placement_video_code; ?></textarea>
                   </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <h3 class="listfusion_heading" style="padding-bottom:10px; border:none;"><span class="listfusion_stepIndicator listfusion_stepActive">5</span>&nbsp;
          Squeeze page name:
          <input name="listfusion[displayname]" type="text" id="sqpgdisplayname" value="<?php echo trim($this->listfusionShow_placement_name); ?>" size="35px" class="regular-text" style="width:200px;" />
          <span style="color: #c4c4c4; font-weight:normal; font-size:12px;">(Appears only to you)</span>&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span> </h3>
        <div style="padding-top:20px;">
          <input type="submit" class="button button-primary" value="Save" name="listfusion[process_squeezepg_save]" />
        </div>
        <input type="hidden" value="<?php echo $_GET['split']; ?>" name="listfusion[split_id]">
        <input type="hidden" value="<?php echo LIST_FUSION_ADMIN_URL; ?>" id="listfusion_ajax_url">
      </form>
      <!--/Eof squeeze page-->
    </div>
  </div>
</div>
<script>
window.onload=function(){ 
__listfusionSelectTab(<?php echo ($display_fieldID?$display_fieldID:'1'); ?>,'<?php echo ($this->listfusionShow_placement_item_type?$this->listfusionShow_placement_item_type:'squeezepg'); ?>');
};
</script>

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

if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'optinpopup' ) {
	$image_preview_type = 'optinpopup'.$this->process_dec_options['preview_type'];
	$display_fieldID = 1;
} else if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'adpopup' ) {
	$image_preview_type = 'adpopup'.$this->process_dec_options['preview_type'];
	$display_fieldID = 2;
} else if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'socialpopup' ) {
	$image_preview_type = 'socialpopup'.$this->process_dec_options['preview_type'];
	$display_fieldID = 3;
} else if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'custompopup' ) {
	$display_fieldID = 4;
} else {
	$image_preview_type = 'optinpopup1';
}
?>

<h2 style="padding-bottom:10px; font-weight:bold;">
  <?php if(isset($_GET['id'])) { ?>
  Edit
  <?php } else { ?>
  Add New
  <?php } ?>
  PopUp</h2>
<div style="padding:5px 0px 10px 0px;"> <a href="<?php echo $this->listfusion_page; ?>"><input name="" type="button" class="button button-primary"  value="<< Back To DashBoard" /></a> 
  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php if( $_GET['ab'] == 'true' ) { ?>
  <span style="color:#FF0000; font-weight:normal; font-size:14px; background:#FFFFCC; padding:10px;">You Are On <strong>SPLIT TEST MODE</strong> (Note: Some feature will go disable on SPLIT TEST PROCESS)</span> 
  <?php } ?>
  
  </div>
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  <div id="listfusion-nav">
    <ul>
      <li class="current" onclick="__listfusionSelectTab(1,'optinpopup')"><a id="listfusionHead-1"><strong>Optin PopUp</strong></a></li>
      <li onclick="__listfusionSelectTab(2,'adpopup')"><a id="listfusionHead-2" ><strong>Ad PopUp</strong></a></li>
      <li onclick="__listfusionSelectTab(3,'socialpopup')"><a id="listfusionHead-3" ><strong>Social Share PopUp</strong></a></li>
      <li onclick="__listfusionSelectTab(4,'custompopup')"><a id="listfusionHead-4" ><strong>Custom PopUp </strong></a></li>
    </ul>
  </div>
  <div class="listfusion-content">
    <div class="listfusion-section">
      <form action="" method="post" name="popup" onsubmit="return __listfusion_popup_chk();">
	  <input type="hidden" value="optinpopup" id="listFusionType" name="listfusion[fusionType]" >
      <!--Start PopUp-->
      <?php if( $displayARPMessage == 1 ) { ?>
      <div style="font-size:11px; background-color:#FFFBCC; padding:17px 10px 0px 10px;font-family: Open Sans,sans-serif;">
        <div style="text-align:center"> <span class="listfusion-placementLinks" style="font-weight:bold;"> WARNING: <a href="?page=listfusion-arp">Click To Connect</a> With Your AutoResponder Service Before Using Optin PopUp </span> </div>
        <div>&nbsp;</div>
      </div>
      <?php } ?>
      <!--Start PopUp-->
	  <div id="lookNfeel_custom" style="display:none;">
		  <h3 class="listfusion_heading" style="border-bottom:none; padding-bottom:10px;">
		  <span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Custom popup option: &nbsp;&nbsp;
			<input name="listfusion[htmloriframe]" type="radio" value="1" onclick="__listfusion_custom_popup();" 
			<?php   echo ( $_GET['id'] ?(($this->process_dec_options['htmloriframe']==1)?'checked':''):'checked');  ?> 
			/>&nbsp;HTML&nbsp;&nbsp;
			<input name="listfusion[htmloriframe]" type="radio" value="2" onclick="__listfusion_custom_popup();" 
			<?php if($this->process_dec_options['htmloriframe']==2) { echo 'checked'; } ?> 
			/>&nbsp;IFRAME&nbsp;
		  &nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> 
		  </h3>	
		  
		<div id="custom_html" style="display:<?php echo ($_GET['id']?(($this->process_dec_options['htmloriframe']==1)?'block':'none'):'block'); ?>">  
			<div style="color:#999999; padding:10px; background-color:#FFFFCC; margin:5px 0px 15px 0px;">
			<input name="listfusion[popup_applyshortcode]" type="checkbox" value="1"  <?php if($this->process_dec_options['popup_applyshortcode']==1){ echo 'checked'; } ?> /> <strong style="color:#000000; font-size:14px;">Apply ShortCode</strong> 
			<span style="padding-left:10px;">(<span style="color:#FF9900">INFORMATION:</span> Custom popup supports ANY SHORTCODES)</span>
			</div>
			<?php 
				$html_iframe_contentValue = ( $this->listfusionShow_placement_custom_msg?$this->listfusionShow_placement_custom_msg:'' ); 
				$this->listfusion_display_editor($html_iframe_contentValue, 'custom_popup_content'); 
			?>
			
			
		<div style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
            <tr valign="top">
              <th width="20%">Width</th>
			  <td width="80%"><input type="text"  value="<?php echo ($_GET['id']?$this->process_dec_options['popup_custom_html_width']:'450px'); ?>" name="listfusion[popup_custom_html_width]" /> 
          <span style="color:#999999; padding-left:5px;"> px or % (default: 450px) </span></td>
			</tr>
			</tr>
            <tr valign="top">
              <th width="20%">Height</th>
			  <td width="80%"><input type="text" value="<?php echo ($_GET['id']?$this->process_dec_options['popup_custom_html_height']:'300px'); ?>" name="listfusion[popup_custom_html_height]" /> 
          <span style="color:#999999; padding-left:5px;"> px or % (default: 300px) </span></td>
			</tr>
		  </tbody>
	    </table>	  	  
		</div>

			
			
		</div>
		
		<div id="custom_iframe" style="display:<?php echo ($_GET['id']?(($this->process_dec_options['htmloriframe']==2)?'block':'none'):'none'); ?>;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
            <tr valign="top">
              <th width="20%">Source Url</th>
			  <td width="80%">
			  <input name="listfusion[popup_custom_source_url]" type="text" class="regular-text" value="<?php echo $this->process_dec_options['popup_custom_source_url']; ?>" />
		  </td>
			</tr>
            <tr valign="top">
              <th width="20%">Width</th>
			  <td width="80%"><input type="text"  value="<?php echo ($_GET['id']?$this->process_dec_options['popup_custom_width']:'75'); ?>" name="listfusion[popup_custom_width]" /> %
          <span style="color:#999999; padding-left:5px;"> (Default:75%) </span></td>
			</tr>
			</tr>
            <tr valign="top">
              <th width="20%">Height</th>
			  <td width="80%"><input type="text" value="<?php echo ($_GET['id']?$this->process_dec_options['popup_custom_height']:'75'); ?>" name="listfusion[popup_custom_height]" /> %
          <span style="color:#999999; padding-left:5px;"> (Default:75%) </span></td>
			</tr>
		  </tbody>
	    </table>	  	  
		
		
		
		</div>
		
	  </div>  
	  
	  <div id="lookNfeel_normal">
      <h3 class="listfusion_heading" style="border-bottom:none; padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Look and feel: &nbsp;&nbsp;
        <select name="listfusion[preview_type]" id="theme_preview_type" style="width:180px; background-color:#FDECE9" onchange="listfusion_demo_graber('imgpreview', this.value, '<?php echo LIST_FUSION_ADMIN_URL; ?>', 'listFusionType')" >
		
		  <?php for( $i=1; $i<=16; $i++ ) { ?>
		  <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['preview_type'] == $i ) { echo 'selected'; } ?> >Theme <?php echo $i; ?></option>
		  <?php } ?>
		  
        </select>
        &nbsp;
		<span id="preview_pickdesign_color">
        <select name="listfusion[preview_color]" style="width:150px;" >
          <option>---Pick Color---</option>
          <option value="1" <?php if( $this->process_dec_options['preview_color'] == '1' ) { echo 'selected'; } ?>> Blue</option>
          <option value="2" <?php if( $this->process_dec_options['preview_color'] == '2' ) { echo 'selected'; } ?>> Red</option>
          <option value="3" <?php if( $this->process_dec_options['preview_color'] == '3' ) { echo 'selected'; } ?>> Black</option>
          <option value="4" <?php if( $this->process_dec_options['preview_color'] == '4' ) { echo 'selected'; } ?>> Purple</option>
          <option value="5" <?php if( $this->process_dec_options['preview_color'] == '5' ) { echo 'selected'; } ?>> Green</option>
        </select>
		</span>
        &nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
		<span id="loaddemo_previewimg" style="display:none;"><img src="<?php echo LIST_FUSION_FULLPATH; ?>lib/images/spinner.gif"></span>
      <div id="ajx-preview" style="background-color:#F9F8F3; padding:20px 5px;-moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;display:block; text-align:center;"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/popup/<?php echo $image_preview_type; ?>.png" style="border:none;" /></div>
	  </div>
	  
      <!--START SUBMIT/LINK DESIGN-->
      <h3 id="designsubmitbtm" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_btm_design', 'listfusion_popup_btm_design_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_btm_design_img" border="0" title="Click to collapse" align="top" />Design submit/link button</a>&nbsp;&nbsp;</h3>
      <div id="listfusion_popup_btm_design" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  
        <div style="padding:3px 4px 4px 4px; ">
		
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
            <tr valign="top">
              <th width="20%">Button Background - Gradient</th>
			  <td>from
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_from_color']:'FDC32A'); ?>'; name="listfusion[btm_from_color]" style="width:120px;" />
          to
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_to_color']:'FF6A00'); ?>'; name="listfusion[btm_to_color]" style="width:120px;" />
		  <br><br><span style="color:#c4c4c4; padding-left:5px;"> (Default: FDC32A, FF6A00) </span>
		  </td>
			</tr>
			
            <tr valign="top">
              <th width="20%">Button Background:hover - Gradient</th>
			  <td>from
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_from_hover_color']:'FDC32A'); ?>'; name="listfusion[btm_from_hover_color]" style="width:120px;" />
          to
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['btm_to_hover_color']:'FDC32A'); ?>'; name="listfusion[btm_to_hover_color]" style="width:120px;" />
		  <br><br><span style="color:#c4c4c4; padding-left:5px;"> (Default: FDC32A, FDC32A) </span>
		  </td>
			</tr>
			
			
            <tr valign="top">
              <th width="20%">Submit Button Text Color:</th>
			  <td><input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['submit_btm_text']:'222222'); ?>'; name="listfusion[submit_btm_text]" />
          <span style="color:#c4c4c4; padding-left:5px;"> (Default: 222222) </span></td>
			</tr>
			
            <tr valign="top">
              <th width="20%">Submit Button Font Size:</th>
			  <td>
			  <select name="listfusion[submit_font_size]" rows="6">
				  <?php 
				  if( $this->process_dec_options['submit_font_size'] ) $chk_submit_font_size = $this->process_dec_options['submit_font_size'];
				  else $chk_submit_font_size = 19;
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
      <!--EOF START SUBMIT/LINK DESIGN-->
	  
      <!--AUTO-RESPONDER CONNECTION-->
	  
	  	<!--SHOW HIDE: OPTIN-->
	  <div id="autoresponderConnection" style="display:block">
		  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;Connect template with your autoresponder service&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (OPTIN)</span> </h3>
		  <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
			<?php $this->__listfusion_autoresponderComboBox( 'listfusion[selected_arp]',''.$this->listfusionShow_placement_arp_id.'', 'popup_arpJs' ,'popup_dropdownResponsebk', 'popp_SplitName','popp_OnlyName_arp','popup_selected_onlyEmail','popup_arp_trackingcode' ); ?>
			<span id="popup_dropdownResponsebk" style="display:none;"><img src="<?php echo LIST_FUSION_FULLPATH; ?>lib/images/spinner.gif"></span> 
		  </div>
		  
		  <div id="displayARPajxResult"  style="display:<?php echo ($_GET['id']?$this->listfusionShow_TrackingFldSH:'none'); ?>;padding:2px 4px 2px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		  
			<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Tracking Code:</th>
					<td width="80%">
						<input type="text" name="listfusion[arp_trackingcode]"  style="width:180px;width:280px; background-color:#FFFBCC;" value="<?php echo $this->listfusionShow_placement_arp_trackingcode; ?>" /> 
					</td>
				</tr>
			</tbody>
			</table>	

		  
		  </div>
		  
		  			  <div id="preview_optinmsg" style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Optin Message</th>
					<td width="80%">
						<textarea name="listfusion[field_optinmsg]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_optinmsg;  ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>		
	  </div>

		  
	  </div>
	  
	  	<!--SHOW HIDE: AD-->
	  <div id="popup_displayAds" style="display:none;">
		  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;Ad popup configuration&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (AD)</span> </h3>
      <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Redirect link url</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<input id="popup_redirectURL" name="listfusion[ad_redirecturl]" type="text" value="<?php echo $this->process_dec_options['ad_redirecturl']; ?>" size="35px" class="regular-text" />
						<div style="padding-left:5px; padding-top:15px;">
						open link in &nbsp;&nbsp;
						<input name="listfusion[ad_linkopenin]" type="radio" value="1" <?php echo ($_GET['id']?(($this->process_dec_options['ad_linkopenin'] == 1)?'checked':'' ):'checked') ?> /> same window  &nbsp;&nbsp;
						<input name="listfusion[ad_linkopenin]" type="radio" value="2" <?php if( $this->process_dec_options['ad_linkopenin'] == 2 ) { echo 'checked'; } ?> /> new window
						</div>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th width="20%">Cute link</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<?php bloginfo('siteurl');?>/<input type="text" id="textcutelink"  value="<?php echo $this->listfusionShow_placement_cutelink; ?>" name="listfusion[ad_cutelink]" style="line-height:20px; width:200px;"> 
						 <?php if ( get_option('permalink_structure') == '' ) { ?>  
							<div style="color:#999999; padding:10px; background-color:#FFFFCC; margin-top:10px;">
							<span style="color:#FF9900">WARNING:</span> <strong>WordPress must be configured</strong>, cute link won't work until you select a permalink structure other than "Default" ... <a href="<?php echo get_bloginfo('siteurl'); ?>/wp-admin/options-permalink.php" style="color:#0033FF; text-decoration:none;">Permalink Settings</a>
							</div>
						 <?php } else { ?>
							<div style="color:#999999; padding-left:5px; padding-top:15px;">
							(Max 50 character allowed, Leave empty to disable)
							</div>
						 <?php } ?>
						
						
						</div>
					</td>
				</tr>
				
				
				<tr valign="top">
					<th width="20%">Cloak link URL</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<input type="text" id="textlink"  value="<?php echo $this->process_dec_options['ad_clocklink']; ?>" name="listfusion[ad_clocklink]" style="line-height:20px; width:200px;"><span style="color:#999999; padding-left:5px;"> leave bank to disable </span>
						<div style="color:#999999; padding-left:5px; padding-top:15px;">
						<span style="color:#FF9900">REMINDER:</span> Some of the affiliate network won't allow to cloak their links, Before activating this feature make sure you read affiliate networks TOS (Terms of Service), <br><br>Cute Link MUST be activate to enable this feature.
						</span>
						</div>
						</div>
					</td>
				</tr>

			</tbody>
		</table>			
		</div>
		
	  <div id="preview_admsg" style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Ad Message</th>
					<td width="80%">
						<textarea name="listfusion[field_admsg]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_admsg; ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>		
	  </div>
			  
	  </div>
	  
		
      <div id="blockaftersubsORclickad" style="display:block;padding:0px 0px 0px 25px; border-bottom:1px solid #EEEDED; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;"></div>
		
	  	<!--SHOW HIDE: SOCIAL SHARE-->
	  <div id="popup_socialShare" style="display:none;">
		  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;Social popup configuration&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (SOCIAL)</span> </h3>
      <div id="listfusion_popup_social_content" style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Facebook</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<div>
						<input name="listfusion[social_show_facebook]" type="checkbox" value="1" <?php if( $this->process_dec_options['social_show_facebook'] == 1 ) { echo 'checked'; } ?> />&nbsp;show like button 
						</div>
						<br>
						URL to like <input name="listfusion[social_facebook_url]" type="text" value="<?php echo $this->process_dec_options['social_facebook_url']; ?>" size="35px" class="regular-text" /> <div style="color:#c4c4c4; padding-top:5px;">(Leave empty to use display page URL)</div>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th width="20%">Twitter</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<div>
						<input name="listfusion[social_show_twitter]" type="checkbox" value="1" <?php if( $this->process_dec_options['social_show_twitter'] == 1 ) { echo 'checked'; } ?> />&nbsp;show tweet button 
						</div>
						<br>
						URL to tweet: <input name="listfusion[soical_twitter_url]" type="text" value="<?php echo $this->process_dec_options['soical_twitter_url']; ?>" size="35px" class="regular-text" /> 
						<br><div style="color:#c4c4c4; padding-top:5px;">(Leave empty to use display page URL)</div>
						<br>
						<div>
						Tweet text
						<textarea name="listfusion[soical_twitter_msg]" class="large-text code" rows="3" cols="55"><?php echo $this->listfusionShow_placement_item_social_twtter_txt; ?></textarea>
						</div>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th width="20%"> Google+</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<div>
						<input name="listfusion[social_show_google]" type="checkbox" value="1" <?php if( $this->process_dec_options['social_show_google'] == 1 ) { echo 'checked'; } ?> />&nbsp;show +1 button
						</div>
						<br>
						URL to +1: <input name="listfusion[social_google_url]" type="text" value="<?php echo $this->process_dec_options['social_google_url']; ?>" size="35px" class="regular-text" /> 
						<br><div style="color:#c4c4c4; padding-top:5px;">(Leave empty to use display page URL)</div>
						</div>
					</td>
				</tr>
				
				
				<tr valign="top">
					<th width="20%"> LinkedIn+</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<div>
						<input name="listfusion[social_show_linkedin]" type="checkbox" value="1" <?php if( $this->process_dec_options['social_show_linkedin'] == 1 ) { echo 'checked'; } ?> />&nbsp;show linkedIn button
						</div>
						<br>
						URL to share: <input name="listfusion[social_linkedin_url]" type="text" value="<?php echo $this->process_dec_options['social_linkedin_url']; ?>" size="35px" class="regular-text" /> 
						<br><div style="color:#c4c4c4; padding-top:5px;">(Leave empty to use display page URL)</div>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th width="20%">Pinterest</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<div>
						<input name="listfusion[social_show_pinterest]" type="checkbox" value="1" <?php if( $this->process_dec_options['social_show_pinterest'] == 1 ) { echo 'checked'; } ?> />&nbsp;show pinterest button 
						</div>
						<br>
						URL to pin: <input name="listfusion[social_pinterest_url]" type="text" value="<?php echo $this->process_dec_options['social_pinterest_url']; ?>" size="35px" class="regular-text" /> 
						<br><div style="color:#c4c4c4; padding-top:5px;">(Leave empty to use display page URL)</div>
						<br>
						<div>Image URL to pin: <input name="listfusion[social_pinterest_img_url]" type="text" value="<?php echo $this->process_dec_options['social_pinterest_img_url']; ?>" class="regular-text" style="width:250px;" /> </div>
						<br>
						<div>
						Description
						<textarea name="listfusion[social_pinterest_messange]" class="large-text code" rows="3" cols="55"><?php echo $this->listfusionShow_placement_item_social_pinterest_txt; ?></textarea>
						</div>
						</div>
					</td>
				</tr>
				
				
			</tbody>
		</table>	
				
		</div>	
		
			  <div id="preview_socialmsg" style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Social Message</th>
					<td width="80%">
						<textarea name="listfusion[field_socialmsg]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_socialmsg;  ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>		
	  </div>

		  
	  </div>
		
		
      <!--EOF AUTO-RESPONDER CONNECTION-->
	  
	  
	  
	  
      <!--TEMPLATE FIELDS-->
      <h3 id="contentfillup" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">4</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_content', 'listfusion_popup_content_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_content_img" border="0" title="Click to collapse" align="top" />Fill up popup content</a>&nbsp;&nbsp;</h3>
      <div id="listfusion_popup_content" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
            <tr valign="top" id="preview_header">
              <th width="20%">Title </th>
              <td width="80%"><!--<input name="listfusion[field_header]" type="text" value="<?php echo $this->listfusionShow_placement_title; ?>" size="35px" class="regular-text" style="width:300px;" />-->
			  <textarea name="listfusion[field_header]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_title; ?></textarea>
				<select name="listfusion[field_header_size]" class="colorSelectorInput" rows="6">
				  <option value="">--- Font Size ---</option>
				  <?php for( $i=26; $i<=73; $i++ ) { ?>
                  <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['field_header_size'] == $i ) { echo 'selected';  } ?> ><?php echo $i; ?>px</option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr valign="top" id="preview_maintext">
              <th scope="row">Message</th>
              <td><textarea name="listfusion[field_main_msg]" class="large-text code" rows="10" cols="55"><?php echo $this->listfusionShow_placement_msg; ?></textarea>
                <p><i><strong>Information</strong>: support HTML tags</i></p></td>
            </tr>
            <tr valign="top">
              <th width="20%">Security note</th>
              <td width="80%"><input name="listfusion[field_security_note]" type="text" value="<?php echo $this->listfusionShow_placement_security_note; ?>" size="35px" class="regular-text" /></td>
            </tr>
            <tr valign="top">
              <th width="20%">Submit/Link button text</th>
              <td width="80%"><input id="popup_submitbtn_txt" name="listfusion[field_button_text]" type="text" value="<?php echo $this->listfusionShow_placement_submit_txt; ?>" size="35px" class="regular-text" />
                <!--Select Btm Text-->
                <div class="listfusion-placementLinks"> <span style="font-size:11px; color:#999999;"><a onClick="__JS_listfustion_ShowHide('listfusion_popup_btm_pretext', 'listfusion_popup_btm_pretext_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer"><img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_btm_pretext_img" border="0"  align="top" />&nbsp;Pre-defined button text</a></span> </div>
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
            <tr valign="top" id="preview_listpoints">
              <th width="20%">List points</th>
              <td width="20%">
			   <ul id="bulletlist-ul" style="padding-top:0px; margin-top:0px;">
			   
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
              </td>
            </tr>
            <tr valign="top" id="preview_uploadimg">
              <th scope="row">Image</th>
              <td>
			    <input type="hidden" id="img" name="listfusion[field_img_url]" value="<?php echo $this->process_dec_options['field_img_url']; ?>" class="regular-text">
				<?php if( isset($_GET['id']) && $this->process_dec_options['field_img_url'] != '' ) { ?>
					<div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="<?php echo $this->process_dec_options['field_img_url']; ?>" style="display: block; width:50%;"> </div>
					<a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display:inline-block;" rel-id="img">Remove Upload</a>
					<a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img" style="display:none;">Upload</a> 
				<?php } else { ?>
					<div> <img class="listfusion_upload_image_preview" id="listfusion_upload_image_preview_img" src="" style="display: none;width:50%;"> </div>
					<a href="javascript:void(0);" class="listfusion_img_upload_remove button-secondary" style="display: none;" rel-id="img">Remove Upload</a>
					<a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);" class="listfusion_img_upload button-secondary" rel-id="img" style="display: inline-block;">Upload</a> 
				<?php } ?>
				</td>
            </tr>
            <tr valign="top" id="preview_videoID">
              <th scope="row">Video embed code</th>
              <td><textarea name="listfusion[field_video_code]" class="large-text code" rows="4" cols="55"><?php echo $this->listfusionShow_placement_video_code; ?></textarea></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--TEMPLATE FIELDS-->
	  
      <!--START SSCHEDULE + DELAY + AUTO CLOSE SETTINGS -->
	  <div id="schedule_delay_autoclose" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">5</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_schedule', 'listfusion_popup_schedule_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_schedule_img" border="0" title="Click to collapse" align="top" />Schedule <span style="color:#009900">+</span> delay <span style="color:#009900">+</span> auto close <span style="color:#009900">+</span> close button settings </a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div id="listfusion_popup_schedule" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Schedule</th>
					<td width="80%">
					
							<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[scheduleOnDisplay]" type="radio" value="1" checked="checked" onclick="__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit')" <?php if( $this->process_dec_options['scheduleOnDisplay'] == 1 ) { echo 'checked'; } ?> />&nbsp;display on every page load
							</div>
					
					
							<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[scheduleOnDisplay]" type="radio" value="2" onclick="__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit')" <?php if( $this->process_dec_options['scheduleOnDisplay'] == 2 ) { echo 'checked'; } ?> />&nbsp;display for first <input type="text" maxlength="5" size="2" value="<?php echo ($this->process_dec_options['display_for_first_visits']?$this->process_dec_options['display_for_first_visits']:'2'); ?>" name="listfusion[display_for_first_visits]" id="schedule_for_frist_visits" /> visits 
							</div>
							
							
							<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[scheduleOnDisplay]" type="radio" value="3" onclick="__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit')" <?php if( $this->process_dec_options['scheduleOnDisplay'] == 3 ) { echo 'checked'; } ?> />&nbsp;display on every <input type="text" maxlength="5" size="2" value="<?php echo ($this->process_dec_options['display_on_every_days']?$this->process_dec_options['display_on_every_days']:'3'); ?>" name="listfusion[display_on_every_days]"  id="schedult_on_every_days" /> days
							</div>
							
							
							<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[scheduleOnDisplay]" type="radio" value="4" onclick="__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit')" <?php if( $this->process_dec_options['scheduleOnDisplay'] == 4 ) { echo 'checked'; } ?> >&nbsp;display after <input type="text" maxlength="5" size="2" value="<?php echo ($this->process_dec_options['display_after_visit']?$this->process_dec_options['display_after_visit']:'4'); ?>" name="listfusion[display_after_visit]"  id="schedult_after_visit" /> visits
							</div>
					
					</td>
				</tr>
				
				<tr valign="top">
					<th width="20%">Delay</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						open popup delay in <input type="text" maxlength="5" size="2" value="<?php echo $this->process_dec_options['display_delayShow']; ?>" name="listfusion[display_delayShow]" /> seconds
						<span style="color:#999999; padding-left:5px;">(leave empty to disable)</span>
						</div>
					</td>
				</tr>
					
			</tbody>
		</table>
		
		<div id="autoClose_closebtm" style="display:block">
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
		<tbody>
			<tr valign="top">
				<th width="20%">Auto close</th>
				<td width="80%">
					<div style="padding:4px 4px 4px 4px;">
					auto close popup in <input type="text" maxlength="5" size="2" value="<?php echo $this->process_dec_options['display_auto_close']; ?>" name="listfusion[display_auto_close]" /> seconds <span style="color:#999999; padding-left:5px;">(leave empty to disable)</span>
					</div>
				</td>
			</tr>	
			
			<tr valign="top">
				<th width="20%">Close button</th>
				<td width="80%">
					<div style="padding:4px 4px 4px 4px;">
					<input name="listfusion[hide_close_btn]" type="checkbox" value="1" <?php if( $this->process_dec_options['hide_close_btn'] == 1 ) { echo 'checked'; } ?> /> hide close button
					</div>
				</td>
			</tr>	
		</tbody>
		</table>
		</div>
		
				  
      </div>
	  </div>
      <!--EOF START SUBMIT/LINK DESIGN-->
	  
	  
      <!--START CLOSE LINK + BUTTOM SETTINGS SUBMIT/LINK DESIGN-->
	  <div id="visitors_control_settings" style="display:block">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">6</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_close', 'listfusion_popup_close_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_close_img" border="0" title="Click to collapse" align="top" />Visitors control settings </a><br></h3>
	  
      <div id="listfusion_popup_close" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  <div style="color:#999999; padding-left:5px;font-size: 15px;line-height: 23px;">(This feature will allow your blog visitors to decide whether they want popup box to appear or not on their next visit)</div>
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Cookie Time after user clicks on "Don't Show Again" link</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<input type="text" maxlength="5" size="2" value="<?php echo ($_GET['id']?$this->process_dec_options['item_user_click_close_link']:''); ?>" name="listfusion[item_user_click_close_link]" />&nbsp; days <span style="color:#999999;">&nbsp;&nbsp;(Leave empty to disable Visitors' control feature)</span>
						<div style="color:#999999; padding-left:5px;"><br>When user click on 'Dont Show Me' link, how long should it be before the popup is shown again?</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th width="20%">Close popup</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[item_user_click_close_noconformation]" type="checkbox" value="1" <?php if ($this->process_dec_options['item_user_click_close_noconformation'] == '1') { echo 'checked'; } ?> /> ask confirmation message before close<span style="color:#999999; padding-left:5px;"></span>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th width="20%">Close link text</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
							<input name="listfusion[item_click_close_linktext]" type="text" value="<?php echo ($_GET['id']?trim($this->listfusionShow_placement_item_close_linktext):'Don\'t show again'); ?>" size="35px" class="regular-text" style="width:300px;" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>			
						  
	  
	  </div>
	  </div>
      <!--CLOSE LINK + BUTTOM SETTINGS SUBMIT/LINK DESIGN-->
	  
	  
      <!--START COOKIE-->
	  <div id="item_cookie_settings" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">7</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_cookie', 'listfusion_popup_cookie_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_cookie_img" border="0" title="Click to collapse" align="top" />Cookie settings (on close <span style="color:#009900">+</span> on conversion)</a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div id="listfusion_popup_cookie" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="30%">Cookie Time when user clicks on close button</th>
					<td width="70%" style="padding:0px 0px 10px 0px;">
						Disable popup box for <input type="text" maxlength="5" size="2" value="<?php echo ($_GET['id']?$this->process_dec_options['popup_user_click_close_btm']:''); ?>" name="listfusion[popup_user_click_close_btm]" />&nbsp; days when user click on close button  <span style="color:#999999;">&nbsp;&nbsp; (leave empty to disable)</span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">Cookie time after subscriber OR click on ad </th>
					<td width="70%" style="padding:0px 0px 10px 0px;">
						Disable popup box for <input type="text" maxlength="5" size="2" value="<?php echo ($_GET['id']?$this->process_dec_options['once_subscribe_disable_for']:'30'); ?>" name="listfusion[once_subscribe_disable_for]" />  days once user subscribe -OR- click on ad link button <span style="color:#00FF00; font-weight:normal; font-size:14px;">**</span> <br><span style="color:#c4c4c4; padding-left:0px;">(leave empty to disable)</span>
					</td>
				</tr>
			</tbody>
		</table>
					
		</div>	
	   </div>	  
      <!--CLOSE START COOKIE-->
	  
	  
	  <!--HTML exit popup-->
	  <div id="item_htmlexitpopup" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">8</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_htmlexitpopup', 'listfusion_popup_htmlexitpopup_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_htmlexitpopup_img" border="0" title="Click to collapse" align="top" />Show PopUp...</a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Powerful Feature</span> </h3>
      <div id="listfusion_popup_htmlexitpopup" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
<!--	  <div style="color:#999999; padding-left:5px;font-size: 15px; line-height: 23px;">(This feature allows you to display above selected popup, when user tries to leave the page -OR- leaves the browser viewport -OR- on scroll page down -OR- on user inactivity )</div>
-->	  
	  
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<td width="70%" style="padding:0px 0px 10px 0px;">
					<ul>
					<li>
					<input name="listfusion[show_popup_actions]" type="radio" value="1" 
					<?php if($this->process_dec_options['show_popup_actions'] == 1){ echo 'checked'; } ?> /> <strong>ONLY when</strong> user perform one of below "<strong>show popup</strong>" options &nbsp;&nbsp;
					</li>
					<li>
					<input name="listfusion[show_popup_actions]" type="radio" value="2" <?php if( $_GET['id'] == '' ) { ?>checked="checked"  <?php } ?>
					<?php if($this->process_dec_options['show_popup_actions'] == 2){ echo 'checked'; } ?> /> On page load <strong>AND when</strong> user perform one of below "<strong>show popup</strong>" options
					</li>
					</ul>
					</td>
				</tr>
			</tbody>
		</table>
	  
	  
	  
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">Show PopUp</th>
					<td width="70%" style="padding:0px 0px 10px 0px;">
		<select id="show_exit_html_popup" name="listfusion[show_exit_html_popup]" onchange="listfusion_htmlpop()">
		<option value="0" <?php if($this->process_dec_options['show_exit_html_popup'] == 0){ echo 'selected'; } ?>>--------- Select display type ---------</option>
		<option value="1" <?php if($this->process_dec_options['show_exit_html_popup'] == 1){ echo 'selected'; } ?>>When user try to leave the page</option>
		<option value="2" <?php if($this->process_dec_options['show_exit_html_popup'] == 2){ echo 'selected'; } ?>>When mouse leaves the browser viewport</option>
		<option value="3" <?php if($this->process_dec_options['show_exit_html_popup'] == 3){ echo 'selected'; } ?>>When user scroll page down</option>
		<option value="4" <?php if($this->process_dec_options['show_exit_html_popup'] == 4){ echo 'selected'; } ?>>When user inactivity (X seconds of curser inactivity)</option>
		</select>
		<div id="browser_viewpoint_display" style="display:<?php echo ($this->process_dec_options['show_exit_html_popup'] == 2?'block':'none'); ?>; padding:10px 0px 0px 0px;color:#999999;">This feature will display above selected popup, only when visitors leave the browser viewport for the FIRST TIME</div>
					</td>
				</tr>
			</tbody>
		</table>
	 <div id="jsalert_htmlexitpopup" style="display:<?php echo ($this->process_dec_options['show_exit_html_popup'] == 1?'block':'none'); ?>">	
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">JavaScript alert message</th>
					<td width="70%">
					
					<textarea name="listfusion[field_js_htmlpopup_alert]" class="large-text code" rows="4" cols="35"><?php echo  ( $_GET['id'] ) ? $this->listfusionShow_placement_exit_htmljs_msg : 'W A I T   B E F O R E   Y O U   G O !'; ?></textarea> 
					<div style="color:#999999; padding-left:5px;font-size: 15px; line-height: 23px;">(JS alert is necesseary before you show above selected popup) Type the message you want to display in the alert box or exit popup as shown in the image below)</div>
						<img src="<?php echo LIST_FUSION_LIBPATH.'images/exit-popup/2.png'; ?>">
					</td>
				</tr>
			</tbody>
		</table>
	  </div>
	  
	  <div id="jsalert_onpagescroll" style="display:<?php echo ($this->process_dec_options['show_exit_html_popup'] == 3?'block':'none'); ?>">	
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">After page scroll length</th>
					<td width="70%">
						<input type="text" name="listfusion[onpagescroll_height]" class="regular-text" style="width:200px;" value="<?php echo ($_GET['id']?$this->process_dec_options['onpagescroll_height']:'50');  ?>">
					</td>
				</tr>
			</tbody>
		</table>
	  </div>
	  
	  
	  <div id="jsalert_userinactivity" style="display:<?php echo ($this->process_dec_options['show_exit_html_popup'] == 4?'block':'none'); ?>">	
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">Curser inactivity time</th>
					<td width="70%">
						<input type="text" name="listfusion[curser_inactivity]" class="regular-text" style="width:200px;" value="<?php echo ($_GET['id']?$this->process_dec_options['curser_inactivity']:14);  ?>"> Seconds
					</td>
				</tr>
			</tbody>
		</table>
	  </div>
	  
	  	  
	  </div>
	  </div>
	  <!--EOF HTML exit popup-->
	  
	  
	  <!--OnClick Action-->
	  
	  <div id="onclickactionrow" style="display:none;">
	  <?php if( $_GET['ab'] == 'true' ) {  ?>
	  
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">*</span>&nbsp;
	  <input name="listfusion[popup_onClickAction_self_display]" type="checkbox" value="1" id="onclickaction" disabled="disabled" /><span style="color:#c4c4c4;">Apply OnClick action for this current popup</span>  <br>
	  <div style="color:#c4c4c4; padding-left:32px; padding-top:5px; font-weight:normal; font-size:14px;">(To set up onclick action, go to "Onclick Tag" which will appear right below this record (after you save this record))</div>
	  </h3>
	  
	  <?php } else { ?>
	  
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">*</span>&nbsp;
	  <input <?php if ($this->process_dec_options['popup_onClickAction_self_display'] == 1) { echo 'checked';  } ?> name="listfusion[popup_onClickAction_self_display]" type="checkbox" value="1" onclick="__listfusion_showHidediv(this,'whereToShow','whereToShow')" id="onclickaction" />Apply OnClick action for this current popup<br>
	  <div style="color:#c4c4c4; padding-left:32px; padding-top:5px; font-weight:normal; font-size:14px;">(To set up onclick action, go to "Onclick Tag" which will appear right below this record (after you save this record))</div>
	  </h3>
	  
	   <?php } ?>
	  </div>
	 
	  <!--Eof OnClick Action-->

	  
      <!--START SHOW-->
	  <div id="whereToShow" style="display:<?php if ($this->process_dec_options['popup_onClickAction_self_display'] == 1) { echo 'none'; } ?>">
     
	  <?php if( $_GET['ab'] == 'true' ) {  ?>
	  
	  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">9</span>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_wheretoshow_img" border="0" title="Click to collapse" align="top" /><span style="color:#c4c4c4;">Where to show popup? </span>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#c4c4c4; font-weight:normal; font-size:14px;">Required</span> </h3>
	  
	  <?php } else { ?>
	  
	  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">9</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_wheretoshow', 'listfusion_popup_wheretoshow_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_wheretoshow_img" border="0" title="Click to collapse" align="top" />Where to show popup? </a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span> </h3>
	  
	  <?php } ?>
	  
      <div id="listfusion_popup_wheretoshow" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
          <?php 
$this->listfusion_page_list('display_in_all','display_in_front','display_in_home','display_in_post','display_in_archive','display_in_search','display_in_other','showOnPostWithID','dontShowOnPostWithID','display_catIn','display_in_cat','display_in_pageid','listfusion_showlist','display_listfusion_in_all',($this->listfusionShow_in_all?$this->listfusionShow_in_all:($_GET['id']?'':'checked')),$this->listfusionShow_in_home,$this->listfusionShow_in_front,$this->listfusionShow_in_post,$this->listfusionShow_in_arch,$this->listfusionShow_in_search,$this->listfusionShow_in_other,$this->listfusionShow_showOnPostWithID,$this->listfusionShow_dontShowOnPostWithID,$this->listfusionShow_display_in_pageid,$this->listfusionShow_display_catIn,$this->listfusionShow_display_in_cat,''); 
?>

		</div>	  
		</div>
      <!--CLOSE START SHOW-->
	  
	  
	  <!--Custom CSS-->
	  <div id="item_customCSS" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">10</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_popup_customcss', 'listfusion_popup_customcss_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_customcss_img" border="0" title="Click to collapse" align="top" />Enter Custom CSS</a></h3>
      <div id="listfusion_popup_customcss" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  <div style="color:#999999; padding-left:5px;">(If your popup design is breaking because your blog theme is overwriting on it, or if you need to customize some 
sections, then you can do it from here.)</div>
	  
	  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">Custom CSS </th>
					<td width="70%"><textarea name="listfusion[field_customcss]" class="large-text code" rows="4" cols="35"><?php echo  ( $_GET['id'] ) ? $this->listfusionShow_placement_custom_css_code : ''; ?></textarea>
					<small style="color:#999999; font-size:small;">(Enter just CSS code)</small>
					</td>
				</tr>
			</tbody>
		</table>
	  
	  </div>
	  </div>
	  <!--Eof custom CSS-->
	  
	  
	  
      <!--NAME-->
      <h3 class="listfusion_heading" style="padding-bottom:10px; border:none;"><span class="listfusion_stepIndicator listfusion_stepActive">11</span>&nbsp;
	  PopUp name: <input id="popupItemName" name="listfusion[displayname]" type="text" value="<?php echo trim($this->listfusionShow_placement_name); ?>" size="35px" class="regular-text" style="width:200px;" />
                  <span style="color: #c4c4c4; font-weight:normal; font-size:14px;">(Appears only to you)</span>&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span>
	  
	  </h3>
	  
        <div style="padding-top:20px;">
          <input type="submit" class="button button-primary" value="Save" name="listfusion[process_popup_save]" />
        </div>
	  
	  
      <!--/Eof PopUp-->
	  <input type="hidden" value="<?php echo $_GET['split']; ?>" name="listfusion[split_id]">							
	  <input type="hidden" value="<?php echo LIST_FUSION_ADMIN_URL; ?>" id="listfusion_ajax_url">							
	  </form>
    </div>
  </div>
</div>
<script>
window.onload=function(){ 
__listfusionSelectTab(<?php echo ($display_fieldID?$display_fieldID:'1'); ?>,'<?php echo ($this->listfusionShow_placement_item_type?$this->listfusionShow_placement_item_type:'optinpopup'); ?>');
<?php if( isset( $_GET['id'] ) && $_GET['id'] != '' ) { ?>
__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit');
<?php } else { ?>
__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit');
<?php } ?>
};
</script>

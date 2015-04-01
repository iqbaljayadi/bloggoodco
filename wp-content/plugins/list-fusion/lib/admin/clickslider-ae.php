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

if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'clickslideroptin' ) {
	$image_preview_type = 'optinclickslider'.$this->process_dec_options['preview_type'];
	$display_fieldID = 1;
} else if( $_GET['id'] && $this->listfusionShow_placement_item_type == 'clicksliderad' ) {
	$image_preview_type = 'adclickslider'.$this->process_dec_options['preview_type'];
	$display_fieldID = 2;
} else {
	$image_preview_type = 'optinclickslider1';
}

?>

<h2 style="padding-bottom:10px; font-weight:bold;">
  <?php if(isset($_GET['id'])) { ?>
  Edit
  <?php } else { ?>
  Add New
  <?php } ?>
  Click Slider</h2>
  
  <div style="padding:5px 0px 10px 0px;"> <a href="<?php echo $this->listfusion_page; ?>"><input name="" type="button" class="button button-primary"  value="<< Back To DashBoard" /></a> 

  &nbsp;&nbsp;&nbsp;&nbsp;
  <?php if( $_GET['ab'] == 'true' ) { ?>
  <span style="color:#FF0000; font-weight:normal; font-size:14px; background:#FFFFCC; padding:10px;">You Are On <strong>SPLIT TEST MODE</strong> (Note: Some feature will go disable on SPLIT TEST PROCESS)</span> 
  <?php } ?>
  
  </div>
  
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  
	<div id="listfusion-nav">
	  <ul>
		<li class="current" onclick="__listfusionSelectTab(1,'clickslideroptin')"><a id="listfusionHead-1"><strong>Optin Click Slider</strong></a></li>
		<li onclick="__listfusionSelectTab(2,'clicksliderad')"><a id="listfusionHead-2" ><strong>Ad Click Slider</strong></a></li>
	  </ul>
	</div>
	
	<div class="listfusion-content">
	  <div class="listfusion-section">
	  <!--Start Click Slider-->
	  
	 <!--Start PopUp-->
      <?php if( $displayARPMessage == 1 ) { ?>
      <div style="font-size:11px; background-color:#FFFBCC; padding:17px 10px 0px 10px;font-family: Open Sans,sans-serif;">
        <div style="text-align:center"> <span class="listfusion-placementLinks" style="font-weight:bold;"> WARNING: <a href="?page=listfusion-arp">Click To Connect</a> With Your AutoResponder Service Before Using Click Slider </span> </div>
        <div>&nbsp;</div>
      </div>
      <?php } ?>
      <!--Start PopUp-->
	  
      <form action="" method="post" name="popup" onsubmit="return __listfusion_clickslider_chk();">
	  <input type="hidden" value="clickslideroptin" id="listFusionType" name="listfusion[fusionType]" >
      <h3 class="listfusion_heading" style="border-bottom:none; padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Look and feel: &nbsp;&nbsp; 
	    <span style="display:none;">
        <select name="listfusion[preview_type]" id="theme_preview_type" style="width:180px; background-color:#FDECE9" onchange="listfusion_demo_graber('imgpreview', this.value, '<?php echo LIST_FUSION_ADMIN_URL; ?>', 'listFusionType')" >
		
		  <?php for( $i=1; $i<=1; $i++ ) { ?>
		  <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['preview_type'] == $i ) { echo 'selected'; } ?> >Theme <?php echo $i; ?></option>
		  <?php } ?>
		  
        </select>
		</span>
        &nbsp;</h3>
		<span id="loaddemo_previewimg" style="display:none;"><img src="<?php echo LIST_FUSION_FULLPATH; ?>lib/images/spinner.gif"></span>
      <div id="ajx-preview" style="background-color:#F9F8F3; padding:20px 5px;-moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;display:block; text-align:center;"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/clickslider/<?php echo $image_preview_type; ?>.png" style="border:none;" /></div>
	  
	  <!--where to Placement?-->
      <h3 id="designsubmitbtm" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;&nbsp;&nbsp;Choose slider display screen position&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	   <div style="padding:3px 4px 4px 4px; ">
	  <input name="listfusion[slider_display_screen_placement]" type="radio" value="1" <?php echo (($this->process_dec_options['slider_display_screen_placement']==1)?'checked':'') ?> /> Top Left
	  &nbsp;&nbsp;&nbsp;
	  <input name="listfusion[slider_display_screen_placement]" type="radio" value="2" <?php echo (($this->process_dec_options['slider_display_screen_placement']==2)?'checked': (($_GET['id']=='')?'checked':'') ) ?> /> Bottom Left
	   </div>
	  </div>
	  <!--eof where to Placement?-->
	  
	  
	  
	  <!--START SLIDER DESIGN-->
      <h3 id="designsubmitbtm" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_design', 'listfusion_slider_design_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_slider_design_img" border="0" title="Click to collapse" align="top" />Design click slider</a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div id="listfusion_slider_design" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  <div style="padding:3px 4px 4px 4px; ">
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
            <tr valign="top">
              <th width="20%">Slider Background - Gradient</th>
			  <td>from
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['clkslider_from_color']:'555B61'); ?>'; name="listfusion[clkslider_from_color]" style="width:120px;" />
          to
          <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['clkslider_to_color']:'242729'); ?>'; name="listfusion[clkslider_to_color]" style="width:120px;" />
		  <br><br><span style="color:#c4c4c4; padding-left:5px;"> (Default: 555B61, 242729) </span>
		  </td>
			</tr>
		  </tbody>
		</table>
	  </div>	  

	  
	  </div>	  
	  <!--EOF SLIDER DESIGN-->
	  
      <!--START SUBMIT/LINK DESIGN-->
      <h3 id="designsubmitbtm" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">4</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_btm_design', 'listfusion_slider_btm_design_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_slider_btm_design_img" border="0" title="Click to collapse" align="top" />Design submit/link button</a>&nbsp;&nbsp;</h3>
      <div id="listfusion_slider_btm_design" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  
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
				  else $chk_submit_font_size = 16;
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
	  
	  
	  <!--START ARP CONNECTION-->
	<div id="slider_autoresponderConnection" style="display:block">
		  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">5</span>&nbsp;&nbsp;&nbsp;Connect template with your autoresponder service&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (OPTIN)</span> </h3>
		  <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
			<?php $this->__listfusion_autoresponderComboBox( 'listfusion[selected_arp]',''.$this->listfusionShow_placement_arp_id.'', 'clickslider_arpJs' ,'clickslider_dropdownResponsebk', 'clickslider_SplitName','clickslider_OnlyName_arp','clickslider_selected_onlyEmail','clickslider_arp_trackingcode' ); ?>
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
	  </div>	  
	  <!--EOF ARP CONNECTION-->
	  
	  <!--AD SLIDER-->
	   <div id="slider_displayAds" style="display:none;">
		  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">5</span>&nbsp;&nbsp;Ad click slider configuration&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required (AD)</span> </h3>
      <div style="display:block;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
					<th width="20%">Redirect link url</th>
					<td width="80%">
						<div style="padding:4px 4px 4px 4px;">
						<input id="slider_redirectURL" name="listfusion[ad_redirecturl]" type="text" value="<?php echo $this->process_dec_options['ad_redirecturl']; ?>" size="35px" class="regular-text" />
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
	  </div>
	  
	  <!--EOF AD SLIDER-->
	  
	  
      <!--TEMPLATE FIELDS-->
      <h3 id="contentfillup" class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">6</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_content', 'listfusion_slider_content_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_slider_content_img" border="0" title="Click to collapse" align="top" />Content fill-up section</a>&nbsp;&nbsp;</h3>
	  
      <div id="listfusion_slider_content" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
        <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
          <tbody>
		  
		  
            <tr valign="top">
              <th width="20%">Click message</th>
              <td width="80%">
			  <input name="listfusion[slider_clickmessage]" type="text" value="<?php echo $this->process_dec_options['slider_clickmessage']; ?>" size="35px" class="regular-text" style="width:200px;" /><span style="color:#c4c4c4; padding-left:5px;"> (Standard: 7 character) </span>
              </td>
            </tr>
			
            <tr valign="top">
              <th width="20%">Gap margin</th>
              <td width="80%">
			  <input name="listfusion[slider_margin_gap]" type="text" value="<?php echo $this->process_dec_options['slider_margin_gap']; ?>" size="35px" class="regular-text" style="width:100px;" /> px &nbsp;<span style="color:#c4c4c4; padding-left:5px;">(<span style="color:#949914">Min Gap: 90px</span>) leave empty for default </span><br>
			   <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/clickslider/gap.png" />
			   <span style="color:#c4c4c4; padding-left:5px;"> (Gap between click message & display slider) </span>
              </td>
            </tr>
			
		  
            <tr valign="top">
              <th width="20%">Title</th>
              <td width="80%">
			  <textarea name="listfusion[field_header]" class="large-text code" rows="3" cols="35"><?php echo $this->listfusionShow_placement_title; ?></textarea>
				<select name="listfusion[field_header_size]" class="colorSelectorInput" rows="6">
				  <option value="">--- Font Size ---</option>
				  <?php for( $i=26; $i<=73; $i++ ) { ?>
                  <option value="<?php echo $i; ?>" <?php if( $this->process_dec_options['field_header_size'] == $i ) { echo 'selected';  } ?> ><?php echo $i; ?>px</option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;Title text Color: <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['slider_text_color']:'FFFFFF'); ?>'; name="listfusion[slider_text_color]" style="width:120px;" />
              </td>
            </tr>
			
			<tr valign="top">
              <th scope="row">Message</th>
              <td><textarea name="listfusion[field_main_msg]" class="large-text code" rows="10" cols="55"><?php echo $this->listfusionShow_placement_msg; ?></textarea>
                <p>Text Color: <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['message_text_color']:'97ABBF'); ?>'; name="listfusion[message_text_color]" style="width:120px;" />&nbsp;&nbsp;<i><strong>Information</strong>: support HTML tags</i> </p></td>
            </tr>
			
			<tr valign="top">
              <th width="20%">Security note</th>
              <td width="80%"><input name="listfusion[field_security_note]" type="text" value="<?php echo $this->listfusionShow_placement_security_note; ?>" size="35px" class="regular-text" style="width:16em;" />&nbsp; Font color:  <input type="text" class="color"  value='<?php echo ($_GET['id']?$this->process_dec_options['security_note_color']:'A29898'); ?>'; name="listfusion[security_note_color]" style="width:120px;" /></td>
            </tr>
			
			<tr valign="top">
              <th width="20%">Submit/Link button text</th>
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
			
			
			
		  </tbody>
		</table>  	  
	  </div>
      <!--EOF TEMPLATE FIELDS-->
	  
	  <!--SCHEDULE-->
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">7</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_schedule', 'listfusion_slider_schedule_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_slider_schedule_img" border="0" title="Click to collapse" align="top" />Schedule settings </a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div id="listfusion_slider_schedule" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
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
			</tbody>
		</table>	
	  
	  </div>
	  <!--EOF SCHEDULE-->
	  
	  
      <!--START COOKIE-->
	  <div id="item_cookie_settings" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">8</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_cookie', 'listfusion_slider_cookie_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_cookie_img" border="0" title="Click to collapse" align="top" />Cookie settings</a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span> </h3>
      <div id="listfusion_slider_cookie" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
		<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
			<tbody>
				<tr valign="top">
				<th width="30%">Cookie time after subscribe OR click on ad </th>
					<td width="70%" style="padding:0px 0px 10px 0px;">
						Disable click slider for <input type="text" maxlength="5" size="2" value="<?php echo ($_GET['id']?$this->process_dec_options['once_subscribe_disable_for']:'30'); ?>" name="listfusion[once_subscribe_disable_for]" />  days once user subscribe -OR- click on ad link buttom <span style="color:#00FF00; font-weight:normal; font-size:14px;">**</span> <br><span style="color:#c4c4c4; padding-left:0px;">(leave empty to disable)</span>
					</td>
				</tr>
			</tbody>
		</table>
					
		</div>	
	   </div>	  
      <!--CLOSE START COOKIE-->
	  
	  
	  
<!--Where To Show-->
<?php if( $_GET['ab'] == 'true' ) {  ?>
	  <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">9</span>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_wheretoshow_img" border="0" title="Click to collapse" align="top" /><span style="color:#c4c4c4;">Where to click slider? </span>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#c4c4c4; font-weight:normal; font-size:14px;">Required</span> </h3>
<?php } else { ?>	  
<h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">9</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_wheretoshow', 'listfusion_slider_wheretoshow_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_popup_wheretoshow_img" border="0" title="Click to collapse" align="top" />Where to show click slider? </a>&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span> </h3>
<?php } ?>


<div id="listfusion_slider_wheretoshow" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
          <?php 
$this->listfusion_page_list('display_in_all','display_in_front','display_in_home','display_in_post','display_in_archive','display_in_search','display_in_other','showOnPostWithID','dontShowOnPostWithID','display_catIn','display_in_cat','display_in_pageid','listfusion_showlist','display_listfusion_in_all',($this->listfusionShow_in_all?$this->listfusionShow_in_all:($_GET['id']?'':'checked')),$this->listfusionShow_in_home,$this->listfusionShow_in_front,$this->listfusionShow_in_post,$this->listfusionShow_in_arch,$this->listfusionShow_in_search,$this->listfusionShow_in_other,$this->listfusionShow_showOnPostWithID,$this->listfusionShow_dontShowOnPostWithID,$this->listfusionShow_display_in_pageid,$this->listfusionShow_display_catIn,$this->listfusionShow_display_in_cat,''); 
?>
		</div>	  
	  <!--Eof Where To Show-->
	  
	  
	  <!--Custom CSS-->
	  <div id="item_customCSS" style="display:block;">
      <h3 class="listfusion_heading" style="padding-bottom:10px;"><span class="listfusion_stepIndicator listfusion_stepActive">10</span>&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_slider_customcss', 'listfusion_slider_customcss_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer; text-decoration:none;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_slider_customcss_img" border="0" title="Click to collapse" align="top" />Custom CSS</a></h3>
      <div id="listfusion_slider_customcss" style="display:none;padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	  
	  <div style="color:#999999; padding-left:5px;">(If your slider design is breaking because your blog theme is overwriting on it, or you need to customize some section. then you can do it from here)</div>
	  
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
	  Click slider name: <input id="sliderItemName" name="listfusion[displayname]" type="text" value="<?php echo trim($this->listfusionShow_placement_name); ?>" size="35px" class="regular-text" style="width:200px;" />
                  <span style="color: #c4c4c4; font-weight:normal; font-size:14px;">(Appears only to you)</span>&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;<span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span>
	  
	  </h3>
	  
        <div style="padding-top:20px;">
          <input type="submit" class="button button-primary" value="Save" name="listfusion[process_clickslider_save]" />
        </div>
	  
	  
	  
	    <input type="hidden" value="<?php echo $_GET['split']; ?>" name="listfusion[split_id]">							
	    <input type="hidden" value="<?php echo LIST_FUSION_ADMIN_URL; ?>" id="listfusion_ajax_url">							
		</form>	
			
	  <!--/Eof Click Slider-->
	  </div>
	</div>

</div>
<script>
window.onload=function(){ 
<?php if( isset( $_GET['id'] ) ) { ?>
	__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit');
<?php } else { ?>
	__listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit');
<?php } ?>
__listfusionSelectTab(<?php echo ($display_fieldID?$display_fieldID:'1'); ?>,'<?php echo ($this->listfusionShow_placement_item_type?$this->listfusionShow_placement_item_type:'clickslideroptin'); ?>');
};
</script>

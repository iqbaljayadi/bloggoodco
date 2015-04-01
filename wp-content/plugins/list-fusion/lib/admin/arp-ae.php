<script type="text/javascript" src="<?php echo LIST_FUSION_FULLPATH; ?>lib/js/arp.js"></script>

<h2 style="padding-bottom:10px; font-weight:bold;">
  <?php if(isset($_GET['id'])) { echo 'Edit';} else { ?>
  Add New
  <?php } ?>
  Autoresponder Connection</h2>
  
<div style="padding:5px 0px 10px 0px;"> <a href="<?php echo $this->listfusion_page; ?>"><input name="" type="button" class="button button-primary"  value="<< Back To Autoresponder DashBoard" /></a> 


<div style="width:850px; margin:20px 0px 20px 0px; position:relative;">
	<div id="listfusion-nav">
	  <ul>
		<li class="current" onclick="__listfusionSelectTab(1)"><a id="listfusionHead-1"><strong>Autoresponder Connection</strong></a></li>
	  </ul>
	</div>
	
	<div class="listfusion-content">
	  <div class="listfusion-section">
	  <!--Start ARP-->
	  
			
<form name="listfustion_arp_form" method="post" action="" onsubmit="return __listfustion_chkname();" >
  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
    <tbody>
      <tr valign="top">
        <th scope="row" style="width:140px;">Connection Type:</th>
        <td><fieldset>
          <label for="default_html_connection" style="color:#333366; font-weight:bold;">
          <input name="listfusion[connection_type]" type="radio" value="1" <?php echo ($_GET['id']?$connection_type_chk1:'checked'); ?> onclick="__JS_listfustion_ImgSwitchType('1','show_csv_backup')"  />
          <span id="connection_type_txt1">HTML Form Code</span> </label>
          <br>
          <label for="html_plus_csv_connection">
          <input name="listfusion[connection_type]" type="radio" value="2" onclick="__JS_listfustion_ImgSwitchType('2','show_csv_backup')"  <?php echo $connection_type_chk2; ?>  />
          <span id="connection_type_txt2">HTML Form Code + Store In .CSV File</span> </label>
          <br>
          <label for="dot_csv_connection">
          <input name="listfusion[connection_type]" type="radio" value="3" onclick="__JS_listfustion_ImgSwitchType('3','store_data_on_csv_standalone')" <?php echo $connection_type_chk3; ?> />
          <span id="connection_type_txt3">Store In .CSV File (STAND ALONE)</span> </label>
          <br>
          <label for="dot_csv_connection">
          <input name="listfusion[connection_type]" type="radio" value="4" onclick="__JS_listfustion_ImgSwitchType('4','send_optin_to_email')" <?php echo $connection_type_chk4; ?> />
          <span id="connection_type_txt4">Send Optins To E-mail</span> </label>
          </fieldset>
		  </td>
      </tr>
    </tbody>
  </table>
  <hr style="border: 0;border-top: 1px solid #ddd;border-bottom:3px solid #949494;">
  <!--Connection Name-->
  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
    <tbody>
      <tr valign="top">
        <th scope="row">Connection Name: <span style="color:#FF6633; font-style:italic;">(Required)</span><br>
          <span style="color:#C4C4C4"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/arrow_left.png" border="0" align="absmiddle">&nbsp;Appears only to you</span></th>
        <td><p>
            <input type="text" class="regular-text" value="<?php echo $this->arp_edresult['optin_form_name']; ?>" name="listfusion[optin_form_name]" id="arp_connection_name" />
            &nbsp;</p></td>
      </tr>
    </tbody>
  </table>
  
  <!--SEND OPTIN INFOMRATION TO EMAIL-->
   <div style="display:<?php echo ($send_optin_email?$send_optin_email:'none'); ?>" id="send_optin_to_email">
  <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
    <tbody>
      <tr valign="top">
        <th scope="row">E-mail Address</th>
        <td><p><input type="text" class="regular-text" value="<?php echo $this->__listfusion_escape_query(stripslashes($arped_options['send_optin_to_email'])); ?>" name="listfusion[send_optin_to_email]" />&nbsp;</p></td>
      </tr>
	  
      <tr valign="top">
        <th scope="row">Thank You Page Url:</th>
        <td><p><input type="text" class="regular-text" value="<?php echo $this->__listfusion_escape_query(stripslashes($arped_options['send_optin_to_email_thank_url'])); ?>" name="listfusion[send_optin_to_email_thank_url]" />&nbsp;</p>
		<div style="padding-top:10px;">Here is where your visitors will land after successful opt-in. If you leave it blank, they will be redirected 
              to home page.</div>
		</td>
      </tr>
    </tbody>
  </table>
  </div>
  <!--EOF SEND OPTIN INFOMRATION TO EMAIL-->
  
  
  
  <!--CONNECT ONLY USING .CSV-->
  <div style="display:<?php echo ($connection_stand_alone?$connection_stand_alone:'none'); ?>" id="store_data_on_csv_standalone">
	<table class="<?php echo $this->list_fusion_replaceclassname; ?>" style="background:#E6E9F4;">
      <tbody>
        <tr valign="top">
          <th scope="row">Store Opt-ins in .CSV file:</th>
          <td scope="row"><span style="font-style:italic">This feature will JUST STORE subscribe opt-in information to the location <strong><?php echo LIST_FUSION_RELPATH.'/csv/'; ?></strong> based on field you going to provide below. <br>
            <span style="color:#FF3300">IMPORTANT! This feature will not subscribe opt-in information to any 3rd party service like Aweber, Mailchimp, etc.</span></strong></span>
            <div style="padding-top:8px;"><?php echo $this->__listfustion_csv_chk(2); ?></div></td>
        </tr>
      </tbody>
    </table>
    
	<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
      <tbody>
        <tr valign="top">
          <th scope="row">Thank You Page Url:</th>
          <td><p>
              <input type="text" class="regular-text" value="<?php echo $arped_options['thank_you_page_url']; ?>" name="listfusion[thank_you_page_url]" />
              <br>
            <div style="padding-top:10px;">Here is where your visitors will land after successful opt-in. If you leave it blank, they will be redirected 
              to home page.</div>
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--DISPLAY HTML CODE AREA-->
  <div style="display:<?php echo ($hidden_display_html_form_code?$hidden_display_html_form_code:'block'); ?>" id="display_html_form_code">
    <!--CSV STORE-->
    <div id="show_csv_backup" style="display:<?php echo ($hidden_csv_html?$hidden_csv_html:'none') ?>;">
      <table class="<?php echo $this->list_fusion_replaceclassname; ?>" style="background:#E6E9F4;">
        <tbody>
          <tr valign="top">
            <th scope="row">Store Opt-ins in .CSV file:<span style="color:#FF6633; font-style:italic;">(Required)</span></th>
            <td scope="row"><input name="listfusion[arp_store_in_csv_as_backup]" type="checkbox" value="1" <?php echo ($arped_options['arp_store_in_csv_as_backup']?'checked':'checked'); ?> />
              &nbsp;<span style="font-style:italic">This feature will act as back-up without harming opt-in process. The system will store user information (name, email, zip code...etc of those who subscribe using 'List Fusion') based on Autoresponder connection you provide below.<br>
              <strong>(Your file will be stored in: <?php echo LIST_FUSION_RELPATH.'/csv/backup/'; ?>)</strong></span>
              <div style="padding-top:8px;"><?php echo $this->__listfustion_csv_chk(1); ?></div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--API Connection-->
    <div id="api_connection_css" style="display:<?php echo ($api_connection_process_css?$api_connection_process_css:'block'); ?>;">
      <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
        <tbody>
          <tr valign="top">
            <th scope="row">Grab HTML Code Via API Connection:</th>
            <td><p>
                <select name="listfusion[select_api_connections]" id="listfusion_select_api_connections" onchange="__listfustion_api_call()">
                  <option>...</option>
                  <option value="1">MailChimp</option>
                  <option value="2">GetResponse</option>
                </select>
                <input type="hidden" value="<?php echo LIST_FUSION_ADMIN_URL; ?>" id="listfusion_ajax_url">
				&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Recommended</span>
              </p>
              <!--MailChimp-->
              <div id="mailchimp_api_input_form" style="padding:5px 0px 0px 2px; margin-top:10px; display:none;"> MailChimp API Key
                <input type="text" value="<?php echo get_option('mailchimp_apikey'); ?>" id="listfustion_mailchimp_api_key">
                <input type="button" class="button button-primary" value="Process MailChimp API"  id="process_mailchimp_api_call" />
                &nbsp;&nbsp;&nbsp;<span class="description"><a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">Where can I find my API Key?</a></span>
                <div style="padding:5px 0px 5px 2px; margin-top:10px;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/spinner.gif" border="0" id="mailchimp_wait_processing" style="display:none;" />
                  <div id="displayMailChimpResult"></div>
                </div>
              </div>
              <!--GetResponse-->
              <div id="getResponse_api_input_form" style="padding:5px 0px 0px 2px; margin-top:10px; display:none;"> getResponse API Key
                <input type="text" value="<?php echo get_option('getResponse_apikey'); ?>" id="listfustion_getResponse_api_key">
                <input type="button" class="button button-primary" value="Process getResponse API"  id="process_getResponse_api_call" />
                &nbsp;&nbsp;&nbsp;<span class="description"><a href="http://www.getresponse.com/learning-center/glossary/api-key.html" target="_blank">Where can I find my API Key?</a></span>
                <div style="padding:5px 0px 5px 2px; margin-top:10px;"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/spinner.gif" border="0" id="getResponse_wait_processing" style="display:none;" />
                  <div id="displaygetResponseResult"></div>
                </div>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--HTML FORM CODE-->
    <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
      <tbody>
        <tr valign="top">
          <th scope="row">Enter your HTML Form Code:</th>
          <td><p>
              <textarea rows="7" class="large-text code" id="listfustion_html_optin_form_code" name="listfusion[optin_html_form_code]" ><?php echo $this->arp_edresult['optin_html_form_code']; ?></textarea>
            </p>
            <p style="font-style:italic;"> <strong>NOTE:</strong> If your service provider is not on the API connection,  then grab HTML form code from your email service provider and paste it into the above box.</p></td>
        </tr>
      </tbody>
    </table>
    <!--Process HTML FORM BTM-->
    <div style="padding-top:15px">
      <input type="button" class="button button-primary" value="Process HTML Form" id="listfustion_process_form" onclick="__JS_listfustion_html_Process('null')" />
    </div>
    <!--Hidden Fields-->
    <div id="listfustion_form_code_html" style="display:none"></div>
    <input type="hidden" name="listfusion[optin_hidden_fields]" id="listfustion_html_form_hidden_flds" value="<?php echo $this->arp_edresult['optin_hidden_fields']; ?>"  />
    <input type="hidden" id="chk_if_click_process_html_form_btm" value="<?php echo $chk_if_click_process_html_form_btm; ?>">
    <!--Eof Hidden Fields-->
    <br>
    <hr style="border: 0;border-top: 1px solid #ddd;border-bottom: 1px solid #fafafa;">
    <!--HIDDEN PROCESS START-->
    <div id="configure_optin" style="display:<?php echo ($_GET['id']?$hidden_process_html_form:'none'); ?>">
      <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
        <tbody>
          <!--NAME-->
          <tr valign="top" id="hide_one" style="display:<?php echo $block_name_fld; ?>">
            <th scope="row"><span id="field_name" style="color:<?php echo $name_color; ?>">Name:</span></th>
            <td><p>
                <select style="width:280px;" id="listfusion_name_fld" name="listfusion[arp_name_fld]" <?php echo $disable_name_dropdown; ?> >
                  <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, $namefld ); ?>
                </select>
                <br>
              <div style="padding-top:10px;">
                <input name="listfusion[split_name]" type="checkbox" value="1" id="listfusion_split_name" onclick="__JS_listfustion_html_Process('split')" <?php echo $chk_split_name; ?> />
                Split name into first and last name <span style="color:<?php echo ($display_split_name_txt_color?$display_split_name_txt_color:'#f1f1f1'); ?>; font-weight:bold;" id="split_namefld">(Global Effect)</span></div>
              <!--FF6633-->
              </p>
            </td>
          </tr>
          <!--SPLIT NAME-->
          <tr valign="top" id="first_name_tbl" style="display:<?php echo ($display_split_option?$display_split_option:'none'); ?>;">
            <th scope="row">First Name:</th>
            <td><p>
                <select style="width:280px;" name="listfusion[first_name_fld]" id="listfusion_first_name_fld" >
                  <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, $firstnamefld ); ?>
                </select>
              </p></td>
          </tr>
          <tr valign="top" id="last_name_tbl"  style="display:<?php echo ($display_split_option?$display_split_option:'none'); ?>;">
            <th scope="row">Last Name:</th>
            <td><p>
                <select style="width:280px;" name="listfusion[last_name_fld]" id="listfusion_last_name_fld" >
                  <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, $lastnamefld ); ?>
                </select>
              </p></td>
          </tr>
          <!--EMAIL-->
          <tr valign="top">
            <th scope="row">Email:</th>
            <td><p>
                <select style="width:280px;"  id="listfusion_email_fld" name="listfusion[optin_email_fld]" >
                  <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, $this->arp_edresult['optin_email_fld'] ); ?>
                </select>
                <br>
              <div style="padding-top:10px;">
                <input name="listfusion[display_only_email]" type="checkbox" value="1" onclick="__JS_listfustion_displayOnlyEmail()" id="listfusion_disply_only_email" <?php echo $chk_displayOnly_email; ?> />
                Enable only email field <span style="color:<?php echo ($display_only_email_txt_color?$display_only_email_txt_color:'#F1F1F1'); ?>; font-weight:bold;" id="enableEmailFld">(Global Effect)</span></div>
              </p>
            </td>
          </tr>
          <!--TRACKING CODDE-->
          <tr valign="top">
            <th scope="row">Tracking Code:</th>
            <td><p>
                <select style="width:280px;"  name="listfusion[trackcode_fld]" id="listfusion_trackcode_fld" >
                  <option value="None" selected >None</option>
                  <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $hiddenflds_arr, $this->arp_edresult['optin_trackcode_fld'] ); ?>
                </select>
                <br>
                <span style="color:#C4C4C4; font-weight:bold;"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/arrow_left.png" border="0" align="absmiddle">&nbsp;Sepcially design for Aweber users</span> </p></td>
          </tr>
          <!--TRACKING CODDE-->
          <tr valign="top">
            <th scope="row">Form Action Url:</th>
            <td><p>
                <input type="text" class="regular-text" value="<?php echo $this->arp_edresult['optin_form_url']; ?>" name="listfusion[optin_form_url]" id="listfusion_redirect_url" />
                <br>
              <div style="padding-top:10px;">
                <input type="checkbox" value="1" name="listfusion[submit_form_to_new_window]" <?php echo $sftonewwindow; ?> />
                Submit form to new window</div>
              </p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!--EOF HIDDEN PROCESS START-->
  <div id="field_placeholder" style="display:<?php echo ($hidden_save_btm?$hidden_namefild_text:'none'); ?>;">
    <hr style="border: 0;border-top: 1px solid #ddd;border-bottom: 1px solid #fafafa;">
    <!--TEMPLATE: FIELD NAME-->
    <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
      <tbody>
        <!--Name field-->
        <tr valign="top" id="name_fld_level" style="display:<?php echo $display_name_hide; ?> " >
          <th scope="row">Name Field Text:</th>
          <td><p>
              <input type="text" name="listfusion[field_name]"  class="regular-text" value="<?php echo ($_GET['id']?$this->arp_edresult['fld_name']:'Enter Your Name...'); ?>" style="background:#FFE0E0;" />
            </p></td>
        </tr>
        <!--First name field-->
        <tr valign="top" id="split_first_name" style="display:<?php echo ($display_split_option?$display_split_option:'none'); ?>;">
          <th scope="row">First Name Field Text:</th>
          <td><p>
              <input type="text" name="listfusion[field_fname]"  class="regular-text" value="<?php echo ($_GET['id']?$this->arp_edresult['fld_fname']:'Enter Your First Name...'); ?>" style="background:#FFE0E0;"  />
            </p></td>
        </tr>
        <!--last name field-->
        <tr valign="top" id="split_last_name"  style="display:<?php echo ($display_split_option?$display_split_option:'none'); ?>;">
          <th scope="row">Last Name Field Text:</th>
          <td><p>
              <input type="text" name="listfusion[field_lname]"  class="regular-text" value="<?php echo ($_GET['id']?$this->arp_edresult['fld_lname']:'Enter Your Last Name...'); ?>" style="background:#FFE0E0;"  />
            </p></td>
        </tr>
        <!--Email field-->
        <tr valign="top">
          <th scope="row">Email Field Text:</th>
          <td><p>
              <input type="text" name="listfusion[field_email]"  class="regular-text" value="<?php echo ($_GET['id']?$this->arp_edresult['fld_email']:'Enter Your E-Mail...'); ?>" style="background:#FFE0E0;"  />
            </p></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--EOF PLACEHOLDER-->
  <div id="extra_field_showup" style="display:<?php echo ($hidden_custom_fld?$hidden_custom_fld:'none'); ?>;">
    <hr style="border: 0;border-top: 1px solid #ddd;border-bottom: 1px solid #fafafa;">
    <!--Add Custom Fields-->
    <h3 class="listfusion_heading" style="border-bottom:none;"> <span class="listfusion_stepIndicator listfusion_stepActive">1</span> &nbsp; <a onClick="__JS_listfustion_ShowHide('arp_add_custom_fld_show', 'arp_add_custom_fld_show_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="arp_add_custom_fld_show_img" border="0" title="Click to collapse" align="top" /><span style="font-weight: 600;">Custom Fields</span><span style="color:#FF6633; font-weight:bold; font-size:13px;">&nbsp;&nbsp;(Use Only When Necessary)</span> </a> </h3>
    <div style="font-size:11px; display:none;" id="arp_add_custom_fld_show">
      <!--Custom Fields Section-->
      <?php $randomNum1 = rand(1,999);  ?>
      <input type="hidden" value="1" id="newExtraFldValue1" />
      <table class="<?php echo $this->list_fusion_replaceclassname; ?>">
        <tbody>
          <tr>
            <td><?php 
			  $countARPCustomFld = 1;
			  if( $arped_options['listfusion_customfields'] == ''  ) $arped_options['listfusion_customfields'] = array(''=>'');
			  foreach( (array) $arped_options['listfusion_customfields'] as $key => $val ) {
				  if( $countARPCustomFld == 1 ) { 
					$nextfld = '&nbsp;&nbsp;<a id="displayCustomFldClone" style="text-decoration:none; cursor:pointer;">[+]</a> <img src="'.LIST_FUSION_LIBPATH.'images/point-left.gif" border="0" align="absmiddle"><img src="'.LIST_FUSION_LIBPATH.'images/point-left.gif" border="0" align="absmiddle">';
					$next_padding = "padding: 8px 0px 8px 22px";
					//$next_minus = '';
				  } else { 
					$nextfld = ''; 
					$next_padding = "padding: 8px 0px 8px 3px";
					//$next_minus = '<a style="text-decoration:none; cursor:pointer" onclick="__listfusion_removeCreateFld()">[-]</a>';
				  }
			 ?>
              <div id="<?php echo 'listfusionCFLD'.+$countARPCustomFld; ?>">
              <div style=" <?php echo $next_padding; ?> " id="customflddb<?php echo $countARPCustomFld ?>">
              <?php if(  $countARPCustomFld != 1 ) { ?>
              <a style="text-decoration:none; cursor:pointer" onclick="__listfusion_removeCreateFld('customflddb<?php echo $countARPCustomFld ?>', '<?php echo 'listfusionCFLD'.+$countARPCustomFld; ?>')">[-]</a>
              <?php } ?>
              <input name="listfustionLabelCustomFld[]" class="regular-text" type="text" value="<?php echo trim($this->__listfusion_op_option_filter($key)); ?>" placeholder="Enter Field Lebel..." style="width: 200px;border: 1px solid #D8CECE;"/>
              &nbsp;&nbsp;
              <select style="width:250px;" name="listfustionFieldCustomFld[]" id="listfusion_custom_fld" >
                <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, trim($val)); ?>
              </select>
              <?php 
				 echo $nextfld;
				 echo '</div></div>'; 
				 $countARPCustomFld++; 
			 } 
			 ?>
              <div id='new_withinpostcustomfld' style="padding-left:0px;"></div>
              <br>
              <p style="font-style:italic;"> <strong>INSTRUCTION:</strong> Enter Field Lebel == Enter Field Label such as Your Zip Code Here, Your Country Code, etc. (for all) </p></td>
          </tr>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
  <!--EOF EXTRA FIELDS-->
  <!--Save Connection-->
  <div style="display:<?php echo ($hidden_save_btm?$hidden_save_btm:'none'); ?>" id="submit_arp_form"> <br>
    <br>
    <input type="submit" class="button button-primary" value="Save" name="listfusion[process_arp_save]" />
    <p>Please double-check your settings before clicking SAVE button. Saving false information will not send subscribers to your list and will also effect on auto filling form.</p>
  </div>
  <br class="clear">
  <br class="clear">
</form>
<!--EOF DISPLAY HTML CODE AREA-->
<div id="applyCustomFldClone" style="display:none;">
  <div style="padding: 8px 0px 8px 0px"><a style="text-decoration:none; cursor:pointer" id="customFldCloneDelete">[-]</a>&nbsp;
    <input class="regular-text" type='text' name="listfustionLabelCustomFld[]" value='' placeholder="Enter Field Lebel..." style="width:200px;border: 1px solid #D8CECE;" >
    &nbsp;&nbsp;
    <select style="width:250px;" name="listfustionFieldCustomFld[]" id="listfusion_clone_fld" />
    
    <?php if( isset($_GET['id']) ) $this->__listfusion_arp_dropdown( $arr_name, ''); ?>
    </select>
    &nbsp;&nbsp; </div>
</div>



	  <!--/Eof ARP-->
	  </div>
	</div>

</div> 

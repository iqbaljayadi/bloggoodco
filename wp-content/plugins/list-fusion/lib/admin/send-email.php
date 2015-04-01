<h2 style="padding-bottom:10px; font-weight:bold;">Send Email to First Commentator</h2>
<?php
if( trim($this->listfusion_global_message) != '' ) {  
	echo "<div id='listfustion_msg' style='display:none;background-color:#FFFFAA;  height:24px; padding:15px 20px 6px 20px; font-weight:bold; font-size:15px;'>";
	echo $this->listfusion_global_message;
	echo "</div>";
}	
?>
<br>


<div style="margin-top:5px; padding-top:50px; border-top: 1px solid #D6D4D4; min-height:110px; border-bottom: 1px solid #D6D4D4;">
<table style="width:860px;">
<tr>
<td>
<form name="listfustion_send_first_email_stats" method="post" action="">

<div style="float:left; text-align:center; font-size:60px; font-weight:bold; width:160px;">
	<?php echo $this->listfusion_sentEmail_status; ?>
	<br>
	<div style="font-size:14px; padding-top:35px;">Total Email Sent</div>
</div>

<div style="float:left; text-align:center; font-size:40px; font-weight:bold; width:200px;">
	<span class="listfusion_stats" style="color:<?php echo $activeColorStats; ?>; text-transform:uppercase;"><?php echo $activeColorStatsContent; ?></span>
	<br>
	 <div style="font-size:14px; padding-top:35px;">Feature Status</div>
</div>

<div style="float:left; text-align:center; font-size:40px; font-weight:bold; width:200px; text-transform:uppercase;">
	<a href="<?php echo $this->listfusion_page.'action=reset'; ?>" onclick="return confirm('Are You Sure You Want To RESET email send stats. Please note this action is irreversible');" style="text-decoration:none;">Reset</a>
	<br>
	<div style="font-size:14px; padding-top:35px;">Control (Reset Stats)</div>
</div>

<div style="clear:both"></div>

</form></td></tr></table>
</div>



<br>
<!--Available Replacement Tags-->
<h3 class="listfusion_heading"><span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;<a onClick="__JS_listfustion_ShowHide('listfusion_sendemail_show', 'listfusion_sendemail_show_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer">
		<img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="listfusion_sendemail_show_img" border="0" title="Click to collapse" align="top" />Available Replacement Tags</a><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"></h3>
<div style="font-size:11px; display:none;" id="listfusion_sendemail_show">
<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
<tbody>
<tr valign="top">
	<th width="20%">Blog Post Author's Name:  </th>
	<td width="80%"><input name="textfield" readonly="" onclick="this.select();" type="text" value="%author_name%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
<tr valign="top">	
	<th scope="row">Blog Post Author's Email: </th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%author_email%" size="40" style="background-color:#FFFFFF;" class="regular-text"  /></td>
</tr>
<tr>	
	<th scope="row">Commentator's Name:</th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%commentator_name%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
<tr>	
	<th scope="row">Commentator's Email:</th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%commentator_email%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
<tr>	
	<th scope="row">Commentator's Website:</th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%commentator_website%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
<tr>	
	<th scope="row">Your Blog Post URL:</th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%blog_post_link%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
<tr>	
	<th scope="row">Your Blog URL:</th>
	<td><input name="textfield2" readonly="" onclick="this.select();" type="text" value="%blog_url%" size="40" style="background-color:#FFFFFF;" class="regular-text" /></td>
</tr>
</tbody>
</table>
</div>

<form name="listfustion_send_first_email" method="post" action="">

<!-- Send Email Type-->
<h3 class="listfusion_heading" style="border-bottom:none;"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;&nbsp;&nbsp;Send Email Type</h3>
<div style="padding:5px 5px 5px 5px;-moz-border-radius:8px; -khtml-border-radius: 8px; -webkit-border-radius:8px; background-color:#F8F8F8; display:display;">
<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
<tbody>
	<tr valign="top">
		<td scope="row"><input name="listfusion[send_email_type]" type="radio" value="1" <?php echo $sendEmail_type1; ?> /> Send email immediately after first commentator comments again on your blog.
		<div style="font-size:11px; color:#999999;">
			(Send only after the first commentator comment is approved by admin)
		</div></td>
	</tr>
	
	<tr valign="top">
		<td scope="row"><input name="listfusion[send_email_type]" type="radio" value="2" <?php echo $sendEmail_type2; ?> />&nbsp;&nbsp;Send email to the first commentator immediately when comment is approved by admin </td>
	</tr>

</tbody>
</table>
</div>
<!--Email Necesseary Fields-->

<h3 class="listfusion_heading" style="border-bottom:none;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;&nbsp;Email Fields</h3>
<div style="padding:5px 5px 5px 15px;-moz-border-radius:8px; -khtml-border-radius: 8px; -webkit-border-radius:8px; background-color:#F8F8F8; display:display;">
<table class="<?php echo $this->list_fusion_replaceclassname; ?>">
<tbody>
	<tr valign="top">
		<th scope="row">Author's Name:</th>
		<td><input name="listfusion[email_from_name]" type="text" value="<?php echo $this->listfusion_sentEmail_name; ?>" size="35px" class="regular-text" /></td>
	</tr>
	<tr valign="top">
		<th scope="row">Author's Email:</th>
		<td><input name="listfusion[email_from_email]" type="text" value="<?php echo $this->listfusion_sentEmail_email; ?>" size="35px" class="regular-text" /> </td>
	</tr>
	<tr valign="top">
		<th scope="row">Subject:</th>
		<td><input name="listfusion[email_subject]" type="text" value="<?php echo $this->listfusion_sentEmail_subject; ?>" size="60px" class="regular-text" /> </td>
	</tr>
	<tr valign="top">
		<th scope="row">Choose Responsive Email Template: <br><span style="color:#C4C4C4">(On clicking image layout, HTML content will be appear inside message box below)</span></th>
		<td>
		<img id="se_tmp1" src="<?php echo LIST_FUSION_LIBPATH ?>images/resp-email/template-1.jpg" class="listfusion_img" onclick="__listfusion_sendEmailText('sendEmail_template1','listfusion_send_email_message'); __listfusion_active_selected('se_tmp1','se_tmp2','se_tmp3');"/>&nbsp;&nbsp;
		<img id="se_tmp2" src="<?php echo LIST_FUSION_LIBPATH ?>images/resp-email/template-2.jpg" class="listfusion_img" onclick="__listfusion_sendEmailText('sendEmail_template2','listfusion_send_email_message'); __listfusion_active_selected('se_tmp2','se_tmp1','se_tmp3');"/>&nbsp;&nbsp;
		<img id="se_tmp3" src="<?php echo LIST_FUSION_LIBPATH ?>images/resp-email/template-3.jpg" class="listfusion_img" onclick="__listfusion_sendEmailText('sendEmail_template3','listfusion_send_email_message'); __listfusion_active_selected('se_tmp3','se_tmp1','se_tmp2');"/>
		
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Message:</th>
		<td><textarea rows="10" cols="55" id="listfusion_send_email_message" name="listfusion[email_content]" class="large-text code" ><?php echo $this->listfusion_sentEmail_content; ?></textarea>
		<p><input type="button" value="Preview" class="button button-primary" onclick="__listfusion_preview_sendEmail();"> | <span class="listfusion_link" href="" onclick="__listfusion_restore();">Restore Text Message</span></p></td>
	</tr>
</tbody>
</table>
</div>

<br>
<h3 class="listfusion_heading" style="border-bottom:none;"><span class="listfusion_stepIndicator listfusion_stepActive">4</span>&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="listfusion[send_email_active]" <?php echo $sendemail_Enable; ?> >&nbsp;&nbsp;<strong>Enable "Send Email to First Commentator"</strong><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"></h3>

<div style="padding-top:20px;">
<input type="submit" class="button button-primary" value="Save" name="listfusion[send_email_data_submit]" />
</div>


</form>
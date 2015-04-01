<h2 style="padding-bottom:10px;font-weight:bold;">Settings</h2>
<?php $this->__listfusion_handleGLOBALmag($this->listfusion_global_message); ?>
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  
	<div id="listfusion-nav">
	  <ul>
		<li class="current" onclick="__listfusionSelectTab(1,'squeezepage_stng')"><a id="listfusionHead-1"><strong>Squeeze page settings</strong></a></li>
		<li onclick="__listfusionSelectTab(2,'other_stng')"><a id="listfusionHead-2" ><strong>Other settings</strong></a></li>
	  </ul>
	</div>
	
	<div class="listfusion-content">
	  <div class="listfusion-section">
	  <!--Start settings-->
	  
<!--Start squeeze page-->
<div id="squeezepage_settings">
	<?php 
	$filename = LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template().'/template-listfusion-squeezepg.php';
	if ( !file_exists( $filename ) ) { 
		$display_activate_sqpg = 1;
		$followStep = 2;
	} else {
		$followStep = 1;
	} 
	
	if( $display_activate_sqpg == 1 ) {
	?>					
		<h3 class="listfusion_heading" style="padding-bottom:10px;">
		<span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;How to activate squeeze page?</a>&nbsp;&nbsp;
		</h3>
		<div id="listfusion_sqpg_btm_design" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		  <div style="padding:3px 4px 4px 4px; ">
					<div id="chkbox_options">
						<div style="padding:4px 4px 4px 4px;">
						<div style="padding-bottom:5px;"><strong>Automatic Process</strong> </div> 
						<div style="padding-bottom:5px;">
						<ol>
						<li>
						In order to activate squeeze page feature you must have <strong>"template-listfusion-squeezepg.php"</strong> page, on your current theme location ( <strong><?php echo LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template(); ?> </strong>)
						</li>
						</ol>
						</div>
						<form action="" method="post">
						<input type="submit" name="listfusion[installFile]" value="Install File Now" class="button button-primary" style="background-color:#5FB41F;border-color:#427A19;background-image:none; border:1px solid #427A19;" />
						</form>
						<div style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif; padding-top:10px;">
						Please note: If you change your website theme, you have to continue process again.
						</div>
						</div>
						
						<div style="border-bottom:1px solid #CCCCCC; width:80%" align="center" >&nbsp;</div>
						
						<div style="padding:10px 4px 8px 4px;">
						<div style="padding-bottom:5px;"><strong>Manual Process</strong> </div> 
						<ol>
						<li><span class="placementLinks"><a href="<?php echo LIST_FUSION_LIBPATH; ?>user-lib/squeeze-pg/template-listfusion-squeezepg.zip">Download</a></span> Zip file.</li>
						<li>Unzip the file you will see <strong>"template-listfusion-squeezepg.php"</strong> page, place it on your current theme location ( <strong><?php echo LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template(); ?> </strong>)</li>
						</ol>
						<div style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif; padding-top:10px;">
						Please note: If you change your website theme, you have to continue process again.
						</div>
						</div>
					</div>		  
		  </div>
		</div>  
	<?php } ?>	
	<h3 class="listfusion_heading" style="padding-bottom:10px;">
		<span class="listfusion_stepIndicator listfusion_stepActive"><?php echo $followStep;?></span>&nbsp;&nbsp;How to display a squeeze page? (Getting Started Guide)</a>&nbsp;&nbsp;
	</h3>
	
	<div style="background-color:#F8F8F8; padding:10px 5px 5px 10px; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
	<div id="chkbox_options">
		<div style="padding:4px 4px 8px 4px;">
		<ol>
		<li>First create NEW squeeze page, Go to: <span class="placementLinks"><a style="color:#0066FF;" href="<?php echo LIST_FUSION_SITEURL.'/wp-admin/admin.php?page=listfusion&action=aesqpg' ?>">Add New Squeeze Page</a> and create one.</span><font color="#FF0000"><strong>&nbsp;Important &nbsp;!!!</strong></font></li>
		
		<li>After you create your FIRST squeeze page, Go to: "<span class="placementLinks"><a style="color:#0066FF;" href="<?php echo LIST_FUSION_SITEURL.'/wp-admin/post-new.php?post_type=page' ?>">Add New Page</a></span>" (Pages-&gt;Add New Page).</li>
		<li>Enter title.</li>
		<li>Scroll page down, you will see <strong>"List Fusion :: Squeeze Page".</strong></li>
		<li><strong>Choose created squeeze page</strong> from the dropdown list. <font color="#FF0000"><strong>&nbsp;Important &nbsp;!!!</strong></font></li>
		<li>Configure squeeze page SEO.</li>
		<li>Choose the template <strong>"List Fusion Squeeze Page"</strong> under <strong>Page Attributes</strong>. <font color="#FF0000"><strong>&nbsp;Important &nbsp;!!!</strong></font></li>
		<li>Hit Publish.</li>
		<li>You're done!</li>
		</ol>
		<div style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif;padding-top:10px;">
		Please note: You can create any number of Optin Squeeze Pages. 
		</div>
		</div>
		</div>
	</div>
	
	
</div>
<!--Eof Start squeeze page-->

<div id="other_settings" style="display:none">
<form action="" method="post">
		<h3 class="listfusion_heading" style="padding-bottom:10px;">
		<span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;List fusion responsive behaviour</a>&nbsp;&nbsp;
		</h3>
		
		<div id="listfusion_sqpg_btm_design" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		  <div style="padding:3px 4px 4px 4px; font-size:14px; ">
		  <input name="listfusion[listfusion_activate_mobile]" type="checkbox" value="1" <?php if( get_option('listfusion_activate_mobile') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Activate Responsive Behaviour For Mobile/ipad
		   <div style="font-size:10px; color:#999999; padding:10px 0px 0px 40px; font-size:14px;">Note: Activate feature only works for NON-RESPONSIVE THEME</div>
		  </div>
		</div>
		
		
		<!--Fancy Box Settings-->
		
		<h3 class="listfusion_heading" style="padding-bottom:10px;">
		<span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;&nbsp;FancyBox Javascript Settings</a>&nbsp;&nbsp;
		</h3>
		
		<div id="listfusion_sqpg_btm_design" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		  <div style="padding:3px 4px 4px 4px; font-size:14px; ">
		 <input name="listfusion[listfusion_custompop_fancybox]" type="checkbox" value="1" <?php if( get_option('listfusion_custompop_fancybox') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp;Disable fancybox JS loading
		  </div>
		  
		  <div style="padding:3px 4px 4px 4px; font-size:14px; margin-top:10px; ">
		 <input name="listfusion[listfusion_custompop_fancybox_mousewheel]" type="checkbox" value="1" <?php if( get_option('listfusion_custompop_fancybox_mousewheel') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp;Disable fancybox MouseWheel JS loading
		  </div>

		</div>
		
		
		<!--Social JS Settings-->
		
		
		<h3 class="listfusion_heading" style="padding-bottom:10px;">
		<span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;Social Javascript Settings</a>&nbsp;&nbsp;
	   <div style="font-size:10px; color:#999999; padding:10px 0px 0px 40px; font-size:14px;">(Avoid conflict by turing Javascript OFF, If other theme or plugins loading any of these below scripts)</div>
		</h3>
		
		<div id="listfusion_sqpg_btm_design" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
		
		  <div style="padding:3px 4px 4px 4px; font-size:14px; ">
		<input name="listfusion[listfusion_disable_facebookJS]" type="checkbox" value="1" <?php if( get_option('listfusion_disable_facebookJS') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Disable facebook JS loading
		  </div>
		  
		  <div style="padding:3px 4px 4px 4px; font-size:14px; margin-top:10px; ">
		<input name="listfusion[listfusion_disable_twitterJS]" type="checkbox" value="1" <?php if( get_option('listfusion_disable_twitterJS') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Disable twitter JS loading
		  </div>
		  
		  <div style="padding:3px 4px 4px 4px; font-size:14px; margin-top:10px; ">
		<input name="listfusion[listfusion_disable_googleplusJS]" type="checkbox" value="1" <?php if( get_option('listfusion_disable_googleplusJS') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Disable google+ JS loading
		  </div>

		  <div style="padding:3px 4px 4px 4px; font-size:14px; margin-top:10px; ">
		<input name="listfusion[listfusion_disable_linkedInJS]" type="checkbox" value="1" <?php if( get_option('listfusion_disable_linkedInJS') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Disable linkedIn JS loading
		  </div>

		  <div style="padding:3px 4px 4px 4px; font-size:14px; margin-top:10px; ">
		<input name="listfusion[listfusion_disable_pinterestJS]" type="checkbox" value="1" <?php if( get_option('listfusion_disable_pinterestJS') == 1 ) { echo 'checked'; } ?> />&nbsp;&nbsp; Disable pinterest JS loading
		  </div>
		  
		  
		</div>
		
			<input type="submit" name="listfusion[globalsettings]" value="Save" class="button button-primary" style="background-image:none;" />


</form>
</div>

		
	  <!--/Eof settings-->
	  </div>
	</div>

</div>

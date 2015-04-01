<h2 style="padding-bottom:10px; font-weight:bold;">Autoresponder Manager <a href="<?php echo $this->listfusion_page.'action=aearp'; ?>" class="add-new-h2">Add New Connection</a></h2>
<!--Display Message-->
<?php $this->__listfusion_handleGLOBALmag($this->listfusion_global_message); ?>
<!--Eof Display Message-->
<form action="" method="post">
  <div class="tablenav top">
  <div class="alignleft actions bulkactions" style="padding-bottom:10px;">
    <select name="global_action">
      <option selected="selected">Bulk Action</option>
      <option value="trash">Move to Trash</option>
    </select>
    <input type="submit" name="global_arp_submit" id="doaction" class="button action" onclick="return confirm('Are You Sure You Want To DELETE Checked Autoresponder Connections.');" value="Apply">
  </div>
  <div class="tablenav-pages one-page"><span class="displaying-num">
    <?php if(  $chk_arp_service > 0 ) { echo "Available Connection:&nbsp;".$chk_arp_service;  }?>
    </span><br class="clear">
  </div>
  <table class="wp-list-table widefat fixed pages" cellspacing="0">
    <!--Start Header-->
    <thead>
      <tr style="background-color:#E1E4EE; background-image:none;">
        <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
        <th scope="col" class="manage-column column-title" style="font-weight:bold;">List Of Autoresponder Connections</th>
        <th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Form Auto Filler</th>
        <th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Connection Type</th>
        <th scope="col" class="manage-column column-date" style="font-weight:bold;"><span>Add Date</span></th>
      </tr>
    </thead>
    <tbody>
	  <?php  
		  if( $listfusion_items_arpconnection ) { 
				$i = 1;
				foreach ( $listfusion_items_arpconnection as $row ) {
				$options = unserialize($row['options']);
				if( $options['connection_type'] == 1 ) $connection_type = 'HTML';
				if( $options['connection_type'] == 2 ) $connection_type = 'HTML + .CSV';
				if( $options['connection_type'] == 3 ) $connection_type = '.CSV (STAND ALONE)';
				if( $options['connection_type'] == 4 ) $connection_type = 'SEND EMAIL';
				
				if( $row['flag_aff'] == 0 ) { 
					$affstatus = 'enable';
					$affcolor='#666666';
					$alert_msg = 'Active';
					$status = 'Disable';
					$status_color = 'listfusion_status_active';
				} else if( $row['flag_aff'] == 1 ) {
					$affstatus = 'disable';
					$affcolor='#009933';
					$alert_msg = 'Deactive';
					$status = 'Active';
					$status_color = 'listfusion_status_disable';
				}
				
				if( $i % 2 == 0 ) $class = '';
				else $class = 'alternate';
			?>
      <!--Start Display Result-->
      <tr valign="top" class="<?php echo $class; ?>">
        <th scope="row" class="check-column"><input type="checkbox" name="arpchkall[]" value="<?php echo $row['id']; ?>"></th>
        <td class="column-title"><a class="row-title" href="<?php echo $this->listfusion_page.'action=aearp&id='.$row['id']; ?>" style="font-weight:normal;"><?php echo $row['optin_form_name']; ?></a>
          <div class="row-actions"> <span class="edit"><a href="<?php echo $this->listfusion_page.'action=aearp&id='.$row['id']; ?>" title="Edit this item">Edit</a> | </span> <span class="trash"><a class="submitdelete" onclick="return confirm('Are You Sure You Want To DELETE this Autoresponder Connections.');" href="<?php echo $this->listfusion_page.'did='.$row['id']; ?>" title="Move this item to the Trash">Delete</a></span> </div></td>
        <td class="author column-author"><a onclick="return confirm('Are you sure to <?php echo $alert_msg; ?> Form Auto Filler?');" href="<?php echo $this->listfusion_page.'arpid='.$row['id'].'&flag='.$affstatus; ?>" > <?php echo ucwords($affstatus); ?> </a> <br>
          <span style="color:#CCCCCC">Status: <span class="<?php echo $status_color; ?>"><?php echo $status; ?></span></span>
          <!--<a href="#">Disable</a>--></td>
        <td class="author column-author"><?php echo $connection_type; ?></td>
        <td class="date column-date"><abbr><?php echo $row['add_date']; ?></abbr></td>
      </tr>
      <!--Eof Start Display Result-->
      <?php $i++;
			}
	      } else {
	  ?>	
      <tr valign="top" class="alternate">
        <th colspan="5" scope="row" style="text-align:center;padding: 10px;">No ANY Autoresponder Connections Added yet <span class="newform"><a href="<?php echo $this->listfusion_page.'action=aearp'; ?>" style="color:#0033CC; text-decoration:none; font-weight:bold;"> Go Add One </a></th>
      </tr>
	  <?php } ?>	
			
			
    </tbody>
  </table>
</form>
<?php if(  $chk_arp_service > 0 ) { ?>
<br>
<div>
  <h4 class="listfusion_alert"> <a onClick="__JS_listfustion_ShowHide('auto_form_filler_info', 'auto_form_filler_info_img', 2, '<?php echo LIST_FUSION_LIBPATH;?>');" style="cursor:hand;cursor:pointer"> <img src="<?php echo LIST_FUSION_LIBPATH; ?>images/plus-small.gif" id="auto_form_filler_info_img" border="0" title="Click to collapse" align="top" /> <span>Form Auto Filler <i>(Information)</i></span> </a>
    <div style="font-size:11px; padding-top:8px; display:none; color:#333;" id="auto_form_filler_info"> <strong>1.</strong> Your information (Name, Email) will be automatically filled while you are logged in. <br>
      <div style="padding-top:8px;"><strong>2.</strong> For not logged in user, form auto filler grabs the visitor's name and email from the comment they have made.</div>
      <div style="padding-top:8px;"><strong>3.</strong> If you have choose "Split name into first and last" while creating the form your visitor information will be automatically split into FIRST and LAST NAME while Auto Filling Name Information.</div>
      <div style="padding-top:8px;"><strong style="color:#FF3300">IMPORTANT::</strong> 'Form Auto Filler' use wp_footer() wordpress hook to process, Please check your template file for existence of wp_footer() hook right before &lt;/body&gt; tag if 'Form Auto Filler' is not working at all.</div>
    </div>
  </h4>
</div>
<?php } ?>
<br class="clear">
<br class="clear">
<br class="clear">

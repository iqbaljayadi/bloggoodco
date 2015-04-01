<h2 style="padding-bottom:10px;">Exit JS PopUp <a href="<?php echo $this->listfusion_page.'action=aejsp'; ?>" class="add-new-h2">Add New Exit JS PopUp</a></h2>
<?php $this->__listfusion_handleGLOBALmag($this->listfusion_global_message); ?>
<p>Redirect any visitors trying to leave your page/site to a page of your choosing. (NEED JS POPUP)</p>
<form action="" method="post">
<div class="tablenav top">

	<div class="alignleft actions bulkactions" style="padding-bottom:10px;">
		<select name="global_action">
			<option selected="selected">Bulk Action</option>
			<option value="trash">Move to Trash</option>
		</select>
		<input type="submit" name="global_ext_js_submit" id="doaction" class="button action" onclick="return confirm('Are You Sure You Want To DELETE Checked Records.');" value="Apply">
	</div>

	<div class="tablenav-pages one-page"><span class="displaying-num"><?php if(  $chk_arp_service > 0 ) { echo "Available Connection:&nbsp;".$chk_arp_service;  }?> </span><br class="clear"></div>
	
	<table class="wp-list-table widefat fixed pages" cellspacing="0">
		
		<!--Start Header-->
		<thead>
		<tr style="background-color:#E1E4EE; background-image:none;">
		  <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
			<th scope="col" class="manage-column column-title" style="font-weight:bold;">List Of Added JS PopUp</th>
			<th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Stats</th>
			<th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Analytics Report</th>
			<th scope="col" class="manage-column column-date" style="font-weight:bold;"><span>Add Date</span></th>	
		</tr>
		</thead>
			<tbody>
		<?php if( $exit_js_popups == 0 ) { ?>
		
			<tr valign="top" class="alternate">
				<th colspan="5" scope="row" style="text-align:center;padding: 10px;">No ANY JS PopUp Added yet <span class="newform"><a href="<?php echo $this->listfusion_page.'action=aejsp'; ?>" style="color:#0033CC; text-decoration:none; font-weight:bold;"> Go Add One </a></span></th>
			</tr>
		
		 <?php } else if( $exit_js_popups > 0 ) { 
				$i = 1;
				while ( $row = mysql_fetch_assoc( $process_sql ) ) { 
			
				if( $row['flag'] == 0 ) { 
					$affstatus = 'enable';
					$affcolor='#666666';
					$alert_msg = 'Active';
					$status = 'Disable';
					$status_color = 'listfusion_status_active';
				} else if( $row['flag'] == 1 ) {
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
				<th scope="row" class="check-column"><input type="checkbox" name="ejpchkall[]" value="<?php echo $row['id']; ?>"></th>
				<td class="column-title"><a class="row-title" href="<?php echo $this->listfusion_page.'action=aejsp&id='.$row['id']; ?>" style="font-weight:normal;"><?php echo $row['item_name']; ?></a>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $this->listfusion_page.'action=aejsp&id='.$row['id']; ?>" title="Edit this item">Edit</a> | </span>
					<span class="trash"><a class="submitdelete" onclick="return confirm('Are You Sure You Want To DELETE this Record.');" href="<?php echo $this->listfusion_page.'did='.$row['id']; ?>" title="Move this item to the Trash">Delete</a></span>
				</div>
				</td>			
				<td class="author column-author">
				<a onclick="return confirm('Are you sure to <?php echo $alert_msg; ?> this record?');" href="<?php echo $this->listfusion_page.'ejpid='.$row['id'].'&flag='.$affstatus; ?>" > <?php echo ucwords($affstatus); ?> </a> <br><span style="color:#CCCCCC">Status: <span class="<?php echo $status_color; ?>"><?php echo $status; ?></span></span>
				<!--<a href="#">Disable</a>--></td>				<td class="author column-author"><a href="<?php echo $this->listfusion_page.'action=stats&id='.$row['id']; ?>"><img src="<?php echo LIST_FUSION_LIBPATH; ?>images/analytics.png">View Daily Stats</a></td>
				<td class="date column-date"><abbr><?php echo $row['add_date']; ?></abbr></td>		
			</tr>
			
		<!--Eof Start Display Result-->
		
		 <?php $i++;
			}
			} ?>	
		</tbody>
	</table>

</form>
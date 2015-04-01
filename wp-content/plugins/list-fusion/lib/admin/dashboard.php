<h2 style="border-bottom: 1px solid #D2D6D5; padding: 9px 15px 0px 0;"><?php echo $this->list_fusion_img; ?> <span class="button button-primary" id="listfusion_menu_dropdown" style="cursor:pointer;margin-top: 20px;"> <span id="plusmenu_dropdown" style="font-size:14px;">+</span><span id="minusmenu_dropdown" style="display:none;font-size:14px;">-</span>&nbsp;Add New Fusion</span></h2>
<div style="clear:both"></div>
<div id="showHideConnections" style="display:none; border: 0; background:#EBEBEB;">
  <!--LIST FUSION CONNECTION TYPE-->
  <ul>
    <li class="listfusion_btm"> 
	  <a href="<?php echo $this->listfusion_page.'action=aepopup'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;border-color:#1A356E;background-image:none; border:1px solid #C6442B;" value="PopUp Box">
      </a> 
	</li>
    <li class="listfusion_btm">
	  <a href="<?php echo $this->listfusion_page.'action=aesqpg'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;border-color:#1A356E;background-image:none; border:1px solid #C6442B;" value="Squeeze Page">
	  </a>
    </li>
    <li class="listfusion_btm">
	  <a href="<?php echo $this->listfusion_page.'action=clkslider'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;border-color:#1A356E;background-image:none; border:1px solid #C6442B;" value="Click Slider">
	  </a>
    </li>
	
    <li class="listfusion_btm"><a href="<?php echo $this->listfusion_page.'action=witinpost'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;border-color:#1A356E;background-image:none; border:1px solid #C6442B;" value="Within Bottom Of Post"></a>
    </li>
	
    <li class="listfusion_btm"><a href="<?php echo $this->listfusion_page.'action=sidebar'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;border-color:#1A356E;background-image:none; border:1px solid #C6442B;" value="Sidebar"></a>
    </li>
	
    <li class="listfusion_btm"> <a href="<?php echo $this->listfusion_page.'action=aejsp'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;background-image:none; border:1px solid #B47811;" value="Exit JS PopUp">
      </a> </li>
	  
	  <?php if( $filter->insidebox == 1 ){ ?>
    <li class="listfusion_btm"><input name="" type="button" class="button button-primary" style="background-color: #B9B2B1;background-image:none; border:1px solid #858077;" value="Inside The Comment Box (record added: ONLY 1 RECORD ALLOWED)"></li>
	  <?php } else {  ?>
    <li class="listfusion_btm"> <a href="<?php echo $this->listfusion_page.'action=icbox'; ?>">
      <input name="" type="button" class="button button-primary" style="background-color: #D95E46;background-image:none; border:1px solid #B47811;" value="Inside The Comment Box">
      </a> </li>
	  <?php } ?>
	  
  </ul>
  <!--/EOF LIST FUSION CONNECTION TYPE-->
</div>
<div style="clear:both"></div>
<?php 
if( $_GET['sts'] == 1 ) $this->listfusion_global_message = 'NEW RECORD ADDED successfully';
else if( $_GET['sts'] == 2 ) $this->listfusion_global_message = 'RECORD UPDATE successfully';
$this->__listfusion_handleGLOBALmag($this->listfusion_global_message); 
?>
<form action="" method="post">
  <div class="actions bulkactions" style="padding-bottom:10px; padding-top:10px; float:left;">
    <select name="global_action">
      <option selected="selected">Bulk Action</option>
      <option value="trash">Move to Trash</option>
    </select>
    <input type="submit" name="global_placement_submit" id="doaction" class="button action" onclick="return confirm('Are You Sure You Want To DELETE Checked Records.');" value="Apply">
  </div>
  <!--FILTER RECORD-->
  <div class="alignleft actions" style="padding-top: 15px; font-size:14px;"> &nbsp;&nbsp;&nbsp;<span style="font-size:14px; color:#0033FF; cursor:pointer; font-weight:bold;" id="listfusion_filter_dropdown"><span id="rec_plusmenu_dropdown" style="font-size:14px;">+</span><span id="rec_minusmenu_dropdown" style="display:none;font-size:14px;">-</span> Filter Below Records </span> <img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle">&nbsp;&nbsp;<span style="color:#FF0000;">Filter</span> </div>
  <div id="listfusion_showhide_filter_rec" style="clear:both; padding-top:1px; display:none;">
  <ul class="listfusion_short_rec_left">
  <li>
  <?php 
  if ( $filter != '' ) {
  ?> 
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=1'; ?>"> All (<?php if( $filter->total >0 ){ echo $filter->total; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp; 
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=2'; ?>"> PopUp Box (<?php if( $filter->popup >0 ){ echo $filter->popup; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp; 
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=3'; ?>"> Squeeze Page (<?php if( $filter->squeezepg >0 ){ echo $filter->squeezepg; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp; 
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=4'; ?>"> Click Slider (<?php if( $filter->clickslider >0 ){ echo $filter->clickslider; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp;  
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=5'; ?>"> Within Bottom Of Post (<?php if( $filter->withinpost >0 ){ echo $filter->withinpost; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp;  
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=6'; ?>"> Sidebar (<?php if( $filter->sidebar >0 ){ echo $filter->sidebar; } else { echo '0'; }; ?>)</a></span> 
&nbsp;&nbsp;  
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=7'; ?>"> Exit Js PopUp (<?php if( $filter->exitjspopup >0 ){ echo $filter->exitjspopup; } else { echo '0'; }; ?>)</a></span>  
&nbsp;&nbsp;  
  <span class="listfusion_rec_btm"><a href="<?php echo $this->listfusion_page.'filter=8'; ?>"> Inside Comment Box (<?php if( $filter->insidebox >0 ){ echo $filter->insidebox; } else { echo '0'; }; ?>)</a></span>  
  <?php } ?>
	 	
		</li>
   </ul>	
  </div>
  <!--/EOF FILTER RECORD-->
  <div class="tablenav-pages one-page"><span class="displaying-num">
    <?php //if(  $chk_arp_service > 0 ) { echo "Available Connection:&nbsp;".$chk_arp_service;  }?>
    </span><br class="clear">
  </div>
  <table class="wp-list-table widefat fixed pages" cellspacing="0">
    <!--Start Header-->
    <thead>
      <tr style="background-color:#E1E4EE; background-image:none;">
        <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
        <th scope="col" class="manage-column column-title" style="font-weight:bold;">List Fusions</th>
        <th scope="col" class="manage-column column-author" style="width:90px;font-weight:bold;">Theme</th>
        <th scope="col" class="manage-column column-author" style="width:90px;font-weight:bold;">Campaign</th>
        <th scope="col" class="manage-column column-author" style="width:130px;font-weight:bold;">Fusion Type</th>
        <th scope="col" class="manage-column column-author" style="width:90px;font-weight:bold;">Stats</th>
        <th scope="col" class="manage-column column-author" style="width:130px;font-weight:bold;">Analytics</th>
        <th scope="col" class="manage-column column-date" style="font-weight:bold;"><span>Add Date</span></th>
      </tr>
    </thead>
    <tbody>
      <?php if( $listfusion_items ) { 
				$i = 1;
				foreach ( $listfusion_items as $filter ) {
				
				$item_option = unserialize($filter->option_values);
				if( $filter->item_type == "custompopup" && $item_option['popup_onClickAction_self_display'] == 1 ) {
					$onclick_action = $item_option['popup_onClickAction_self_display'];
				} else {
					$onclick_action = 2;
				}
				$id = $filter->id; 
				$mainROOTIDSP = $filter->id; 
				$item_name = $filter->item_name; 
				$item_type = $filter->item_type; 
				$childid = $filter->childid; 
				$flag = $filter->flag;
				$add_date = $filter->add_date;
				
				if( $flag == 0 ) { 
					$affstatus = 'enable';
					$affcolor='#666666';
					$alert_msg = 'Active';
					$status = 'Disable';
					$status_color = 'listfusion_status_active';
				} else if( $flag == 1 ) {
					$affstatus = 'disable';
					$affcolor='#009933';
					$alert_msg = 'Deactive';
					$status = 'Active';
					$status_color = 'listfusion_status_disable';
				}
				
				if( $i % 2 == 0 ) $class = '';
				else $class = 'alternate';
				
				$this->__listfusion_dashboard_ext($item_type);
			?>
      <!--Start Display Result-->
      <tr valign="top" class=" <?php echo $class; ?> ">
        <th scope="row" class="check-column"><input type="checkbox" name="lfnchkall[]" value="<?php echo $id; ?>"></th>
        
		<td class="column-title">
		<strong><a style="font-size: 14px;font-weight: 600;font-weight:normal;" href="<?php echo $this->listfusion_page.'action='.$this->edit_action.'&id='.$id; ?>"><?php echo $item_name;  if( $onclick_action == 1 ) { echo '&nbsp;<strong style="color:#AFAAAA">(OnClick PopUp)</strong>'; }?></a></strong>
        <div class="row-actions"> 
		<span class="edit"><a href="<?php echo $this->listfusion_page.'action='.$this->edit_action.'&id='.$id; ?>" title="Edit this item">Edit</a> | </span> 
		
		<span class="trash"><a class="submitdelete" onclick="return confirm('Are you sure to DELETE ROOT \'<?php echo $item_name; ?>\'? If you continue this action... You will loose click analytics and all other records that are connected with this ROOT record');" href="<?php echo $this->listfusion_page.'did='.$id; ?>" title="delete">Delete</a></span>
		
        <?php if( $this->split_display == 1 && $onclick_action != 1 ) { ?>
        | <span class="abtest"><a href="<?php echo $this->listfusion_page.'action='.$this->edit_action.'&ab=true&split='.$id; ?>" title="Edit this item">A/B Test</a> 
		</span>
        <?php } ?>
		
		<!--Tag-->
        <?php if( $onclick_action == 1 ) { ?>
        | <span class="abtest">
			<a style="cursor:pointer;" onClick="return listfusion_Overlay(this, 'listfusiontag_<?php echo $id; ?>', 'rightbottom')" >OnClick Tag</a>
		</span>
        <?php } ?>
		
						<!--Tag HTML-->
	<div id="listfusiontag_<?php echo $id; ?>" style="position:absolute; width:500px; padding:8px; display:none; z-index:999999;">
		 
	 <table cellpadding="2" cellspacing="1" style="background: #FFFFAA; border: 1px solid #FFAD33; padding: 8px 8px 8px 8px; 	border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index:999999; 
	box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); padding:10px;">
	 <tr>
	  <td align="right" width="108"><span style="font-weight: bold;">Template Tag:</span></td>
	  <td><input type="text" name="tt" id="tt_<?php echo $id;?>" style="width:250px;font-size:10px;"  value="&lt;?php  if(function_exists('listfusion_getTemplateTag')) listfusion_getTemplateTag( '[LFONCLICK:Popup=<?php echo $id; ?>] YOUR CONTENT GOES HERE [/LFONCLICK:Popup]' );  ?&gt;" onfocus="this.select()">
	</td></tr>
	
	 <tr>
	  <td align="right"><span style="font-weight: bold;">Post/Page Tag:</span></td>
	  <td><input type="text" name="pt" id="pt_<?php echo $id; ?>" style="width:250px;font-size:10px;" value="[LFONCLICK:Popup=<?php echo $id; ?>] Your Content Goes Here [/LFONCLICK:Popup]" onfocus="this.select()"></td></tr>
	  
	</tr>
	 <tr>
	  <td align="right"><span style="font-weight: bold;">Widget Tag:</span></td>
	  <td><small>Go to widget section and drag and drop '<strong>List Fusion: OnClick PopUp</strong>' Widget to its specific location</small></td></tr>

	  
	 <tr><td colspan="2" align="right"><br><b><a onClick="listfusion_OverlayClose('listfusiontag_<?php echo $id; ?>'); return false" style="cursor:pointer;">Close</a></b></td></tr>
	 </table>
	 </div>
	 <!--Eof Tag HTML-->
		
		</div>
        </td>
		
        <td><span style="padding:2px 5px 3px 0px; -moz-border-radius:2px; border-radius:2px;"><?php if( $item_option['preview_type'] != '' ) { ?> Theme <?php echo $item_option['preview_type']; } else { echo 'N/A';} ?></span></td>
        <td><span style="padding:2px 5px 3px 0px; -moz-border-radius:2px; border-radius:2px;"><?php echo $this->campaign; ?></span></td>
		
        <td><span style="background:<?php echo $this->fusionColor; ?>; color:#FFFFFF; padding:2px 5px 3px 5px; -moz-border-radius:2px; border-radius:2px; opacity: 0.8; filter: alpha(opacity=80);"><?php echo $this->type; ?></span></td>
		
        <td class="author column-author"><a onclick="return confirm('Are you sure to <?php echo $alert_msg; ?> this record?');" href="<?php echo $this->listfusion_page.'pmtid='.$id.'&flag='.$affstatus; ?>" > <?php echo ucwords($affstatus); ?> </a> <br>
          <span style="color:#CCCCCC">Status: <span class="<?php echo $status_color; ?>"><?php echo $status; ?></span></span>
        </td>
		  
        <td class="author column-author"><a href="<?php echo $this->listfusion_page.'action=stats&id='.$id; ?>"><img src="<?php echo LIST_FUSION_LIBPATH; ?>images/analytics.png">View Daily Stats</a></td>
		
        <td class="date column-date"><abbr><?php echo $add_date; ?></abbr></td>
      </tr>
      <!--Eof Start Display Result-->
	  
	  <!--A/B Test Display-->
	  <?php 
		$ab_sql = "SELECT id,item_name,option_values,item_type,childid,flag,add_date
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='$id' ORDER BY id ASC";
		$process_ab_test = $wpdb->get_results( $ab_sql );
		
		$j = $i;
		if( $process_ab_test ) {
		    $this->ab_active == 1;
			foreach ( $process_ab_test as $filter ) {
			 
			$item_ab_option = unserialize($filter->option_values);
				$j = $j+1;
				$id = $filter->id;
				$item_name = $filter->item_name; 
				$item_type = $filter->item_type;
				$childid = $filter->childid; 
				$flag = $filter->flag;
				$add_date = $filter->add_date;
				
				if( $flag == 0 ) { 
					$affstatus = 'enable';
					$affcolor='#666666';
					$alert_msg = 'Active';
					$status = 'Disable';
					$status_color = 'listfusion_status_active';
				} else if( $flag == 1 ) {
					$affstatus = 'disable';
					$affcolor='#009933';
					$alert_msg = 'Deactive';
					$status = 'Active';
					$status_color = 'listfusion_status_disable';
				}
				
				if( $j % 2 == 0 ) $class = '';
				else $class = 'alternate';

				$this->__listfusion_dashboard_ext($item_type);
			
	   ?>
	   
      <tr valign="top" class="<?php echo $class; ?>">
        <th scope="row" class="check-column" ><input type="checkbox" name="lfnchkall[]" value="<?php echo $id; ?>"></th>
		
        <td class="column-title">
		    <img src="<?php echo LIST_FUSION_FULLPATH ?>lib/images/sub.gif" border="0" align="absmiddle">&nbsp;
			<strong><a style="font-size: 14px;font-weight: 600;font-weight:normal;" href="<?php echo $this->listfusion_page.'action='.$this->edit_action.'&ab=true&split='.$mainROOTIDSP.'&id='.$id; ?>" ><?php echo $item_name; ?>
			</a></strong>
          <div class="row-actions"> 
		  <span class="edit"> <a href="<?php echo $this->listfusion_page.'action='.$this->edit_action.'&ab=true&split='.$mainROOTIDSP.'&id='.$id; ?>" title="Edit this item">Edit</a> | </span> 
		  <span class="trash"><a class="submitdelete" onclick="return confirm('Are you sure to DELETE Split Test Record \'<?php echo $item_name; ?>\'? ');" href="<?php echo $this->listfusion_page.'did='.$id; ?>" title="Move this item to the Trash">Delete</a></span>
          </div>
		</td>
		
        <td><span style="padding:2px 5px 3px 0px; -moz-border-radius:2px; border-radius:2px;"><?php if( $item_ab_option['preview_type'] != '' ) { ?> Theme <?php echo $item_ab_option['preview_type']; } else { echo 'N/A';} ?></span></td>
        <td><span style="padding:2px 5px 3px 0px; -moz-border-radius:2px; border-radius:2px;"><?php echo $this->campaign; ?></span></td>
		
        <td>
			<img src="<?php echo LIST_FUSION_FULLPATH ?>lib/images/sub.gif" border="0" align="absmiddle">&nbsp;
			<span style="border:1px solid <?php echo $this->fusionColor; ?>; color:#000; padding:2px 5px 3px 5px; -moz-border-radius:2px; border-radius:2px; opacity: 0.8; filter: alpha(opacity=80);"><?php echo $this->type; ?> (A/B)</span>
		</td>
		
        <td class="author column-author">
			<a onclick="return confirm('Are you sure to <?php echo $alert_msg; ?> this record?');" href="<?php echo $this->listfusion_page.'pmtid='.$id.'&flag='.$affstatus; ?>" > <?php echo ucwords($affstatus); ?> </a> <br>
			<span style="color:#CCCCCC">Status: <span class="<?php echo $status_color; ?>"><?php echo $status; ?></span></span>
		</td>
		
        <td class="author column-author">
			<a href="<?php echo $this->listfusion_page.'action=stats&id='.$id; ?>">
			<img src="<?php echo LIST_FUSION_LIBPATH; ?>images/analytics.png">View Daily Stats
			</a>
		</td>
		
        <td class="date column-date"><abbr><?php echo $add_date; ?></abbr></td>
      </tr>
		
	   <?php 
	   		 $j = $j+1; 
	   		 $j--;
			}
		}
	  ?>
	  <!--Eof A/B Test Display-->
      <?php 
	        if( $this->ab_active == 1 ) { 
				$i = $j - 1; 
			} else {
				$i = $j; 
			}
			$i++;
			}
			
			
		} else {
		?>
      <tr valign="top" class="alternate">
        <th colspan="8" scope="row" style="text-align:center;padding: 10px;">No ANY Connection Added yet <span class="newform"><a href="<?php echo $this->listfusion_page.'action='.$this->addnew_fusion_now; ?>" style="color:#0033CC; text-decoration:none; font-weight:bold;"> Go Add One </a></span></th>
      </tr>
	<?php } ?>
		
		
    </tbody>
  </table>
</form>

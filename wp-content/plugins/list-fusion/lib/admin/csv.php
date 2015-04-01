<h2 style="padding-bottom:10px;font-weight:bold;">.CSV File Manager</h2>
<?php $this->__listfusion_handleGLOBALmag($this->listfusion_global_message); ?>
<div style="width:850px; margin:10px 0px 20px 0px; position:relative;">
  
	<div id="listfusion-nav">
	  <ul>
		<li class="current" onclick="__listfusionSelectTab(1,'csvBackup')"><a id="listfusionHead-1"><strong>.CSV (BackUp)</strong></a></li>
		<li onclick="__listfusionSelectTab(2,'csvStandAlone')"><a id="listfusionHead-2" ><strong>.CSV (Stand Alone)</strong></a></li>
	  </ul>
	</div>
	
	<div class="listfusion-content">
	  <div class="listfusion-section">
	  <!--Start PopUp-->
	  
	  	<!--Start CSV Backup-->
		<div id="csv_backup">
			<p class="listfusion_alert" style="margin:0px 0px 5px 0px;"><strong>Connection Type: </strong>HTML Form Code + Store In .CSV File</p>
			<br>
			<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<!--Start Header-->
			<thead>
			<tr style="background-color:#E5E8F1; background-image:none;">
				<th scope="col" class="manage-column column-title" style="font-weight:bold;">Created .CSV BackUp Files</th>
				<th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Action</th>
			</tr>
			</thead>
			<!--Start Display Result-->
			<tbody>
			
			<?php 
			$dir = LIST_FUSION_RELPATH.'/csv/backup/'; // The directory containing the files. 
			$ext = '.csv'; // The file extension.
			$array = glob(LIST_FUSION_RELPATH.'/csv/backup/*.csv',GLOB_BRACE);
			if(count($array) > 0) {	
				$count = 1;
				foreach (glob($dir . '/*' . $ext) as $file) {
				if( $count % 2 == 0 ) $color = 'alternate';
				else $color = '';
				?> 
			
				<tr valign="top" class="<?php echo $color; ?>">
					<td class="column-title"><span style="font-size: 14px;"><?php echo $count; ?>.&nbsp;</span><a class="row-title" href="#" style="font-weight:normal;"><?php echo basename($file, $ext); ?></a>  
					<div class="row-actions">&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="trash"><a onclick="return confirm('WARNING:: Are you sure to DELETE this .CSV file');" href="<?php echo $this->listfusion_page.'type=csv&csvdel=1&val='.LIST_FUSION_RELPATH.'/csv/backup/'. basename($file, $ext) .'.csv'; ?>">Delete</a></span>
					</div>
					</td>			
					<td class="author column-author"><a href="<?php echo LIST_FUSION_FULLPATH.'csv/backup/'. basename($file, $ext) .'.csv'; ?>">Download</a></td>
				</tr>

			<?php 
				$count++; 
				} 
			} else {
			?>
			<tr valign="top" class="">
			  <td class="column-title" colspan="2">No any .csv file created yet</td>			
				
			</tr>
			<?php 
			}
			?>
			</tbody>
		</table>	
			
		</div>
		
		
	  	<!--Start CSV Stand Alone Backup-->
		<div id="csv_standalone" style="display:none;">
			<p class="listfusion_alert" style="margin:0px 0px 5px 0px;"><strong>Connection Type: </strong>Store In .CSV File (STAND ALONE)</p>	
			
			
			<table class="wp-list-table widefat fixed pages" cellspacing="0">
			<!--Start Header-->
			<thead>
			<tr style="background-color:#E5E8F1; background-image:none;">
				<th scope="col" class="manage-column column-title" style="font-weight:bold;">Created .CSV Stand Alone Files</th>
				<th scope="col" class="manage-column column-author" style="width:150px;font-weight:bold;">Action</th>
			</tr>
			</thead>
			<!--Start Display Result-->
			<tbody>
			
			<?php 
			$dir = LIST_FUSION_RELPATH.'/csv/'; // The directory containing the files. 
			$ext = '.csv'; // The file extension.
			$array = glob(LIST_FUSION_RELPATH.'/csv/*.csv',GLOB_BRACE);
			if(count($array) > 0) {	
				$count = 1;
				foreach (glob($dir . '/*' . $ext) as $file) {
				if( $count % 2 == 0 ) $color = 'alternate';
				else $color = '';
				?> 
			
				<tr valign="top" class="<?php echo $color; ?>">
					<td class="column-title"><span style="font-size: 14px;"><?php echo $count; ?>.&nbsp;</span><a class="row-title" href="#" style="font-weight:normal;"><?php echo basename($file, $ext); ?></a>  
					<div class="row-actions">&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="trash"><a onclick="return confirm('WARNING:: Are you sure to DELETE this .CSV file');" href="<?php echo $this->listfusion_page.'type=csv&csvdel=1&val='.LIST_FUSION_RELPATH.'/csv/'. basename($file, $ext) .'.csv'; ?>">Delete</a></span>
					</div>
					</td>			
					<td class="author column-author"><a href="<?php echo LIST_FUSION_FULLPATH.'csv/'. basename($file, $ext) .'.csv'; ?>">Download</a></td>
				</tr>

			<?php 
				$count++; 
				} 
			} else {
			?>
			<tr valign="top" class="">
			  <td class="column-title" colspan="2">No any .csv file created yet</td>			
				
			</tr>
			<?php 
			}
			?>
			</tbody>
		</table>	
			
			
			
		</div>
		
		
	  <!--/Eof PopUp-->
	  </div>
	</div>

</div>

<h2 style="padding-bottom:10px; font-weight:bold;">Daily Analytics Report</h2>
<?php
global $wpdb;
if( $_GET['clean'] == 1 ) {
	$sql = "DELETE FROM $this->listfusion_status_table WHERE listfusionID='".$_GET['id']."' ";
	$wpdb->query( $sql );
	$listfusion_global_message = 'All stats to ZERO, Successfully';
}

$this->__listfusion_handleGLOBALmag($listfusion_global_message);

if(isset($_POST['searchRecords']) && $_POST['searchRecords'] == 'Search' ) {
	$month = $_POST['Smonth'];
	$year = $_POST['Syear'];
} else {
	$month = date('m');
	$year = date('Y');
}
?>
<br>
<a href="<?php echo $this->listfusion_page; ?>"><input name="" type="button" class="button button-primary"  value="<< Back To Records" /></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo $this->listfusion_page.'action='.$_GET['action'].'&id='.$_GET['id'].'&clean=1'; ?>"  onclick="return confirm('Are you sure you want reset all stats to ZERO. Be very careful not to do this in the middle of a test you care about, though. Once done it cannot be undone');"><input name="" type="button" class="button button-primary" style="background:#CC3300; border:none;"  value="RESET STATS" /></a>
<div style="clear:both"></div>
<br>
<div style="height:auto;">

<table style="width:630px;">
<tr>
<td>
  <div style="margin-top:5px; padding-top:50px; border-top: 1px solid #D6D4D4; min-height:110px; border-bottom: 1px solid #D6D4D4;">
  
    <div style="float:left; text-align:center; font-size:60px; font-weight:bold; width:160px;">
        <?php 
			$totalImp = $wpdb->get_var("SELECT SUM(impressions) FROM $this->listfusion_status_table WHERE listfusionID='$_GET[id]' ");
			if( $totalImp == '' ) echo '0';
			else echo $totalImp = $totalImp;
		?>
        <br>
        <div style="font-size:14px; padding-top:35px;">Total Impression</div>
    </div>
	
    <div style="float:left; text-align:center; font-size:60px; font-weight:bold; width:160px;">
        <?php 
			$totalClick = $wpdb->get_var("SELECT SUM(click) FROM $this->listfusion_status_table WHERE listfusionID='$_GET[id]' ");
			if( $totalClick == '' ) echo '0';
			else echo $totalClick = $totalClick;
		?>
        <br>
        <div style="font-size:14px; padding-top:35px;"> Total Clicks </div>
    </div>
	
     <div style="float:left; text-align:center; font-size:60px; font-weight:bold; width:300px;">
        <?php 
			if ( $totalImp > 0 ) $crt = ( $totalClick / $totalImp ) * 100; 
			else $crt = 0;
			echo $crt = sprintf("%01.2f", $crt).'%';	
		?>
        <br>
		<div style="font-size:14px; padding-top:35px;"> Total CTR% </div>
    </div>
  </div>
</td></tr></table>  
  
  
  
  
  <!--Search Date-->
  <div style="clear:both"></div>
  <h3 style="padding:10px 0px 0px 0px;">Short Your Records:</h3>
  
<table style="width:630px;">
<tr>
<td>
  <form action="" method="post">
    <table class="wp-list-table widefat fixed pages" cellspacing="0" style="background:#D8DBE4;">
      <tr>
        <td width="18%"><strong>Year:</strong>
          <select name="Syear" style="width:90px;">
            <?php 
		  		for( $i=14; $i<=37; $i++ ) {  
		  		$displayMonth = '20'.$i;
				if( $year == $displayMonth ) $select = 'selected';
				else $select = '';
		  ?>
            <option value="<?php echo $displayMonth; ?>" <?php echo $select; ?> ><?php echo $displayMonth; ?></option>
            <?php } ?>
          </select>
          &nbsp;&nbsp;&nbsp; <strong>Month:</strong>
          <select name="Smonth" style="width:90px;">
            <?php 
		  		for( $i=1; $i<=12; $i++ ) {  
				if( $i == $month ) $select = 'selected';
				else $select = '';
		  ?>
            <option value="<?php echo $i; ?>"  <?php echo $select; ?> >
            <?php
		  if( $i == 1 ) echo 'Jan';
		  else  if( $i == 2 ) echo 'Feb';
		  else  if( $i == 3 ) echo 'Mar';
		  else  if( $i == 4 ) echo 'Apr';
		  else  if( $i == 5 ) echo 'May';
		  else  if( $i == 6 ) echo 'Jun';
		  else  if( $i == 7 ) echo 'Jul';
		  else  if( $i == 8 ) echo 'Aug';
		  else  if( $i == 9 ) echo 'Sep';
		  else  if( $i == 10 ) echo 'Oct';
		  else  if( $i == 11 ) echo 'Nov';
		  else  if( $i == 12 ) echo 'Dec';
		  ?>
            </option>
            <?php } ?>
          </select>
          &nbsp;&nbsp;&nbsp;
          <input name="searchRecords" type="submit" value="Search" class="button button-primary" />
		  </td>
      </tr>
    </table>
  </form>
  </td>
 </tr>
</table>
  
  
  <br>
  <div style="clear:both"></div>
  <br>
  <!--Eof Search-->
</div>
<?php
for($m=1;$m<=cal_days_in_month(CAL_GREGORIAN, $month, $year);$m++)
{
	if($m <10){ $mon="0".$m; }
	else { $mon = $m;}
	$mon_days[] = $year.'-'.$month.'-'.$mon;
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawPerDayChart);
      google.setOnLoadCallback(drawPerMonthChart);
	  
	 /* PER DAY STATS
	 **********************************/ 
      function drawPerDayChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Impression', 'Clicks'],
		  
		  <?php 
			$i = 1;       
			foreach( (array) $mon_days as $val ) {
				$rows = $wpdb->get_row( "SELECT * FROM $this->listfusion_status_table WHERE listfusionID='$_GET[id]' and now_date = date('$val') and year = $year ORDER BY id DESC ", ARRAY_A );
				if ($rows != null) {
				    if( $rows['click'] == '' ) $click = 0;
					else  $click = $rows['click'];
					echo $impStats = "['".$rows['now_date']."', ".$rows['impressions'].", $click],";
				} else {
				  	echo $impStats = "['".$year.'-'.$month.'-'.$i."', 0, 0],";
				}
				
			$i++;	
			}
         ?>
        ]);

        var options = {
		
          title: 'Impression and Click by Days',
          hAxis: {title: '', titleTextStyle: {color: 'red'}}
        };

        ///var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
		chart.draw(data, options);
      }
	  
    </script>
<div id="chart_div" style="width:630px; height: 400px; padding:0px; margin:0px;"></div>
<!--<div id="chart_month_div" style="width:800px; height: 400px; padding:0px; margin:0px;"></div>-->
<div style="clear:both"></div>
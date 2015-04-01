<script>
phynuchs_ajax_url="<?php echo admin_url( 'admin-ajax.php' ); ?>";
phynuchs_ajax_loader="<?php echo plugins_url('images/ajax-loader.gif', dirname(__FILE__)) ?>";
</script>
<div class="wrap" id="phynuchs-options-panel"><br/>

  <div class="socnet-header-left" style="height:auto;padding:30px 0px;">
     <img class="socnet-logo" src="<?php echo SOCIAL_STATISTICS_PLUGIN_URL; ?>/icon/Icon-32-px.png" />
     <span style="font-size:16px;font-weight:bold;">WPsocialstats by <a href="http://www.powerwp.com">Powerwp</a></span>
  </div>
  <h2>Options For Auto Updating Your Social Stats</h2>
  <br/>

  <form action="options.php" method="post" id="">
	<h3>Check box to have your social analytics updated automatically once a day</h3>
    

    <table class="form-table">
      <tbody>
	<tr valign="top" id="phynuchs-enable-auto">
	  <th scope="row">
	    Enable auto updates  
	  </th>
	  <td>
	    <input type="checkbox" name="enable-auto"></input>
	  </td>
            
	</tr>

      </tbody>
    </table>

<br/>
     <input class="button button-primary" type="button" value="submit" id="phynuchs-button"/>
  </form>


</div>



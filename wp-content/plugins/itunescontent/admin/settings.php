<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
<?php
if(isset($_GET['tab'])){ $this->admin_tabs($_GET['tab']); }else{ $this->admin_tabs(); }
$this->opt = $this->get_options();
if (isset($_POST['update_iTunesContent'])) {
	
	if($_GET['page'] == $this->base_name){
		
		$message = 'Settings Updated.';
		
		$tab = (isset($_GET['tab']) ? $_GET['tab'] : 'settings');
		$error = (isset($error) ? $error : NULL);
		switch ( $tab ){
			case 'settings':
				$this->opt['default_country'] = (isset($_POST['options']['default_country']) ? $_POST['options']['default_country'] : NULL);
				$this->opt['default_feed_type'] = (isset($_POST['options']['default_feed_type']) ? $_POST['options']['default_feed_type'] : NULL);
				$this->opt['summary_show'] = (isset($_POST['options']['summary_show']) ? $_POST['options']['summary_show'] : NULL);
				$this->opt['summary_limit'] = (isset($_POST['options']['summary_limit']) ? preg_replace('/[^0-9]/', '', $_POST['options']['summary_limit']) : NULL);
			break;
			case 'affiliate-settings':
				$this->opt['affiliate_active'] = (isset($_POST['options']['affiliate_active']) ? $_POST['options']['affiliate_active'] : NULL);
				$this->opt['affiliate_network'] = (isset($_POST['options']['affiliate_network']) ? $_POST['options']['affiliate_network'] : NULL);
				$this->opt['affiliate_id_linkshare'] = (isset($_POST['options']['affiliate_id_linkshare']) ? $_POST['options']['affiliate_id_linkshare'] : NULL);
				$this->opt['affiliate_id_tradedoubler'] = (isset($_POST['options']['affiliate_id_tradedoubler']) ? $_POST['options']['affiliate_id_tradedoubler'] : NULL);
			break;
			case 'cache':
				$this->opt['cache']['amount'] = (isset($_POST['options']['cache']['amount']) ? $_POST['options']['cache']['amount'] : NULL);
				$this->opt['cache']['unit'] = (isset($_POST['options']['cache']['unit']) ? $_POST['options']['cache']['unit'] : NULL);
				if( isset($_POST['options']['clear_cache']) ){
					$this->cache_clear();
					$message.= "<br />Cache Cleared.";
				}
			break;
			default:
		}
		update_option($this->options_name, $this->opt);
	}
	if(!$error){
?>
<div id="message" class="updated fade"><p><strong><?php _e($message, 'iTunesContent');?></strong></p></div>
<?php }else{ ?>
<div id="message" class="error fade"><p><strong><?php _e($error, 'iTunesContent');?></strong></p></div>
<?php }} ?>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <?php
	if($_GET['page'] == $this->base_name){
    $tab = (isset($_GET['tab']) ? $_GET['tab'] : 'settings');
	?>
    <table class="form-table" cellpadding="0" cellspacing="0">
    <?php
    switch ( $tab ){
		case 'settings':
	?>
	<tr>
    	<th><label for="options_default_country"><strong>Default Country:</strong></label></th>
        <td>
        <select id="options_default_country" name="options[default_country]">
        	<option value="<?php _e($this->opt['default_country'], 'iTunesContent'); ?>"><?php _e($this->itunes['countries'][$this->opt['default_country']], 'iTunesContent'); ?></option>
            <?php foreach($this->itunes['countries'] as $code=>$country){ ?>
            <option value="<?php echo $code; ?>"><?php echo $country; ?></option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    	<th><label for="options_default_feed_type"><strong>Default Feed Type:</strong></label></th>
        <td>
        <select id="options_default_feed_type" name="options[default_feed_type]">
        	<option value="<?php _e($this->opt['default_feed_type'], 'iTunesContent'); ?>"><?php _e($this->itunes['feed_types'][$this->opt['default_feed_type']], 'iTunesContent'); ?></option>
            <?php foreach($this->itunes['feed_types'] as $code=>$title){ ?>
            <option value="<?php echo $code; ?>"><?php echo $title; ?></option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    	<th><label for="options_summary_show"><strong>Show Summary?:</strong></label></th>
        <td><input id="options_summary_show" name="options[summary_show]" type="checkbox" value="1"<?php if($this->opt['summary_show']==1){ echo ' checked="checked"'; } ?> /></td>
    </tr>
    <tr>
    	<th><label for="options_summary_limit"><strong>Summary Word Limit:</strong></label></th>
        <td><input name="options[summary_limit]" type="text" value="<?php _e($this->opt['summary_limit'], 'iTunesContent'); ?>" size="3" /></td>
    </tr>
    <?php
		break;
		case 'affiliate-settings':
	?>    
    <tr>
    	<th><label for="options_affiliate_active"><strong>Activate Affiliate Links:</strong></label></th>
        <td><input id="options_affiliate_active" name="options[affiliate_active]" type="checkbox" value="1"<?php if($this->opt['affiliate_active']=='1'){ echo " checked=\"checked\""; } ?> /></td>
    </tr>
    
    <?php if(empty($this->opt['affiliate_id_linkshare'])){ ?>
    <tr>
    	<th><strong>Join LinkShare:</strong></th>
        <td>
        <a href="http://bit.ly/1bq1FDQ" target="_blank"><img border="0" alt="LinkShare UK Referral Program" src="http://ad.linksynergy.com/fs-bin/show?id=38YDpEEyo3M&bids=117947.10000008&subid=0&type=4&gridnum=0"></a>
        </td>
    </tr>
    <?php } ?>
    <tr>
    	<th><label for="options_affiliate_network_linkshare"><strong>Use LinkShare Affiliate Links:</strong></label></th>
        <td><input id="options_affiliate_network_linkshare" name="options[affiliate_network]" type="radio" value="linkshare"<?php if($this->opt['affiliate_network']=='linkshare'){ echo ' checked="checked"'; } ?> /></td>
    </tr>
    <tr>
    	<th><label for="options_affiliate_id_linkshare"><strong>LinkShare Affiliate ID:</strong></label></th>
        <td><input id="options_affiliate_id_linkshare" name="options[affiliate_id_linkshare]" type="text" value="<?php _e($this->opt['affiliate_id_linkshare'], 'iTunesContent'); ?>" /></td>
    </tr>
    
    <tr>
    	<th><label for="options_affiliate_network_tradedoubler"><strong>Use TradeDoubler Affiliate Links:</strong></label></th>
        <td><input id="options_affiliate_network_tradedoubler" name="options[affiliate_network]" type="radio" value="tradedoubler"<?php if($this->opt['affiliate_network']=='tradedoubler'){ echo ' checked="checked"'; } ?> /></td>
    </tr>
    <tr>
    	<th><label for="options_affiliate_id_tradedoubler"><strong>TradeDoubler Affiliate ID:</strong></label></th>
        <td><input id="options_affiliate_id_tradedoubler" name="options[affiliate_id_tradedoubler]" type="text" value="<?php _e($this->opt['affiliate_id_tradedoubler'], 'iTunesContent'); ?>" /></td>
    </tr>
    <?php
		break;
		case 'cache':
	?>
    <tr>
    	<th><strong>Cache Time:</strong></th>
        <td>
        <select name="options[cache][amount]">
        	<option value="<?php _e($this->opt['cache']['amount'], 'iTunesContent'); ?>"><?php _e($this->opt['cache']['amount'], 'iTunesContent'); ?></option>
            <?php for($i=1;$i<=31;$i++){ ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
        <select name="options[cache][unit]">
        	<option value="<?php _e($this->opt['cache']['unit'], 'iTunesContent'); ?>"><?php _e(ucfirst($this->opt['cache']['unit']), 'iTunesContent'); ?></option>
            <option value="hours">Hours</option>
            <option value="days">Days</option>
            <option value="weeks">Weeks</option>
        </select>
        </td>
    </tr>
    <tr>
    	<th><label for="options_clear_cache"><strong>Clear Cache?:</strong></label></th>
        <td><input id="options_clear_cache" name="options[clear_cache]" type="checkbox" value="1" /></td>
    </tr>
    <?php
		break;
		default:
	}
	}
	?>
    
    </table>
    
    <p class="submit">
    <input type="submit" name="update_iTunesContent" value="<?php _e('Update Settings', 'iTunesContent') ?>" class="button-primary" />
    </p>
    </form>
</div>
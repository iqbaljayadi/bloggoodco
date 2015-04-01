<?php
$script = '<script type="text/javascript">';
$script.= 'var $ = jQuery.noConflict();';
$script.= '$(document).ready(function() {';
$script.= '$(\'select#options_feed\').change(function() {';
$script.= '$(\'select#options_genre\').html(\'<option value="" selected="selected">All (Click Generate Shortcode for more options)</option>\').attr(\'disabled\', \'disabled\');';
$script.= '});';
$script.= '});';
$script.= '</script>';
echo $script;
		
$this->opt = $this->get_options();

$form['id'] = (isset($_POST['options']['id']) ? $_POST['options']['id'] : NULL);
$form['country'] = (isset($_POST['options']['country']) ? $_POST['options']['country'] : $this->opt['default_country']);
$form['feed'] = (isset($_POST['options']['feed']) ? $_POST['options']['feed'] : $this->opt['default_feed_type']);
$form['genre'] = (isset($_POST['options']['genre']) ? $_POST['options']['genre'] : NULL);
$form['limit'] = (!empty($_POST['options']['limit']) ? preg_replace('/[^0-9]/', '', $_POST['options']['limit']) : '5');

if (isset($_POST['generate_shortcode'])) {
	
	$id = (!empty($_POST['options']['id']) ? ' id="'.$_POST['options']['id'].'"' : NULL);
	$country = (!empty($_POST['options']['country']) ? ' country="'.$_POST['options']['country'].'"' : NULL);
	$feed = (!empty($_POST['options']['feed']) ? ' feed="'.$_POST['options']['feed'].'"' : NULL);
	$genre = (!empty($_POST['options']['genre']) ? ' genre="'.$_POST['options']['genre'].'"' : NULL);
	$limit = (!empty($_POST['options']['limit']) ? ' limit="'.$_POST['options']['limit'].'"' : ' limit="5"');
	
	$shortcode = '[itunes';
	if(!empty($id)){
		$shortcode.= $id;
		$shortcode.= $country;
	}else{
		$shortcode.= $country;
		$shortcode.= $feed;
		$shortcode.= $genre;
		$shortcode.= $limit;
	}
	$shortcode.= ']';
	
?>
<div id="message" class="updated fade"><p><strong><?php _e('Shortcode generated.', 'iTunesContent');?></strong></p></div>
<?php } ?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    
    <table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">
        <table cellpadding="0" cellspacing="0">
		<?php if (isset($_POST['generate_shortcode'])) { ?>
        <tr>
            <td colspan="2">
            <textarea id="itunes_shortcode" cols="100" rows="1"><?php echo $shortcode; ?></textarea>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th><label for="options_id"><strong>iTunes ID:</strong></label></th>
            <td><input name="options[id]" type="text" value="<?php _e($form['id'], 'iTunesContent'); ?>" /></td>
        </tr>
        <tr>
            <th><label for="options_country"><strong>Country:</strong></label></th>
            <td>
            <select id="options_country" name="options[country]">
                <option value="<?php _e($form['country'], 'iTunesContent'); ?>"><?php _e($this->itunes['countries'][$form['country']], 'iTunesContent'); ?></option>
                <?php foreach($this->itunes['countries'] as $key=>$value){ ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
            </td>
        </tr>
        <tr>
            <th><label for="options_feed"><strong>Feed:</strong></label></th>
            <td>
            <select id="options_feed" name="options[feed]">
                <option value="<?php _e($form['feed'], 'iTunesContent'); ?>"><?php _e($this->itunes['feed_types'][$form['feed']], 'iTunesContent'); ?></option>
                <?php foreach($this->itunes['feed_types'] as $key=>$value){ ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
            </td>
        </tr>
        <?php if( isset($_POST['options']['feed']) && !empty($this->itunes['genres'][$_POST['options']['feed']]) ){ ?>
        <tr>
            <th><label for="options_genre"><strong>Genre:</strong></label></th>
            <td>
            <select id="options_genre" name="options[genre]">
                <option value="<?php _e($form['genre'], 'iTunesContent'); ?>"><?php _e($this->itunes['genres'][$_POST['options']['feed']][$form['genre']], 'iTunesContent'); ?></option>
                <?php foreach($this->itunes['genres'][$_POST['options']['feed']] as $key=>$value){ ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th><label for="options_limit"><strong>Limit:</strong></label></th>
            <td><input name="options[limit]" type="text" value="<?php _e($form['limit'], 'iTunesContent'); ?>" size="3" /></td>
        </tr>
        </table>
        
        <p class="submit">
        <input type="submit" name="generate_shortcode" value="<?php _e('Generate Shortcode', 'iTunesContent') ?>" class="button-primary" />
        </p>
        
        </td>
        <td valign="top">
        <div style="width: 400px;">
        <?php
        if (isset($_POST['generate_shortcode'])) {
			echo '<h2>Preview</h2>';
            if(!empty($form['id'])){
                $output = $this->format_lookup($this->do_lookup($form['id'], $form['country']));
            }else{
                $output = $this->get_data($this->get_url($form['country'], $form['feed'], $form['limit'], $form['genre']), $form['feed'], $form['limit']);
            }
            echo $output;
        }
        ?>
        </div>
        </td>
      </tr>
    </table>
    </form>
</div>
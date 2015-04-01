<?php
/*
Plugin Name: iTunes Content
Plugin URI: #
Description: Easily add iTunes content to your website.
Version: 1.3
Author: Craig Wistow
Author URI: http://www.wistow.net
*/
/*
Copyright 2013 Craig Wistow (email : craig@koosk.com)
*/
require_once('widget.php');
if (!class_exists("iTunesContent")) {
class iTunesContent {

	var $version = '1.3';
	var $base_name;
	var $options_name = 'iTunesContentOptions';
	var $opt;
	var $country_data;
	var $itunes;

	public function __construct(){
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
		
		// Actions
		add_action('admin_menu', array($this, 'add_admin_menu'));
		add_action('widgets_init', array($this, 'register_custom_widgets'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'add_plugin_actions'));
		
		// Shortcodes
		add_shortcode('itunes', array($this, 'itunes_shortcode'));
		
		$this->base_name = basename(__FILE__);
		$this->opt = $this->get_options();
		
		$this->itunes['countries'] = $this->get_country_data();
		$this->itunes['feed_types'] = $this->get_itunes_feed_types();
		$this->itunes['genres'] = $this->get_itunes_genres();
	}
	
	public function get_options() {
		${$this->options_name} = array(
									'default_country'=>'us',
									'default_feed_type'=>'topsongs',
									'summary_show'=>'1',
									'summary_limit'=>'30',
									'affiliate_active'=>'0',
									'affiliate_network'=>'',
									'affiliate_id_linkshare'=>'',
									'affiliate_id_tradedoubler'=>'',
									'cache'=>array('amount'=>'1', 'unit'=>'hours'),
									);
		$this->opt = get_option($this->options_name);
		if (!empty($this->opt)) {
			foreach ($this->opt as $key => $option)
				${$this->options_name}[$key] = $option;
		}
		#unset(${$this->options_name});
		update_option($this->options_name, ${$this->options_name});
		return ${$this->options_name};
	}
	
	public function activate(){
		
	}
	
	public function deactivate(){
		
	}
	
	public function add_plugin_actions($links) {
		array_unshift($links, '<a href="options-general.php?page='.$this->base_name.'">'.__('Settings').'</a>');
		return $links;
	}
	
	public function register_custom_widgets(){
		register_widget('iTunesContentWidget');
	}
	
	public function get_country_data(){
		$countries = array(
						'ai'=>'Anguilla',
						'ag'=>'Antigua &amp; Barbuda',
						'ar'=>'Argentina',
						'am'=>'Armenia',
						'au'=>'Australia',
						'at'=>'Austria',
						'az'=>'Azerbaijan',
						'bs'=>'Bahamas',
						'bh'=>'Bahrain',
						'bb'=>'Barbados',
						'by'=>'Belarus',
						'be'=>'Belgium',
						'bz'=>'Belize',
						'bm'=>'Bermuda',
						'bo'=>'Bolivia',
						'bw'=>'Botswana',
						'br'=>'Brazil',
						'vg'=>'British Virgin Islands',
						'bn'=>'Brunei Darussalam',
						'bg'=>'Bulgaria',
						'bf'=>'Burkina Faso',
						'kh'=>'Cambodia',
						'ca'=>'Canada',
						'cv'=>'Cape Verde',
						'ky'=>'Cayman Islands',
						'cl'=>'Chile',
						'co'=>'Colombia',
						'cr'=>'Costa Rica',
						'hr'=>'Croatia',
						'cy'=>'Cyprus',
						'cz'=>'Czech Republic',
						'dk'=>'Denmark',
						'dm'=>'Dominica',
						'do'=>'Dominican Republic',
						'ec'=>'Ecuador',
						'eg'=>'Egypt',
						'sv'=>'El Salvador',
						'ee'=>'Estonia',
						'fj'=>'Fiji',
						'fi'=>'Finland',
						'fr'=>'France',
						'gm'=>'Gambia',
						'de'=>'Germany',
						'gh'=>'Ghana',
						'gr'=>'Greece',
						'gd'=>'Grenada',
						'gt'=>'Guatemala',
						'gw'=>'Guinea-Bissau',
						'hn'=>'Honduras',
						'hk'=>'Hong Kong',
						'hu'=>'Hungary',
						'in'=>'India',
						'id'=>'Indonesia',
						'ie'=>'Ireland',
						'il'=>'Israel',
						'it'=>'Italy',
						'jp'=>'Japan',
						'jo'=>'Jordan',
						'kz'=>'Kazakhstan',
						'ke'=>'Kenya',
						'kg'=>'Kyrgyzstan',
						'la'=>'Lao, People\'s Democratic Republic of',
						'lv'=>'Latvia',
						'lb'=>'Lebanon',
						'lt'=>'Lithuania',
						'lu'=>'Luxembourg',
						'mo'=>'Macau',
						'my'=>'Malaysia',
						'mt'=>'Malta',
						'mu'=>'Mauritius',
						'mx'=>'Mexico',
						'fm'=>'Micronesia, Federated States of',
						'md'=>'Moldova',
						'mn'=>'Mongolia',
						'mz'=>'Mozambique',
						'na'=>'Namibia',
						'np'=>'Nepal',
						'nl'=>'Netherlands',
						'nz'=>'New Zealand',
						'ni'=>'Nicaragua',
						'ne'=>'Niger',
						'ng'=>'Nigeria',
						'no'=>'Norway',
						'om'=>'Oman',
						'pa'=>'Panama',
						'pg'=>'Papua New Guinea',
						'py'=>'Paraguay',
						'pe'=>'Peru',
						'ph'=>'Philippines',
						'pl'=>'Poland',
						'pt'=>'Portugal',
						'qa'=>'Qatar',
						'ro'=>'Romania',
						'ru'=>'Russia',
						'sa'=>'Saudi Arabia',
						'sg'=>'Singapore',
						'sk'=>'Slovakia',
						'si'=>'Slovenia',
						'za'=>'South Africa',
						'es'=>'Spain',
						'lk'=>'Sri Lanka',
						'kn'=>'St. Kitts and Nevis',
						'sz'=>'Swaziland',
						'se'=>'Sweden',
						'ch'=>'Switzerland',
						'tw'=>'Taiwan',
						'tj'=>'Tajikistan',
						'th'=>'Thailand',
						'tt'=>'Trinidad and Tobago',
						'tr'=>'Turkey',
						'tm'=>'Turkmenistan',
						'ug'=>'Uganda',
						'ua'=>'Ukraine',
						'ae'=>'United Arab Emirates',
						'gb'=>'United Kingdom',
						'us'=>'United States',
						'uz'=>'Uzbekistan',
						've'=>'Venezuela',
						'vn'=>'Vietnam',
						'zw'=>'Zimbabwe',
						);
		return $countries;
	}
	
	public function get_country_codes(){
		foreach($this->itunes['countries'] as $key=>$value){ $countries[] = $key; }
		return $countries;
	}
	
	public function get_itunes_feed_types(){
		return array(
			'topaudiobooks'=>'Top Audiobooks',
			'topfreeapplications'=>'Top Free Apps',
				'toppaidapplications'=>'Top Paid Apps',
				'topgrossingapplications'=>'Top Grossing Apps',
				'topfreeipadapplications'=>'Top Free iPad Apps',
				'toppaidipadapplications'=>'Top Paid iPad Apps',
				'topgrossingipadapplications'=>'Top Grossing iPad Apps',
				'newapplications'=>'New Apps',
				'newfreeapplications'=>'New Free Apps',
				'newpaidapplications'=>'New Paid Apps',
			'topmovies'=>'Top Movies',
				'topvideorentals'=>'Top Video Rentals',
			'topsongs'=>'Top Songs',
				'topalbums'=>'Top Albums',
				'topimixes'=>'Top iMixes',
			'topmacapps'=>'Top Mac Apps',
				'topfreemacapps'=>'Top Free Mac Apps',
				'toppaidmacapps'=>'Top Paid Mac Apps',
				'topgrossingmacapps'=>'Top Grossing Mac Apps',
			'toppodcasts'=>'Top Podcasts',
			'topfreeebooks'=>'Top Free Books',
				'toppaidebooks'=>'Top Paid Books',
			'topitunesucollections'=>'Top iTunes U Collections',
				'topitunesucourses'=>'Top iTunes U Courses',
			'toptvepisodes'=>'Top TV Episodes',
				'toptvseasons'=>'Top TV Seasons',
			'topmusicvideos'=>'Top Music Videos',
			);
	}
	
	public function get_itunes_genres(){
		$genres['iosapps'] = array(
							''=>'All',
							'6018'=>'Books',
							'6000'=>'Business',
							'6022'=>'Catalogs',
							'6017'=>'Education',
							'6016'=>'Entertainment',
							'6015'=>'Finance',
							'6023'=>'Food &amp; Drink',
							'6014'=>'Games',
							'6013'=>'Health &amp; Fitness',
							'6012'=>'Lifestyle',
							'6020'=>'Medical',
							'6011'=>'Music',
							'6010'=>'Navigation',
							'6009'=>'News',
							'6021'=>'Newsstand',
							'6008'=>'Photo &amp; Video',
							'6007'=>'Productivity',
							'6006'=>'Reference',
							'6005'=>'Social Networking',
							'6004'=>'Sports',
							'6003'=>'Travel',
							'6002'=>'Utilities',
							'6001'=>'Weather',
							);
							
		$genres['movies'] = array(
							''=>'All',
							'4401'=>'Action &amp; Adventure',
							'4434'=>'African',
							'4402'=>'Anime',
							'4431'=>'Bollywood',
							'4403'=>'Classics',
							'4404'=>'Comedy',
							'4422'=>'Concert Films',
							'4405'=>'Documentary',
							'4406'=>'Drama',
							'4407'=>'Foreign',
							'4420'=>'Holiday',
							'4408'=>'Horror',
							'4409'=>'Independent',
							'4425'=>'Japanese Cinema',
							'4426'=>'Jidaigeki',
							'4410'=>'Kids &amp; Family',
							'4428'=>'Korean Cinema',
							'4421'=>'Made for TV',
							'4433'=>'Middle Eastern',
							'4423'=>'Music Documentaries',
							'4424'=>'Music Feature Films',
							'4411'=>'Musicals',
							'4432'=>'Regional Indian',
							'4412'=>'Romance',
							'4429'=>'Russian',
							'4413'=>'Sci-Fi &amp; Fantasy',
							'4414'=>'Short Films',
							'4415'=>'Special Interest',
							'4417'=>'Sports',
							'4416'=>'Thriller',
							'4427'=>'Tokusatsu',
							'4430'=>'Turkish',
							'4419'=>'Urban',
							'4418'=>'Western',
							);
		
		$genres['music'] = array(
							''=>'All',
							'20'=>'Alternative',
							'29'=>'Anime',
							'2'=>'Blues',
							'1122'=>'Brazilian',
							'4'=>'Children\'s Music',
							'1232'=>'Chinese',
							'22'=>'Christian &amp; Gospel',
							'5'=>'Classical',
							'3'=>'Comedy',
							'6'=>'Country',
							'17'=>'Dance',
							'50000063'=>'Disney',
							'25'=>'Easy Listening',
							'7'=>'Electronic',
							'28'=>'Enka',
							'50'=>'Fitness &amp; Workout',
							'50000064'=>'French Pop',
							'50000068'=>'German Folk',
							'50000066'=>'German Pop',
							'18'=>'Hip-Hop / Rap',
							'8'=>'Holiday',
							'1262'=>'Indian',
							'53'=>'Instrumental',
							'27'=>'J-Pop',
							'11'=>'Jazz',
							'51'=>'K-Pop',
							'52'=>'Karaoke',
							'30'=>'Kayokyoku',
							'1243'=>'Korean',
							'12'=>'Latino',
							'13'=>'New Age',
							'9'=>'Opera',
							'14'=>'Pop',
							'15'=>'R&amp;B / Soul',
							'24'=>'Reggae',
							'21'=>'Rock',
							'10'=>'Singer / Songwriter',
							'16'=>'Soundtrack',
							'50000061'=>'Spoken Word',
							'23'=>'Vocal',
							'19'=>'World',
							);
		
		$genres['macapps'] = $genres['iosapps'];
		
		// Add
		$genres['macapps']['12002'] = 'Developer Tools';
		$genres['macapps']['12022'] = 'Graphics &amp; Design';
		$genres['macapps']['12013'] = 'Photography';
		$genres['macapps']['12020'] = 'Video';
		asort($genres['macapps']);
		
		// Remove		
		unset($genres['macapps']['6018']);
		unset($genres['macapps']['6022']);
		unset($genres['macapps']['6023']);
		unset($genres['macapps']['6010']);
		unset($genres['macapps']['6021']);
		unset($genres['macapps']['6008']);
		
		$genres['podcasts'] = array(
							''=>'All',
							'1301'=>'Arts',
							'1321'=>'Business',
							'1303'=>'Comedy',
							'1304'=>'Education',
							'1323'=>'Games &amp; Hobbies',
							'1325'=>'Government &amp; Organizations',
							'1307'=>'Health',
							'1305'=>'Kids &amp; Family',
							'1310'=>'Music',
							'1311'=>'News &amp; Politics',
							'1314'=>'Religion &amp; Spirituality',
							'1315'=>'Science &amp; Medicine',
							'1324'=>'Society &amp; Culture',
							'1316'=>'Sports &amp; Recreation',
							'1309'=>'TV &amp; Film',
							'1318'=>'Technology',
							);
							
		$genres['books'] = array(
							''=>'All',
							'9007'=>'Arts &amp; Entertainment',
							'9008'=>'Biographies &amp; Memoirs',
							'9009'=>'Business &amp; Personal Finance',
							'9010'=>'Children &amp; Teens',
							'9026'=>'Comics &amp; Graphic Novels',
							'9027'=>'Computers &amp; Internet',
							'9028'=>'Cookbooks, Food &amp; Wine',
							'9031'=>'Fiction &amp; Literature',
							'9025'=>'Health, Mind &amp; Body',
							'9015'=>'History',
							'9012'=>'Humor',
							'9024'=>'Lifestyle &amp; Home',
							'9032'=>'Mysteries &amp; Thrillers',
							'9002'=>'Nonfiction',
							'9030'=>'Parenting',
							'9034'=>'Politics &amp; Current Events',
							'9029'=>'Professional &amp; Technical',
							'9033'=>'Reference',
							'9018'=>'Religion &amp; Spirituality',
							'9003'=>'Romance',
							'9020'=>'Sci-Fi &amp; Fantasy',
							'9019'=>'Science &amp; Nature',
							'9035'=>'Sports &amp; Outdoors',
							'9004'=>'Travel &amp; Adventure',
							);
							
		$genres['itunesu'] = array(
							''=>'All',
							'40000016'=>'Art &amp; Architecture',
							'40000001'=>'Business',
							'40000053'=>'Communications &amp; Media',
							'40000009'=>'Engineering',
							'40000026'=>'Health &amp; Medicine',
							'40000041'=>'History',
							'40000056'=>'Language',
							'40000140'=>'Law &amp; Politics',
							'40000070'=>'Literature',
							'40000077'=>'Mathematics',
							'40000054'=>'Philosophy',
							'40000094'=>'Psychology &amp; Social Science',
							'40000055'=>'Religion &amp; Spirituality',
							'40000084'=>'Science',
							'40000101'=>'Society',
							'40000109'=>'Teaching &amp; Learning',
							);
							
		$genres['tvshows'] = array(
							''=>'All',
							'4003'=>'Action &amp; Adventure',
							'4002'=>'Animation',
							'4004'=>'Classic',
							'4000'=>'Comedy',
							'4001'=>'Drama',
							'4005'=>'Kids',
							'4011'=>'Latino TV',
							'4006'=>'Nonfiction',
							'4007'=>'Reality TV',
							'4008'=>'Sci-Fi &amp; Fantasy',
							'4009'=>'Sports',
							'4010'=>'Teens',
							);
							
		$genres['musicvideos'] = array(
							''=>'All',
							'1620'=>'Alternative',
							'1629'=>'Anime',
							'1685'=>'Big Band',
							'1602'=>'Blues',
							'1671'=>'Brazilian',
							'1604'=>'Children\'s Music',
							'1637'=>'Chinese',
							'1622'=>'Christian &amp; Gospel',
							'1605'=>'Classical',
							'1603'=>'Comedy',
							'1606'=>'Country',
							'1617'=>'Dance',
							'1631'=>'Disney',
							'1625'=>'Easy Listening',
							'1607'=>'Electronic',
							'1628'=>'Enka',
							'1683'=>'Fitness &amp; Workout',
							'1632'=>'French Pop',
							'1634'=>'German Folk',
							'1633'=>'German Pop',
							'1618'=>'Hip-Hop / Rap',
							'1608'=>'Holiday',
							'1690'=>'Indian',
							'1684'=>'Instrumental',
							'1627'=>'J-Pop',
							'1611'=>'Jazz',
							'1686'=>'K-Pop',
							'1687'=>'Karaoke',
							'1630'=>'Kayokyoku',
							'1648'=>'Korean',
							'1612'=>'Latin',
							'1613'=>'New Age',
							'1609'=>'Opera',
							'1626'=>'Podcasts',
							'1614'=>'Pop',
							'1615'=>'R&amp;B / Soul',
							'1624'=>'Reggae',
							'1621'=>'Rock',
							'1610'=>'Singer / Songwriter',
							'1616'=>'Soundtrack',
							'1689'=>'Spoken Word',
							'1623'=>'Vocal',
							'1619'=>'World',
							);
						
		$array['topfreeapplications'] = $genres['iosapps'];
		$array['toppaidapplications'] = $genres['iosapps'];
		$array['topgrossingapplications'] = $genres['iosapps'];
		$array['topfreeipadapplications'] = $genres['iosapps'];
		$array['toppaidipadapplications'] = $genres['iosapps'];
		$array['topgrossingipadapplications'] = $genres['iosapps'];
		$array['newapplications'] = $genres['iosapps'];
		$array['newfreeapplications'] = $genres['iosapps'];
		$array['newpaidapplications'] = $genres['iosapps'];
		
		$array['topmovies'] = $array['topvideorentals'] = $genres['movies'];
		
		$array['topsongs'] = $array['topalbums'] = $array['topimixes'] = $genres['music'];
		
		$array['topmacapps'] = $genres['macapps'];
		$array['topfreemacapps'] = $genres['macapps'];
		$array['toppaidmacapps'] = $genres['macapps'];
		$array['topgrossingmacapps'] = $genres['macapps'];
		
		$array['toppodcasts'] = $genres['podcasts'];
		
		$array['topfreeebooks'] = $array['toppaidebooks'] = $genres['books'];
		
		$array['topitunesucollections'] = $array['topitunesucourses'] = $genres['itunesu'];
		
		$array['toptvepisodes'] = $array['toptvseasons'] = $genres['tvshows'];
		
		$array['topmusicvideos'] = $genres['musicvideos'];
		
		return $array;
	}
	
	public function get_url($country_code='gb', $feed_type='topsongs', $limit='10', $genre=''){
		if( isset($genre) && !empty($genre) ){ $genre = 'genre='.$genre.'/'; }
		$url = 'https://itunes.apple.com/'.$country_code.'/rss/'.$feed_type.'/limit='.$limit.'/'.$genre.'xml';
		return $url;
	}
	
	public function get_itunes_data($url){
		$data = file_get_contents($url);
		$data = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $data);
		if($data){
			return json_decode(json_encode((array) simplexml_load_string($data)), 1);
		}
	}
	
	public function cache_add($filename, $data){
		$filename = $filename.'.html';
		$f = fopen(plugin_dir_path(__FILE__).'cache/'.$filename, 'w');
		fwrite($f, $data);
		fclose($f);
	}
	
	public function cache_clear(){
		$files = glob(plugin_dir_path(__FILE__).'cache/*');
		if(!empty($files)){
			foreach($files as $file){
				if(is_file($file)){ unlink($file); }
			}
		}
	}
	
	public function admin_tabs($current = 'settings'){
		$tabs = array('settings'=>'Settings', 'affiliate-settings'=>'Affiliate Settings', 'cache'=>'Cache');
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo '<a class="nav-tab'.$class.'" href="?page='.$this->base_name.'&tab='.$tab.'">'.$name.'</a>';
		}
		echo '</h2>';
	}
	
	public function add_admin_menu(){
		add_menu_page('iTunes Content', 'iTunes Content', 'administrator', $this->base_name, array($this, 'display_admin_page'), plugin_dir_url(__FILE__).'/img/icons/plugin.png');
		add_submenu_page($this->base_name, 'Shortcode Generator', 'Shortcode Generator', 'administrator', 'shortcode_generator', array($this, 'display_shortcode_generator'));
	}
	
	public function display_admin_page(){
		require_once('admin/settings.php');
	}
	
	public function display_shortcode_generator(){
		require_once('admin/shortcode-generator.php');
	}
	
	public function itunes_shortcode($atts){
		extract(shortcode_atts(array(
				'id'=>'',
				'country'=>$this->opt['default_country'],
				'feed'=>$this->opt['default_feed_type'],
				'limit'=>5,
				'genre'=>'',
				), $atts));
		$id = esc_attr($id);
		$country = strtolower(esc_attr($country));
		$country = (in_array($country, $this->get_country_codes()) ? $country : $this->opt['default_country']);
		$feed = strtolower(esc_attr($feed));
		$limit = preg_replace('/[^0-9]/', '', esc_attr($limit));
		$genre = preg_replace('/[^0-9]/', '', esc_attr($genre));
		
		if(!empty($id)){
			$output = $this->format_lookup($this->do_lookup($id, $country));
		}else{
			$output = $this->get_data($this->get_url($country, $feed, $limit, $genre), $feed, $limit);
		}
		
		return $output;
	}
	
	public function do_lookup($id, $country=''){
		$url = 'https://itunes.apple.com/lookup?id='.$id.'&country='.$country;
		return $url;
	}
	
	public function get_itunes_data_from_lookup($url){
		$data = file_get_contents($url);
		if($data){
			return json_decode($data, 1);
		}
	}
	
	public function format_lookup($url){
		$filename = md5($url);
		$filepath = plugin_dir_path(__FILE__).'cache/'.$filename.'.html';
		
		$seconds = abs(strtotime($this->opt['cache']['amount'].' '.$this->opt['cache']['unit'])-time());
		
		$html = (isset($html) ? $html : NULL);
		
		if( file_exists($filepath) && time()-$seconds < filemtime($filepath) ){
			if( $f = fopen($filepath, 'r') ){
				return fread($f, filesize($filepath));
			}
		}else{
			$data = $this->get_itunes_data_from_lookup($url);
			#print_r($data);
			if( !empty($data) && $data['resultCount']>0 ){
				foreach($data['results'] as $media){
					
					if( isset($media['wrapperType']) && $media['wrapperType']=='collection' ){
						if( $media['collectionType']=='Album' ){
							$item['artist'] = $media['artistName'];
							$item['name'] = $media['collectionName'];
							$item['link'] = $media['collectionViewUrl'];
							if( isset($media['collectionPrice']) ){
								$item['price'] = $media['collectionPrice'];
							}
						}
					}
					elseif( isset($media['kind']) && $media['kind']=='software' ){
						$item['artist'] = $media['artistName'];
						$item['name'] = $media['trackName'];
						$item['link'] = $media['trackViewUrl'];
						$item['price'] = $media['formattedPrice'];
					}
					else{
						$item['artist'] = $media['artistName'];
						$item['name'] = $media['trackName'];
						$item['link'] = $media['trackViewUrl'];
						$item['price'] = $media['formattedPrice'];
					}
					
					if( isset($item['price']) && $item['price']=='-1' ){ $item['price'] = ''; }
					
					if( $this->opt['affiliate_active']=='1' && $this->opt['affiliate_network']=='linkshare' && !empty($this->opt['affiliate_id_linkshare']) && strpos($item['link'], 'itunes.apple.com')!==false ){
						$link = 'http://click.linksynergy.com/fs-bin/stat?id='.$this->opt['affiliate_id_linkshare'].'&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1='.$item['link'];
					}
					elseif( $this->opt['affiliate_active']=='1' && $this->opt['affiliate_network']=='tradedoubler' && !empty($this->opt['affiliate_id_tradedoubler']) && strpos($item['link'], 'itunes.apple.com')!==false ){
						$link = 'http://clkuk.tradedoubler.com/click?p=23708&a='.$this->opt['affiliate_id_tradedoubler'].'&url='.$item['link'];
					}
					else{
						$link = $item['link'];
					}
					
					if( isset($item['artist']) && isset($item['name']) ){
						$icons['video'] = $this->get_youtube_video($item['artist'].' - '.$item['name']);
					}
					
					if( isset($media['link'][1]['@attributes']['href']) ){
						$icons['song'] = $media['link'][1]['@attributes']['href'];
					}
					
					if( isset($media['artworkUrl512']) ){
						$image = $media['artworkUrl512'];
					}
					elseif( isset($media['artworkUrl350']) ){
						$image = $media['artworkUrl350'];
					}
					elseif( isset($media['artworkUrl340']) ){
						$image = $media['artworkUrl340'];
					}
					elseif( isset($media['artworkUrl256']) ){
						$image = $media['artworkUrl256'];
					}
					elseif( isset($media['artworkUrl100']) ){
						$image = $media['artworkUrl100'];
					}
					elseif( isset($media['artworkUrl60']) ){
						$image = $media['artworkUrl60'];
					}
					
					$html.= '<div class="iTunesContent">';
					
					$html.= '<div class="row">';
					$html.= '<div class="three columns">';
					$html.= '<div class="thumb"><a href="'.$link.'" title="'.$item['name'].'" target="_blank"><img src="'.$image.'" alt="'.$item['name'].'" /></a></div>';
					$html.= '</div>';
					$html.= '<div class="nine columns">';
					
					$html.= '<div class="row">';
					$html.= '<div class="twelve columns"><div class="title"><a href="'.$link.'" title="'.$item['name'].'" target="_blank">'.$item['name'].'</a></div></div>';
					$html.= '</div><!-- .row -->';
					
					$html.= '<div class="row">';
					$html.= '<div class="twelve columns"><div class="artist">'.$item['artist'].'</div></div>';
					$html.= '</div><!-- .row -->';
					
					if( isset($media['description']) && $this->opt['summary_show']=='1' ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns"><div class="summary">'.wp_trim_words(ucfirst(strtolower($media['description'])), $this->opt['summary_limit'], '&hellip;').'</div></div>';
						$html.= '</div><!-- .row -->';
					}
					
					if( isset($item['price']) || isset($media['imrentalPrice']) ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns">';
						if( isset($item['price']) ){
							$html.= '<div class="buy">Price: '.$item['price'].'</div>';
						}
						if( isset($media['imrentalPrice']) ){
							$html.= '<div class="rent">Rental Price: '.$media['imrentalPrice'].'</div>';
						}
						$html.= '</div>';
						$html.= '</div><!-- .row -->';
					}
					
					if( !empty($icons) ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns">';
						$html.= '<div class="icons">';
						if(!empty($icons['video'])){
							$html.= '<a href="http://www.youtube.com/embed/'.$icons['video'].'" class="itunes-lightbox" title="Watch '.$item['name'].' by '.$item['artist'].'"><img src="'.plugin_dir_url(__FILE__).'img/icons/video.png" /></a>';
						}
						if(!empty($icons['song'])){
							$html.= '<a href="'.$icons['song'].'" class="itunes-lightbox" title="Listen to '.$item['name'].' by '.$item['artist'].'"><img src="'.plugin_dir_url(__FILE__).'img/icons/song.png" /></a>';
						}
						$html.= '</div>';
						$html.= '</div>';
						$html.= '</div><!-- .row -->';
					}
					
					$html.= '</div>';
					$html.= '</div><!-- .row -->';
					
					$html.= '</div>';
					
				}
				$this->cache_add($filename, $html);
				return $html;
			}else{
				$html = 'No results found';
				return $html;
			}
		}
	}
	
	public function get_data($url, $feed_type, $limit){
		$filename = md5($url);
		$filepath = plugin_dir_path(__FILE__).'cache/'.$filename.'.html';
		
		$seconds = abs(strtotime($this->opt['cache']['amount'].' '.$this->opt['cache']['unit'])-time());
		
		$html = (isset($html) ? $html : NULL);
		
		if( file_exists($filepath) && time()-$seconds < filemtime($filepath) ){
			if( $f = fopen($filepath, 'r') ){
				return fread($f, filesize($filepath));
			}
		}else{
			$data = $this->get_itunes_data($url);
			#print_r($data);
			
			$new['entry'] = array();
			if($limit > 1){
				$new['entry'] = $data['entry'];
			}
			else{
				array_push($new['entry'], $data['entry']);
			}
			
			if( !empty($data) && isset($new['entry']) ){
				foreach($new['entry'] as $media){
					
					if( $this->opt['affiliate_active']=='1' && $this->opt['affiliate_network']=='linkshare' && !empty($this->opt['affiliate_id_linkshare']) && strpos($media['id'], 'itunes.apple.com')!==false ){
						$link = 'http://click.linksynergy.com/fs-bin/stat?id='.$this->opt['affiliate_id_linkshare'].'&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1='.$media['id'];
					}
					elseif( $this->opt['affiliate_active']=='1' && $this->opt['affiliate_network']=='tradedoubler' && !empty($this->opt['affiliate_id_tradedoubler']) && strpos($media['id'], 'itunes.apple.com')!==false ){
						$link = 'http://clkuk.tradedoubler.com/click?p=23708&a='.$this->opt['affiliate_id_tradedoubler'].'&url='.$media['id'];
					}
					else{
						$link = $media['id'];
					}
					
					if($feed_type=='topsongs' || $feed_type=='topmovies' || $feed_type=='topvideorentals'){
						if( $feed_type=='topmovies' || $feed_type=='topvideorentals' ){
							$icons['video'] = $this->get_youtube_video($media['imname'].' - official - movie - trailer');
						}else{
							$icons['video'] = $this->get_youtube_video($media['imartist'].' - '.$media['imname']);
						}
					}
					
					if($feed_type=='topsongs'){
						$icons['song'] = $media['link'][1]['@attributes']['href'];
					}
					
					if($feed_type=='toptvepisodes' || $feed_type=='toptvseasons'){
						$icons['preview'] = $media['link'][1]['@attributes']['href'];
					}
					
					$image = count($media['imimage'])-1;// Get largest image size
					
					$html.= '<div class="iTunesContent">';
					
					$html.= '<div class="row">';
					$html.= '<div class="three columns">';
					$html.= '<div class="thumb"><a href="'.$link.'" title="'.$media['title'].'" target="_blank"><img src="'.$media['imimage'][$image].'" alt="'.$media['title'].'" /></a></div>';
					$html.= '</div>';
					$html.= '<div class="nine columns">';
					
					$html.= '<div class="row">';
					$html.= '<div class="twelve columns"><div class="title"><a href="'.$link.'" title="'.$media['title'].'" target="_blank">'.$media['imname'].'</a></div></div>';
					$html.= '</div><!-- .row -->';
					
					$html.= '<div class="row">';
					$html.= '<div class="twelve columns"><div class="artist">'.$media['imartist'].'</div></div>';
					$html.= '</div><!-- .row -->';
					
					if( isset($media['summary']) && $this->opt['summary_show']=='1' ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns"><div class="summary">'.wp_trim_words(ucfirst(strtolower($media['summary'])), $this->opt['summary_limit'], '&hellip;').'</div></div>';
						$html.= '</div><!-- .row -->';
					}
					
					if( isset($media['imprice']) || isset($media['imrentalPrice']) ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns">';
						if( isset($media['imprice']) ){
							$html.= '<div class="buy">Price: '.$media['imprice'].'</div>';
						}
						if( isset($media['imrentalPrice']) ){
							$html.= '<div class="rent">Rental Price: '.$media['imrentalPrice'].'</div>';
						}
						$html.= '</div>';
						$html.= '</div><!-- .row -->';
					}
					
					if( !empty($icons) ){
						$html.= '<div class="row">';
						$html.= '<div class="twelve columns">';
						$html.= '<div class="icons">';
						if(!empty($icons['video'])){
							$html.= '<a href="http://www.youtube.com/embed/'.$icons['video'].'" class="itunes-lightbox" title="Watch '.$media['imname'].' by '.$media['imartist'].'"><img src="'.plugin_dir_url(__FILE__).'img/icons/video.png" /></a>';
						}
						if(!empty($icons['song'])){
							$html.= '<a href="'.$icons['song'].'" class="itunes-lightbox" title="Listen to '.$media['imname'].' by '.$media['imartist'].'"><img src="'.plugin_dir_url(__FILE__).'img/icons/song.png" /></a>';
						}
						if(!empty($icons['preview'])){
							$html.= '<a href="'.$icons['preview'].'" class="itunes-lightbox" title="Watch '.$media['imartist'].' - '.$media['imname'].'"><img src="'.plugin_dir_url(__FILE__).'img/icons/preview.png" /></a>';
						}
						$html.= '</div>';
						$html.= '</div>';
						$html.= '</div><!-- .row -->';
					}
					
					$html.= '</div>';
					$html.= '</div><!-- .row -->';
					
					$html.= '</div>';
				}
				$this->cache_add($filename, $html);
				return $html;
			}else{
				$html = 'No results found';
				return $html;
			}
		}
	}
	
	public function get_youtube_video($string){
		$url = 'http://gdata.youtube.com/feeds/api/videos?q='.urlencode($string).'&max-results=1';
		$c = curl_init($url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($c);
		if(curl_getinfo($c, CURLINFO_HTTP_CODE) != 400){
			$data = json_decode(json_encode((array) simplexml_load_file($url)), 1);
			if( !empty($data) && isset($data['entry']) ){
				parse_str(parse_url($data['entry']['link'][0]['@attributes']['href'], PHP_URL_QUERY), $video);
			}
		}
		curl_close($c);
		return isset($video['v']) ? $video['v'] : false;
	}
	
	public function get_widget($id='', $country_code='gb', $feed_type='topsongs', $limit='10', $genre=''){
		if(!empty($id)){
			return $this->format_lookup($this->do_lookup($id, $country_code));
		}else{
			if( isset($feed_type) && empty($this->itunes['genres'][$feed_type]) ){ $genre=''; }
			return $this->get_data($this->get_url($country_code, $feed_type, $limit, $genre), $feed_type, $limit);
		}
	}
	
	public function admin_enqueue_scripts(){
		$this->enqueue_scripts();
		wp_register_script('itunescontent-admin-js', plugins_url('/admin/js/itunescontent.js', __FILE__), array('jquery'));
		wp_enqueue_script('itunescontent-admin-js');
	}
	
	public function enqueue_scripts(){
		wp_register_script('divbox-js', plugins_url('/js/divbox.js', __FILE__), array('jquery'));
		wp_enqueue_script('divbox-js');
	}
		
	public function enqueue_styles(){
		wp_register_style('itunescontent-style', plugins_url('/css/itunescontent.css', __FILE__), array(), $this->version, 'all');
		wp_enqueue_style('itunescontent-style');
		wp_register_style('divbox-style', plugins_url('/css/divbox.css', __FILE__), array(), $this->version, 'all');
		wp_enqueue_style('divbox-style');
	}

}
}
if (class_exists("iTunesContent")) {
	$itunes_content = new iTunesContent();
}
?>
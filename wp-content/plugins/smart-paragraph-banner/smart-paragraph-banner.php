<?php
/*
 * Plugin Name: Smart Paragraph Banner
 * Plugin URI: http://www.tonjoo.com/smart-paragraph-banner/
 * Description: Automatically put a banner on the middle of the paragraph / post.
 * Version: 1
 * Author: Todi
 * Author URI: http://todiadiyatmo.com/
 * License: GPLv2
 * 
 */

define("SPB_VERSION", '1.0.0');
define('SMART_PARA_BANNER_DIR',plugin_dir_path( __FILE__ ) );

include SMART_PARA_BANNER_DIR.'/theme-options.php';
include SMART_PARA_BANNER_DIR.'/post-meta.php';

/**
 * Do Filter after this 
 * add_filter('the_content', 'do_shortcode', 11); // AFTER wpautop()
 * So we can preserve shortcode
 */
add_filter('the_content', 'spb_the_content', 10);

function spb_the_content($content) {

	if(!$content||$content=='')
		return $content;
	


	$banner = get_option('tonjoo_uncache_script_shortcode');

	$spb_active = get_post_meta( get_the_ID(),'spb_active',true );

    // If shortcode banner found, skip
	if (strpos($content,$banner) !== false) {
	    return $content;
	}

	// Other exception
    if(!is_single()||get_post_type()!='post'||$spb_active==='yes')
    	return $content;

    $docDOM = new DOMDocument();

    $content = mb_convert_encoding($content, 'html-entities', 'utf-8'); 
 	
 	$docDOM->loadHTML($content);

 	$items = $docDOM->documentElement;


 	// no child, do banner after content
 	if (!$items->hasChildNodes()) {
 		return $content.$banner;
 	}

 	$item = $items->childNodes->item(0);

	if (!$item->hasChildNodes()) {
		return $content.$banner;
	}

	$childs = $item->childNodes;
	
	// no p found, go put banner on the bottom of content;
	if($childs->length==0||$childs->length==1) {
		return $content.$banner;
	}



	$finalChildsDOM = array();

	foreach ($childs as $childsDOM) {
		if(is_a($childsDOM,'DOMElement'))
			array_push($finalChildsDOM, $childsDOM);
	}

	// to small to put banner in the middle
	if(sizeof($finalChildsDOM)<=3) {
		return $content.$banner;
	}


	// Get the middle of paragraph
	$middle = floor((sizeof($finalChildsDOM))/2)-1;

	return spb_add_banner($docDOM,$middle,$content,$finalChildsDOM,$banner,$item,$items);
	

}

function spb_add_banner($docDOM,$middle,$content,$finalChildsDOM,$banner,$item,$items) {

	$forbiddenTagName = array('h1','h2','h3','h4','h5','h6','hr','br','strong','b');

	$domToAdd = $finalChildsDOM[$middle];

	if(WP_DEBUG&&isset($_GET['spb_debug']))
	{	
		echo "<pre>";
		foreach ($finalChildsDOM as $domAnak) {
			echo $domAnak->tagName;
			echo "<br>";
			
		}
		echo "Current Tag Name : ".$domToAdd->tagName;
		echo "</pre>";

	}


	// The middle of the post is safe
	if(!in_array($domToAdd->tagName,$forbiddenTagName)) {
		

		$banner = $docDOM->createElement('p', $banner);

		$items->removeChild($item);

		array_splice($finalChildsDOM, $middle+1, 0, array($banner));

		foreach ($finalChildsDOM as $newChild) {
			$items->appendChild($newChild);
		}

		return spb_save($docDOM);

	}

	// rule 6 line ,1 move
	if(sizeof($finalChildsDOM)>=14) {
 		$move = 3;
	}
	elseif(sizeof($finalChildsDOM)>=8) {
		$move = 2;
	}
	else
	{
		$move = 1;
	}

	$middleUpCounter = $middle;

	$middleDownCounter = $middle;

	// Mark the banner final position;
	$finalPos = false;

	// mode down
	for($i=1;$i<=$move;$i++) {

		// move to one node to the down
		$middleDownCounter = $middleDownCounter+1;

		if($middleDownCounter>=sizeof($finalChildsDOM)-2)
			break;


		if(!in_array($finalChildsDOM[$middleDownCounter]->tagName,$forbiddenTagName)) {


			$finalPos = $middleDownCounter;
			
			break;

		}

	}

	

	// only look down if look up is not found
	if($finalPos===false) {
		//move up
		for($i=1;$i<=$move;$i++) {

			// move to one node to the up
			$middleUpCounter = $middleUpCounter-1;

			if($middleUpCounter>=2)
				break;

			
			if(!in_array($finalChildsDOM[$middleUpCounter]->tagName,$forbiddenTagName)) {

				$finalPos = $middleUpCounter;
				
				break;

			}

		}
	}

	if($finalPos===false)
		return $content.$banner;

	// Rebuild child with new element

	$banner = $docDOM->createElement('p', $banner);

	$items->removeChild($item);

	array_splice($finalChildsDOM, $finalPos+1, 0, array($banner));

	foreach ($finalChildsDOM as $newChild) {
		$items->appendChild($newChild);
	}

    return spb_save($docDOM);

}

function spb_save($docDOM) {
	return preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $docDOM->saveHTML()));
}
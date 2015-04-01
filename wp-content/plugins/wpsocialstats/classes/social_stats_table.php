<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Social_Stats_Table extends WP_List_Table {
    
    private $options;

    function __construct(){
        global $status, $page;

        //Set parent defaults
	/* added by GenLEE begin */
	if (is_admin())
	/* added by GenLEE End */
        parent::__construct( array(
            'singular'  => 'entry',     
            'plural'    => 'entries',    
            'ajax'      => false       
        ) );
    }

    function get_options(){

        return $this->options;
    }
    
    
    function column_default($item, $column_name){

        return $item[$column_name];
    }
    
    function column_title($item){
    
        //Return the title contents
        return "<a href='".esc_attr($item["permalink"])."' target='_blank'>".$item['title']."</a>";
    }
    
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    
    
    function get_columns(){
        $columns = array(
            /*'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text */
            'title'     => 'Title',
            'count_twitter'    => 'Twitter',
            'count_facebook'  => 'Facebook',
            'count_google'  => 'Google&nbsp;+',
            'count_stumbleupon'  => 'StumbleUpon',
            'count_linkedin'  => 'LinkedIn',
            'count_pinterest'  => 'Pinterest',
            'total'  => 'Total'
        );
        return $columns;
    }
    
    function get_sortable_columns( $is_sortable ) {

        if( $is_sortable ){

            $sortable_columns = array(
                'title'     => array('title',false),
                'count_twitter'     => array('twitter',false), 
                'count_facebook'     => array('facebook',false), 
                'count_google'     => array('google',false), 
                'count_stumbleupon'     => array('stumbleupon',false), 
                'count_linkedin'     => array('linkedin',false), 
                'count_pinterest'     => array('pinterest',false), 
                'total'     => array('total',false)
            );

        }
        else {

            $sortable_columns = array(
                'title'     => array('title',false)
            );
        }

        return $sortable_columns;
    }
    
    function get_bulk_actions() {
        $actions = array();
        return $actions;
    }

    // added by GenLEE Begin

    function phy_all_nums($datas) {
        $mall_nums = array();

	foreach ($datas as $data) {
		$mall_nums[] = $this->phy_translate_num($data['count_twitter']);
		$mall_nums[] = $this->phy_translate_num($data['count_google']);
		$mall_nums[] = $this->phy_translate_num($data['count_facebook']);
		$mall_nums[] = $this->phy_translate_num($data['count_linkedin']);
		$mall_nums[] = $this->phy_translate_num($data['count_stumbleupon']);
		$mall_nums[] = $this->phy_translate_num($data['count_pinterest']);
	}

	$mall_nums = array_unique($mall_nums);
	sort($mall_nums);
	return $mall_nums;
    }

    function phy_paint_color($datas) {
	    $max_e = $min_e = 0;
	    // $max_tc = $min_tc = 0;
	    // $max_tr = $min_tr = 0;

	    foreach ($datas as $data) {
		    if ($data['permalink'] != '#') {
			    if ($max_e < $this->phy_translate_num($data['count_twitter']))
				    $max_e = $this->phy_translate_num($data['count_twitter']);
			    if ($min_e > $this->phy_translate_num($data['count_twitter']))
				    $min_e = $this->phy_translate_num($data['count_twitter']);

			    if ($max_e < $this->phy_translate_num($data['count_google']))
				    $max_e = $this->phy_translate_num($data['count_google']);
			    if ($min_e > $this->phy_translate_num($data['count_google']))
				    $min_e = $this->phy_translate_num($data['count_google']);

			    if ($max_e < $this->phy_translate_num($data['count_facebook']))
				    $max_e = $this->phy_translate_num($data['count_facebook']);
			    if ($min_e > $this->phy_translate_num($data['count_facebook']))
				    $min_e = $this->phy_translate_num($data['count_facebook']);

			    if ($max_e < $this->phy_translate_num($data['count_linkedin']))
				    $max_e = $this->phy_translate_num($data['count_linkedin']);
			    if ($min_e > $this->phy_translate_num($data['count_linkedin']))
				    $min_e = $this->phy_translate_num($data['count_linkedin']);			    

			    if ($max_e < $this->phy_translate_num($data['count_stumbleupon']))
				    $max_e = $this->phy_translate_num($data['count_stumbleupon']);
			    if ($min_e > $this->phy_translate_num($data['count_stumbleupon']))
				    $min_e = $this->phy_translate_num($data['count_stumbleupon']);

			    if ($max_e < $this->phy_translate_num($data['count_pinterest']))
				    $max_e = $this->phy_translate_num($data['count_pinterest']);
			    if ($min_e > $this->phy_translate_num($data['count_pinterest']))
				    $min_e = $this->phy_translate_num($data['count_pinterest']);
		    }
	    }

	    $result = array();

	    $mall_nums = $this->phy_all_nums($datas);	    

	    /*foreach ($datas as $data) {
		    if ($data['permalink'] != '#') {
			    $data['count_twitter'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_twitter']);
			    $data['count_google'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_google']);
			    $data['count_facebook'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_facebook']);
			    $data['count_linkedin'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_linkedin']);
			    $data['count_stumbleupon'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_stumbleupon']);
			    $data['count_pinterest'] = $this->phy_get_pcolor($max_e, $min_e, $data['count_pinterest']);
			    $data['total'] = '<div '.'style="color:black;font-weight:bold;">'.$data['total'].'</div>';
		    }
		    $result[] = $data;
	    }*/

	   foreach ($datas as $data) {
		    if ($data['permalink'] != '#') {
			    $data['count_twitter'] = $this->phy_get_pcolor2($mall_nums, $data['count_twitter']);
			    $data['count_google'] = $this->phy_get_pcolor2($mall_nums, $data['count_google']);
			    $data['count_facebook'] = $this->phy_get_pcolor2($mall_nums, $data['count_facebook']);
			    $data['count_linkedin'] = $this->phy_get_pcolor2($mall_nums, $data['count_linkedin']);
			    $data['count_stumbleupon'] = $this->phy_get_pcolor2($mall_nums, $data['count_stumbleupon']);
			    $data['count_pinterest'] = $this->phy_get_pcolor2($mall_nums, $data['count_pinterest']);
			    $data['total'] = '<div '.'style="color:black;font-weight:bold;">'.$data['total'].'</div>';
		    }
		    $result[] = $data;
	    }

	    return $result;
    }

    function phy_get_pcolor2($datas, $val){
	    $val = $this->phy_translate_num($val);
	    foreach ($datas as $index => $data) {
		if ($data == $val)
                    $myval = ($index + 1.0)/count($datas);
	    }

	    $myval = (1 - $myval) * 120;
	    $myval = (int)$myval + 1;

	    $color = $this->phy_getRGB($myval, 100, 90);

	    $mycolor = explode(',', $color);
	    $rcolor = array();
	    foreach ($mycolor as $comp) {
		    $rcolor[] = 255 - $comp;
	    }
	    $rcolor = implode(',', $rcolor);
	    // return '<div class="phy-item" style="color:rgb('.$rcolor.');" phy-data="rgb('.$color.')">'.$this->phy_translate_num_r($val).'</div>';
	    return '<div class="phy-item" style="color:black;font-weight:bold;" phy-data="rgb('.$color.')">'.$this->phy_translate_num_r($val).'</div>';
    }

    function phy_get_pcolor($max, $min, $val){
	    if ($max == $min)
		    $max = $min + 1;
	    $val = $this->phy_translate_num($val);

	    $myval = ($val - $min)/($max - $min);
	    $myval = (1 - $myval) * 80;
	    $myval = (int)$myval + 20;

	    $color = $this->phy_getRGB($myval, 100, 90);

	    $mycolor = explode(',', $color);
	    $rcolor = array();
	    foreach ($mycolor as $comp) {
		    $rcolor[] = 255 - $comp;
	    }
	    $rcolor = implode(',', $rcolor);
	    // return '<div class="phy-item" style="color:rgb('.$rcolor.');" phy-data="rgb('.$color.')">'.$this->phy_translate_num_r($val).'</div>';
	    return '<div class="phy-item" style="color:black;font-weight:bold;" phy-data="rgb('.$color.')">'.$this->phy_translate_num_r($val).'</div>';
    }
    
    function phy_getRGB($iH, $iS, $iV) {

	    if($iH < 0)   $iH = 0;   // Hue:
	    if($iH > 360) $iH = 360; //   0-360
	    if($iS < 0)   $iS = 0;   // Saturation:
	    if($iS > 100) $iS = 100; //   0-100
	    if($iV < 0)   $iV = 0;   // Lightness:
	    if($iV > 100) $iV = 100; //   0-100

	    $dS = $iS/100.0; // Saturation: 0.0-1.0
	    $dV = $iV/100.0; // Lightness:  0.0-1.0
	    $dC = $dV*$dS;   // Chroma:     0.0-1.0
	    $dH = $iH/60.0;  // H-Prime:    0.0-6.0
	    $dT = $dH;       // Temp variable

	    while($dT >= 2.0) $dT -= 2.0; // php modulus does not work with float
	    $dX = $dC*(1-abs($dT-1));     // as used in the Wikipedia link

	    switch($dH) {
            case($dH >= 0.0 && $dH < 1.0):
		    $dR = $dC; $dG = $dX; $dB = 0.0; break;
            case($dH >= 1.0 && $dH < 2.0):
		    $dR = $dX; $dG = $dC; $dB = 0.0; break;
            case($dH >= 2.0 && $dH < 3.0):
		    $dR = 0.0; $dG = $dC; $dB = $dX; break;
            case($dH >= 3.0 && $dH < 4.0):
		    $dR = 0.0; $dG = $dX; $dB = $dC; break;
            case($dH >= 4.0 && $dH < 5.0):
		    $dR = $dX; $dG = 0.0; $dB = $dC; break;
            case($dH >= 5.0 && $dH < 6.0):
		    $dR = $dC; $dG = 0.0; $dB = $dX; break;
            default:
		    $dR = 0.0; $dG = 0.0; $dB = 0.0; break;
	    }

	    $dM  = $dV - $dC;
	    $dR += $dM; $dG += $dM; $dB += $dM;
	    $dR *= 255; $dG *= 255; $dB *= 255;

	    return round($dR).",".round($dG).",".round($dB);
    }


    function phy_translate_num($count) {
	    if ($count == 'n/a')
		    return 0;
	    return $count;
    }

    function phy_translate_num_r($count) {
	    if ($count == '0')
		    return "n/a";
	    return $count;
    }

    function prepare_total_info($all_posts, $category){
	    $recentPosts = $all_posts;

	    if ($category != -1) {
		    $cat = get_cat_name($category);
	    } else
		    $cat = "All Categories";
			    
	    $title = '<strong>Total Shares For ' . '<em>' . $cat . '</em></strong>';

	    $google_count = $stumbleupon_count = $twitter_count = $facebook_count 
		    = $linkedin_count = $pinterest_count = $total = 0;

	    while ( $recentPosts->have_posts() ) { 

		    $recentPosts->the_post();
		    $elem_id = get_the_ID();

		    $count_data = unserialize( get_post_meta( $elem_id, "WSS_DATA", true) );
			
			// print_r( get_post_meta( $elem_id, "WSS_DATA", true) );
			
			/*
			foreach( $count_data as $k=>$v ){
				
				if( $k == 'pinterest' ){
					
					print_r( $v );
					echo '<br/><Br/>';
				}
			}
			*/
			
		    if(  $count_data !== FALSE ) {
			    $google_count += $this->phy_translate_num($count_data["google"]);
			    $stumbleupon_count += $this->phy_translate_num($count_data["stumbleupon"]);
			    $twitter_count += $this->phy_translate_num($count_data["twitter"]);
			    $facebook_count += $this->phy_translate_num($count_data["facebook"]);
			    $linkedin_count += $this->phy_translate_num($count_data["linkedin"]);
			    $pinterest_count += $this->phy_translate_num($count_data["pinterest"]);
			    $total += $this->phy_translate_num($count_data["total"]);
		    }

	    }

	    return array( "ID" => "",
			  "permalink" => "#",
			  "title" => $title,
			  "count_twitter" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($twitter_count).'</strong>',
			  "count_google" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($google_count).'</strong>',
			  "count_facebook" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($facebook_count).'</strong>',
			  "count_linkedin" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($linkedin_count).'</strong>',
			  "count_stumbleupon" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($stumbleupon_count).'</strong>',
			  "count_pinterest" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($pinterest_count).'</strong>',
			  "total" => '<strong "style="color:black;font-weight:bold;">'.$this->phy_translate_num_r($total).'</strong>' );
	    
    }
    // added by GenLEE End
    
    function prepare_items() {

        $post_type = isset( $_GET['post_type'] ) ? (string)$_GET['post_type'] : "post";
        $per_page = isset( $_GET['per_page'] ) ? (int)$_GET['per_page'] : 10;
        $cat_perm = isset( $_GET['cat'] ) ? $_GET['cat'] : "-1";
        $show_date = isset( $_GET['date'] ) ? (int)$_GET['date'] : 0;
        $page = isset($_GET['paged'])?$_GET['paged']:1;
        $orderby = isset($_GET['orderby'])?$_GET['orderby']:"date";
        $order = isset($_GET['order'])?$_GET['order']:"asc";

        $date = $show_date;

        if( strlen($date) == 6 ){
            $month = substr($date,4,6);
            $year = substr($date,0,4);
        }
        else {
            $year = "";
            $month = "";
        }

        if( -1 != $cat_perm ){

            $category = $cat_perm;

        }else{

            $category = '';
        } 


        $recentPosts = new WP_Query();

        $allPosts = new WP_Query();

        if( 'page' == $post_type ){
            $allPosts->query(  'post_status=publish&showposts=-1&posts_per_page=-1&year='.$year.'&monthnum='.$month.'&post_type=page&cat='.$category );
        }
        else{
            $allPosts->query(  'post_status=publish&showposts=-1&posts_per_page=-1&year='.$year.'&monthnum='.$month.'&cat='.$category );
        }

        $old_wss_data = array();

        $all_wss_data = array();

        $start =true;

        while ( $allPosts->have_posts() ) : 

            $allPosts->the_post();

            $all_wss_data[] = get_the_ID();

            //update_post_meta( get_the_ID(), "WSS_DATA", null); 
            //update_post_meta( get_the_ID(), "WSS_UPDATED", null);

            $count_data = unserialize( get_post_meta( get_the_ID(), "WSS_DATA", true) );

            $start = false;

            if( $count_data === FALSE ){
                $old_wss_data[] =  get_the_ID();
            }

        endwhile;

        $is_sortable = count( $old_wss_data ) === 0;

        $sortable_query = "";

        if( $is_sortable || $orderby == "title" ){


            switch( $orderby ){

                case "facebook" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_FACEBOOK";

                break;

                case "google" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_GOOGLE";
                    
                break;

                case "pinterest" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_PINTEREST";
                    
                break;

                case "twitter" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_TWITTER";
                    
                break;

                case "linkedin" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_LINKEDIN";
                    
                break;

                case "stumbleupon" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_STUMBLEUPON";
                    
                break;

                case "total" :

                    $sortable_query .= "&orderby=meta_value_num&order=".$order."&meta_key=";

                    $sortable_query .= "WSS_DATA_TOTAL";
                    
                break;

                case "title" :

                    $sortable_query .= "&orderby=title&order=".$order;

                break;

                case "date" :

                    $sortable_query .= "&orderby=post_date&order=desc";

                break;

                default : 

                    $sortable_query = "";

                break;

            }

        }
        else {

             $sortable_query .= "&orderby=post_date&order=desc";
        }

        if( 'post' == $post_type ){
            $recentPosts->query( 'post_status=publish&showposts='.$per_page.'&posts_per_page='.$per_page.'&year='.$year.'&monthnum='.$month.'&cat='.$category.'&paged='.$page. $sortable_query );
        }
        if( 'page' == $post_type){
            $recentPosts->query( 'post_status=publish&showposts='.$per_page.'&posts_per_page='.$per_page.'&year='.$year.'&monthnum='.$month.'&post_type='.$post_type.'&paged='.$page. $sortable_query );
        }

        $number_pages = $recentPosts->max_num_pages;

        $data = array();
	// added by GenLEE Begin
	if ($post_type == 'post')
		$data[] = $this->prepare_total_info($allPosts, $cat_perm);
	// added by GenLEE End

        while ( $recentPosts->have_posts() ) : 

            $recentPosts->the_post();

            $elem_id = get_the_ID();

            $permalink = get_permalink();

            $count_data = unserialize( get_post_meta( $elem_id, "WSS_DATA", true) );

            if(  $count_data === FALSE ){

                $google_count = $stumbleupon_count = $twitter_count = $facebook_count = $linkedin_count = $pinterest_count = $total = "n/a";
            }
            else {

                $google_count = $count_data["google"];

                $stumbleupon_count = $count_data["stumbleupon"];

                $twitter_count = $count_data["twitter"];

                $facebook_count = $count_data["facebook"];

                $linkedin_count = $count_data["linkedin"];

                $pinterest_count =$count_data["pinterest"];

                $total = $count_data["total"] ;

            }

            $data[] = array(
                "ID" => $elem_id,
                "permalink" => $permalink,
                "title" => get_the_title(),
                "count_twitter" => $twitter_count,
                "count_google" => $google_count,
                "count_facebook" => $facebook_count,
                "count_linkedin" => $linkedin_count,
                "count_stumbleupon" => $stumbleupon_count,
                "count_pinterest" => $pinterest_count,
                "total" => $total

            );

        endwhile;

	$data = $this->phy_paint_color($data);

        $columns = $this->get_columns();

        $hidden = array();

        $sortable = $this->get_sortable_columns( $is_sortable );
        
        $this->_column_headers = array($columns, $hidden, $sortable);
    
        $current_page = $paged;
        
        $total_items = count($all_wss_data);
        
        $this->items = $data;
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,            
            'per_page'    => $per_page,                 
            'total_pages' => ceil($total_items/$per_page)
        ) );

        $this->options = array(
            "post_type" =>$post_type,
            "per_page" => $per_page,
            "cat_perm" => $cat_perm,
            "category" => $category,
            "show_date" => $show_date,
            "page" => $page,
            "orderby" => $orderby,
            "order" => $order,
            "sortable" => $is_sortable,
            "all_data" => $all_wss_data,
            "old_data" => $old_wss_data
        );
    }
    
}
?>
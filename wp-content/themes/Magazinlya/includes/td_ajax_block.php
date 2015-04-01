<?php



function td_head_ajax_block() {
    echo '<script>';
    echo 'var td_ajax_url="' . admin_url('admin-ajax.php') . '";';
    echo '</script>';
}

add_action('wp_head', 'td_head_ajax_block');



function td_ajax_block(){
    global $post;
    //get the data from ajax() call


    if (!empty($_POST['td_atts'])) {
        $td_atts = json_decode(stripslashes($_POST['td_atts']), true); //current block args
    } else {
        $td_atts = ''; //not ok
    }

    if (!empty($_POST['td_cur_cat'])) {
        $td_cur_cat = $_POST['td_cur_cat']; //the new id filter
    } else {
        $td_cur_cat = '';
    }

    if (!empty($_POST['td_column_number'])) {
        $td_column_number =  $_POST['td_column_number']; //the block is on x columns
    } else {
        $td_column_number = 0; //not ok
    }


    if (!empty($_POST['td_current_page'])) {
        $td_current_page = $_POST['td_current_page'];
    } else {
        $td_current_page = 1;
    }

    if (!empty($td_cur_cat)) {
        $td_atts['category_ids'] = $td_cur_cat;
        unset($td_atts['category_id']);
    }

    if (!empty($_POST['td_block_id'])) {
        $td_block_id = $_POST['td_block_id'];
    } else {
        $td_block_id = ''; //not ok
    }

    if (!empty($_POST['block_type'])) {
        $block_type = $_POST['block_type'];
    } else {
        $block_type = '';
    }

    $td_data_source = new td_data_source(); //new data source
    $td_query = &$td_data_source->get_wp_query($td_atts, $td_current_page); //by ref  do the query


    $buffy ='';

    switch ($block_type) {
        case '1':
            $buffy .= td_block1_inner($td_query, $td_column_number);
            break;
        case '2':
            $buffy .= td_block2_inner($td_query, $td_column_number);
            break;
        case '3':
            $buffy .= td_block3_inner($td_query, $td_column_number);
            break;
        case '4':
            $buffy .= td_block4_inner($td_query, $td_column_number);
            break;
        case '5':
            $buffy .= td_block5_inner($td_query, $td_column_number);
            break;
        case 'slide':
            $buffy .= td_slide_inner($td_query, $td_column_number);
            break;

        case 'gallery':
            $buffy .= td_gallery_inner($td_query, $td_column_number);
            break;

    }




    /*
    $myFile = "D:/xxxxxx.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    $stringData = print_r($_POST, true) . "\n";
    fwrite($fh, $stringData);
    fclose($fh);
    */

    //pagination
    $td_hide_prev = false;
    $td_hide_next = false;
    if ($td_current_page == 1) {
        $td_hide_prev = true; //hide link on page 1
    }

    if ($td_current_page >= $td_query->max_num_pages ) {
        $td_hide_next = true; //hide link on last page
    }


    $buffyArray = array(
        'td_data' => $buffy,
        'td_block_id' => $td_block_id,
        'td_cur_cat' => $td_cur_cat,
        'td_hide_prev' => $td_hide_prev,
        'td_hide_next' => $td_hide_next
    );

    // Return the String
    die(json_encode($buffyArray));
}

// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_td_ajax_block', 'td_ajax_block' );
add_action( 'wp_ajax_td_ajax_block', 'td_ajax_block' );
?>
<?php
function td_ad_box( $atts ) {
    //print_r($atts);
    //die;
    extract(shortcode_atts(
        array(
            'spot_name' => '',
            'align_left' => '' //align left in inline contentn
        ), $atts));


    if (empty($spot_name)) {
        return;
    }



    $spot_name = str_replace('_', ' ',$spot_name);
    $spot_name_parts = explode(' -- ', $spot_name);



    //print_r($spot_name_parts);
    if (empty($spot_name_parts[0]) or empty($spot_name_parts[1])) {
        return;
    }

    //echo $spot_name_parts[0] . '<br>';

    $spot_name = $spot_name_parts[1];
    $spot_type =  strtolower($spot_name_parts[0]);


    if (!empty($align_left)) {
        $align_left_class = 'td_rec_left';
    } else {
        $align_left_class = '';
    }


    $buffy = '';
    $buffy .= '<div class="td_block_wrap td_rec ' . $align_left_class . '">';
        $buffy .= '<div class="td_mod_wrap">';

        if ($spot_type == 'ad spot') {

            //read the adspots
            $td_ad_spots = td_get_option('td_ad_spots');
            $buffy .= '<div class="td-rec-phone td-rec-spot">';
                if (!empty($td_ad_spots[$spot_name]['p'])) {
                    $buffy .= stripslashes($td_ad_spots[$spot_name]['p']);
                }
            $buffy .= '</div>';


            $buffy .= '<div class="td-rec-tablet-p td-rec-spot">';
            if (!empty($td_ad_spots[$spot_name]['tp'])) {
                $buffy .= stripslashes($td_ad_spots[$spot_name]['tp']);
            }
            $buffy .= '</div>';


            $buffy .= '<div class="td-rec-tablet-l td-rec-spot">';
            if (!empty($td_ad_spots[$spot_name]['tl'])) {
                $buffy .= stripslashes($td_ad_spots[$spot_name]['tl']);
            }
            $buffy .= '</div>';

            $buffy .= '<div class="td-rec-monitor td-rec-spot">';
            if (!empty($td_ad_spots[$spot_name]['m'])) {
                $buffy .= stripslashes($td_ad_spots[$spot_name]['m']);
            }
            $buffy .= '</div>';
        } elseif ($spot_type == 'adsense spot') {

            $td_adsense_spots = td_get_option('td_adsense_spots');
            //print_r($td_adsense_spots[$spot_name]);
            $buffy .= '
            <div class="td-g-rec">
             <script type="text/javascript">
                /* Replace this with your AdSense Publisher ID */
                google_ad_client = "' . $td_adsense_spots[$spot_name]['pub_id'] . '";
                var td_screenwidth = jQuery(document).width();
                ';

            if (!empty($td_adsense_spots[$spot_name]['p']) and !empty($td_adsense_spots[$spot_name]['p_w']) and !empty($td_adsense_spots[$spot_name]['p_h'])) {
                $buffy .= '
                    if ( td_screenwidth < 768 ) {
                        /* Phones */
                        google_ad_slot	= "' . $td_adsense_spots[$spot_name]['p'] . '";
                        google_ad_width	= ' . $td_adsense_spots[$spot_name]['p_w'] . ';
                        google_ad_height 	= ' . $td_adsense_spots[$spot_name]['p_h'] . ';
                    };
                    ';
            }

            if (!empty($td_adsense_spots[$spot_name]['tp']) and !empty($td_adsense_spots[$spot_name]['tp_w']) and !empty($td_adsense_spots[$spot_name]['tp_h'])) {
                $buffy .= '
                    if (td_screenwidth >= 768  && td_screenwidth < 1019 ) {
                        /* portrait tablets */
                        google_ad_slot	= "' . $td_adsense_spots[$spot_name]['tp'] . '";
                        google_ad_width 	= ' . $td_adsense_spots[$spot_name]['tp_w'] . ';
                        google_ad_height 	= ' . $td_adsense_spots[$spot_name]['tp_h'] . ';
                    };
                    ';
            }
            if (!empty($td_adsense_spots[$spot_name]['tl']) and !empty($td_adsense_spots[$spot_name]['tl_w']) and !empty($td_adsense_spots[$spot_name]['tl_h'])) {
                $buffy .= '
                    if (td_screenwidth >= 1019  && td_screenwidth < 1200 ) {
                        /* landscape tablets */
                        google_ad_slot 	= "' . $td_adsense_spots[$spot_name]['tl'] . '";
                        google_ad_width 	= ' . $td_adsense_spots[$spot_name]['tl_w'] . ';
                        google_ad_height 	= ' . $td_adsense_spots[$spot_name]['tl_h'] . ';
                    };
                    ';
            }
            if (!empty($td_adsense_spots[$spot_name]['m']) and !empty($td_adsense_spots[$spot_name]['m_w']) and !empty($td_adsense_spots[$spot_name]['m_h'])) {
                $buffy .= '
                    if ( td_screenwidth >= 1200 ){
                        /* large monitors */
                        google_ad_slot 	= "' . $td_adsense_spots[$spot_name]['m'] . '";
                        google_ad_width 	= ' . $td_adsense_spots[$spot_name]['m_w'] . ';
                        google_ad_height 	= ' . $td_adsense_spots[$spot_name]['m_h'] . ';
                    }
                    ';
            }
            $buffy .= '
             </script>
             <script type="text/javascript"
               src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
             </script>
             </div>
            ';
        }

        $buffy .= '</div>';
    $buffy .= '</div>';


    return $buffy;

}
add_shortcode('td_ad_box', 'td_ad_box');


//read the adspots
$td_ad_spots = td_get_option('td_ad_spots');
$td_pb_ad_spots = array();
if (!empty($td_ad_spots)) {
    foreach ($td_ad_spots as $td_ad_spot) {
        $td_pb_ad_spots['Ad spot -- ' . $td_ad_spot['name']] = 'Ad spot -- ' . $td_ad_spot['name'];
    }
}

//read the google adspots
$td_adsense_spots = td_get_option('td_adsense_spots');
if (!empty($td_adsense_spots)) {
    foreach ($td_adsense_spots as $td_ad_spot) {
        $td_pb_ad_spots['Adsense spot -- ' . $td_ad_spot['name']] = 'Adsense spot -- ' . $td_ad_spot['name'];
    }
}


wpb_map(
        array(
        "name" => __("Ad box", TD_THEME_NAME),
        "base" => "td_ad_box",
        "class" => "",
        "controls" => "full",
        "category" => __('Content', TD_THEME_NAME),
		'icon' => 'icon-pagebuilder-ads',
        "params" => array(
            array(
                "param_name" => "spot_name",
                "type" => "dropdown",
                "value" => $td_pb_ad_spots,
                "heading" => __("Sort order:", TD_THEME_NAME),
                "description" => "",
                "holder" => "div",
                "class" => ""
            )
        )
    )
);

?>
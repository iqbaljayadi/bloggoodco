<?php


$td_defaultOptions['sidebars'] = '';
$td_defaultOptions['td_ad_spots'] = '';

//add and autoload the option
add_option(TD_THEME_OPTIONS_NAME, $td_defaultOptions, '', 'yes' );



function td_on_theme_activate($oldname, $oldtheme=false) {
    //set up the page builder
    add_option('wpb_js_row_css_class', 'row-fluid');

    $wpb_columns = array(
        'span1' => 'span1',
        'span2' => 'span2',
        'span3' => 'span3',
        'span4' => 'span4',
        'span5' => 'span5',
        'span6' => 'span6',
        'span7' => 'span7',
        'span8' => 'span8',
        'span9' => 'span9',
        'span10' => 'span10',
        'span11' => 'span11',
        'span12' => 'span12'
    );
    add_option('wpb_js_column_css_classes', $wpb_columns);

    //the pagebuilder templates
    $td_pagebuilder_templates = array
    (
        'sidebar-right_28390' => array (
            'name' => 'Sidebar right',
            'template' => '[vc_row el_position=\"first last\"] [vc_column width=\"2/3\"] [/vc_column] [vc_column el_position=\"last\" width=\"1/3\"] [/vc_column] [/vc_row]'
        ),

        'sidebar-left_18719' => array (
            'name' => 'Sidebar left',
            'template' => '[vc_row el_position=\"first last\"] [vc_column width=\"1/3\"] [/vc_column] [vc_column width=\"2/3\"] [/vc_column] [/vc_row]'
        ),

        'homepage_4160' => Array (
            'name' => 'Homepage',
            'template' => '[vc_row el_position=\"first last\"] [vc_column width=\"2/3\"] [td_slide limit=\"8\" sort=\"popular\" hide_title=\"hide_title\" el_position=\"first\"] [td_block1 limit=\"5\" sort=\"popular\" custom_title=\"MOST POPULAR\" ajax_pagination=\"load_more\"] [td_block2 limit=\"6\" show_child_cat=\"4\" ajax_pagination=\"next_prev\"] [vc_row_inner] [vc_column_inner width=\"1/2\"] [td_slide limit=\"5\" custom_title=\"PEOPLE\" el_position=\"first last\"] [/vc_column_inner] [vc_column_inner width=\"1/2\"] [td_block4 limit=\"4\" sort=\"popular\" el_position=\"first last\"] [/vc_column_inner] [/vc_row_inner] [td_gallery limit=\"7\" el_position=\"last\"] [/vc_column] [vc_column width=\"1/3\"] [td_social icon_style=\"1\" icon_size=\"32\" behance=\"#\" dribbble=\"#\" evernote=\"#\" facebook=\"#\" google=\"#\" googleplus=\"#\" grooveshark=\"#\" instagram=\"#\" pinterest=\"#\" rss=\"#\" twitter=\"#\" vimeo=\"#\" woordpress=\"#\" youtube=\"#\" el_position=\"first\"] [td_block3 limit=\"3\" custom_title=\"LATEST VIDEO\"] [td_ad_box spot_name=\"ad_spot_--_sidebar_ad\"] [td_block5 limit=\"4\" sort=\"popular\" custom_title=\"TECH POPULAR\" ajax_pagination=\"load_more\"] [td_slide limit=\"5\" el_position=\"last\"] [/vc_column] [/vc_row]'
        ),
        'contact_533' => Array(
            'name' => 'Contact',
            'template' => '[vc_row el_position="first last"] [vc_column width="2/3"] [td_text_with_title title="Location" style="style_3" el_position="first"]

Fashion week officially begins Thursday, and while some of the brightest stars in the industry unveil their latest collections, many struggling designers are working hard trying to make it to Lincoln Center some day. NY1â€²s Cheryl Wills filed the following report.

[/td_text_with_title] [vc_gmaps link="http://maps.google.com/maps?q=Town+Hall+Square,+Kent+Street,+Sydney,+New+South+Wales,+Australia&hl=en&sll=-33.887464,151.187968&sspn=0.007472,0.016512&oq=square+australia+sy&t=h&hq=Town+Hall+Square,&hnear=Kent+St,+New+South+Wales+2000,+Australia&z=16" size="308" type="m" zoom="14"] [vc_row_inner] [vc_column_inner width="1/2"] [td_text_with_title title="Contact" style="style_2" el_position="first last"]

Fashion week officially begins theThursday, and while some of the brightest stars industry unverteil their latest.

Lincoln Center some day. NY1â€²s Cheryl Wills filed the following report.

[/td_text_with_title] [/vc_column_inner] [vc_column_inner width="1/2"] [td_social custom_title="OUR SOCIAL PROFILES" icon_style="1" icon_size="32" dribbble="http://www.tagdiv.com" facebook="http://www.tagdiv.com" googleplus="#" grooveshark="http://www.tagdiv.com" linkedin="#" twitter="http://www.tagdiv.com" youtube="http://www.tagdiv.com" el_position="first"] [td_definition_list title="OUR INFO" term1="Address" term1_d="John Doe 20, West Bank" term2="Phone" term2_d="(552) 365.2014" term3="Email" term3_d="contact@tagdiv.com" term4="-" term4_d="-" term5="Mon-Fri" term5_d="09:00 â€“ 18:00" term6="Sat" term6_d="10:00 â€“ 15:00" term7="Sun" term7_d="Closed" el_position="last"] [/vc_column_inner] [/vc_row_inner] [contact-form-7 title="Send us a message:" id="797" el_position="last"] [/vc_column] [vc_column width="1/3"] [vc_widget_sidebar sidebar_id="sidebar-1" el_position="first last"] [/vc_column] [/vc_row]'
        )
    );

    update_option('wpb_js_templates',$td_pagebuilder_templates);

    //update the wordpress default time format
    update_option('date_format', 'M j, Y');
    //echo get_option('date_format');
}
add_action("after_switch_theme", "td_on_theme_activate", 10 ,  2);

//update_option('wpb_js_templates',unserialize(''));





//echo str_replace(array("\r\n","\r"),"",serialize(get_option('wpb_js_templates'))); ;

//print_r(get_option('wpb_js_templates'));

$td_isFirstInstall = td_get_option('firstInstall');
if (empty($td_isFirstInstall)) {
    wp_insert_term('Featured', 'category', array(
        'description' => 'Featured posts',
        'slug' => 'featured',
        'parent' => 0
    ));
    td_update_option('firstInstall', 'themeInstalled');
}
?>

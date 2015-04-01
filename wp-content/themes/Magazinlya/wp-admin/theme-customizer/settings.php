<?php


class td_wp_customizer_builder {

    var $wp_customize;
    var $last_section_id;
    var $last_setting_id;

    var $td_priority;


    function __construct($wp_customize) {
        $this->wp_customize = $wp_customize;
        $this->last_section_id = '';
        $this->td_priority = 21;
        $this->td_control_priority = 1;
    }


    function add_section($title, $section_id = '', $priority = false) {
        if (empty($section_id)) {
            $section_id = str_replace(' ', '_', trim(strtolower($title)));
        }


        if ($priority === false) {
            $priority = $this->td_priority;
        }

        $this->wp_customize->add_section($section_id, array(
            'title' => TD_THEME_NAME . ' : ' . $title,
            'priority' => $priority,
        ));
        $this->last_section_id = $section_id;

        $this->td_priority++;
    }




    function add_radio($title, $setting_id, $parms) {
        $this->last_setting_id = $setting_id;

        $td_default_selected_id = '';
        foreach ($parms as $parm_id => $parm_value) {
            $td_default_selected_id = $parm_id;
            break;
        }
        $this->wp_customize->add_setting(TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']', array(
            'default' => $td_default_selected_id,
            'type' => 'option',
            'capability' => 'edit_theme_options',
        ));
        $this->wp_customize->add_control('tdc_' . $setting_id, array(
            'label' => $title,
            'section' => $this->last_section_id,
            'settings' => TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']',
            'type' => 'radio',
            'choices' => $parms,
            'priority' => $this->td_control_priority
        ));


        $this->td_control_priority++;
    }


    function add_select($title, $setting_id, $parms) {
        $this->last_setting_id = $setting_id;

        $td_default_selected_id = '';
        foreach ($parms as $parm_id => $parm_value) {
            $td_default_selected_id = $parm_id;
            break;
        }
        $this->wp_customize->add_setting(TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']', array(
            'default' => $td_default_selected_id,
            'type' => 'option',
            'capability' => 'edit_theme_options',
        ));
        $this->wp_customize->add_control('tdc_' . $setting_id, array(
            'label' => $title,
            'section' => $this->last_section_id,
            'settings' => TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']',
            'type' => 'select',
            'choices' => $parms,
            'priority' => $this->td_control_priority
        ));

        $this->td_control_priority++;
    }


    function add_color($title, $setting_id, $default = '#FFFFFF') {
        //theme color
        $this->wp_customize->add_setting(TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']', array(
            'default' => $default,
            'type' => 'option'
        ));

        $this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'tds_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']',
            'priority' => $this->td_control_priority
        )));

        $this->td_control_priority++;
    }

    function add_input($title, $setting_id, $default = '') {
        $this->wp_customize->add_setting(TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control('tds_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->td_control_priority
        ) );

        $this->td_control_priority++;
    }

    function add_image_upload($title, $setting_id, $default = '') {
        //custom logo
        $this->wp_customize->add_setting(TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']', array(
            'default' => $default,
            'type' => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_Image_Control( $this->wp_customize, 'tds_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => TD_THEME_OPTIONS_NAME . '[tds_' . $setting_id . ']',
            'priority' => $this->td_control_priority
        )));

        $this->td_control_priority++;
    }




}




function td_register_customizer($wp_customize) {

    $td_wp_customizer_builder = new td_wp_customizer_builder($wp_customize);


    $currentSidebars = td_get_option('sidebars'); //read the sidebars
    //print_r($currentSidebars);
    /*  ----------------------------------------------------------------------------
        Template options
     */
    $sidebars_array[''] = 'Default sidebar';
    if (!empty($currentSidebars)) {
        foreach ($currentSidebars as $sidebar) {
            $sidebars_array[$sidebar] = $sidebar;
        }
    }


    $module_array = array(
        '' => 'module 2',
        'mod3' => 'module 3',
        'mod4' => 'module 4',
        'mod5' => 'module 5',
        'mod6' => 'module 6'
    );


    $td_wp_customizer_builder->add_section('Template options');




    $td_wp_customizer_builder->add_radio('Responsive', 'responsive', array(
        '' => 'Full responsive',
        '980' => '980px fixed layout',
        '1200' => '1200px fixed layout'
    ));



    $td_wp_customizer_builder->add_select('Blog - sidebar', 'blog_sidebar', $sidebars_array);



    $td_wp_customizer_builder->add_select('Blog - sidebar position', 'blog_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));


    $td_wp_customizer_builder->add_select('Blog - show in post index', 'blog_excerpts', array(
        '' => 'Full posts',
        'excerpts' => 'Excerpts only'
    ));



    $td_wp_customizer_builder->add_select('Search page - layout', 'search_page_layout', $module_array);
    $td_wp_customizer_builder->add_select('Search page - sidebar position', 'search_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));


    $td_wp_customizer_builder->add_select('Archive page - layout', 'archive_page_layout', $module_array);
    $td_wp_customizer_builder->add_select('Archive page - sidebar position', 'archive_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));

    $td_wp_customizer_builder->add_select('Author page - layout', 'author_page_layout', $module_array);
    $td_wp_customizer_builder->add_select('Author page - sidebar position', 'author_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));


    $td_wp_customizer_builder->add_select('Category page - layout', 'category_page_layout', $module_array);
    $td_wp_customizer_builder->add_select('Category page - sidebar position', 'category_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));

    $td_wp_customizer_builder->add_select('Tag page - layout', 'tag_page_layout', $module_array);
    $td_wp_customizer_builder->add_select('Tag page - sidebar position', 'tag_sidebar_pos', array(
        '' => 'Sidebar right',
        'sidebar_left' => 'Sidebar left',
        'no_sidebar' => 'No sidebar',
    ));


    $td_wp_customizer_builder->add_select('404 page - layout', '404_page_layout', $module_array);



    /*  ----------------------------------------------------------------------------
        Colors
     */
    $td_wp_customizer_builder->add_section('Colors');
    $td_wp_customizer_builder->add_color('Header color', 'header_color', '#ee5656');
	$td_wp_customizer_builder->add_color('Header line color', 'header_line_color', '#f57272');
	$td_wp_customizer_builder->add_color('Link color', 'link_color', '#ee5656');
	$td_wp_customizer_builder->add_color('Link hover color', 'link_hover_color', '#ee5656');

    /*  ----------------------------------------------------------------------------
        Logo
    */
    $td_wp_customizer_builder->add_section('Logo');
    $td_wp_customizer_builder->add_image_upload('Upload your logo (298px x 124px) .png', 'logo_upload');
    $td_wp_customizer_builder->add_image_upload('Upload your logo (596px x 248px) .png', 'logo_upload_r');
    $td_wp_customizer_builder->add_image_upload('Favicon (16px x 16px) .png', 'favicon_upload');


    /*  ----------------------------------------------------------------------------
        Post settings
    */
    $td_wp_customizer_builder->add_section('Post settings');
    $td_wp_customizer_builder->add_radio('Featured image', 'show_featured_image', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Featured image lightbox?', 'featured_image_view_setting', array(
        '' => 'Show lightbox',
        'link' => 'Link to picture',
        'no_link' => 'No link'
    ));

    $td_wp_customizer_builder->add_radio('Tags', 'show_tags', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Author box', 'show_author_box', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Next and Previous posts', 'show_next_prev', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Similar articles', 'similar_articles', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Similar articles - type', 'similar_articles_type', array(
        '' => 'by category',
        'by_tag' => 'by tag',
        'by_auth' => 'by author'
    ));

    $td_wp_customizer_builder->add_radio('Similar articles - count', 'similar_articles_count', array(
        '' => '2 posts',
        '4' => '4 posts',
        '6' => '6 posts',
        '8' => '8 posts'
    ));


    $td_wp_customizer_builder->add_radio('Breadcrumbs - Show them on posts', 'breadcrumbs_show', array(
        '' => 'Show breadcrumbs',
        'hide' => 'Hide breadcrumbs'
    ));

    $td_wp_customizer_builder->add_radio('Breadcrumbs - show home link', 'breadcrumbs_show_home', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Breadcrumbs - show parent category link', 'breadcrumbs_show_parent', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));

    $td_wp_customizer_builder->add_radio('Breadcrumbs - show article title', 'breadcrumbs_show_article', array(
        '' => 'Show',
        'hide' => 'Hide'
    ));


    /*  ----------------------------------------------------------------------------
       Navigation
    */
    $td_wp_customizer_builder->add_section('Navigation', 'nav');
    $td_wp_customizer_builder->add_radio('Snap menu', 'snap_menu', array(
        '' => 'Only on big screens (not on mobile)',
        'always' => 'Always',
        'never' => 'Never'
    ));



    /*  ----------------------------------------------------------------------------
      Background
    */
    $td_wp_customizer_builder->add_section('Background', 'background_image');

    $td_wp_customizer_builder->add_radio('Stretch background', 'stretch_background', array(
        '' => 'No',
        'yes' => 'Yes'
    ));

    /*  ----------------------------------------------------------------------------
      Background
    */
    $td_wp_customizer_builder->add_section('Header', 'header_options');

    $td_wp_customizer_builder->add_radio('Header style', 'header_style', array(
        '' => 'Style 1 (logo + widget area)',
        '2' => 'Style 2 (no header)',
        '3' => 'Style 3 (default - responsive ad spot)',
        '4' => 'Style 4 (full width widget area)',
        '5' => 'Style 5 (full width menu + default responsive ad)'
    ));


    /*  ----------------------------------------------------------------------------
      Excerpts
    */
    $td_wp_customizer_builder->add_section('Excerpts');
    //$td_wp_customizer_builder->add_input('Module 1 - title length', 'mod1_title_excerpt');
    $td_wp_customizer_builder->add_input('Module 2 - title length (words)', 'mod2_title_excerpt');
    $td_wp_customizer_builder->add_input('Module 3 - title length (words)', 'mod3_title_excerpt');
    $td_wp_customizer_builder->add_input('Module 4 - title length (words)', 'mod4_title_excerpt');
    $td_wp_customizer_builder->add_input('Module 5 - title length (words)', 'mod5_title_excerpt');
    $td_wp_customizer_builder->add_input('All module - content length (words)', 'mod_content_excerpt', 25);
    $td_wp_customizer_builder->add_input('Wordpress default excerpt', 'wp_default_excerpt', 22);

    /*  ----------------------------------------------------------------------------
       Ads
    */
    $td_wp_customizer_builder->add_section('Ads');

    //read the adspots
    $td_ad_spots = td_get_option('td_ad_spots');
    $td_pb_ad_spots = array();
    $td_pb_ad_spots[''] = 'None';

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


    //header ad
    $td_wp_customizer_builder->add_select('Top ad spot', 'top_ad_spot', $td_pb_ad_spots);


    //inline ads
    $td_wp_customizer_builder->add_radio('Inline ad', 'inline_ad', array(
        '' => 'Center',
        'left' => 'Left aligned'
    ));

    $td_wp_customizer_builder->add_input('Show Ad after paragraph:', 'inline_ad_paragraph', 3);
    $td_wp_customizer_builder->add_select('Inline ad spot', 'inline_ad_spot', $td_pb_ad_spots);


    /*  ----------------------------------------------------------------------------
       Footer
    */
    $td_wp_customizer_builder->add_section('Footer');

    //header ad
    $td_wp_customizer_builder->add_radio('Footer widget columns', 'footer_widget_cols', array(
        '' => '1/3 - 1/3 - 1/3',
        '23-13' => '2/3 - 1/3',
        '13-23' => '1/3 - 2/3',
        '33' => '3/3 (full)'
    ));

    $td_wp_customizer_builder->add_input('Footer copyright text', 'footer_copyright');
    $td_wp_customizer_builder->add_radio('Show copyright symbol', 'footer_copy_symbol', array(
        '' => 'yes',
        'no' => 'no'
    ));

    $td_tmp_categ = td_get_category2id_array();
    $td_tmp_categ = array_flip($td_tmp_categ);
    $td_tmp_categ[''] = 'None';
    //print_r(array_flip(td_get_category2id_array()));
    $td_wp_customizer_builder->add_select('Footer link 1', 'footer_link_1', $td_tmp_categ);
    $td_wp_customizer_builder->add_select('Footer link 2', 'footer_link_2', $td_tmp_categ);
    $td_wp_customizer_builder->add_select('Footer link 3', 'footer_link_3', $td_tmp_categ);
    $td_wp_customizer_builder->add_select('Footer link 4', 'footer_link_4', $td_tmp_categ);
    $td_wp_customizer_builder->add_select('Footer link 5', 'footer_link_5', $td_tmp_categ);


}



add_action('customize_register', 'td_register_customizer');
?>

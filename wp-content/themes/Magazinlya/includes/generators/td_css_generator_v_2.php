<?php





/*  ----------------------------------------------------------------------------
    compile and render the custom css
*/
function td_render_custom_css_v2() {

    $raw_css = "
    <style>

    /* @td-custom-background */
    .td-custom-background {
        background-color: @td-custom-background;
    }

    /* @header_color */
	.td-header-line, .td-menu-wrap, .td-triangle-left-wrap, .td-triangle-right-wrap, .td-rating-bar-wrap div, .sf-menu ul a:hover, .sf-menu ul .sfHover > a, .sf-menu ul .current-menu-ancestor > a, .sf-menu ul .current-menu-item > a, .td-footer-line, .ui-tabs-nav .ui-tabs-active a, .td-menu-style-2-line, .td-menu-style-2 {
		background-color: @header_color;
    }
	
	.td-footer-line {
		border-color: @header_color;
    }
	
	body .wpb_btn-danger, .ui-tabs-nav .ui-tabs-active a {
	    background-color: @header_color !important;
    }




    /* @header_line_color */
	.td-menu-wrap, .td-triangle-left-wrap, .td-triangle-right-wrap,  .td-menu-style-2-line {
        border-bottom: 3px solid @header_line_color;
    }



    /* @header_menu_separator */
	.sf-menu > li:before {
        background-color: @header_menu_separator;
    }

    /* @header_triangle_color */
    .td-triangle-left {
      border-color: transparent @header_triangle_color transparent transparent;
    }

    .td-triangle-right {
        border-color: @header_triangle_color transparent transparent transparent;
    }
	
	/* @link_color */
	a {
		color: @link_color;
    }
    .cur-sub-cat {
      color:@link_color !important;
    }

	
	/* @link_hover_color */
	a:hover {
		color: @link_hover_color;
    }
    </style>
    ";

    $td_custom_css_parser = new td_custom_css_parser($raw_css);

    //load the user settings
    $td_custom_css_parser->load_setting('header_color');
	$td_custom_css_parser->load_setting('header_line_color');
	$td_custom_css_parser->load_setting('link_color');
	$td_custom_css_parser->load_setting('link_hover_color');

    //load the custom triangle color
    $td_header_line_color = td_get_option('tds_header_line_color');
    if (!empty($td_header_line_color)) {
        //echo $td_header_line_color;
        $td_custom_css_parser->load_setting_raw('header_triangle_color', adjustBrightness($td_header_line_color, -40));


    }

    //load the menu separator
    $tds_header_color = td_get_option('tds_header_color');
    if (!empty($tds_header_color)) {
        $td_custom_css_parser->load_setting_raw('header_menu_separator', adjustBrightness($tds_header_color, 30));
    }

    //custom background color
    $td_tmp_background_color = get_background_color();
    if (!empty($td_tmp_background_color)) {
        $td_custom_css_parser->load_setting_raw('td-custom-background', '#' . $td_tmp_background_color);
    }



    //output the style
    echo $td_custom_css_parser->compile_css();
}


add_action('wp_head', 'td_render_custom_css_v2');



/*  ----------------------------------------------------------------------------
    the custom compiler
 */
class td_custom_css_parser {
    var $raw_css;
    var $settings; //array

    var $css_sections; //array

    function __construct($raw_css) {
        $this->raw_css = $raw_css;
    }


    function load_setting($name) {
        $this->load_setting_raw($name, td_get_option('tds_' . $name));
    }

    function load_setting_raw($full_name, $value) {
        $this->settings[$full_name] = $value;
    }

    function split_into_sections() {
        //remove <style> wrap
        $this->raw_css = str_replace('<style>', '', $this->raw_css);
        $this->raw_css = str_replace('</style>', '', $this->raw_css);

        //explode the sections
        $css_splits = explode('/*', $this->raw_css);
        foreach ($css_splits as $css_split) {
            $css_split_parts = explode('*/', $css_split);
            if (!empty($css_split_parts[0]) and !empty($css_split_parts[1])) {
                $this->css_sections[trim($css_split_parts[0])] = $css_split_parts[1];
            }
        }
    }


    function compile_sections() {
        if (!empty($this->css_sections) and !empty($this->settings)) {
            foreach ($this->css_sections as $section_name => &$section_css) {
                foreach ($this->settings as $setting_name => $setting_value) {
                    $section_css = str_replace('@' . $setting_name, $setting_value, $section_css);
                }
            }
        }
    }




    function compile_css() {
        $this->split_into_sections();
        $this->compile_sections();

        $buffy = '';

        foreach ($this->css_sections as $section_name => $section_css) {
            if (!empty($this->settings[str_replace('@', '', $section_name)])) {
                $buffy.= $section_css;
            }
        }

        $buffy = trim($buffy);

        if (!empty($buffy)) {
            $buffy = "\n<!-- Style rendered by theme -->" . "\n\n<style>\n    " . $buffy . "\n</style>\n\n";
        }
        //print_r($this->css_sections);
        echo $buffy;
    }
}


?>
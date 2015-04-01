<?php
class td_util {

    //returns the $class if the variable is not empty or false
    static function if_show($variable, $class) {
        if ($variable !== false and !empty($variable)) {
            return ' ' . $class;
        } else {
            return '';
        }
    }

    //returns the class if the variable is empty or false
    static function if_not_show($variable, $class){
        if ($variable === false or empty($variable)) {
            return ' ' . $class;
        } else {
            return '';
        }
    }

}


//reads a theme option from wp
function td_get_option ($optionName) {

    $theme_options = get_option(TD_THEME_OPTIONS_NAME);
    if (!empty($theme_options[$optionName])) {
        return $theme_options[$optionName];
    } else {
        return;
    }

}

//updates a theme option
function td_update_option($optionName, $newValue) {
    $theme_options = get_option(TD_THEME_OPTIONS_NAME);
    //print_r($optionName);
    $theme_options[$optionName] = $newValue;
    update_option(TD_THEME_OPTIONS_NAME, $theme_options);
}




//transforms a tagDiv color profile name to #hexcolor
function td_get_color_profile($userEnteredColor) {
    global $td_colorProfiles;
    if (!empty($td_colorProfiles[$userEnteredColor])) {
        return $td_colorProfiles[$userEnteredColor];
    } else {
        return $userEnteredColor;
    }
}

function td_excerpt($post_content, $limit, $show_shortcodes = '') {
    $excerpt = explode(' ', $post_content, $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }

    if ($show_shortcodes == '') {
        $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    }

    $excerpt = esc_attr(strip_tags($excerpt));
    return $excerpt;
}




//used by page builder
function td_get_category2id_array($add_all_category = true) {


    $categories = get_categories(array(
        'hide_empty' => 0
    ));
    $categories_parents = array();
    $categories_childs = array();

    if ($add_all_category) { //add all categories if necessary
        $categories_buffer['- All categories -'] = '';
    }


    foreach ($categories as $category) {
        if ($category->category_parent == 0) {
            $categories_parents[$category->name] =  $category->term_id;
        } else {
            $categories_childs[$category->category_parent][$category->name] = $category->term_id;
        }
    }
    ksort ($categories_parents);
    foreach ($categories_parents as $category_name => $category_id) {
        $categories_buffer[$category_name] = $category_id;
        if (!empty($categories_childs[$category_id])) {
            ksort ($categories_childs[$category_id]);
            foreach ($categories_childs[$category_id] as $child_name => $child_id) {
                $categories_buffer[' - ' . $child_name] = $child_id;
            }
        }
    }

    $td_category_structure_buffer = $categories_buffer;


    return $categories_buffer;
}

//used in css include functions
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


function td_parse_class_name($name) {
    return str_replace(' ', '_', $name);
}

/*  ----------------------------------------------------------------------------
    used by the css compiler in /includes/generators/td_css_generator_v_2.php
 */
function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}


/*  ----------------------------------------------------------------------------
    mbstring support
 */

if (!function_exists('mb_strlen')) {
    function mb_strlen ($string) {
        return strlen($string);
    }
}

if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack,$needle,$offset=0) {
        return strpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strrpos')) {
    function mb_strrpos ($haystack,$needle,$offset=0) {
        return strrpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string) {
        return strtolower($string);
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string){
        return strtoupper($string);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($string,$start,$length) {
        return substr($string,$start,$length);
    }
}






<?php
function td_menu_home($atts, $content = null) {
    return '<span class="menu_icon td-sp td-sp-ico-home"></span><span class="menu_hidden">' . __td('HOME', TD_THEME_NAME) . '</span>' ;
    //return '<img class="menu_icon td-retina" width="25" src="' .  get_template_directory_uri() . '/images/header/ico-home.png" alt=""/> <span class="menu_hidden">' . __td('HOME', TD_THEME_NAME) . '</span>';
}
add_shortcode('menu_home', 'td_menu_home');



function td_category_home($atts, $content = null) {
    return '<span class="menu_icon td-sp td-sp-ico-categ"></span><span class="menu_hidden">' . __td('CATEGORIES', TD_THEME_NAME) . '</span>' ;
    //return '<img class="menu_icon td-retina" width="25" src="' .  get_template_directory_uri() . '/images/header/ico-categ.png" alt=""/> <span class="menu_hidden">' . __td('CATEGORIES', TD_THEME_NAME) . '</span>';
}
add_shortcode('category_home', 'td_category_home');

?>
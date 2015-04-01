<?php



class td_admin_controller {
    public static $current_page = '';


    static function run_view($view_name) {

    }



    static function get_cur_controller() {
        if (!empty($_REQUEST['td_page'])) {
            return $_REQUEST['td_page'];
        } else {
            return 'index';
        }
    }

    static function get_url($controller, $action = '', $parms = '') {


        if (empty($action)) {
            if ($controller == 'index') {
                return '?page=td_controller.php' . $parms;
            } else {
                return '?page=td_controller.php&td_page=' . $controller . $parms;
            }
        } else {
            return '?page=td_controller.php&td_page=' . $controller . '&td_action=' . $action . $parms;
        }
    }
}



function td_wp_admin_controller() {

    /* wp doc: add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function); */
    //add_submenu_page( "td_theme_page", "Custom code", "Custom code", "edit_posts", "td_theme_code", "td_theme_code" );

    add_theme_page('<span class="td-theme-option">Theme</span> - Options', '<span class="td-theme-option">Theme</span> - Options', 'edit_themes', basename(__FILE__), 'td_wp_admin_controller_run' );

}
add_action('admin_menu', 'td_wp_admin_controller');




function td_wp_admin_controller_run() {
    if (!is_admin()){
        return;
    }

    require_once 'td_parts/td_options_navigation.php';

    if (!empty($_REQUEST['td_page'])) {
        require_once 'views/' . $_REQUEST['td_page'] . '.php';
        if (!empty($_REQUEST['td_action'])) {
            call_user_func('td_mvc_' . $_REQUEST['td_page'] . '_' . $_REQUEST['td_action']);
        } else {
            call_user_func('td_mvc_' . $_REQUEST['td_page'] . '_index');
        }

    } else {
        require_once 'views/index.php';
        td_run_index();
    }
}




?>
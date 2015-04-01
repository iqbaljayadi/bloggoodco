<?php



function td_wp_is_tab_active($controller) {
    if (td_admin_controller::get_cur_controller() == $controller) {
        echo ' td-tab-active';
    }
}
?>


<div class="td-tabs-wrap td-wrap">
    <ul class="td-tabs">
        <li><a href="<?php echo td_admin_controller::get_url('index')?>" class="<?php td_wp_is_tab_active('index') ?>">Theme Options</a></li>
        <li><a href="<?php echo td_admin_controller::get_url('ads')?>" class="<?php td_wp_is_tab_active('ads') ?>">Ads</a></li>
        <li><a href="<?php echo td_admin_controller::get_url('adsense')?>" class="<?php td_wp_is_tab_active('adsense') ?>">Google AdSense</a></li>
        <li><a href="<?php echo td_admin_controller::get_url('sidebars')?>" class="<?php td_wp_is_tab_active('sidebars') ?>">Sidebars</a></li>
        <li><a href="<?php echo td_admin_controller::get_url('translate')?>" class="<?php td_wp_is_tab_active('translate') ?>">Translate</a></li>
        <li><a href="<?php echo td_admin_controller::get_url('analytics')?>" class="<?php td_wp_is_tab_active('analytics') ?>">Analytics</a></li>
    </ul>
</div>
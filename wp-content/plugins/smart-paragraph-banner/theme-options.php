<?php

defined( 'ABSPATH' ) OR exit;

add_action('admin_menu', 'spb_create_theme_options_page');
add_action('admin_init', 'spb_register_and_build_fields');

function spb_create_theme_options_page() {
   add_options_page('Smart Paragraph Banner', 'Smart Paragraph Banner', 'administrator', __FILE__, 'spb_options_page_fn');
}

function spb_register_and_build_fields() {
   
   register_setting('tonjoo_spb', 'tonjoo_uncache_script_shortcode');

}

function spb_options_page_fn() {
?>
   <div id="theme-options-wrap" class="widefat">
      <div class="icon32" id="icon-tools"></div>
      <form method="post" action="options.php" enctype="multipart/form-data">

         <?php 

            settings_fields('tonjoo_spb'); 

            do_settings_sections( 'tonjoo_spb' ); 

            $banner = get_option('tonjoo_uncache_script_shortcode');

         ?>
         <p>Shortcode in banner</p>
         <input type='text' name='tonjoo_uncache_script_shortcode' value="<?php echo $banner ?>">



         <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Smart Paragraph Banner'); ?>" />
         </p>
   </form>
</div>

<?php
}
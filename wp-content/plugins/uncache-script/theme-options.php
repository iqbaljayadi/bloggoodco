<?php

defined( 'ABSPATH' ) OR exit;

add_action('admin_menu', 'scu_create_theme_options_page');
add_action('admin_init', 'scu_register_and_build_fields');

function scu_create_theme_options_page() {
   add_options_page('Uncache Script', 'Uncache Script', 'administrator', __FILE__, 'options_page_fn');
}

function scu_register_and_build_fields() {
   
   register_setting('tonjoo_uncache_script', 'tonjoo_uncache_script_version');

}

function options_page_fn() {
?>
   <div id="theme-options-wrap" class="widefat">
      <div class="icon32" id="icon-tools"></div>

      <h2>Uncache Script</h2>
      <p>Just hit the "Uncache Script" button to force your scripts and style to uncache !</p>
      <p><b>*Important : If you use W3Total Cache script/style cache you should disable this plugin </b></p>

      <form method="post" action="options.php" enctype="multipart/form-data">

         <?php 

            settings_fields('tonjoo_uncache_script'); 

            do_settings_sections( 'tonjoo_uncache_script' ); 

            $version = get_option('tonjoo_uncache_script_version');

            if(!$version)
            {

               $version = 1;
               $nextVersion = 1;

            }
            else
               $nextVersion = $version +1 ; 

         ?>

         <p>Current Version : <?php echo $version ?> </p>

         <input type='hidden' name='tonjoo_uncache_script_version' value="<?php echo $nextVersion ?>">



         <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Uncache Script'); ?>" />
         </p>
   </form>
</div>

<?php
}

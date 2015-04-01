<?php 
/*  ----------------------------------------------------------------------------
    tagDiv sidebar loader

    Load order on pages / posts:
    - custom post / page sidebar
    - primary category sidebar
    - default sidebar

    Load order on category template:
    - custom category sidebar
    - default sidebar
 */


//if it's singular read the post/page sidebar setings
if (is_singular()) {
    $td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);

}

if (!empty($td_post_theme_settings['td_sidebar'])) {
    /*  ----------------------------------------------------------------------------
        sidebar from post/page
     */
    dynamic_sidebar($td_post_theme_settings['td_sidebar']);
} else {
    
    if (is_category()) {
        /*  ----------------------------------------------------------------------------
            sidebar from category on category page
         */
        $curCategoryID = get_query_var('cat');
        $tax_meta_sidebar = get_tax_meta($curCategoryID, 'tdc_sidebar_name');
        if (!empty($tax_meta_sidebar)) {
            //show the category one
            dynamic_sidebar($tax_meta_sidebar);
        } else {
            //show default
            if (!dynamic_sidebar(TD_THEME_NAME . ' default')) { 
                ?>
                    <!-- .no sidebar -->
                <?php 
            }
        }
    } elseif (is_single()) {
        /*  ----------------------------------------------------------------------------
            sidebar from category on post page
         */
        $primary_category_id = td_global::get_primary_category_id();
        if (!empty($primary_category_id)) {
            $tax_meta_sidebar = get_tax_meta($primary_category_id, 'tdc_sidebar_name');
            if (!empty($tax_meta_sidebar)) {
                //show the category one
                dynamic_sidebar($tax_meta_sidebar);
            } else {
                //show default
                if (!dynamic_sidebar(TD_THEME_NAME . ' default')) { 
                    ?>
                        <!-- .no sidebar -->
                    <?php 
                }
            }
        }
    } elseif (is_home()) {
        /*  ----------------------------------------------------------------------------
            it's the blog index template (home.php but I think we go with index.php)
         */
        $tds_blog_sidebar = td_get_option('tds_blog_sidebar');

        if (!empty($tds_blog_sidebar)) {
            dynamic_sidebar($tds_blog_sidebar);
        } else {
            //show default
            if (!dynamic_sidebar(TD_THEME_NAME . ' default')) {
                ?>
                <!-- .no sidebar -->
            <?php
            }
        }


    } elseif (!dynamic_sidebar(TD_THEME_NAME . ' default')) {
        ?>
            <!-- .no sidebar -->
        <?php 
    } 
}
?>                            
                   

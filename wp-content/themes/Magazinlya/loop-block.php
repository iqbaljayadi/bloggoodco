<?php
/*
 *
 * This loop is used by:
 *  - author.php
 *  - category.php
 *  - tag.php
 *  - archive.php
 *
 *  It renders the posts with the help of the module renderer /includes/pagebuilder/td_modules.php

    tagDiv 2013 - contact@tagDiv.com for any questions and thanks for using our theme! :)

 */


global $td_loop_block_module; //the module type used in the loop


//the template layout builder
$td_template_layout = new td_template_layout();

if (is_category()) {
    global $td_category_sidebar_position; //get the category custom sidebar setting /category.php
    $td_template_layout->set_sidebar_setting($td_category_sidebar_position); //calculate the columns via the default sidebar position setting
} elseif (is_tag()) {
    $td_template_layout->set_sidebar_setting(td_get_option('tds_tag_sidebar_pos'));
} elseif (is_author()) {
    $td_template_layout->set_sidebar_setting(td_get_option('tds_author_sidebar_pos'));
} elseif (is_archive()) {
    $td_template_layout->set_sidebar_setting(td_get_option('tds_archive_sidebar_pos'));
} elseif (td_global::$is_404) { //check like that because of wp bug with 404 page that has query
    $td_template_layout->set_sidebar_setting('no_sidebar');
} elseif (is_search()) {
    $td_template_layout->set_sidebar_setting(td_get_option('tds_search_sidebar_pos'));
} else {
    $td_template_layout->set_sidebar_setting(td_get_option('tds_category_sidebar_pos'));
}



if (have_posts()) {
    while ( have_posts() ) : the_post();

        echo $td_template_layout->layout_open_element();
            switch ($td_loop_block_module) {
                case 'mod2':
                    echo td_modules::mod2_render($post);
                    break;
                case 'mod3':
                    echo td_modules::mod3_render($post);
                    break;
                case 'mod4':
                    echo td_modules::mod4_render($post);
                    break;
                case 'mod5':
                    echo td_modules::mod5_render($post);
                    break;
                case 'mod6':
                    echo td_modules::mod6_render($post);
                    break;
                default:
                    echo td_modules::mod2_render($post);
                    break;
            }

        echo $td_template_layout->layout_close_element();

        //increment variables (post count etc)
        $td_template_layout->layout_next();

    endwhile; //end loop

    echo $td_template_layout->close_all_tags();

    echo td_page_generator::get_pagination();

} else {
    echo td_page_generator::no_posts();
}

?>
<?php
/*  ----------------------------------------------------------------------------
    the blog index template
 */

get_header();


//save the id of the main page, used by the sidebar on blog pages
td_global::load_main_page_id(get_queried_object_id());


$td_home_sidebar_position = td_get_option('tds_blog_sidebar_pos');

switch ($td_home_sidebar_position) {
    case 'sidebar_left':
        echo td_page_generator::wrap_start();
        ?>
        <div class="span4 column_container">
            <?php get_sidebar(); ?>
        </div>
        <div class="span8 column_container">
            <?php
            get_template_part('loop');
            ?>
        </div>
        <?php
        echo td_page_generator::wrap_end();
        break;

    case 'no_sidebar':
        echo td_page_generator::wrap_start();
        ?>
        <div class="span12 column_container">
            <?php
            get_template_part('loop');
            ?>
        </div>
        <?php
        echo td_page_generator::wrap_end();
        break;



    default:
        echo td_page_generator::wrap_start();
        ?>
            <div class="span8 column_container">
                <?php
                get_template_part('loop');
                ?>
            </div>
            <div class="span4 column_container">
                <?php get_sidebar(); ?>
            </div>
        <?php
        echo td_page_generator::wrap_end();
        break;
}

get_footer();

?>
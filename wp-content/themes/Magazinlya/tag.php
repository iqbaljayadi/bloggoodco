<?php

global $td_loop_block_module; //the module type used in the loop

$td_loop_block_module = td_get_option('tds_tag_page_layout');



get_header();



switch (td_get_option('tds_tag_sidebar_pos')) {
    case 'sidebar_left':
        echo td_page_generator::wrap_start();
        ?>
        <div class="span4 column_container">
            <?php get_sidebar(); ?>
        </div>
        <div class="span8 column_container">
            <?php
            get_template_part('loop-block');
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
            get_template_part('loop-block');
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
                get_template_part('loop-block');
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
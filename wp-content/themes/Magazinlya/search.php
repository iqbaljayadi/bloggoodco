<?php

global $wp_query, $td_loop_block_module;

$td_loop_block_module = td_get_option('tds_search_page_layout');

//search only in posts
$args = array_merge( $wp_query->query, array( 'post_type' => 'post' ) );

query_posts( $args );


get_header();



switch (td_get_option('tds_search_sidebar_pos')) {
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
                echo td_text_with_title(array('title' => __td('Search Results for:') . ' ' . get_search_query(), 'style' => 'style_2', 'class' => 'category-title'));
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
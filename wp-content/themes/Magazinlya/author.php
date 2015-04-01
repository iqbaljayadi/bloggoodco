<?php

global $td_loop_block_module; //the module type used in the loop

$td_loop_block_module = td_get_option('tds_author_page_layout');





get_header();


$td_page_parts = new td_page_parts(); //the author box is from here


$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

//print_r($curauth->display_name);


switch (td_get_option('tds_author_sidebar_pos')) {
    case 'sidebar_left':
        echo td_page_generator::wrap_start();
        ?>
            <div class="span4 column_container">
                <?php get_sidebar(); ?>
            </div>
            <div class="span8 column_container">
                <div class="author-box-wrap author-page">
                    <h1 class="h5-caps-title"><?php echo $curauth->display_name ?></h1>
                    <?php  echo get_avatar($curauth->user_email, '106'); ?>
                    <div class="desc">
                        <?php echo $curauth->description ?>
                        <div class="td-author-social">
                            <?php
                            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                                //echo get_the_author_meta($td_social_id) . '<br>';
                                $authorMeta = get_the_author_meta($td_social_id);
                                if (!empty($authorMeta)) {
                                    echo  td_social_icons::get_icon($authorMeta, $td_social_id, 4, 16);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php get_template_part('loop-block'); ?>
            </div>
        <?php
        echo td_page_generator::wrap_end();
        break;

    case 'no_sidebar':
        echo td_page_generator::wrap_start();
        ?>
            <div class="span12 column_container">
                <div class="author-box-wrap author-page">
                    <h1 class="h5-caps-title"><?php echo $curauth->display_name ?></h1>
                    <?php  echo get_avatar($curauth->user_email, '106'); ?>
                    <div class="desc">
                        <?php echo $curauth->description ?>
                        <div class="td-author-social">
                            <?php
                            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                                //echo get_the_author_meta($td_social_id) . '<br>';
                                $authorMeta = get_the_author_meta($td_social_id);
                                if (!empty($authorMeta)) {
                                    echo  td_social_icons::get_icon($authorMeta, $td_social_id, 4, 16);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php get_template_part('loop-block'); ?>
            </div>
        <?php
        echo td_page_generator::wrap_end();
        break;



    default:
        echo td_page_generator::wrap_start();


        ?>
            <div class="span8 column_container">
                <div class="author-box-wrap author-page">
                    <h1 class="h5-caps-title"><?php echo $curauth->display_name ?></h1>
                    <?php  echo get_avatar($curauth->user_email, '106'); ?>
                    <div class="desc">
                        <?php echo $curauth->description ?>
                        <div class="td-author-social">
                            <?php
                            foreach (td_social_icons::$td_social_icons_array as $td_social_id => $td_social_name) {
                                //echo get_the_author_meta($td_social_id) . '<br>';
                                $authorMeta = get_the_author_meta($td_social_id);
                                if (!empty($authorMeta)) {
                                    echo  td_social_icons::get_icon($authorMeta, $td_social_id, 4, 16);
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php get_template_part('loop-block'); ?>
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
<?php

global $td_loop_block_module;

get_header();

echo td_page_generator::wrap_start();

?>

    <div class="span12 column_container">
        <div class="td-404-title">
            <?php _etd('404 Error - page not found'); ?>
        </div>

        <?php
        echo td_text_with_title(array('title' => __td('Our latest posts'), 'style' => 'style_3', 'class' => 'td-404-head'), '');


        $args = array(
            'post_type'=> 'post',
            'showposts' => 6
        );
        query_posts($args);

        td_global::$is_404 = true;
        $td_loop_block_module = td_get_option('tds_404_page_layout');
        //$td_loop_block_module

        get_template_part('loop-block');
        //get_template_part('category', 'slider');

        ?>
    </div>
<?php

echo td_page_generator::wrap_end();
get_footer();
?>
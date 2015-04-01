<?php
/*  ----------------------------------------------------------------------------
   all the page parts are here:
   /includes/td_page_generator/td_page_parts.php - - the class extends: /includes/pagebuilder/td_module_parts.php

    tagDiv 2013 - contact@tagDiv.com for any questions and thanks for using our theme! :)
*/

if (have_posts()) {
    while ( have_posts() ) : the_post();

        global $post;

        $td_page_parts = new td_page_parts($post);

        //update the page view if single
        td_page_generator::update_page_views(get_the_ID());

        //set the current post id
        td_global::load_post($post)
        ?>

        <!-- .post -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?> <?php echo $td_page_parts->get_item_scope()?>>
            <header>


                <?php
                    echo $td_page_parts->get_bread_crumbs();
                    echo $td_page_parts->get_title();
                ?>
                <div class="td-post-meta">
                    <?php
                        echo $td_page_parts->get_category();
                        echo $td_page_parts->get_author();
                        echo $td_page_parts->get_commentsAndViews();
                    ?>
                </div>
            </header>
            <?php
                echo $td_page_parts->get_image('featured-image');
                if (is_home()) {
                    $tds_blog_excerpts = td_get_option('tds_blog_excerpts');
                    if (!empty($tds_blog_excerpts)) {
                        echo $td_page_parts->get_content(true);
                    } else {
                        echo $td_page_parts->get_content();
                    }
                } else {
                    echo $td_page_parts->get_content();
                }


                wp_link_pages(); //paging @todo fix it
            ?>
            <footer class="clearfix">
                <?php
                echo $td_page_parts->get_review();
                echo $td_page_parts->get_source_and_via();
                echo $td_page_parts->get_the_tags();
                echo $td_page_parts->get_next_prev_posts();
                echo $td_page_parts->get_author_box();
                ?>
            </footer>
        </article> <!-- /.post -->
        <?php
        echo $td_page_parts->related_posts();
    endwhile; //end loop

    //get the pagination
    echo td_page_generator::get_pagination();
} else {
    echo td_page_generator::no_posts();
}

?>
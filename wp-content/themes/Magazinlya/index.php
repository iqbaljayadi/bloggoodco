<?php
/*  ----------------------------------------------------------------------------
    Used by pagebuilder for all the pages
 */

get_header();

?>
    <div class="container td-page-wrap">
        <div class="row">
            <div class="span12">
                <div class="td-grid-wrap">
                    <div class="container-fluid">
                        <div class="wpb_row row-fluid ">
                            <div class="span8 wpb_column column_container">
                                <?php
                                    get_template_part('loop');
                                    comments_template( '', true );
                                ?>
                            </div>

                            <div class="span4 wpb_column column_container">
                                <div class="wpb_widgetised_column wpb_content_element">
                                    <?php get_sidebar(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
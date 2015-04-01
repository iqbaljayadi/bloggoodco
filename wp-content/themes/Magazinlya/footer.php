<!-- footer line -->
<div class="container td-footer-line">
    <div class="row">
        <div class="span12"></div>
    </div>
</div>



<?php


    $tds_footer_widget_cols = td_get_option('tds_footer_widget_cols');

    //reset global columns
    global $td_row_count, $td_column_count;
    $td_row_count = 1;

    switch ($tds_footer_widget_cols) {
        case '23-13':

            ?>
            <div class="container td-footer-wrap">
                <div class="row">
                    <div class="span12">
                        <div class="td-grid-wrap">
                            <div class="container-fluid">
                                <div class="wpb_row row-fluid ">
                                    <div class="span8 wpb_column column_container">
                                        <?php
                                            $td_column_count = '2/3'; //2 cols widget
                                            dynamic_sidebar('Footer 1')
                                        ?>
                                    </div>

                                    <div class="span4 wpb_column column_container">
                                        <?php
                                            $td_column_count = '1/3'; //1 col widget
                                            dynamic_sidebar('Footer 2')
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            break;

        case '13-23':
            ?>
            <div class="container td-footer-wrap">
                <div class="row">
                    <div class="span12">
                        <div class="td-grid-wrap">
                            <div class="container-fluid">
                                <div class="wpb_row row-fluid ">
                                    <div class="span4 wpb_column column_container">
                                        <?php
                                            $td_column_count = '1/3'; //1 col widget
                                            dynamic_sidebar('Footer 1')
                                        ?>
                                    </div>
                                    <div class="span8 wpb_column column_container">
                                        <?php
                                            $td_column_count = '2/3'; //2 cols widget
                                            dynamic_sidebar('Footer 2')
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            break;

        case '33':
            $td_column_count = '1/1'; //3 cols widget
            ?>
            <div class="container td-footer-wrap">
                <div class="row">
                    <div class="span12">
                        <div class="td-grid-wrap">
                            <div class="container-fluid">
                                <div class="wpb_row row-fluid ">
                                    <div class="span12 wpb_column column_container">
                                        <?php dynamic_sidebar('Footer 1')?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            break;

        default:
            $td_column_count = '1/3'; //1 col widget - all!
            ?>
                <div class="container td-footer-wrap">
                    <div class="row">
                        <div class="span12">
                            <div class="td-grid-wrap">
                                <div class="container-fluid">
                                    <div class="wpb_row row-fluid ">
                                        <div class="span4 wpb_column column_container">
                                            <?php dynamic_sidebar('Footer 1')?>
                                        </div>

                                        <div class="span4 wpb_column column_container">
                                            <?php dynamic_sidebar('Footer 2')?>
                                        </div>
                                        <div class="span4 wpb_column column_container">
                                            <?php dynamic_sidebar('Footer 3')?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            break;


    }
?>


<div class="container td-sub-footer-wrap">
    <div class="row">
        <div class="span12">
            <div class="td-grid-wrap">
                <div class="container-fluid">
                    <div class="row-fluid ">
                        <div class="span4 td-sub-footer-copy">
                            <?php
                                $tds_footer_copyright = td_get_option('tds_footer_copyright');
                                $tds_footer_copy_symbol = td_get_option('tds_footer_copy_symbol');

                                //show copyright symbol
                                if ($tds_footer_copy_symbol == '') {
                                    echo '&copy; ';
                                }

                                echo $tds_footer_copyright;
                            ?>
                        </div>
                        <div class="span8 td-sub-footer-menu">

                            <?php


                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu',
                                'menu_class'=> '',
                                'fallback_cb' => 'td_wp_footer_menu'
                            ));

                            //if no menu
                            function td_wp_footer_menu() {
                                $tds_footer_link_1 = td_get_option('tds_footer_link_1');
                                $tds_footer_link_2 = td_get_option('tds_footer_link_2');
                                $tds_footer_link_3 = td_get_option('tds_footer_link_3');
                                $tds_footer_link_4 = td_get_option('tds_footer_link_4');
                                $tds_footer_link_5 = td_get_option('tds_footer_link_5');

                                if (!empty($tds_footer_link_1) or !empty($tds_footer_link_2) or !empty($tds_footer_link_3) or !empty($tds_footer_link_4) or !empty($tds_footer_link_5)) {
                                    echo '<ul>';
                                    if (!empty($tds_footer_link_1)) {
                                        $td_category_obj = get_category($tds_footer_link_1);
                                        echo '<li><a href="' . get_category_link($td_category_obj->cat_ID) . '">' . $td_category_obj->name . '</a></li>';
                                    }
                                    if (!empty($tds_footer_link_2)) {
                                        $td_category_obj = get_category($tds_footer_link_2);
                                        echo '<li><a href="' . get_category_link($td_category_obj->cat_ID) . '">' . $td_category_obj->name . '</a></li>';
                                    }
                                    if (!empty($tds_footer_link_3)) {
                                        $td_category_obj = get_category($tds_footer_link_3);
                                        echo '<li><a href="' . get_category_link($td_category_obj->cat_ID) . '">' . $td_category_obj->name . '</a></li>';
                                    }
                                    if (!empty($tds_footer_link_4)) {
                                        $td_category_obj = get_category($tds_footer_link_4);
                                        echo '<li><a href="' . get_category_link($td_category_obj->cat_ID) . '">' . $td_category_obj->name . '</a></li>';
                                    }
                                    if (!empty($tds_footer_link_5)) {
                                        $td_category_obj = get_category($tds_footer_link_5);
                                        echo '<li><a href="' . get_category_link($td_category_obj->cat_ID) . '">' . $td_category_obj->name . '</a></li>';
                                    }
                                    echo '</ul>';
                                }
                            }



                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php wp_footer();?>
</body>
</html>
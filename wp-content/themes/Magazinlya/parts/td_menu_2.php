<!-- menu -->
<div class="td-menu-placeholder td-menu-style-2">
    <div class="td-menu-style-2-line">
        <div class="container td-menu-wrap">
            <div class="td-triangle-left-wrap">
                <div class="td-triangle-left"></div>
            </div>

            <div class="td-triangle-right-wrap">
                <div class="td-triangle-right"></div>
            </div>
            <div class="row-fluid">
                <div class="span10" id="td-top-menu">
                    <?php
                    add_filter('wp_nav_menu_objects', 'my_nav_menu_objects_shortcode_mangler', 11);


                    //do shortcodes in menu
                    function my_nav_menu_objects_shortcode_mangler($items) {
                        $td_is_firstMenu = true;
                        foreach ($items as $item) {
                            if ($td_is_firstMenu) {
                                $item->classes[] = 'menu-item-first';
                                $td_is_firstMenu = false;
                            }


                            //echo $item->title;

                            if (strpos($item->title,'[') === false) {
                                $item->title = mb_strtoupper($item->title);
                            }
                            $item->title = do_shortcode($item->title);


                            if ($item->url == '#' ) {
                                $item->title = $item->title . '<div class="sub_menu_arrow"></div>';
                            }

                        }
                        return $items;
                    }

                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'menu_class'=> 'sf-menu',
                        'fallback_cb' => 'td_wp_page_menu'
                    ));

                    //if no menu
                    function td_wp_page_menu() {
                        //this is the default menu
                        echo '<ul class="sf-menu">';
                        echo '<li class="menu-item-first"><a href="' . home_url() . '/wp-admin/nav-menus.php">Click here - to use the wordpress menu builder</a></li>';
                        //wp_list_pages('sort_column=menu_order&title_li=');
                        echo '</ul>';
                    }
                    ?>
                </div>
                <div class="span2" id="td-top-search">
                    <!-- Search -->
                    <div class="header-search-wrap">
                        <div class="dropdown header-search">
                            <a id="search-button" href="#" role="button" class="dropdown-toggle needsclick" data-toggle="dropdown"><span class="td-sp td-sp-ico-search"></span></a>
                            <div class="dropdown-menu" aria-labelledby="search-button">
                                <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                                    <input name="s" class="span2" id="td-header-search" size="16" type="text" placeholder="<?php _etd('Search...')?>"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row-fluid -->
        </div> <!-- /.td-menu-wrap -->
    </div>
</div> <!-- /.td-menu-placeholder -->
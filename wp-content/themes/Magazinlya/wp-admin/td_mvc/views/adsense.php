<?php


function td_mvc_adsense_delete() {
    $td_ad_spots = td_get_option('td_adsense_spots'); //read the sidebars


    /*
     * check if we have a get request (the delete)
     */
    if (isset($_REQUEST['delete_adspot'])) {
        if (!empty($td_ad_spots)) {
            unset($td_ad_spots[$_REQUEST['delete_adspot']]);

        }
        td_update_option('td_adsense_spots', $td_ad_spots);
    }

    td_mvc_adsense_index();
}


function td_mvc_adsense_update() {
    $td_ad_spots = td_get_option('td_adsense_spots'); //read the sidebars


    if (isset($_POST['td_update'])) {


        //pubid
        if (!empty($_POST['pub_id'])) {
            $new_ad_spot['pub_id'] = $_POST['pub_id'];
        }

        //phone
        if (!empty($_POST['p'])) {
            $new_ad_spot['p']= $_POST['p'];
        }

        if (!empty($_POST['p_w'])) {
            $new_ad_spot['p_w']= $_POST['p_w'];
        }

        if (!empty($_POST['p_h'])) {
            $new_ad_spot['p_h']= $_POST['p_h'];
        }

        //tablet portrait
        if (!empty($_POST['tp'])) {
            $new_ad_spot['tp']= $_POST['tp'];
        }

        if (!empty($_POST['tp_w'])) {
            $new_ad_spot['tp_w']= $_POST['tp_w'];
        }

        if (!empty($_POST['tp_h'])) {
            $new_ad_spot['tp_h']= $_POST['tp_h'];
        }

        //tablet landscape
        if (!empty($_POST['tl'])) {
            $new_ad_spot['tl']= $_POST['tl'];
        }

        if (!empty($_POST['tl_w'])) {
            $new_ad_spot['tl_w']= $_POST['tl_w'];
        }

        if (!empty($_POST['tl_h'])) {
            $new_ad_spot['tl_h']= $_POST['tl_h'];
        }

        //monitor
        if (!empty($_POST['m'])) {
            $new_ad_spot['m']= $_POST['m'];
        }

        if (!empty($_POST['m_w'])) {
            $new_ad_spot['m_w']= $_POST['m_w'];
        }

        if (!empty($_POST['m_h'])) {
            $new_ad_spot['m_h']= $_POST['m_h'];
        }

        $new_ad_spot['name'] = $_POST['current_name'];

        //save the new sidebar
        $td_ad_spots[$_POST['current_name']] = $new_ad_spot;
        ksort($td_ad_spots); //sort the array
        td_update_option('td_adsense_spots', $td_ad_spots);

    }

    td_mvc_adsense_index();
}

function td_mvc_adsense_insert() {
    $td_ad_spots = td_get_option('td_adsense_spots'); //read the sidebars


    if (isset($_POST['td_insert'])) {


        if (empty($_POST['new_ad_spot_name'])) {
            echo '<div class="td-message"><p>Please enter a spot name.</p></div>';
        }
        elseif (!empty($td_ad_spots) and !empty($td_ad_spots[strtolower($_POST['new_ad_spot_name'])])) {
            echo '<div class="td-message"><p>The ad spot name already exists</p></div>';
        }
        else {

            //name
            if (!empty($_POST['new_ad_spot_name'])) {
                $new_ad_spot['name'] = strtolower($_POST['new_ad_spot_name']);
            }

            //pubid
            if (!empty($_POST['pub_id'])) {
                $new_ad_spot['pub_id'] = $_POST['pub_id'];
            }

            //phone
            if (!empty($_POST['p'])) {
                $new_ad_spot['p']= $_POST['p'];
            }

            if (!empty($_POST['p_w'])) {
                $new_ad_spot['p_w']= $_POST['p_w'];
            }

            if (!empty($_POST['p_h'])) {
                $new_ad_spot['p_h']= $_POST['p_h'];
            }

            //tablet portrait
            if (!empty($_POST['tp'])) {
                $new_ad_spot['tp']= $_POST['tp'];
            }

            if (!empty($_POST['tp_w'])) {
                $new_ad_spot['tp_w']= $_POST['tp_w'];
            }

            if (!empty($_POST['tp_h'])) {
                $new_ad_spot['tp_h']= $_POST['tp_h'];
            }

            //tablet landscape
            if (!empty($_POST['tl'])) {
                $new_ad_spot['tl']= $_POST['tl'];
            }

            if (!empty($_POST['tl_w'])) {
                $new_ad_spot['tl_w']= $_POST['tl_w'];
            }

            if (!empty($_POST['tl_h'])) {
                $new_ad_spot['tl_h']= $_POST['tl_h'];
            }

            //monitor
            if (!empty($_POST['m'])) {
                $new_ad_spot['m']= $_POST['m'];
            }

            if (!empty($_POST['m_w'])) {
                $new_ad_spot['m_w']= $_POST['m_w'];
            }

            if (!empty($_POST['m_h'])) {
                $new_ad_spot['m_h']= $_POST['m_h'];
            }


            //save the new sidebar
            $td_ad_spots[strtolower($_POST['new_ad_spot_name'])] = $new_ad_spot;
            //print_r($td_ad_spots);
            ksort($td_ad_spots); //sort the array
            td_update_option('td_adsense_spots', $td_ad_spots);

        }
    }

    td_mvc_adsense_index();
}




function td_adsense_init_and_show_info(&$td_ad_spot, $adsize) {
    if (empty($td_ad_spot[$adsize . '_w'])) {
        $td_ad_spot[$adsize . '_w'] = '';
    }

    if (empty($td_ad_spot[$adsize . '_h'])) {
        $td_ad_spot[$adsize . '_h'] = '';
    }


    if (!empty($td_ad_spot[$adsize])) {
        echo $td_ad_spot[$adsize];

        echo '<div class="td_adsense_size">' . $td_ad_spot[$adsize . '_w'] . ' - ' . $td_ad_spot[$adsize . '_h'] . '</div>';
        $td_ad_spot[$adsize] = stripslashes($td_ad_spot[$adsize]);
    } else {
        $td_ad_spot[$adsize] = '';
    }
}

function td_mvc_adsense_index() {
    $td_ad_spots = td_get_option('td_adsense_spots'); //read the sidebars

    ?>

    <div class="td-wrap">
        <div class="td-section">
            <div class="td-section-title">Responsive Google AdSense</div>
            <p>Here you can manage your responsive AdSense spots. The responsive spot dynamically loads a google ad based on the users screen size. In order to be compliant with AdSense TOS the spot is not reloaded on resize and it's not modified in any way once it's loaded.</p>
        </div>



        <table class="td-ads-table td-google-adsense">
            <thead>
            <tr>
                <th>Name</th>
                <th class="td-th-center">Pub id</th>
                <th class="td-th-center">Phones <div>(0 - 767px)</div></th>
                <th class="td-th-center">Portrait <div>(768 - 1018px)</div></th>
                <th class="td-th-center">Landscape <div>(1019 - 1199px)</div></th>
                <th class="td-th-center">Desktop<div>(1200px +)</div></th>
                <th colspan="2"><center>Action</center></th>
            </tr>
            </thead>

            <?php
            $td_adspot_yes = 'Y';
            $td_adspot_no = 'N';
            ?>


            <?php
            if (!empty($td_ad_spots)) {
                foreach ($td_ad_spots as $td_ad_spot) { ?>

                    <tr>
                        <td>
                            <?php
                            echo $td_ad_spot['name'];
                            ?>
                        </td>

                        <td>
                            <?php
                            if (!empty($td_ad_spot['pub_id'])) {
                                echo $td_ad_spot['pub_id'];
                            } else {
                                $td_ad_spot['pub_id'] = '';
                            }
                            ?>
                        </td>


                        <td class="td-th-center">
                            <?php td_adsense_init_and_show_info($td_ad_spot, 'p'); ?>
                        </td>

                        <td class="td-th-center">
                            <?php td_adsense_init_and_show_info($td_ad_spot, 'tp'); ?>
                        </td>

                        <td class="td-th-center">
                            <?php td_adsense_init_and_show_info($td_ad_spot, 'tl'); ?>
                        </td>

                        <td class="td-th-center">
                            <?php td_adsense_init_and_show_info($td_ad_spot, 'm'); ?>
                        </td>

                        <td class="td-sidebar-delete">
                            <a href="<?php echo td_admin_controller::get_url('adsense', 'delete', '&delete_adspot=' . $td_ad_spot['name'])?>" onclick="return confirm('Really delete?');"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-delete.png' ?>"/></a>
                        </td>
                        <td class="td-sidebar-edit">
                            <a href="#modal_<?php echo td_parse_class_name($td_ad_spot['name'])?>" class="td_rename" title="Edit"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-edit.png' ?>"/></a>
                        </td>
                    </tr>




                    <tr class="td-hiddent-modal td-modal" id="modal_<?php echo td_parse_class_name($td_ad_spot['name'])?>">
                        <td colspan="8">
                            <!-- Modal edit  :) -->
                            <form action="<?php echo td_admin_controller::get_url('adsense', 'update')?>" method="post">
                                <h3>Add new ad spot</h3>


                                <p>
                                    <label>Publisher ID:</label> <br>
                                    <input class="td-input-full" type="text"  name="pub_id" value="<?php echo $td_ad_spot['pub_id']?>" size="50">
                                </p>

                                <p>
                                    <label>Phones (0 - 767px) - ad ID:</label> <br>
                                    <input class="td-input-half" type="text"  name="p" value="<?php echo $td_ad_spot['p']?>">

                                    <span class="td-inline-label">width:</span>
                                    <input class="td-input" type="text"  name="p_w" value="<?php echo $td_ad_spot['p_w']?>" style="width:60px;">

                                    <span class="td-inline-label">height:</span>
                                    <input class="td-input" type="text"  name="p_h" value="<?php echo $td_ad_spot['p_h']?>" style="width:60px;">
                                </p>

                                <p>
                                    <label>iPad portrait (768 - 1018px) - ad ID:</label> <br>
                                    <input class="td-input-half" type="text"  name="tp" value="<?php echo $td_ad_spot['tp']?>">

                                    <span class="td-inline-label">width:</span>
                                    <input class="td-input" type="text"  name="tp_w" value="<?php echo $td_ad_spot['tp_w']?>" style="width:60px;">

                                    <span class="td-inline-label">height:</span>
                                    <input class="td-input" type="text"  name="tp_h" value="<?php echo $td_ad_spot['tp_h']?>" style="width:60px;">
                                </p>

                                <p>
                                    <label>iPad landscape (1019 - 1199px) - ad ID:</label> <br>
                                    <input class="td-input-half" type="text"  name="tl" value="<?php echo $td_ad_spot['tl']?>">

                                    <span class="td-inline-label">width:</span>
                                    <input class="td-input" type="text"  name="tl_w" value="<?php echo $td_ad_spot['tl_w']?>" style="width:60px;">

                                    <span class="td-inline-label">height:</span>
                                    <input class="td-input" type="text"  name="tl_h" value="<?php echo $td_ad_spot['tl_h']?>" style="width:60px;">
                                </p>

                                <p>
                                    <label>Desktop (1200px +) - ad ID:</label> <br>
                                    <input class="td-input-half" type="text"  name="m" value="<?php echo $td_ad_spot['m']?>">

                                    <span class="td-inline-label">width:</span>
                                    <input class="td-input" type="text"  name="m_w" value="<?php echo $td_ad_spot['m_w']?>" style="width:60px;">

                                    <span class="td-inline-label">height:</span>
                                    <input class="td-input" type="text"  name="m_h" value="<?php echo $td_ad_spot['m_h']?>" style="width:60px;">
                                </p>



                                <input class="button" type="submit" name="add_ad_spot" value="<?php _e('Update ad spot', TD_THEME_NAME)?>" > or <a href="#" class="td_modal_cancel">Cancel</a>
                                <input type="hidden" name="td_update" value="true" />

                                <input type="hidden" name="current_name" value="<?php echo $td_ad_spot['name'] ?>" />
                            </form>
                        </td>
                    </tr>

                <?php
                }
            } //

            ?>
        </table>


        <form action="<?php echo td_admin_controller::get_url('adsense', 'insert')?>" method="post">

            <h3><label>Add new ad spot</label></h3>

            <p>
                <div class="td-form-label">Ad spot name:</label></div>
                <input class="td-input-full" type="text"  name="new_ad_spot_name" value="" size="50">
            </p>

            <p>
                <div class="td-form-label">Publisher ID:</label></div>
                <input class="td-input-full" type="text"  name="pub_id" value="" size="50">
            </p>

            <p>
                <div class="td-form-label">Phones (0 - 767px) - ad ID:</div>
                <input class="td-input-half" type="text"  name="p" value="">

                <span class="td-inline-label">width:</span>
                <input class="td-input" type="text"  name="p_w" value=""style="width:60px;">

                <span class="td-inline-label">height:</span>
                <input class="td-input" type="text"  name="p_h" value=""style="width:60px;">
            </p>

            <p>
                <div class="td-form-label">iPad portrait (768 - 1018px) - ad ID:</div>
                <input class="td-input-half" type="text"  name="tp" value="">

                <span class="td-inline-label">width:</span>
                <input class="td-input" type="text"  name="tp_w" value=""style="width:60px;">

                <span class="td-inline-label">height:</span>
                <input class="td-input" type="text"  name="tp_h" value=""style="width:60px;">
            </p>

            <p>
                <div class="td-form-label">iPad landscape (1019 - 1199px) - ad ID:</div>
                <input class="td-input-half" type="text"  name="tl" value="">

                <span class="td-inline-label">width:</span>
                <input class="td-input" type="text"  name="tl_w" value=""style="width:60px;">

                <span class="td-inline-label">height:</span>
                <input class="td-input" type="text"  name="tl_h" value=""style="width:60px;">
            </p>

            <p>
                <div class="td-form-label">Desktop (1200px +) - ad ID:</div>
                <input class="td-input-half" type="text"  name="m" value="">

                <span class="td-inline-label">width:</span>
                <input class="td-input" type="text"  name="m_w" value=""style="width:60px;">

                <span class="td-inline-label">height:</span>
                <input class="td-input" type="text"  name="m_h" value=""style="width:60px;">
            </p>



            <input class="button" type="submit" name="add_ad_spot" value="<?php _e('Add ad spot', TD_THEME_NAME)?>" >
            <input type="hidden" name="td_insert" value="true" />
        </form>



    </div>
<?php
}
?>
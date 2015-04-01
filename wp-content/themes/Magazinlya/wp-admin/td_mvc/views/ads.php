<?php


function td_mvc_ads_delete() {
    $td_ad_spots = td_get_option('td_ad_spots'); //read the sidebars


    /*
     * check if we have a get request (the delete)
     */
    if (isset($_REQUEST['delete_adspot'])) {
        if (!empty($td_ad_spots)) {
            unset($td_ad_spots[$_REQUEST['delete_adspot']]);

        }
        td_update_option('td_ad_spots', $td_ad_spots);
    }

    td_mvc_ads_index();
}


function td_mvc_ads_update() {
    $td_ad_spots = td_get_option('td_ad_spots'); //read the sidebars


    if (isset($_POST['td_update'])) {


        if (!empty($_POST['new_ad_spot_phone'])) {
            $new_ad_spot['p']= $_POST['new_ad_spot_phone'];
        }
        if (!empty($_POST['new_ad_spot_portrait'])) {
            $new_ad_spot['tp']= $_POST['new_ad_spot_portrait'];
        }
        if (!empty($_POST['new_ad_spot_landscape'])) {
            $new_ad_spot['tl']= $_POST['new_ad_spot_landscape'];
        }
        if (!empty($_POST['new_ad_spot_desktop'])) {
            $new_ad_spot['m']= $_POST['new_ad_spot_desktop'];
        }

        $new_ad_spot['name'] = $_POST['current_name'];

        //save the new sidebar
        $td_ad_spots[$_POST['current_name']] = $new_ad_spot;
        ksort($td_ad_spots); //sort the array
        td_update_option('td_ad_spots', $td_ad_spots);

    }

    td_mvc_ads_index();
}

function td_mvc_ads_insert() {
    $td_ad_spots = td_get_option('td_ad_spots'); //read the sidebars


    if (isset($_POST['td_insert'])) {


        if (empty($_POST['new_ad_spot_name'])) {
            echo '<div class="td-message"><p>Please enter a ad spot name.</p></div>';
        }
        elseif (!empty($td_ad_spots) and !empty($td_ad_spots[strtolower($_POST['new_ad_spot_name'])])) {
            echo '<div class="td-message"><p>The ad spot name already exists</p></div>';
        }
        else {
            if (!empty($_POST['new_ad_spot_name'])) {
                $new_ad_spot['name'] = strtolower($_POST['new_ad_spot_name']);
            }
            if (!empty($_POST['new_ad_spot_phone'])) {
                $new_ad_spot['p']= $_POST['new_ad_spot_phone'];
            }
            if (!empty($_POST['new_ad_spot_portrait'])) {
                $new_ad_spot['tp']= $_POST['new_ad_spot_portrait'];
            }
            if (!empty($_POST['new_ad_spot_landscape'])) {
                $new_ad_spot['tl']= $_POST['new_ad_spot_landscape'];
            }
            if (!empty($_POST['new_ad_spot_desktop'])) {
                $new_ad_spot['m']= $_POST['new_ad_spot_desktop'];
            }

            //save the new sidebar
            $td_ad_spots[strtolower($_POST['new_ad_spot_name'])] = $new_ad_spot;
            ksort($td_ad_spots); //sort the array
            td_update_option('td_ad_spots', $td_ad_spots);

        }
    }

    td_mvc_ads_index();
}


function td_mvc_ads_index() {
    $td_ad_spots = td_get_option('td_ad_spots'); //read the sidebars

    ?>

    <div class="td-wrap">
        <div class="td-section">
            <div class="td-section-title">Responsive Ads</div>
            <p>Show different ads on different devices easily. The code from each text area will show up on the corresponding screen size. For google ads, please use the <a href="<?php echo td_admin_controller::get_url('adsense', 'index')?>">Google AdSense panel</a>.</p>
        </div>



        <table class="td-ads-table">
            <thead>
            <tr>
                <th>Ad spot name</th>
                <th class="td-th-center">Phones <div>(0 - 767px)</div></th>
                <th class="td-th-center">iPad portrait <div>(768 - 1018px)</div></th>
                <th class="td-th-center">iPad landscape <div>(1019 - 1199px)</div></th>
                <th class="td-th-center">Desktop<div>(1200px +)</div></th>
                <th colspan="2"><center>Action</center></th>
            </tr>
            </thead>

            <?php
            $td_adspot_yes = '<img class="td-ico-dot" src="' . get_template_directory_uri() . '/wp-admin/images/ico-dot.png' . '"/>';
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
                        <td class="td-th-center">
                            <?php
                            if (!empty($td_ad_spot['p'])) {
                                echo $td_adspot_yes;
                                $td_ad_spot['p'] = stripslashes($td_ad_spot['p']);
                            } else {
                                echo $td_adspot_no;
                                $td_ad_spot['p'] = '';
                            }
                            ?>
                        </td>

                        <td class="td-th-center">
                            <?php
                            if (!empty($td_ad_spot['tp'])) {
                                echo $td_adspot_yes;
                                $td_ad_spot['tp'] = stripslashes($td_ad_spot['tp']);
                            } else {
                                echo $td_adspot_no;
                                $td_ad_spot['tp'] = '';
                            }
                            ?>
                        </td>

                        <td class="td-th-center">
                            <?php
                            if (!empty($td_ad_spot['tl'])) {
                                echo $td_adspot_yes;
                                $td_ad_spot['tl'] = stripslashes($td_ad_spot['tl']);
                            } else {
                                echo $td_adspot_no;
                                $td_ad_spot['tl'] = '';
                            }
                            ?>
                        </td>

                        <td class="td-th-center">
                            <?php
                            if (!empty($td_ad_spot['m'])) {
                                echo $td_adspot_yes;
                                $td_ad_spot['m'] = stripslashes($td_ad_spot['m']);
                            } else {
                                echo $td_adspot_no;
                                $td_ad_spot['m'] = '';
                            }
                            ?>
                        </td>

                        <td class="td-sidebar-delete">
                            <a href="<?php echo td_admin_controller::get_url('ads', 'delete', '&delete_adspot=' . $td_ad_spot['name'])?>" onclick="return confirm('Really delete?');"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-delete.png' ?>"/></a>
                        </td>
                        <td class="td-sidebar-edit">
                            <a href="#modal_<?php echo td_parse_class_name($td_ad_spot['name'])?>" class="td_rename" title="Edit"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-edit.png' ?>"/></a>
                        </td>
                    </tr>




                    <tr class="td-hiddent-modal td-modal" id="modal_<?php echo td_parse_class_name($td_ad_spot['name'])?>">
                        <td colspan="7">
                            <!-- Modal edit  :) -->
                            <form action="<?php echo td_admin_controller::get_url('ads', 'update')?>" method="post">
                                <h3>Edit ad spot: <?php echo $td_ad_spot['name'] ?> </h3>
                                <p>
                                <div class="td-form-label">Phones (0 - 767px):</div>
                                    <textarea class="td-text-area" name="new_ad_spot_phone"><?php echo $td_ad_spot['p'] ?></textarea>
                                </p>

                                <p>
                                <div class="td-form-label">iPad portrait(768 - 1018px):</div>
                                    <textarea class="td-text-area" name="new_ad_spot_portrait"><?php echo $td_ad_spot['tp'] ?></textarea>
                                </p>

                                <p>
                                <div class="td-form-label">iPad landscape (1019 - 1199px):</div>
                                    <textarea class="td-text-area" name="new_ad_spot_landscape"><?php echo $td_ad_spot['tl'] ?></textarea>
                                </p>

                                <p>
                                <div class="td-form-label">Desktop(1200px +):</div>
                                    <textarea class="td-text-area" name="new_ad_spot_desktop"><?php echo $td_ad_spot['m'] ?></textarea>
                                </p>

                                <input class="button" type="submit" name="add_ad_spot" value="<?php _e('Update', TD_THEME_NAME)?>" >
                                or <a href="#" class="td_modal_cancel">Cancel</a>
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


        <form action="<?php echo td_admin_controller::get_url('ads', 'insert')?>" method="post">


                <h3>Add new ad spot</h3>

                <p>
                    <div class="td-form-label">Ad spot name:</div>
                    <input class="td-input-full" type="text"  name="new_ad_spot_name" value="" size="50">
                </p>



                <p>
                    <div class="td-form-label">Phones (0 - 767px):</div>
                    <textarea class="td-text-area" name="new_ad_spot_phone"></textarea>
                </p>

                <p>
                    <div class="td-form-label">iPad portrait(768 - 1018px):</div>
                    <textarea class="td-text-area" name="new_ad_spot_portrait"></textarea>
                </p>

                <p>
                    <div class="td-form-label">iPad landscape (1019 - 1199px):</div>
                    <textarea class="td-text-area" name="new_ad_spot_landscape"></textarea>
                </p>

                <p>
                    <div class="td-form-label">Desktop(1200px +):</div>
                    <textarea class="td-text-area" name="new_ad_spot_desktop"></textarea>
                </p>






            <input class="button" type="submit" name="add_ad_spot" value="<?php _e('Add ad spot', TD_THEME_NAME)?>" >
            <input type="hidden" name="td_insert" value="true" />
        </form>



    </div>
<?php
}
?>
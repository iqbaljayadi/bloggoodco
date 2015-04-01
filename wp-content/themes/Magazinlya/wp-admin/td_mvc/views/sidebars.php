<?php

function td_mvc_sidebars_delete() {
    $currentSidebars = td_get_option('sidebars'); //read the sidebars

    /*
     * check if we have a get request (the delete)
     */
    if (isset($_REQUEST['delete_sidebar'])) {
        if (!empty($currentSidebars)) {
            $key = array_search($_REQUEST['delete_sidebar'],$currentSidebars);
            if($key!==false){
                unset($currentSidebars[$key]);
            }
        }
        td_update_option('sidebars', $currentSidebars);
    }
    td_mvc_sidebars_index();
}

function td_mvc_sidebars_update() {
    $currentSidebars = td_get_option('sidebars'); //read the sidebars

    if (isset($_POST['td_update'])) {
        if (empty($_POST['new_sidebar_name'])) {
            echo '<div id="message" class="error"><p>Please enter a sidebar name.</p></div>';
        }
        elseif (!empty($currentSidebars) and in_array($_POST['new_sidebar_name'], $currentSidebars)) {
            echo '<div id="message" class="error"><p>The sidebar name already exists</p></div>';
        }
        else {

            foreach($currentSidebars as $sidebarId => &$sidebarName) {
                if ($sidebarName == $_POST['td_old_name']) {
                    $sidebarName = $_POST['new_sidebar_name'];
                }
            }
            td_update_option('sidebars', $currentSidebars);
        }
    }

    td_mvc_sidebars_index();
}

function td_mvc_sidebars_insert() {
    $currentSidebars = td_get_option('sidebars'); //read the sidebars

    /*
     * check if we have a post
     */
    if (isset($_POST['td_insert'])) {
        //we have a post !
        if (empty($_POST['new_sidebar_name'])) {
            echo '<div class="td-message"><p>Please enter a sidebar name.</p></div>';
        }
        elseif (!empty($currentSidebars) and in_array($_POST['new_sidebar_name'], $currentSidebars)) {
            echo '<div class="td-message"><p>The sidebar name already exists</p></div>';
        }
        else {
            //save the new sidebar
            $currentSidebars[] = $_POST['new_sidebar_name'];
            //asort($currentSidebars); //sort the array
            td_update_option('sidebars', $currentSidebars);
        }
    }


    td_mvc_sidebars_index();
}


function td_mvc_sidebars_index() {
    $currentSidebars = td_get_option('sidebars'); //read the sidebars


    ?>
    <div class="td-wrap">
        <div class="td-section">
            <div class="td-section-title">Sidebar manager</div>
            <p>Here you can manage your sidebars. Each page, category or post can have it's custom sidebar form this list. You can add widgets to each one using the <a href="widgets.php">widgets panel</a>.</p>
        </div>

        <?php
        if (empty($currentSidebars)) {
            ?>
            <div class="td-message td-ok"><p>No custom sidebars defined, use this form to add some sidebars.</p></div>
        <?php
        } else {
            ?>



            <table>
                <thead>
                <tr>
                    <th>Sidebar name</th>
                    <th colspan="2"><center>Action</center></th>
                </tr>
                </thead>

                <tbody>
                <?php
                if (!empty($currentSidebars)) {
                    foreach ($currentSidebars as $sidebar) {
                        ?>

                        <tr>
                            <td><?php echo $sidebar ?> </td>
                            <td class="td-sidebar-delete">
                                <a href="<?php echo td_admin_controller::get_url('sidebars', 'delete', '&delete_sidebar=' . $sidebar)?>" onclick="return confirm('Really delete?');"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-delete.png' ?>"/></a>
                            </td>
                            <td class="td-sidebar-edit">
                                <a href="#modal_<?php echo td_parse_class_name($sidebar)?>" class="td_rename" title="Renaming sidebar <?php echo $sidebar ?>"><img src="<?php echo get_template_directory_uri() . '/wp-admin/images/ico-edit.png' ?>"/></a>
                            </td>
                        </tr>


                        <tr class="td-hiddent-modal td-modal" id="modal_<?php echo td_parse_class_name($sidebar)?>">
                            <td colspan="3">
                                <!-- Modal rename :) -->
                                <form action="<?php echo td_admin_controller::get_url('sidebars', 'update')?>" method="post">
                                    <h3>Rename sidebar: <?php echo $sidebar ?> </h3>
                                    <p>
                                        <input class="td-sidebar-name" type="text" placeholder="New sidebar name" name="new_sidebar_name" value="<?php echo $sidebar ?>" size="40">
                                    </p>
                                    <p>
                                        <input  class="button" type="submit" name="update_sidebar" value="<?php _e('Update name', TD_THEME_NAME)?>" > or <a href="#" class="td_modal_cancel">Cancel</a>
                                    </p>
                                    <input type="hidden" name="td_old_name" value="<?php echo $sidebar ?>" />
                                    <input type="hidden" name="td_update" value="true" />
                                </form>
                            </td>
                        </tr>



                    <?php
                    }
                }
                ?>
                </tbody>
            </table>

        <?php } //end check if empty?>

        <form action="<?php echo td_admin_controller::get_url('sidebars', 'insert')?>" method="post">
            <h3>Add new sidebar</h3>
                <div class="td-form-label">Sidebar name:</div>
                <p>
                    <input class="td-input-full" type="text" name="new_sidebar_name" value="" size="50">
                </p>
                <input class="button" type="submit" name="add_sidebar" value="<?php _e('Add sidebar', TD_THEME_NAME)?>" >
                <input type="hidden" name="td_insert" value="true" />
        </form>
    </div>

    <?php
}

?>
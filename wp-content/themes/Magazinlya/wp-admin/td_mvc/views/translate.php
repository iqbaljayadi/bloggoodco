<?php
function td_mvc_translate_update() {
    $td_translation_map_user = td_get_option('td_translation_map_user');

    $post_user_translations = $_POST['translation'];
    foreach ($post_user_translations as $td_string => $td_translation) {
        if (!empty($td_translation)) {
            $td_translation_map_user[$td_string] = $td_translation;
        } else {
            unset($td_translation_map_user[$td_string]);
        }

    }


    td_update_option('td_translation_map_user', $td_translation_map_user);
    //print_r($_POST['translation']);
    td_mvc_translate_index();
}


function td_mvc_translate_index() {
    global $td_translation_map;

    $td_translation_map_user = td_get_option('td_translation_map_user');



    ?>
    <div class="td-wrap">
        <div class="td-section">
            <div class="td-section-title">Translations</div>
            <p>Translate your front end easily without external plugins that costs money. Leave the box empty and the theme will load the default string.</p>
        </div>


        <form action="<?php echo td_admin_controller::get_url('translate', 'update')?>" method="post" class="td-simple-form">
            <table class="">
                <thead>
                <tr>
                    <th>String</th>
                    <th>Translation</th>
                </tr>
                </thead>


                <?php
                foreach ($td_translation_map as $td_string => $td_translation) {
                    if (!empty($td_translation_map_user[$td_string])) {
                        $td_translation = $td_translation_map_user[$td_string];
                    }
                    ?>
                    <tr>
                        <td><?php echo $td_string ?></td>
                        <td><input type="text" name="translation[<?php echo $td_string ?>]" value="<?php echo $td_translation ?>" size="50"></td>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <p>
                <input  class="button" type="submit" name="update_sidebar" value="<?php _e('Save translations', TD_THEME_NAME)?>" >
            </p>
            <input type="hidden" name="td_update" value="true" />
        </form>
    </div>
    <?php
}
?>
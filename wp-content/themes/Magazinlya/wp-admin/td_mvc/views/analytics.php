<?php
function td_mvc_analytics_update() {
    td_update_option('td_analytics', $_POST['td_analytics']);
    td_mvc_analytics_index();
}


function td_mvc_analytics_index() {


    $td_analytics = stripslashes(td_get_option('td_analytics'));
    ?>

    <div class="td-wrap">
        <div class="td-section">
            <div class="td-section-title">Analytics</div>
            <p>The analytics code that you insert here will appear at the end of the page. You can paste multiple stats monitoring codes one after another.</p>
        </div>


        <form action="<?php echo td_admin_controller::get_url('analytics', 'update')?>" method="post" >
            <h3>Insert this code at the end of each page:</h3>
            <p>
                <textarea class="td-text-area" style="height: 200px" name="td_analytics"><?php echo $td_analytics ?></textarea>
            </p>
            <p>
                <input class="button" type="submit" name="add_sidebar" value="<?php _e('Save', TD_THEME_NAME)?>" >
            </p>

            <input type="hidden" name="td_update" value="true" />
        </form>

    </div>
<?php
}

?>
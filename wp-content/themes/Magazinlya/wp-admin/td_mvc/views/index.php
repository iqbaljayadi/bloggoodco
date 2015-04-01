<?php

function td_run_index() {
    ?>
    <div class="td-wrap">

        <div class="td-section">
            <div class="td-section-title">Theme customizer:</div>
            This theme uses the wordpress theme customizer. <br> <br> <br>
            <span style="padding: 13px 10px 10px 10px; background-color:#33A0D0"><a style="color:white; font-size:18px; text-decoration: none" href="customize.php">Open theme customizer</a></span>
        </div>



        <div class="td-section">
            <div class="td-section-title">Theme information:</div>
            <ul>
                <li><strong>Theme name:</strong> <?php echo TD_THEME_NAME?> </li>
                <li><strong>Version:</strong> <?php echo TD_THEME_VERSION?> </li>
                <li><strong>Author:</strong> <a href="http://themeforest.net/user/tagDiv">tagDiv</a></li>
                <li><strong>Email:</strong> contact@tagDiv.com</li>
                <li><strong>Support forum (recommended):</strong> <a href="http://forum.tagdiv.com">forum.tagdiv.com</a></li>
                <li><strong>Documentation URL:</strong> <a href="<?php echo TD_THEME_DOC_URL?>"><?php echo TD_THEME_DOC_URL?></a></li>
                <li><strong>Demo URL:</strong> <a href="<?php echo TD_THEME_DEMO_URL?>"><?php echo TD_THEME_DEMO_URL?></a></li>
                <li><strong>Demo XML import:</strong> <a href="<?php echo TD_THEME_DEMO_XML_URL?>"><?php echo TD_THEME_DEMO_XML_URL?></a></li>

            </ul>

        </div>



        <div class="td-section">
            <div class="td-section-title">Thanks!</div>
            <p>Thanks for using our theme, we had worked very hard to release a great product and we will do our absolute best to support this theme and fix all the issues.</p>
            <p>Marius and Radu from tagDiv - 2013</p>
        </div>
    </div>
    <?php
}
?>
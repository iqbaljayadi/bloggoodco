<?php


//the bottom code for analitics and stuff
function td_ios_redirect() {
    ?>
    <script>
        //themeforest iframe removal code

        var td_is_safari = false;
        var td_is_ios = false;
        var ua = navigator.userAgent.toLowerCase();
        if (ua.indexOf('safari')!=-1){
            if(ua.indexOf('chrome')  > -1){
                //alert("1") // chrome
            }else{
                td_is_safari = true;
            }
        }
        if(navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
            td_is_ios = true;
        }
        if(td_is_ios || td_is_safari) {
            if (top.location != location) {
                top.location.replace("<?php echo TD_THEME_DEMO_URL?>");
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'td_ios_redirect');

?>
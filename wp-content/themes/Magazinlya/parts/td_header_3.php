<!-- logo and ad -->
<div class="container header-wrap td-header-wrap-3">
    <div class="row">
        <div class="span4 header-logo-wrap">
            <?php
            $td_customLogo = td_get_option('tds_logo_upload');
            $td_customLogoR = td_get_option('tds_logo_upload_r');

            if (!empty($td_customLogoR)) {
                ?><a href="<?php echo home_url(); ?>"><img width="298" class="td-retina-data" data-retina="<?php echo htmlentities($td_customLogoR) ?>" src="<?php echo $td_customLogo?>" alt="" /></a><?php
            } else {
                if (!empty($td_customLogo)) {
                    ?><a href="<?php echo home_url(); ?>"><img src="<?php echo $td_customLogo?>" alt=""/></a><?php
                }
            }


            ?>
        </div>
        <div class="span8 td-header-top-ad">
            <?php dynamic_sidebar('Top ad'); ?>
        </div>
    </div>
</div>
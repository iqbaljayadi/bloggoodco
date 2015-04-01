<?php

add_filter( 'wp_footer' , 'write_attention_grabber_frontend_view' );
function write_attention_grabber_frontend_view() {
    $sunrise = new Sunrise_Plugin_Framework;

    $txtPrimary = $sunrise->get_option( 'color-text' );
    $barPrimary = $sunrise->get_option( 'color-primary-bar' );
    $barSecondary = $sunrise->get_option( 'color-secondary-bar' );
    $btnPrimary = $sunrise->get_option( 'color-primary-button' );
    $btnSecondary = $sunrise->get_option( 'color-secondary-button' );
    $btnText = $sunrise->get_option( 'color-text-button' );
    $btnPrimaryHover = $sunrise->get_option( 'color-primary-button-hover' );
    $btnSecondaryHover = $sunrise->get_option( 'color-secondary-button-hover' );
    $btnTextHover = $sunrise->get_option( 'color-text-button-hover' );
    $btnPrimaryActive = $sunrise->get_option( 'color-primary-button-active' );
    $btnSecondaryActive = $sunrise->get_option( 'color-secondary-button-active' );
    $btnTextActive = $sunrise->get_option( 'color-text-button-active' );
    $check = $sunrise->get_option( 'checkmark-color' );

    $fonts = $sunrise->get_option( 'font-stack' );
    if( $fonts ) {
        $fonts = "font-family: " . $fonts . ";";
    }
    ?>
    <style>
        #attention-grabber {
            background-color: <?php echo $barPrimary; ?>;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $barPrimary; ?>), to(<?php echo $barSecondary; ?>));
            background-image: -webkit-linear-gradient(top, <?php echo $barPrimary; ?>, <?php echo $barSecondary; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $barPrimary; ?>, <?php echo $barSecondary; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $barPrimary; ?>, <?php echo $barSecondary; ?>);
            background-image: -o-linear-gradient(top, <?php echo $barPrimary; ?>, <?php echo $barSecondary; ?>);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $barPrimary; ?>', endColorstr='<?php echo $barSecondary; ?>');
            color: <?php echo $txtPrimary; ?>;
        <?php echo $fonts; ?>
        }
        #attention-grabber span, #attention-grabber div {
            color: <?php echo $txtPrimary; ?>;
        <?php echo $fonts; ?>
        }
        #ag-submit {
            background-color: <?php echo $btnPrimary; ?>;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $btnPrimary; ?>), to(<?php echo $btnSecondary; ?>));
            background-image: -webkit-linear-gradient(top, <?php echo $btnPrimary; ?>, <?php echo $btnSecondary; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $btnPrimary; ?>, <?php echo $btnSecondary; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $btnPrimary; ?>, <?php echo $btnSecondary; ?>);
            background-image: -o-linear-gradient(top, <?php echo $btnPrimary; ?>, <?php echo $btnSecondary; ?>);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $btnPrimary; ?>', endColorstr='<?php echo $btnSecondary; ?>');
            border: 1px solid <?php echo $btnSecondary; ?>;
            color: <?php echo $btnText; ?>;
        }
        #ag-submit:hover {
            background-color: <?php echo $btnPrimaryHover; ?>;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $btnPrimaryHover; ?>), to(<?php echo $btnSecondaryHover; ?>));
            background-image: -webkit-linear-gradient(top, <?php echo $btnPrimaryHover; ?>, <?php echo $btnSecondaryHover; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $btnPrimaryHover; ?>, <?php echo $btnSecondaryHover; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $btnPrimaryHover; ?>, <?php echo $btnSecondaryHover; ?>);
            background-image: -o-linear-gradient(top, <?php echo $btnPrimaryHover; ?>, <?php echo $btnSecondaryHover; ?>);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $btnPrimaryHover; ?>', endColorstr='<?php echo $btnSecondaryHover; ?>');
            border: 1px solid <?php echo $btnSecondaryHover; ?>;
            color: <?php echo $btnTextHover; ?>;
        }
        #ag-submit:active {
            background-color: <?php echo $btnPrimaryActive; ?>;
            background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $btnPrimaryActive; ?>), to(<?php echo $btnSecondaryActive; ?>));
            background-image: -webkit-linear-gradient(top, <?php echo $btnPrimaryActive; ?>, <?php echo $btnSecondaryActive; ?>);
            background-image: -moz-linear-gradient(top, <?php echo $btnPrimaryActive; ?>, <?php echo $btnSecondaryActive; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $btnPrimaryActive; ?>, <?php echo $btnSecondaryActive; ?>);
            background-image: -o-linear-gradient(top, <?php echo $btnPrimaryActive; ?>, <?php echo $btnSecondaryActive; ?>);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $btnPrimaryActive; ?>', endColorstr='<?php echo $btnSecondaryActive; ?>');
            border: 1px solid <?php echo $btnSecondaryActive; ?>;
            color: <?php echo $btnTextActive; ?>;
        }
    </style>


    <?php
    $prompt = stripcslashes($sunrise->get_option( 'text-prompt' ));
    $additionalText = stripcslashes($sunrise->get_option('text-additional'));
    $showEmailBox = stripcslashes($sunrise->get_option( 'collect-emails' ));
    $buttonText = stripcslashes($sunrise->get_option( 'text-cta' ));
    $thanks = stripcslashes($sunrise->get_option( 'text-thanks' ));

    $buttonHref = $sunrise->get_option( 'button-href' );
    $buttonTitle = $sunrise->get_option( 'button-title' );

    $domain = get_option('siteurl');
    $domain = str_replace('http://', '', $domain);
    $domain = str_replace('www.', '', $domain);
    $utmData = "?utm_source=" . $domain . "&utm_medium=attentionGrabber&utm_campaign=poweredBy";

    $emailProvider = $sunrise->get_option('email-service-provider');
    $usingCustomerIO = ($emailProvider == 'customerio' || $emailProvider == "");
    $cIoSiteID = $sunrise->get_option( 'customer-io-site-id' );
    $mailChimpApiKey = $sunrise->get_option( 'mailchimp-api-key' );

    $newTab = $sunrise->get_option( 'new-tab' );
    $buttonTarget = "";
    if( $newTab ) {
        $buttonTarget = ' target="_blank"';
    }

    if( $prompt || $additionalText || $buttonText ) {
        ?>
        <!-- Attention Grabber -->
        <div id="attention-grabber" class="hidden">
            <a id="ag-created-by" href="http://conversioninsights.net/<?php echo $utmData; ?>" title="Powered by Conversion Insights: Boost your online revenue.">
                <img src="<?php echo plugins_url( 'attention-grabber-hello-bar-alternative/assets/images/conversion-insights-checkmark-' . $check . '-32.png') ?>" height="26" alt="Powered by Conversion Insights: Boost your online revenue." />
            </a>
            <a id="ag-go-away" class="arrow-up">&nbsp;</a>
            <div id="ag-container" <?php if( !$showEmailBox ) echo 'class="pad-top"';?> >
                <span class="prompt"><?php echo $prompt; ?></span>
                <?php if( $showEmailBox ) { ?>
                    <form id="ag-email-form">
                        <input type="email" id="ag-email" placeholder="Email address">
                        <?php if( $buttonText ) { ?>
                            <button type="submit" id="ag-submit"><?php echo $buttonText; ?></button>
                        <?php } ?>
                    </form>
                <?php } else if($buttonText) { ?>
                    <a id="ag-submit" href="<?php echo $buttonHref; ?>" title="<?php echo $buttonTitle; ?>"<?php echo $buttonTarget;?>><?php echo $buttonText; ?></a>
                <?php } ?>
                <span id="ag-additional"><?php echo $additionalText; ?></span>
            </div>
            <div id="ag-thanks-container" class="pad-top" style="display: none;">
                <span><?php echo $thanks; ?></span>
            </div>
        </div>
        <script>
            <?php if( $usingCustomerIO ) { ?>
            var customerIoSiteID = '<?php echo $cIoSiteID; ?>';

            var _cio = _cio || [];
            (function() {
                var a,b,c;a=function(f){return function(){_cio.push([f].
                    concat(Array.prototype.slice.call(arguments,0)))}};b=["identify",
                    "sidentify","track"];for(c=0;c<b.length;c++){_cio[b[c]]=a(b[c])};
                var t = document.createElement('script'),
                    s = document.getElementsByTagName('script')[0];
                t.async = true;
                t.id    = 'cio-tracker';
                t.setAttribute('data-site-id', customerIoSiteID);
                t.src = 'https://assets.customer.io/assets/track.js';
                s.parentNode.insertBefore(t, s);
            })();
            <?php } else { ?>

            <?php } ?>
        </script>
    <?php
    }
}



<!doctype html >
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta charset="<?php bloginfo( 'charset' );?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


    <?php
    $tds_favicon_upload = td_get_option('tds_favicon_upload');
    if (!empty($tds_favicon_upload)) {
        echo '<link rel="icon" type="image/png" href="' . $tds_favicon_upload . '">';
    }

    //require_once get_template_directory() . '/includes/generators/td_css_generator.php'; //css generated from theme customizer settings
    //require_once get_template_directory() . '/includes/generators/td_js_generator.php'; //js generated from theme customizer settings

    //add the comments reply to script on single pages
    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    }


    wp_head();

    ?>

</head>

<body <?php body_class() ?>>


<?php

//echo td_get_option('tds_header_style');

$tds_header_style = td_get_option('tds_header_style');


if (TD_DEBUG_PAGE_SLUGS_CUSTOM === true) {
    global $wp_query;
    //$post_id = $wp_query->post->ID;

    if (!empty($wp_query->post)) {

        $td_db_header = get_post_meta($wp_query->post->ID, 'td_db_header', true);
        if (!empty($td_db_header)) {
            $tds_header_style = $td_db_header;
        }
    }

}



switch ($tds_header_style) {
    case '2':
        get_template_part('parts/td_header_2');
        get_template_part('parts/td_menu_1');
        break;

    case '3':
        get_template_part('parts/td_top_line');
        get_template_part('parts/td_header_1');
        get_template_part('parts/td_menu_1');

        break;


    case '4':
        get_template_part('parts/td_top_line');
        get_template_part('parts/td_header_4');
        get_template_part('parts/td_menu_1');
        break;


    case '5':
        get_template_part('parts/td_menu_2'); //full width menu
        get_template_part('parts/td_header_5');
        break;

    default:
        get_template_part('parts/td_top_line');
        get_template_part('parts/td_header_3');
        get_template_part('parts/td_menu_1');

        break;
}

?>






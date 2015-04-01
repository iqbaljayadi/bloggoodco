<?php
/*
    tagDiv - 2013
    Our portofolio:  http://themeforest.net/user/tagDiv/portfolio
*/



/*
 * theme specific config values
 */
require_once('includes/td_config.php');


/*
 * theme specific config values
 */
require_once('includes/td_global.php');

/*
 * Util class
 */
require_once('includes/td_util.php' );




/*
 * theme specific config values
 */
require_once('translation/td_translate.php');

/*
 * the code that runs on the first install of the theme
 */
require_once('includes/td_first_install.php');

/*
 * The social icons
 */
require_once('includes/td_social_icons.php' );


/*
 * author meta support
 */
require_once('wp-admin/td_author.php' );



/*
 * Review
 */
require_once('includes/td_review.php' );



/*
 * if debug
 */
if (TD_DEBUG_LIVE_THEME_STYLE) {
    require_once('includes/debug/td_theme_style.php' );
}

if (TD_DEBUG_IOS_REDIRECT) {
    require_once('includes/debug/td_ios_redirect.php' );
}


/*  ----------------------------------------------------------------------------
    widgets
 */
require_once('includes/widget_builder/td_widget_builder.php');
require_once('includes/widget_builder/widgets/td_widget_tab.php');
require_once('includes/widget_builder/widgets/td_block1_widget.php');
require_once('includes/widget_builder/widgets/td_block2_widget.php');
require_once('includes/widget_builder/widgets/td_block3_widget.php');
require_once('includes/widget_builder/widgets/td_block4_widget.php');
require_once('includes/widget_builder/widgets/td_block5_widget.php');
//require_once('includes/widget_builder/widgets/td_block6_widget.php');
require_once('includes/widget_builder/widgets/td_social_widget.php');
require_once('includes/widget_builder/widgets/td_slide_widget.php');
require_once('includes/widget_builder/widgets/td_gallery_widget.php');
require_once('includes/widget_builder/widgets/td_ad_box_widget.php');
require_once('includes/widget_builder/widgets/td_footer_logo_widget.php');



/*  ----------------------------------------------------------------------------
    ajax
 */
require_once("includes/td_ajax_block.php");


/*  ----------------------------------------------------------------------------
    vide thumbnail support
 */
require_once('includes/td_video_support.php');



/*  ----------------------------------------------------------------------------
    css generator
 */
require_once get_template_directory() . '/includes/generators/td_css_generator_v_2.php'; //css generated from theme customizer settings
//require_once get_template_directory() . '/includes/generators/td_js_generator.php'; //js generated from theme customizer settings


/*  ----------------------------------------------------------------------------
    js generator
 */
require_once get_template_directory() . '/includes/generators/td_js_generator.php';



/*  ----------------------------------------------------------------------------
    CSS
 */

function td_load_css() {
    if (is_admin()) {
        wp_enqueue_style('td-wp-admin', get_template_directory_uri() . '/wp-admin/css/wp-admin-style.css', false, TD_THEME_VERSION, 'all' );
        wp_enqueue_style('td-panel', get_template_directory_uri() . '/wp-admin/css/wp-admin-td-panel.css', false, TD_THEME_VERSION, 'all' );
        return;
    }

    //google fonts
    /*
    wp_enqueue_style('google-font-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin'); //used on menus/small text
    wp_enqueue_style('google-font-arimo', 'http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic'); //used on content
    wp_enqueue_style('google-font-ubuntu', 'http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic'); //used on content
    wp_enqueue_style('google-font-oswald', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700'); //used on content
    */
    wp_enqueue_style('google-font-rest', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Arimo:400,700,400italic,700italic|Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic|Oswald:400,300,700'); //used on menus/small text

    //custom bootstrap
    switch(td_get_option('tds_responsive')) {
        case '980':
            wp_enqueue_style('td-bootstrap', get_template_directory_uri() . '/external/td-bootstrap-980.css', array('js_composer_front'), TD_THEME_VERSION, 'all' );
            break;

        case '1200':
            wp_enqueue_style('td-bootstrap', get_template_directory_uri() . '/external/td-bootstrap-1200.css', array('js_composer_front'), TD_THEME_VERSION, 'all' );
            break;

        default:
            wp_enqueue_style('td-bootstrap', get_template_directory_uri() . '/external/td-bootstrap.css', array('js_composer_front'), TD_THEME_VERSION, 'all' );
            break;
    }


    //theme css, do not load on loagin page, load the composer plugin first
    if (!is_login_page()) {
        if (TD_DEBUG_USE_LESS) {
            wp_enqueue_style('td-theme', get_template_directory_uri() . '/theme-style.php', array('td-bootstrap'), TD_THEME_VERSION, 'all' );
            //wp_enqueue_style('td-theme', get_template_directory_uri() . '/theme-style.php', '', TD_THEME_VERSION, 'all' );
        } else {
            wp_enqueue_style('td-theme', get_stylesheet_uri(), array('td-bootstrap'), TD_THEME_VERSION, 'all' );
        }
    }

}
add_action('init', 'td_load_css');



/*  ----------------------------------------------------------------------------
    Javescript
 */

function td_load_js() {

    if (is_admin()) {

        wp_enqueue_script('theme-wp-js', get_template_directory_uri() . '/wp-admin/js/wp-admin-js.js', array('jquery', 'wpb_jscomposer_stage_js'), 1, true);
        return;
    }


    wp_enqueue_script('site', get_template_directory_uri() . '/js/site.js',array( 'jquery' ), 1, false); //load at begining
    wp_enqueue_script('site-external', get_template_directory_uri() . '/js/external.js',array( 'site' ), 1, false); //load at begining

    //JS: html5 shiv for ie8 - this has to be loaded in the header
    //wp_enqueue_script('html5shiv', 'http://html5shiv.googlecode.com/svn/trunk/html5.js','', 1, false);

    //flex slider
    //wp_enqueue_script('td-flex', get_template_directory_uri() . '/external/flexslider/jquery.flexslider-min.js','', 1, false);

    //JS:

    //wp_enqueue_script('easing', get_template_directory_uri() . '/external/jquery.easing-1.3.js','', 1, true);
    //wp_enqueue_script('ioslider', get_template_directory_uri() . '/external/jquery.iosslider.min.js','', 1, true);

    //wp_enqueue_script('ssub', get_template_directory_uri() . '/external/superfish-master/js/supersubs.js','', 1, true);
    //wp_enqueue_script('responsive-menu', get_template_directory_uri() . '/external/Responsive-Menu-master/jquery.mobilemenu.min.js','', 1, true);
    //wp_enqueue_script('menuhover', get_template_directory_uri() . '/external/superfish-master/js/hoverIntent.js','', 1, true);
    //wp_enqueue_script('menu', get_template_directory_uri() . '/external/superfish-master/js/superfish.js','', 1, true);


    //wp_enqueue_script('affix', get_template_directory_uri() . '/external/bootstrap-master/js/bootstrap-affix.js','', 1, true);

    //wp_enqueue_script('collapse', get_template_directory_uri() . '/external/bootstrap-master/js/bootstrap-dropdown.js','', 1, true);

    //wp_enqueue_script('waypoints', get_template_directory_uri() . '/external/waypoints/waypoints.min.js','', 1, true);


    //wp_register_script( 'jquery_ui_tabs_rotate', $this->composer->assetURL( 'jquery-ui-tabs-rotate/jquery-ui-tabs-rotate.js' ), array( 'jquery', 'jquery-ui-tabs' ), WPB_VC_VERSION, true);
    wp_enqueue_script('td-js-composer', get_template_directory_uri() . '/external/js_composer/js_composer_front.js',array( 'jquery', 'jquery-ui-tabs' ), 1, true);


}
add_action('init', 'td_load_js');





/*  ----------------------------------------------------------------------------
    Custom <title> wp_title
 */
function td_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . __td('Page') . ' ' .  max( $paged, $page );

    return $title;
}
add_filter( 'wp_title', 'td_wp_title', 10, 2 );






/*  ----------------------------------------------------------------------------
    Pagebuilder
 */

global $td_row_count, $td_column_count;

$td_row_count = 0;
$td_column_count = 0;

$dir = dirname(__FILE__) . '/wpbakery';

$composer_settings = Array(
    'APP_ROOT'      => $dir . '/js_composer',
    'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
    'APP_DIR'       => basename( $dir ) . '/js_composer/',
    'CONFIG'        => $dir . '/js_composer/config/',
    'ASSETS_DIR'    => 'assets/',
    'COMPOSER'      => $dir . '/js_composer/composer/',
    'COMPOSER_LIB'  => $dir . '/js_composer/composer/lib/',
    'SHORTCODES_LIB'  => $dir . '/js_composer/composer/lib/shortcodes/',

    /* for which content types Visual Composer should be enabled by default */
    'default_post_types' => Array('page')
);

//print_r($composer_settings);

require_once locate_template('/wpbakery/js_composer/js_composer.php');



//pagebuilder map
require_once('includes/pagebuilder/td_pagebuilder.php');


/*
 * Post generator
 */
require_once('includes/td_page_generator/td_page_parts.php' );

/*
 * Page generator
 */
require_once('includes/td_page_generator/td_page_generator.php' );

/*
 * td_template_layout
 */
require_once('includes/td_page_generator/td_template_layout.php' );


$wpVC_setup->init($composer_settings);





/*  ----------------------------------------------------------------------------
    Category metadata
 */

require_once("wp-admin/external/Tax-meta-class/Tax-meta-class.php");
if (is_admin()){
  /*
   * configure your meta box
   */
  $config = array(
    'id' => 'demo_meta_box',          // meta box id, unique per meta box
    'title' => 'Demo Meta Box',          // meta box title
    'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );


  /*
   * Initiate your meta box
   */
  $my_meta =  new Tax_Meta_Class($config);

  /*
   * Add fields to your meta box
   */

    $module_array = array(
        '' => 'default',
        'mod2' => 'module 2',
        'mod3' => 'module 3',
        'mod4' => 'module 4',
        'mod5' => 'module 5',
        'mod6' => 'module 6'
    );
    //layout
    $my_meta->addSelect('tdc_layout', $module_array, array('name'=> __('Layout ','tax-meta'), 'std'=> array('')));

    //sidebar position:
    $my_meta->addSelect('tdc_sidebar_pos',  array(''=>'default', 'sidebar_right'=>'Right sidebar', 'sidebar_left'=>'Left sidebar', 'no_sidebar'=>'No sidebar'), array('name'=> __('Sidebar position ','tax-meta'), 'std'=> array('')));

    //slider
    $my_meta->addSelect('tdc_slider', array(''=>'Show on all pages', 'page_one'=>'Show only on page 1', 'hide_slider'=>'Hide slider'), array('name'=> __('Show featured slider on category ','tax-meta'), 'std'=> array('')));

    //Category color
    $my_meta->addColor('tdc_color', array('name'=> __('Category color ','tax-meta')));

    //background image
    $my_meta->addImage('tdc_image', array('name'=> __('Category background ','tax-meta')));
    $my_meta->addSelect('tdc_image_style', array(''=> 'default', 'yes'=>'Stretch', 'tile'=>'Tile'),array('name'=> __('background style ','tax-meta'), 'std'=> array('')));



    //category sidebar
    $currentSidebars = td_get_option('sidebars'); //read the sidebars
    $categorySidebar = array();

    $categorySidebar[''] = 'Default sidebar';
    if (!empty($currentSidebars)) {
        foreach ($currentSidebars as $sidebar) {
            $categorySidebar[$sidebar] = $sidebar;
        }
    }

    if (count($categorySidebar) > 0) {
      $my_meta->addSelect('tdc_sidebar_name', $categorySidebar, array('name'=> __('Category sidebar','tax-meta'), 'std'=> array('')));
    }
    $my_meta->Finish();
}



/*  ----------------------------------------------------------------------------
    page view counter
 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);







/*  ----------------------------------------------------------------------------
    add span wrap for category number in widget
 */

add_filter('wp_list_categories', 'cat_count_span');
function cat_count_span($links) {
  $links = str_replace('</a> (', ' (', $links);
  $links = str_replace(')', ')</a>', $links);
  return $links;
}

//fix archives widget
add_filter('get_archives_link', 'archive_count_no_brackets');
function archive_count_no_brackets($links) {
    $links = str_replace('</a>&nbsp;(', ' (', $links);
    $links = str_replace(')', ')</a>', $links);
    return $links;
}


//remove gallery style css
add_filter( 'use_default_gallery_style', '__return_false' );



function remove_more_link_scroll( $link ) {

	$link = preg_replace( '|#more-[0-9]+|', '', $link );

        $link = '<div class="more-link-wrap wpb_button wpb_btn-danger">' . $link . '</div>';
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );



/*  ----------------------------------------------------------------------------
    excerpt lenght
 */

add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
    $excerpt_length = td_get_option('tds_wp_default_excerpt');
    if (!empty($excerpt_length) and is_numeric($excerpt_length)) {
        return $excerpt_length;
    } else {
        return 22; //default
    }
}



/*  ----------------------------------------------------------------------------
    more text
 */

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($text){
	return ' ';
}



/*  ----------------------------------------------------------------------------
    editor style
 */

add_editor_style();



/*  ----------------------------------------------------------------------------
    thumbnails
 */

//the image sizes that we use
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(120, 76, true );
add_image_size('art-thumb', 120, 76, true);


$featured_image_height = td_get_option('td_featured_image_height');
if (!empty($featured_image_height) and is_numeric($featured_image_height)) {
    add_image_size('featured-image', 700, $featured_image_height, true);
} else {
    add_image_size('featured-image', 700, 352, true);
}


add_image_size('art-big-2col', 326, 170, true);
add_image_size('art-big-1col', 326, 235, true);
//add_image_size('art-slide', 326, 406, true);
add_image_size('art-slide-med', 700, 352, true);
add_image_size('art-slide-big', 1074, 506, true);

add_image_size('art-gal', 220, 220, true);
add_image_size('side', 326, 132, true); //sidebar


//add_image_size('arhive', 220, 132, true);



/*  ----------------------------------------------------------------------------
    Post formats
 */

add_theme_support('post-formats', array('gallery', 'video'));



/*  ----------------------------------------------------------------------------
    localization
 */

function my_theme_setup(){
    load_theme_textdomain(TD_THEME_NAME, get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'my_theme_setup');



/*  ----------------------------------------------------------------------------
    background support
 */


add_theme_support('custom-background', array(
    'default-color' => 'fcfcfc',
    'default-image' => ''
));


/*  ----------------------------------------------------------------------------
    background support
 */
//custom headers
/*
$defaults = array(
    'default-image'          => '',
    'random-default'         => false,
    'width'                  => '1172',
    'height'                 => '',
    'flex-height'            => true,
    'flex-width'             => true,
    'default-text-color'     => '000000',
    'header-text'            => true,
    'uploads'                => true,
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );
*/

/*  ----------------------------------------------------------------------------
    shortcodes in widgets
 */

add_filter('widget_text', 'do_shortcode');



/*  ----------------------------------------------------------------------------
    content width
 */

if (!isset($content_width)) {
    $content_width = 995;
}


/*  ----------------------------------------------------------------------------
    rss supporrt
 */

add_theme_support('automatic-feed-links');



/*  ----------------------------------------------------------------------------
    Register the themes default menus
 */

function register_my_menus() {
  register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu', TD_THEME_NAME),
        'footer-menu' => __( 'Footer Menu', TD_THEME_NAME)
      )
  );
}
add_action( 'init', 'register_my_menus' );



/*  ----------------------------------------------------------------------------
    Register the themes default sidebars + dinamic ones
 */

//register the default sidebar
register_sidebar(array(
    'name'=> TD_THEME_NAME . ' default',
    'before_widget' => '<aside class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<div class="block-title"><span>',
    'after_title' => '</span></div>'
));

register_sidebar(array(
        'name'=>'Footer 1',
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<div class="block-title"><span>',
        'after_title' => '</span></div>'
    ));

register_sidebar(array(
        'name'=>'Footer 2',
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<div class="block-title"><span>',
        'after_title' => '</span></div>'
    ));

register_sidebar(array(
        'name'=>'Footer 3',
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<div class="block-title"><span>',
        'after_title' => '</span></div>'
    ));



//get our custom dinamic sidebars
$currentSidebars = td_get_option('sidebars');

//if we have user made sidebars, register them in wp
if (!empty($currentSidebars)) {
    foreach ($currentSidebars as $sidebar) {
        register_sidebar(array(
            'name'=>$sidebar,
            'before_widget' => '<aside class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<div class="block-title"><span>',
            'after_title' => '</span></div>',
        ));

    } //end foreach
}

register_sidebar(array(
    'name'=>'Top ad',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
));
/*  -----------------------------------------------------------------------------
    WP-ADMIN section
 */



/*
 * the wp-admin panels
 */

require_once('wp-admin/td_mvc/td_controller.php');

//require_once('wp-admin/td_mvc/td_theme_ads.php');
//require_once('wp-admin/td_mvc/td_theme_adwords.php');
//require_once('wp-admin/td_mvc/td_theme_analytics.php');
//require_once('wp-admin/td_mvc/td_theme_fonts.php');

//require_once('wp-admin/td_mvc/td_theme_sidebars.php');
//require_once('wp-admin/td_mvc/td_theme_translation.php');

/*
 * the wp-admin TinyMCE editor buttons
 */
//require_once('wp-admin/tinymce/tinymce.php');



/*
 * Custom content metaboxes (the select sidebar dropdown/post etc)
 */
require_once ('wp-admin/content-metaboxes/td-metabox-setup.php');




/*
 * Theme customizer
 */
include 'wp-admin/theme-customizer/settings.php';






//the bottom code for analitics and stuff
function td_bottom_code() {
    $td_analytics = td_get_option('td_analytics');
    echo stripslashes($td_analytics);
    echo '

    <!--
        Theme: ' . TD_THEME_NAME .' by tagDiv 2013
        Version: ' . TD_THEME_VERSION . ' (rara)
    -->

    ';


    $authorMetaGoogle = get_the_author_meta('googleplus');
    if (!empty($authorMetaGoogle)) {
        echo '<a href="' . $authorMetaGoogle . '?rel=author"></a>';
    }
}
add_action('wp_footer', 'td_bottom_code');


//Append page slugs to the body class
function add_slug_to_body_class( $classes ) {
        global $post;



        if( is_home() ) {
                $key = array_search( 'blog', $classes );
                if($key > -1) {
                        unset( $classes[$key] );
                };
        } elseif( is_page() ) {
                $classes[] = sanitize_html_class( $post->post_name );
        } elseif(is_singular()) {
                $classes[] = sanitize_html_class( $post->post_name );
        };

        $i = 0;
        foreach ($classes as $key => $value) {
            $pos = strripos($value, 'span');
            if ($pos !== false) {
                unset($classes[$i]);
            }

            $pos = strripos($value, 'row');
            if ($pos !== false) {
                unset($classes[$i]);
            }

            $pos = strripos($value, 'container');
            if ($pos !== false) {
                unset($classes[$i]);
            }

            //remove the custom background - we add it later via js :0
            if ($value == 'custom-background') {
                unset($classes[$i]);
            }

            $classes[] = 'td-custom-background';

            $i++;
        }

        return $classes;
}
add_filter('body_class', 'add_slug_to_body_class');


//remove span row container classes from post_class()
function add_slug_to_post_class( $classes ) {
    $i = 0;
    foreach ($classes as $key => $value) {
        $pos = strripos($value, 'span');
        if ($pos !== false) {
            unset($classes[$i]);
        }

        $pos = strripos($value, 'row');
        if ($pos !== false) {
            unset($classes[$i]);
        }

        $pos = strripos($value, 'container');
        if ($pos !== false) {
            unset($classes[$i]);
        }
        $i++;
    }
    return $classes;
}
add_filter('post_class', 'add_slug_to_post_class');


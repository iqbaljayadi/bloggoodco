<?php 
/*
 * This is the config file for the theme.
 */


define("TD_THEME_NAME", "Magazinly");
define("TD_THEME_NAME_URL", "Magazines");

define("TD_THEME_VERSION", "1.6.2");

define("TD_THEME_DOC_URL", "http://import.tagdiv.com/" . strtolower(TD_THEME_NAME_URL) . "/doc");
define("TD_THEME_DEMO_URL", "http://demo.tagdiv.com/magazinly");
define("TD_THEME_DEMO_XML_URL", "http://import.tagdiv.com/" . strtolower(TD_THEME_NAME_URL) . '/xml.zip');


define("TD_FEATURED_CAT", "Featured"); //featured cat name
define("TD_FEATURED_CAT_SLUG", "featured"); //featured cat slug

define("TD_THEME_OPTIONS_NAME", "td_007"); //where to store our options





//internal debugging option, should be false for release

define("TD_DEBUG_LIVE_THEME_STYLE", false);


define("TD_DEBUG_PAGE_SLUGS_CUSTOM", false); //load customizations based on pageslugs (used in demo)
define("TD_DEBUG_IOS_REDIRECT", false);
define("TD_DEBUG_USE_LESS", false);


?>
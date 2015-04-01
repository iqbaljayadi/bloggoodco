<?php
$td_translation_map = array(
    //header
    'Search...' => __('Search...', TD_THEME_NAME),
    'HOME' => __('HOME', TD_THEME_NAME),
    'CATEGORIES' => __('CATEGORIES', TD_THEME_NAME),

    //title tag
    'Page' => __('Page', TD_THEME_NAME),


    //blocks
    'by' => __('by', TD_THEME_NAME),
    'Load more' => __('Load more', TD_THEME_NAME),

    //breadcrumbs
    'View all posts in' => __('View all posts in', TD_THEME_NAME),

    //article / page
    'Previous article' => __('Previous article', TD_THEME_NAME),
    'Next article' => __('Next article', TD_THEME_NAME),
    'Author' => __('Author', TD_THEME_NAME),
    'More articles from author' => __('More articles from author', TD_THEME_NAME),
    'Similar articles' => __('Similar articles', TD_THEME_NAME),
    'source' => __('source', TD_THEME_NAME),
    'via' => __('via', TD_THEME_NAME),
    'Continue' => __('Continue', TD_THEME_NAME),

    //comments
    'Name:' => __('Name:', TD_THEME_NAME),
    'Email:' => __('Email:', TD_THEME_NAME),
    'Website:' => __('Website:', TD_THEME_NAME),
    'Comment:' => 'Comment:',
    'Leave a Reply' => __('Leave a Reply', TD_THEME_NAME),
    'Post Comment' => __('Post Comment', TD_THEME_NAME),
    'Cancel reply' => __('Cancel reply', TD_THEME_NAME),
    'Reply' => __('Reply', TD_THEME_NAME),
    'Log in to leave a comment' => __('Log in to leave a comment', TD_THEME_NAME),
    'No replies' => __('No replies', TD_THEME_NAME),
    '1 reply' => __('1 reply', TD_THEME_NAME),
    'replies' => __('replies', TD_THEME_NAME),
    'to this post' => __('to this post', TD_THEME_NAME),

    //review
    'Review overview' => __('Review overview', TD_THEME_NAME),
    'Summary' => __('Summary', TD_THEME_NAME),

    //404

    '404 Error - page not found' => __('404 Error - page not found', TD_THEME_NAME),
    'Our latest posts' => __('Our latest posts', TD_THEME_NAME),

    'Search Results for:' => __('Search Results for:', TD_THEME_NAME),
    'No results for your search' => __('No results for your search', TD_THEME_NAME),
    'No posts to display' => __('No posts to display', TD_THEME_NAME)

);

$td_translation_map_user = td_get_option('td_translation_map_user');


//the custom translation function
function __td($td_string, $td_domain = '') {
    global $td_translation_map_user, $td_translation_map;

    if (!empty($td_translation_map_user[$td_string])) {
        //return the user translation
        return $td_translation_map_user[$td_string];

    } elseif (!empty($td_translation_map[$td_string])) {
        //return the default translation
        return $td_translation_map[$td_string];

    } else {
        //no translation detected
        return $td_string;
    }
}



//echo custom translation function
function _etd($td_string, $td_domain = '') {
    echo __td($td_string, $td_domain);
}


?>
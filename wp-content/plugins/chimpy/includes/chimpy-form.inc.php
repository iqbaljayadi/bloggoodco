<?php
/**
 * Renders signup form
 * 
 * @return void
 */
if (!function_exists('chimpy_form')) {
    function chimpy_form()
    {
        $opt = get_option('chimpy_options', $results);

        // Check if integration is enabled
        if (!$opt || !is_array($opt) || empty($opt) || !isset($opt['chimpy_enabled']) || !$opt['chimpy_enabled']) {
            return;
        }

        // Check if at least one form is defined
        if (!isset($opt['forms']) || empty($opt['forms'])) {
            return;
        }

        $form = Chimpy::select_form_by_conditions($opt['forms']);

        $html = chimpy_prepare_form($form, $opt, 'shortcode');

        echo $html;
    }
}

?>
<?php
/**
 * Returns generated form to be displayed
 * 
 * @param array $form
 * @param array $opt
 * @param string $context
 * @param mixed $widget_args
 * @return string
 */
if (!function_exists('chimpy_prepare_form')) {
    function chimpy_prepare_form($form, $opt, $context, $widget_args = null)
    {
        // Extract form id and form settings
        reset($form);
        $form_key = key($form);
        $form = array_pop($form);

        // Get appropriate width limit
        if ($context == 'after_posts') {
            $width_limit = $opt['chimpy_width_limit_after_posts'];
        }
        else if ($context == 'popup') {
            $width_limit = $opt['chimpy_width_limit_popup'];
        }
        else if ($context == 'shortcode') {
            $width_limit = $opt['chimpy_width_limit_shortcode'];
        }
        else {
            $width_limit = null;
        }

        // Title
        $title = ($context == 'widget') ? apply_filters('widget_title', $form['title']) : $form['title'];

        // Color scheme class and css override class
        $custom_classes = ($form['color_scheme'] != 'cyan' ? 'sky-form-' . $form['color_scheme'] . ' ' : '') . 'chimpy_custom_css';

        // Form validation rules
        $validation_rules = array(
            'chimpy_' . $context . '_subscribe[email]' => array(
                'required'  => true,
                'email'     => true,
            ),
        );

        foreach ($form['fields'] as $field) {
            $validation_rules['chimpy_' . $context . '_subscribe[custom][' . $field['tag'] . ']'] = array(
                'required'  => true,
            );
        }

        $validation_rules = json_encode($validation_rules);

        // Form validation error messages
        $validation_messages = array(
            'chimpy_' . $context . '_subscribe[email]' => array(
                'required'  => $opt['chimpy_label_empty_field'],
                'email'     => $opt['chimpy_label_email_invalid'],
            ),
        );

        foreach ($form['fields'] as $field) {
            $validation_messages['chimpy_' . $context . '_subscribe[custom][' . $field['tag'] . ']'] = array(
                'required'  => $opt['chimpy_label_empty_field'],
            );
        }

        $validation_messages = json_encode($validation_messages);

        // Start building form
        $html = '';

        // Ajax URL
        $html .= '<script>var chimpy_ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';

        // Override CSS
        $html .= '<style>' . $form['css_override'] . '</style>';

        // Container
        $html .= '<div class="chimpy-reset chimpy_' . $context . '_content" ' . ($width_limit ? 'style="max-width:' . $width_limit . 'px;"' : '') . '>';

        // Before widget (if it's widget)
        $html .= $widget_args['before_widget'];

        // Start form
        $html .= '<form id="chimpy_' . $context . '" class="chimpy_signup_form sky-form ' . $custom_classes . '">';

        // Form ID
        $html .= '<input type="hidden" name="chimpy_' . $context . '_subscribe[form]" value="' . $form_key . '">';

        // Context
        $html .= '<input type="hidden" id="chimpy_form_context" name="chimpy_' . $context . '_subscribe[context]" value="' . $context . '">';

        // Title
        if (!empty($title)) {
            $html .= '<header>' . $title . '</header>';
        }

        // Start fieldset
        $html .= '<fieldset>';

        // Email field
        $html .= '<section>';

        if (!$form['inline']) {
            $html .= '<label class="label">' . $opt['chimpy_label_email_field'] . '</label>';
        }

        $html .= '<label class="input">';

        $html .= '<input type="email" id="chimpy_' . $context . '_field_email" name="chimpy_' . $context . '_subscribe[email]" ' . ($form['inline'] ? 'placeholder="' . $opt['chimpy_label_email_field'] . '"' : '') . '></input>';

        $html .= '</label>';

        $html .= '</section>';

        // Custom fields
        foreach ($form['fields'] as $field) {
            $html .= '<section>';

            if (!$form['inline']) {
                $html .= '<label class="label">' . $field['name'] . '</label>';
            }

            $html .= '<label class="input">';

            $html .= '<input type="text" id="chimpy_' . $context . '_field_' . $field['tag'] . '" name="chimpy_' . $context . '_subscribe[custom][' . $field['tag'] . ']" ' . ($form['inline'] ? 'placeholder="' . $field['name'] . '"' : '') . '></input>';

            $html .= '</label>';

            $html .= '</section>';
        }

        // End fieldset
        $html .= '</fieldset>';

        // Processing placeholder
        $html .= '<div id="chimpy_signup_' . $context . '_processing" class="chimpy_signup_processing" style="display: none;"></div>';

        // Something went wrong...
        $html .= '<div id="chimpy_signup_' . $context . '_error" class="chimpy_signup_error" style="display: none;"><div>' . $opt['chimpy_label_error'] . '</div></div>';

        // Success
        $html .= '<div id="chimpy_signup_' . $context . '_success" class="chimpy_signup_success" style="display: none;"><div>' . $opt['chimpy_label_success'] . '</div></div>';

        // Start footer
        $html .= '<footer>';

        // Submit button
        $html .= '<button type="button" id="chimpy_' . $context . '_submit" class="button">' . $opt['chimpy_label_submit_button'] . '</button>';

        // End footer
        $html .= '</footer>';

        // End form
        $html .= '</form>';

        // Form validation rules
        $html .= '<script type="text/javascript">'
               . 'jQuery(function() {'
               . 'jQuery("#chimpy_' . $context . '").validate({'
               . 'rules: ' . $validation_rules . ','
               . 'messages: ' . $validation_messages . ','
               . 'errorPlacement: function(error, element) { error.insertAfter(element.parent()); }'
               . '});'
               . '});'
               . '</script>';

        // After widget (if it's widget)
        $html .= $widget_args['after_widget'];

        // End container
        $html .= '</div>';

        return $html;
    }
}

?>
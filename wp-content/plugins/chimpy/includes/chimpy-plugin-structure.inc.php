<?php

/*
 * Returns configuration for this plugin
 * 
 * @return array
 */
if (!function_exists('chimpy_plugin_settings')) {
    function chimpy_plugin_settings($plugin)
    {
        $settings = array(
            'chimpy' => array(
                'title' => __('MailChimp', $plugin->text_domain),
                'page_title' => __('MailChimp', $plugin->text_domain),
                'capability' => 'manage_options',
                'slug' => 'chimpy',
                'children' => array(
                    'forms' => array(
                        'title' => __('Forms', $plugin->text_domain),
                        'icon' => '<i class="fa fa-edit" style="font-size: 0.8em;"></i>',
                        'children' => array(
                            'forms' => array(
                                'title' => __('Signup Form Settings', $plugin->text_domain),
                                'children' => array(
                                ),
                            ),
                        ),
                    ),
                    'display' => array(
                        'title' => __('Display', $plugin->text_domain),
                        'icon' => '<i class="fa fa-desktop" style="font-size: 0.8em;"></i>',
                        'children' => array(
                            'widget' => array(
                                'title' => __('Widget', $plugin->text_domain),
                                'children' => array(
                                ),
                            ),
                            'posts' => array(
                                'title' => __('After Posts', $plugin->text_domain),
                                'children' => array(
                                    'form_after_posts' => array(
                                        'title' => __('Display signup form after posts', $plugin->text_domain),
                                        'type' => 'checkbox',
                                        'default' => 0,
                                        'validation' => array(
                                            'rule' => 'bool',
                                            'empty' => false
                                        ),
                                        'hint' => __('<p></p>', $plugin->text_domain),
                                    ),
                                    'width_limit_after_posts' => array(
                                        'title' => __('Form block width limit (in pixels)', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => '',
                                        'validation' => array(
                                            'rule' => 'number',
                                            'empty' => true,
                                        ),
                                    ),
                                ),
                            ),
                            /*'popup' => array(
                                'title' => __('Popup', $plugin->text_domain),
                                'children' => array(
                                    'popup_enabled' => array(
                                        'title' => __('Enable Popup', $plugin->text_domain),
                                        'type' => 'checkbox',
                                        'default' => 0,
                                        'validation' => array(
                                            'rule' => 'bool',
                                            'empty' => false
                                        ),
                                        'hint' => __('<p></p>', $plugin->text_domain),
                                    ),
                                    'popup_allow_dismissing' => array(
                                        'title' => __('Allow dismissing', $plugin->text_domain),
                                        'type' => 'checkbox',
                                        'default' => 1,
                                        'validation' => array(
                                            'rule' => 'bool',
                                            'empty' => false
                                        ),
                                        'hint' => __('<p></p>', $plugin->text_domain),
                                    ),
                                    'width_limit_popup' => array(
                                        'title' => __('Popup width limit (in pixels)', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => '',
                                        'validation' => array(
                                            'rule' => 'number',
                                            'empty' => true,
                                        ),
                                    ),
                                ),
                            ),*/
                            'shortcode' => array(
                                'title' => __('Shortcode & Function', $plugin->text_domain),
                                'children' => array(
                                    'width_limit_shortcode' => array(
                                        'title' => __('Form block width limit (in pixels)', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => '',
                                        'validation' => array(
                                            'rule' => 'number',
                                            'empty' => true,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'translation' => array(
                        'title' => __('Translation', $plugin->text_domain),
                        'icon' => '<i class="fa fa-font" style="font-size: 0.8em;"></i>',
                        'children' => array(
                            'form_field_translation' => array(
                                'title' => __('Frontend forms', $plugin->text_domain),
                                'children' => array(
                                    'label_email_field' => array(
                                        'title' => __('Email field label', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Email Address', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                    'label_submit_button' => array(
                                        'title' => __('Submit button label', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Signup', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                    'label_empty_field' => array(
                                        'title' => __('(Error) Required field empty', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Please enter a value', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                    'label_email_invalid' => array(
                                        'title' => __('(Error) Email not valid', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Please enter a valid email address', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                    'label_error' => array(
                                        'title' => __('(Error) Unknown error', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Something went wrong... Please try again later.', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                    'label_success' => array(
                                        'title' => __('Subscribed successfully', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => __('Thank you for signing up!', $plugin->text_domain),
                                        'validation' => array(
                                            'rule' => 'string',
                                            'empty' => true
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'integration' => array(
                        'title' => __('Integration', $plugin->text_domain),
                        'icon' => '<i class="fa fa-cogs" style="font-size: 0.8em;"></i>',
                        'children' => array(
                            'settings' => array(
                                'title' => __('Settings', $plugin->text_domain),
                                'children' => array(
                                    'enabled' => array(
                                        'title' => __('Enable Integration', $plugin->text_domain),
                                        'type' => 'checkbox',
                                        'default' => 0,
                                        'validation' => array(
                                            'rule' => 'bool',
                                            'empty' => false
                                        ),
                                        'hint' => __('<p>Enable or disable integration. If disabled, none of the features will be active.</p>', $plugin->text_domain),
                                    ),
                                    'api_key' => array(
                                        'title' => __('MailChimp API key', $plugin->text_domain),
                                        'type' => 'text',
                                        'default' => '',
                                        'validation' => array(
                                            'rule' => 'function',
                                            'empty' => array('enabled'),
                                        ),
                                        'hint' => sprintf(__('<p>API key is required for this plugin to communicate with MailChimp servers.</p> <p>You can read more about it <a href=\'%s\' target=\'_blank\'>here</a>.</p>', $plugin->text_domain), 'http://kb.mailchimp.com/article/where-can-i-find-my-api-key'),
                                    ),
                                ),
                            ),
                            'status' => array(
                                'title' => __('Status', $plugin->text_domain),
                                'children' => array(
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );

        return $settings;
    }
}

?>
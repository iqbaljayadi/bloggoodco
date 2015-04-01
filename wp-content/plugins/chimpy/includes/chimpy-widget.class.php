<?php

/**
 * Chimpy Plugin Widget
 * 
 * @class Chimpy_Widget
 * @package Chimpy
 * @author RightPress
 */
if (!class_exists('Chimpy_Widget')) {
    class Chimpy_Widget extends WP_Widget
    {
        /**
         * Widget constructor (registering widget with WP)
         * 
         * @access public
         * @return void
         */
        public function __construct() {
            parent::__construct(
                'chimpy_form',
                __('MailChimp Signup', 'chimpy'),
                array(
                    'description' => __('Widget displays a signup form, if enabled under MailChimp settings.', 'chimpy'),
                )
            );

            $this->opt = $this->plugin_settings();
        }

        /**
         * Load plugin settings
         * 
         * @access public
         * @return array
         */
        public function plugin_settings()
        {
            $mockup = new stdClass();
            $mockup->text_domain = 'chimpy';

            $this->settings = chimpy_plugin_settings($mockup);

            $results = array();

            // Iterate over settings array and extract values
            foreach ($this->settings as $page => $page_value) {
                foreach ($page_value['children'] as $subpage => $subpage_value) {
                    foreach ($subpage_value['children'] as $section => $section_value) {
                        foreach ($section_value['children'] as $field => $field_value) {
                            if (isset($field_value['default'])) {
                                $results['chimpy_' . $field] = $field_value['default'];
                            }
                        }
                    }
                }
            }

            return array_merge(
                $results,
                get_option('chimpy_options', $results)
            );
        }

        /**
         * Frontend display of widget
         * 
         * @access public
         * @param array $args
         * @param array $instance
         * @return void
         */
        public function widget($args, $instance)
        {
            // Check if integration is enabled
            if (!$this->opt['chimpy_enabled'] || !isset($this->opt['forms']) || empty($this->opt['forms'])) {
                return;
            }

            // Select form that match the conditions best
            $form = Chimpy::select_form_by_conditions($this->opt['forms']);

            if (!$form) {
                return;
            }

            $form_html = chimpy_prepare_form($form, $this->opt, 'widget', $args);

            echo $form_html;
        }

        /**
         * Backend configuration form
         * 
         * @access public
         * @param array $instance
         * @return void
         */
        public function form($instance)
        {
            printf(__('This widget renders a MailChimp signup form. You can edit signup forms <a href="%s">here</a>.', 'chimpy'), site_url('/wp-admin/admin.php?page=chimpy'));
        }

        /**
         * Sanitize form values
         * 
         * @access public
         * @param array $new_instance
         * @param array $old_instance
         * @return void
         */
        public function update($new_instance, $old_instance)
        {
            return array();
        }

    }
}

?>

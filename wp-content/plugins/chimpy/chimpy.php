<?php

/**
 * Plugin Name: Chimpy
 * Plugin URI: http://www.rightpress.net/chimpy
 * Description: MailChimp WordPress Plugin
 * Version: 1.0
 * Author: RightPress
 * Author URI: http://www.rightpress.net
 * Requires at least: 3.5
 * Tested up to: 3.7
 * 
 * Text Domain: chimpy
 * Domain Path: /languages
 * 
 * @package Chimpy
 * @category Core
 * @author RightPress
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define Constants
define('CHIMPY_PLUGIN_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('CHIMPY_PLUGIN_URL', plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__)));

if (!class_exists('Chimpy')) {

    /**
     * Main plugin class
     * 
     * @package Chimpy
     * @author RightPress
     */
    class Chimpy
    {
        // Define class properties
        public $prefix;
        public $prefix_dash;
        public $text_domain;

        /**
         * Class constructor
         * 
         * @access public
         * @return void
         */
        public function __construct()
        {
            // Define plugin-specific properties
            $this->prefix = 'chimpy_';
            $this->prefix_dash = 'chimpy-';
            $this->text_domain = 'chimpy';

            $this->mailchimp = null;

            // Load translation
            load_plugin_textdomain($this->text_domain, false, dirname(plugin_basename(__FILE__)) . '/languages/');

            // Load includes
            foreach (glob(CHIMPY_PLUGIN_PATH . '/includes/*.php') as $filename)
            {
                require $filename;
            }

            // Load MailChimp Wrapper
            if (!class_exists('Mailchimp')) {
                require(CHIMPY_PLUGIN_PATH . '/includes/mailchimp/Mailchimp.php');
            }

            // Load configuration and current settings
            $this->get_config();
            $this->opt = $this->get_options();

            /**
             * For admin only
             */
            if (is_admin()) {
                add_action('admin_menu', array($this, 'add_admin_menu'));
                add_action('admin_init', array($this, 'admin_construct'));
                add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_and_styles'));
                add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'plugin_settings_link'));

                // Ajax handlers
                add_action('wp_ajax_chimpy_mailchimp_status', array($this, 'ajax_mailchimp_status'));
                add_action('wp_ajax_chimpy_get_lists_with_multiple_groups_and_fields', array($this, 'ajax_get_lists_groups_fields'));
                add_action('wp_ajax_chimpy_update_groups_and_tags', array($this, 'ajax_groups_and_tags_in_array'));
            }

            /**
             * For frontend only
             */
            else {
                add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts_and_styles'));
                add_filter('the_content', array($this, 'form_after_content'));
            }

            /**
             * For all
             */
            add_action('widgets_init', create_function('', 'return register_widget("Chimpy_Widget");'));
            add_shortcode('chimpy_form', array($this, 'subscription_shortcode'));
            register_uninstall_hook(__FILE__, array('Chimpy', 'uninstall'));

            /**
             * Ajax handlers
             */
            add_action('wp_ajax_chimpy_subscribe', array($this, 'ajax_subscribe'));
            add_action('wp_ajax_nopriv_chimpy_subscribe', array($this, 'ajax_subscribe'));
        }

        /**
         * Loads (and sets) configuration values from structure file and database
         * 
         * @access public
         * @return void
         */
        public function get_config()
        {
            // Settings tree
            $this->settings = chimpy_plugin_settings($this);

            // Load some data from config
            $this->hints = $this->options('hint');
            $this->validation = $this->options('validation', true);
            $this->titles = $this->options('title');
            $this->options = $this->options('values');
            $this->section_info = $this->get_section_info();
            $this->default_tabs = $this->get_default_tabs();
        }

        /**
         * Get settings options: default, hint, validation, values
         * 
         * @access public
         * @param string $name
         * @param bool $split_by_page
         * @return array
         */
        public function options($name, $split_by_subpage = false)
        {
            $results = array();

            // Iterate over settings array and extract values
            foreach ($this->settings as $page => $page_value) {
                $page_options = array();

                foreach ($page_value['children'] as $subpage => $subpage_value) {
                    foreach ($subpage_value['children'] as $section => $section_value) {
                        foreach ($section_value['children'] as $field => $field_value) {
                            if (isset($field_value[$name])) {
                                $page_options[$this->prefix . $field] = $field_value[$name];
                            }
                        }
                    }

                    $results[preg_replace('/_/', '-', $subpage)] = $page_options;
                    $page_options = array();
                }
            }

            $final_results = array();

            // Do we need to split results by page?
            if (!$split_by_subpage) {
                foreach ($results as $value) {
                    $final_results = array_merge($final_results, $value);
                }
            }
            else {
                $final_results = $results;
            }

            return $final_results;
        }

        /**
         * Get default tab for each page
         * 
         * @access public
         * @return array
         */
        public function get_default_tabs()
        {
            $tabs = array();

            // Iterate over settings array and extract values
            foreach ($this->settings as $page => $page_value) {
                reset($page_value['children']);
                $tabs[$page] = key($page_value['children']);
            }

            return $tabs;
        }

        /**
         * Get array of section info strings
         * 
         * @access public
         * @return array
         */
        public function get_section_info()
        {
            $results = array();

            // Iterate over settings array and extract values
            foreach ($this->settings as $page_value) {
                foreach ($page_value['children'] as $subpage => $subpage_value) {
                    foreach ($subpage_value['children'] as $section => $section_value) {
                        if (isset($section_value['info'])) {
                            $results[$section] = $section_value['info'];
                        }
                    }
                }
            }

            return $results;
        }

        /*
         * Get plugin options set by user
         * 
         * @access public
         * @return array
         */
        public function get_options()
        {
            $default_options = array_merge(
                $this->options('default'),
                array(
                    'chimpy_checkout_fields' => array(),
                    'chimpy_widget_fields' => array(),
                    'chimpy_shortcode_fields' => array(),
                )
            );

            return array_merge(
                       $default_options,
                       get_option($this->prefix.'options', $this->options('default'))
                   );
        }

        /*
         * Update options
         * 
         * @access public
         * @return bool
         */
        public function update_options($args = array())
        {
            return update_option($this->prefix.'options', array_merge($this->get_options(), $args));
        }

        /**
         * Add link to admin page
         * 
         * @access public
         * @return void
         */
        public function add_admin_menu()
        {
            if (!current_user_can('manage_options')) {
                return;
            }

            add_options_page(
                $this->settings['chimpy']['page_title'],
                $this->settings['chimpy']['title'],
                $this->settings['chimpy']['capability'],
                $this->settings['chimpy']['slug'],
                array($this, 'set_up_admin_page')
            );
        }

        /*
         * Set up admin page
         * 
         * @access public
         * @return void
         */
        public function set_up_admin_page()
        {
            // Print notices
            settings_errors('chimpy');

            // Print page tabs
            $this->render_tabs();

            // Check for general warnings
            if (!$this->curl_enabled()) {
                add_settings_error(
                    'error_type',
                    'general',
                    sprintf(__('Warning: PHP cURL extension is not enabled on this server. cURL is required for this plugin to function correctly. You can read more about cURL <a href="%s">here</a>.', $this->text_domain), 'http://php.net/manual/en/book.curl.php')
                );
            }

            // Print page content
            $this->render_page();
        }

        /**
         * Admin interface constructor
         * 
         * @access public
         * @return void
         */
        public function admin_construct()
        {
            if (!admin_construct) {
                return;
            }

            // Iterate subpages
            foreach ($this->settings['chimpy']['children'] as $subpage => $subpage_value) {

                register_setting(
                    $this->prefix.'opt_group_' . $subpage,            // Option group
                    $this->prefix.'options',                          // Option name
                    array($this, 'options_validate')                  // Sanitize
                );

                // Iterate sections
                foreach ($subpage_value['children'] as $section => $section_value) {

                    add_settings_section(
                        $section,
                        $section_value['title'],
                        array($this, 'render_section_info'),
                        $this->prefix_dash.'admin-' . str_replace('_', '-', $subpage)
                    );

                    // Iterate fields
                    foreach ($section_value['children'] as $field => $field_value) {

                        add_settings_field(
                            $this->prefix . $field,                                     // ID
                            $field_value['title'],                                      // Title 
                            array($this, 'render_options_' . $field_value['type']),     // Callback
                            $this->prefix_dash.'admin-' . str_replace('_', '-', $subpage), // Page
                            $section,                                                   // Section
                            array(                                                      // Arguments
                                'name' => $this->prefix . $field,
                                'options' => $this->get_options(),
                            )
                        );

                    }
                }
            }
        }

        /**
         * Render admin page navigation tabs
         * 
         * @access public
         * @param string $current_tab
         * @return void
         */
        public function render_tabs()
        {
            // Get current page and current tab
            $current_page = preg_replace('/settings_page_/', '', $this->get_current_page_slug());
            $current_tab = $this->get_current_tab();

            // Output admin page tab navigation
            echo '<div class="chimpy-container">';
            echo '<div id="icon-chimpy" class="icon32 icon32-chimpy"><br></div>';
            echo '<h2 class="nav-tab-wrapper">';
            foreach ($this->settings as $page => $page_value) {
                if ($page != $current_page) {
                    continue;
                }

                foreach ($page_value['children'] as $subpage => $subpage_value) {
                    $class = ($subpage == $current_tab) ? ' nav-tab-active' : '';
                    echo '<a class="nav-tab'.$class.'" href="?page='.preg_replace('/_/', '-', $page).'&tab='.$subpage.'">'.((isset($subpage_value['icon']) && !empty($subpage_value['icon'])) ? $subpage_value['icon'] . '&nbsp;' : '').$subpage_value['title'].'</a>';
                }
            }
            echo '</h2>';
            echo '</div>';
        }

        /**
         * Get current tab (fallback to default)
         * 
         * @access public
         * @param bool $is_dash
         * @return string
         */
        public function get_current_tab($is_dash = false)
        {
            $tab = (isset($_GET['tab']) && $this->page_has_tab($_GET['tab'])) ? preg_replace('/-/', '_', $_GET['tab']) : $this->get_default_tab();

            return (!$is_dash) ? $tab : preg_replace('/_/', '-', $tab);
        }

        /**
         * Get default tab
         * 
         * @access public
         * @return string
         */
        public function get_default_tab()
        {
            $current_page_slug = $this->get_current_page_slug();
            return $this->default_tabs[$current_page_slug];
        }

        /**
         * Get current page slug
         * 
         * @access public
         * @return string
         */
        public function get_current_page_slug()
        {
            $current_screen = get_current_screen();
            $current_page = $current_screen->base;
            $current_page_slug = preg_replace('/settings_page_/', '', $current_page);
            return preg_replace('/-/', '_', $current_page_slug);
        }

        /**
         * Check if current page has requested tab
         * 
         * @access public
         * @param string $tab
         * @return bool
         */
        public function page_has_tab($tab)
        {
            $current_page_slug = $this->get_current_page_slug();

            if (isset($this->settings[$current_page_slug]['children'][$tab]))
                return true;

            return false;
        }

        /**
         * Render settings page
         * 
         * @access public
         * @param string $page
         * @return void
         */
        public function render_page(){

            $current_tab = $this->get_current_tab(true);

            ?>
                <div class="wrap chimpy">
                    <div class="chimpy-container">
                        <div class="chimpy-left">
                            <form method="post" action="options.php" enctype="multipart/form-data">
                                <input type="hidden" name="current_tab" value="<?php echo $current_tab; ?>" />

                                <?php
                                    settings_fields($this->prefix.'opt_group_'.preg_replace('/-/', '_', $current_tab));
                                    do_settings_sections($this->prefix_dash.'admin-' . $current_tab);

                                    if ($current_tab == 'integration') {
                                        echo '<div class="chimpy-status" id="chimpy-status"><p class="chimpy_loading"><span class="chimpy_loading_icon"></span>'.__('Connecting to MailChimp...', $this->text_domain).'</p></div>';
                                    }

                                    submit_button();
                                ?>

                            </form>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
            <?php

                /**
                 * Pass data on selected lists, groups and merge tags
                 */
                if (isset($this->opt['forms']) && is_array($this->opt['forms']) && !empty($this->opt['forms'])) {

                    $chimpy_selected_lists = array();

                    foreach ($this->opt['forms'] as $form_key => $form) {
                        $chimpy_selected_lists[$form_key] = array(
                            'list'      => $form['list'],
                            'groups'    => $form['groups'],
                            'merge'     => $form['fields']
                        );
                    }
                }
                else {
                    $chimpy_selected_lists = array();
                }

            // Pass variables to JavaScript
            ?>
                <script>
                    var chimpy_hints = <?php echo json_encode($this->hints); ?>;
                    var chimpy_home_url = '<?php echo site_url(); ?>';
                    var chimpy_label_still_connecting_to_mailchimp = '<?php _e('Still connecting to MailChimp...', $this->text_domain); ?>';
                    var chimpy_label_mailing_list = '<?php _e('Mailing list', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_list = '<?php _e('There are no lists named', $this->text_domain); ?>';
                    var chimpy_label_select_mailing_list = '<?php _e('Select a mailing list', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_groups = '<?php _e('Selected list does not have groups named', $this->text_domain); ?>';
                    var chimpy_label_select_some_groups = '<?php _e('Select some groups (optional)', $this->text_domain); ?>';
                    var chimpy_label_groups = '<?php _e('Groups', $this->text_domain); ?>';
                    var chimpy_label_fields_name = '<?php _e('Field Label', $this->text_domain); ?>';
                    var chimpy_label_fields_tag = '<?php _e('MailChimp Tag', $this->text_domain); ?>';
                    var chimpy_label_add_new = '<?php _e('Add Field', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_tags = '<?php _e('Selected list does not have tags named', $this->text_domain); ?>';
                    var chimpy_label_select_tag = '<?php _e('Select a tag', $this->text_domain); ?>';
                    var chimpy_label_connecting_to_mailchimp = '<?php _e('Connecting to MailChimp...', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_pages = '<?php _e('No pages named', $this->text_domain); ?>';
                    var chimpy_label_select_some_pages = '<?php _e('Select some pages', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_posts = '<?php _e('No posts named', $this->text_domain); ?>';
                    var chimpy_label_select_some_posts = '<?php _e('Select some posts', $this->text_domain); ?>';
                    var chimpy_label_no_results_match_post_categories = '<?php _e('No post categories named', $this->text_domain); ?>';
                    var chimpy_label_select_some_post_categories = '<?php _e('Select some post categories', $this->text_domain); ?>';
                    var chimpy_label_signup_form_no = '<?php _e('Signup Form #', $this->text_domain); ?>';
                    var chimpy_label_email = '<?php _e('Email', $this->text_domain); ?>';
                    var chimpy_label_button = '<?php _e('Submit', $this->text_domain); ?>';

                    <?php if ($current_tab == 'forms'): ?>
                    var chimpy_selected_lists = <?php echo json_encode($chimpy_selected_lists); ?>;
                    <?php endif; ?>

                 </script>
            <?php
        }

        /**
         * Render section info
         * 
         * @access public
         * @param array $section
         * @return void
         */
        public function render_section_info($section)
        {
            if (isset($this->section_info[$section['id']])) {
                echo $this->section_info[$section['id']];
            }

            if ($section['id'] == 'forms') {

                if (!$this->opt['chimpy_enabled']) {
                    ?>
                    <div class="chimpy-forms">
                        <p><?php printf(__('You must <a href="%s">enable</a> MailChimp integration to use this feature.', $this->text_domain), admin_url('/options-general.php?page=chimpy&tab=integration')); ?></p>
                    </div>
                    <?php
                }
                else {

                    /**
                     * Load list of all pages
                     */
                    $pages = array('' => '');

                    $pages_raw = get_posts(array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'page',
                    ));

                    foreach ($pages_raw as $post_key => $post) {
                        $post_name = $post->post_title;

                        if ($post->post_parent) {
                            $parent_id = $post->post_parent;
                            $has_parent = true;

                            while ($has_parent) {
                                foreach ($pages_raw as $parent_post_key => $parent_post) {
                                    if ($parent_post->ID == $parent_id) {
                                        $post_name = $parent_post->post_title . ' &rarr; ' . $post_name;

                                        if ($parent_post->post_parent) {
                                            $parent_id = $parent_post->post_parent;
                                        }
                                        else {
                                            $has_parent = false;
                                        }

                                        break;
                                    }
                                }
                            }
                        }

                        $pages[$post->ID] = $post_name;
                    }

                    /**
                     * Load list of all posts
                     */
                    $posts = array('' => '');

                    $posts_raw = get_posts(array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'post'
                    ));

                    foreach ($posts_raw as $post_key => $post) {
                        $post_name = $post->post_title;

                        if ($post->post_parent) {
                            $parent_id = $post->post_parent;
                            $has_parent = true;

                            while ($has_parent) {
                                foreach ($posts_raw as $parent_post_key => $parent_post) {
                                    if ($parent_post->ID == $parent_id) {
                                        $post_name = $parent_post->post_title . ' &rarr; ' . $post_name;

                                        if ($parent_post->post_parent) {
                                            $parent_id = $parent_post->post_parent;
                                        }
                                        else {
                                            $has_parent = false;
                                        }

                                        break;
                                    }
                                }
                            }
                        }

                        $posts[$post->ID] = $post_name;
                    }

                    /**
                     * Load list of all post categories
                     */
                    $post_categories = array('' => '');

                    $post_categories_raw = get_categories(array(
                        'type'          => 'post',
                        'hide_empty'    => 0,
                    ));

                    foreach ($post_categories_raw as $post_cat_key => $post_cat) {
                        $category_name = $post_cat->name;

                        if ($post_cat->parent) {
                            $parent_id = $post_cat->parent;
                            $has_parent = true;

                            while ($has_parent) {
                                foreach ($post_categories_raw as $parent_post_cat_key => $parent_post_cat) {
                                    if ($parent_post_cat->term_id == $parent_id) {
                                        $category_name = $parent_post_cat->name . ' &rarr; ' . $category_name;

                                        if ($parent_post_cat->parent) {
                                            $parent_id = $parent_post_cat->parent;
                                        }
                                        else {
                                            $has_parent = false;
                                        }

                                        break;
                                    }
                                }
                            }
                        }

                        $post_categories[$post_cat->term_id] = $category_name;
                    }

                    /**
                     * Available conditions
                     */
                    $condition_options = array(
                        'always'        => __('Always display this form', $this->text_domain),
                        'pages'         => __('Specific pages', $this->text_domain),
                        'posts'         => __('Specific posts', $this->text_domain),
                        'categories'    => __('Specific post categories', $this->text_domain),
                        'url'           => __('URL contains', $this->text_domain),
                    );

                    /**
                     * Available color schemes
                     */
                    $color_schemes = array(
                        'cyan'      => __('Cyan', $this->text_domain),
                        'red'       => __('Red', $this->text_domain),
                        'orange'    => __('Orange', $this->text_domain),
                        'green'     => __('Green', $this->text_domain),
                        'purple'    => __('Purple', $this->text_domain),
                        'pink'      => __('Pink', $this->text_domain),
                        'yellow'    => __('Yellow', $this->text_domain),
                        'blue'      => __('Blue', $this->text_domain),
                        'black'     => __('Black', $this->text_domain),
                    );

                    /**
                     * Load saved forms
                     */
                    if (isset($this->opt['forms']) && is_array($this->opt['forms']) && !empty($this->opt['forms'])) {

                        // Real forms
                        $saved_forms = $this->opt['forms'];

                        // Pass selected properties to Javascript
                        $chimpy_selected_lists = array();

                        foreach ($saved_forms as $form_key => $form) {
                            $chimpy_selected_lists[$form_key] = array(
                                'list'      => $form['list'],
                                'groups'    => $form['groups'],
                                'merge'     => $form['fields']
                            );
                        }
                    }
                    else {

                        // Mockup
                        $saved_forms[1] = array(
                            'title'     => '',
                            'enabled'   => '1',
                            'inline'    => '1',
                            'double'    => '1',
                            'welcome'    => '1',
                            'list'      => '',
                            'groups'    => array(),
                            'fields'    => array(),
                            'condition' => array(
                                'key'   =>  'always',
                                'value' =>  '',
                            ),
                            'color_scheme'  => 'cyan',
                            'css_override'  => '.chimpy_custom_css {}',
                        );

                        // Pass selected properties to Javascript
                        $chimpy_selected_lists = array();
                    }

                    ?>

                    <div class="chimpy-forms">
                        <div id="chimpy_forms_list">

                        <?php foreach ($saved_forms as $form_key => $form): ?>

                            <div id="chimpy_forms_list_<?php echo $form_key; ?>">
                                <h4 class="chimpy_forms_handle"><span class="chimpy_forms_title" id="chimpy_forms_title_<?php echo $form_key; ?>"><?php _e('Signup Form #', $this->text_domain); ?><?php echo $form_key; ?></span>&nbsp;<span class="chimpy_forms_title_name"><?php echo (!empty($form['title'])) ? '- ' . $form['title'] : ''; ?></span><span class="chimpy_forms_remove" id="chimpy_forms_remove_<?php echo $form_key; ?>" title="<?php _e('Remove', $this->text_domain); ?>"><i class="fa fa-times"></i></span></h4>
                                <div style="clear:both;">

                                    <div class="chimpy_forms_section"><?php _e('Main Settings', $this->text_domain); ?></div>
                                    <table class="form-table"><tbody>
                                            <tr valign="top">
                                                <th scope="row"><?php _e('Form title', $this->text_domain); ?></th>
                                                <td><input type="text" id="chimpy_forms_title_field_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][title]" value="<?php echo $form['title']; ?>" class="chimpy-field chimpy_forms_title_field"></td>
                                            </tr>
                                            <tr valign="top">
                                                <th scope="row"><?php _e('Enabled', $this->text_domain); ?></th>
                                                <td><input type="checkbox" id="chimpy_forms_enabled_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][enabled]" <?php echo ($form['enabled'] ? 'checked="checked"' : ''); ?>></td>
                                            </tr>
                                            <tr valign="top">
                                                <th scope="row"><?php _e('Display field labels inline', $this->text_domain); ?></th>
                                                <td><input type="checkbox" id="chimpy_forms_inline_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][inline]" <?php echo ($form['inline'] ? 'checked="checked"' : ''); ?>></td>
                                            </tr>
                                            <tr valign="top">
                                                <th scope="row"><?php _e('Double opt-in', $this->text_domain); ?></th>
                                                <td><input type="checkbox" id="chimpy_forms_double_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][double]" <?php echo ($form['double'] ? 'checked="checked"' : ''); ?>></td>
                                            </tr>
                                            <tr valign="top">
                                                <th scope="row"><?php _e('Send welcome email', $this->text_domain); ?></th>
                                                <td><input type="checkbox" id="chimpy_forms_welcome_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][welcome]" <?php echo ($form['welcome'] ? 'checked="checked"' : ''); ?>></td>
                                            </tr>
                                    </tbody></table>

                                    <div class="chimpy_forms_section">List & Groups</div>
                                    <p id="chimpy_forms_list_<?php echo $form_key; ?>" class="chimpy_loading_list chimpy_forms_field_list_groups">
                                        <span class="chimpy_loading_icon"></span>
                                        <?php _e('Connecting to MailChimp...', $this->text_domain); ?>
                                    </p>

                                    <div class="chimpy_forms_section">Additional Fields</div>
                                    <p id="chimpy_fields_table_<?php echo $form_key; ?>" class="chimpy_loading_list chimpy_forms_field_fields">
                                        <span class="chimpy_loading_icon"></span>
                                        <?php _e('Connecting to MailChimp...', $this->text_domain); ?>
                                    </p>

                                    <div class="chimpy_forms_section">Conditions</div>
                                    <table class="form-table"><tbody>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Display condition', $this->text_domain); ?></th>
                                            <td><select id="chimpy_forms_condition_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][condition]" class="chimpy-field form_condition_key">

                                                <?php
                                                    foreach ($condition_options as $cond_value => $cond_title) {
                                                        $is_selected = (is_array($form['condition']) && isset($form['condition']['key']) && $form['condition']['key'] == $cond_value) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $cond_value . '" ' . $is_selected . '>' . $cond_title . '</option>';
                                                    }
                                                ?>

                                            </select></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Specific pages', $this->text_domain); ?></th>
                                            <td><select multiple id="chimpy_forms_condition_pages_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][condition_pages][]" class="chimpy-field form_condition_value form_condition_value_pages">

                                                <?php
                                                    foreach ($pages as $key => $name) {
                                                        $is_selected = (is_array($form['condition']) && isset($form['condition']['key']) && $form['condition']['key'] == 'pages' && isset($form['condition']['value']) && is_array($form['condition']['value']) && in_array($key, $form['condition']['value'])) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $key . '" ' . $is_selected . '>' . $name . '</option>';
                                                    }
                                                ?>

                                            </select></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Specific posts', $this->text_domain); ?></th>
                                            <td><select multiple id="chimpy_forms_condition_posts_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][condition_posts][]" class="chimpy-field form_condition_value form_condition_value_posts">

                                                <?php
                                                    foreach ($posts as $key => $name) {
                                                        $is_selected = (is_array($form['condition']) && isset($form['condition']['key']) && $form['condition']['key'] == 'posts' && isset($form['condition']['value']) && is_array($form['condition']['value']) && in_array($key, $form['condition']['value'])) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $key . '" ' . $is_selected . '>' . $name . '</option>';
                                                    }
                                                ?>

                                            </select></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Specific post categories', $this->text_domain); ?></th>
                                            <td><select multiple id="chimpy_forms_condition_categories_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][condition_categories][]" class="chimpy-field form_condition_value form_condition_value_categories">

                                                <?php
                                                    foreach ($post_categories as $key => $name) {
                                                        $is_selected = (is_array($form['condition']) && isset($form['condition']['key']) && $form['condition']['key'] == 'categories' && isset($form['condition']['value']) && is_array($form['condition']['value']) && in_array($key, $form['condition']['value'])) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $key . '" ' . $is_selected . '>' . $name . '</option>';
                                                    }
                                                ?>

                                            </select></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('URL contains', $this->text_domain); ?></th>
                                            <td><input type="text" id="chimpy_forms_condition_url_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][condition_url]" value="<?php echo ((isset($form['condition']['key']) && $form['condition']['key'] == 'url' && isset($form['condition']['value'])) ? $form['condition']['value'] : ''); ?>" class="chimpy-field form_condition_value form_condition_value_url"></td>
                                        </tr>
                                    </tbody></table>

                                    <div class="chimpy_forms_section"><?php _e('Styling', $this->text_domain); ?></div>
                                    <table class="form-table"><tbody>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Color Scheme', $this->text_domain); ?></th>
                                            <td><select id="chimpy_forms_color_scheme_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][color_scheme]" class="chimpy-field chimpy_forms_color_scheme">

                                                <?php
                                                    foreach ($color_schemes as $scheme_value => $scheme_title) {
                                                        $is_selected = ((isset($form['color_scheme']) && $form['color_scheme'] == $scheme_value) ? 'selected="selected"' : '');
                                                        echo '<option value="' . $scheme_value . '" ' . $is_selected . '>' . $scheme_title . '</option>';
                                                    }
                                                ?>

                                            </select></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Override CSS', $this->text_domain); ?></th>
                                            <td><textarea id="chimpy_forms_css_override_<?php echo $form_key; ?>" name="chimpy_options[forms][<?php echo $form_key; ?>][css_override]" class="chimpy-field"><?php echo $form['css_override']; ?></textarea></td>
                                        </tr>
                                    </tbody></table>

                                </div>
                                <div style="clear: both;"></div>
                            </div>

                        <?php endforeach; ?>

                        </div>
                        <div>
                            <button type="button" name="chimpy_add_set" id="chimpy_add_set" disabled="disabled" class="button button-primary" value="<?php _e('Add Form', $this->text_domain); ?>" title="<?php _e('Still connecting to MailChimp...', $this->text_domain); ?>"><i class="fa fa-plus">&nbsp;&nbsp;<?php _e('Add Form', $this->text_domain); ?></i></button>
                            <div style="clear: both;"></div>
                        </div>
                    </div>

                    <?php

                }
            }
            else if ($section['id'] == 'posts') {
                echo '<div class="chimpy-usage"><p>'
                   . __('To display a signup form below main content of each post and page, simply change the setting below.', $this->text_domain)
                   . '</p></div>';
            }
            else if ($section['id'] == 'popup') {
                echo '<div class="chimpy-usage"><p>'
                   . __('You can display a popup with a signup form on every page.<br />Popup will be displayed every time a page is loaded until user subscribes or dismisses the popup.', $this->text_domain)
                   . '</p></div>';
            }
            else if ($section['id'] == 'widget') {
                echo '<div class="chimpy-usage" style="padding-bottom:15px;"><p>'
                   . __('There are multiple ways to display signup forms on your website.', $this->text_domain) . '</p><p>'
                   . sprintf(__('This plugin comes with a widget that can be placed on one of your sidebars.<br />To do so, go to your <a href="%s">widgets page</a> and use a widget called <strong>MailChimp Signup</strong>.', $this->text_domain), admin_url('/widgets.php'))
                   . '</p></div>';
            }
            else if ($section['id'] == 'shortcode') {
                echo '<div class="chimpy-usage"><p>'
                   . __('You can insert a signup form to specific posts by placing the following shortcode:', $this->text_domain)
                   . '</p><div class="chimpy-code">[chimpy_form]</div><p>'
                   . __('Alternatively, you can place the following function directly into your theme:', $this->text_domain)
                   . '</p><div class="chimpy-code">&lt;?php chimpy_form(); ?&gt;</div><p>'
                   . '</p></div>';
            }
        }

        /*
         * Render a text field
         * 
         * @access public
         * @param array $args
         * @return void
         */
        public function render_options_text($args = array())
        {
            printf(
                '<input type="text" id="%s" name="%soptions[%s]" value="%s" class="%sfield" />',
                $args['name'],
                $this->prefix,
                $args['name'],
                $args['options'][$args['name']],
                $this->prefix_dash
            );
        }

        /*
         * Render a text area
         * 
         * @access public
         * @param array $args
         * @return void
         */
        public function render_options_textarea($args = array())
        {
            printf(
                '<textarea id="%s" name="%soptions[%s]" class="%stextarea">%s</textarea>',
                $args['name'],
                $this->prefix,
                $args['name'],
                $this->prefix_dash,
                $args['options'][$args['name']]
            );
        }

        /*
         * Render a checkbox
         * 
         * @access public
         * @param array $args
         * @return void
         */
        public function render_options_checkbox($args = array())
        {
            printf(
                '<input type="checkbox" id="%s" name="%soptions[%s]" value="1" %s />',
                $args['name'],
                $this->prefix,
                $args['name'],
                checked($args['options'][$args['name']], true, false)
            );
        }

        /*
         * Render a dropdown
         * 
         * @access public
         * @param array $args
         * @return void
         */
        public function render_options_dropdown($args = array())
        {
            printf(
                '<select id="%s" name="%soptions[%s]" class="%sfield">',
                $args['name'],
                $this->prefix,
                $args['name'],
                $this->prefix_dash
            );

            foreach ($this->options[$args['name']] as $key => $name) {
                printf(
                    '<option value="%s" %s>%s</option>',
                    $key,
                    selected($key, $args['options'][$args['name']], false),
                    $name
                );
            }

            echo '</select>';
        }

        /*
         * Render a password field
         * 
         * @access public
         * @param array $args
         * @return void
         */
        public function render_options_password($args = array())
        {
            printf(
                '<input type="password" id="%s" name="%soptions[%s]" value="%s" class="%sfield" />',
                $args['name'],
                $this->prefix,
                $args['name'],
                $args['options'][$args['name']],
                $this->prefix_dash
            );
        }

        /**
         * Validate admin form input
         * 
         * @access public
         * @param array $input
         * @return array
         */
        public function options_validate($input)
        {
            $current_tab = isset($_POST['current_tab']) ? $_POST['current_tab'] : 'forms';
            $output = $original = $this->get_options();

            $revert = array();
            $errors = array();

            // Validate forms
            if ($current_tab == 'forms') {
                if (isset($input['forms']) && !empty($input['forms'])) {

                    $new_forms = array();
                    $form_number = 0;

                    foreach ($input['forms'] as $form) {

                        $form_number++;

                        $new_forms[$form_number] = array();

                        // Enabled
                        $new_forms[$form_number]['enabled'] = (isset($form['enabled']) && $form['enabled']) ? '1': '0';

                        // Title
                        $new_forms[$form_number]['title'] = (isset($form['title']) && !empty($form['title'])) ? $form['title']: '';

                        // Display field labels inline
                        $new_forms[$form_number]['inline'] = (isset($form['inline']) && $form['inline']) ? '1': '0';

                        // Double opt-in
                        $new_forms[$form_number]['double'] = (isset($form['double']) && $form['double']) ? '1': '0';

                        // Send welcome email
                        $new_forms[$form_number]['welcome'] = (isset($form['welcome']) && $form['welcome']) ? '1': '0';

                        // List
                        $new_forms[$form_number]['list'] = (isset($form['list_field']) && !empty($form['list_field'])) ? $form['list_field']: '';

                        // Groups
                        $new_forms[$form_number]['groups'] = array();

                        if (isset($form['groups']) && is_array($form['groups'])) {
                            foreach ($form['groups'] as $group) {
                                $new_forms[$form_number]['groups'][] = $group;
                            }
                        }

                        // Fields
                        $new_forms[$form_number]['fields'] = array();

                        if (isset($form['fields']) && is_array($form['fields'])) {

                            $field_number = 0;

                            foreach ($form['fields'] as $field) {

                                if (!is_array($field) || !isset($field['name']) || !isset($field['tag']) || empty($field['tag'])) {
                                    continue;
                                }

                                $field_number++;

                                $new_forms[$form_number]['fields'][$field_number] = array(
                                    'name'  => $field['name'],
                                    'tag'   => $field['tag']
                                );
                            }
                        }

                        // Condition
                        $new_forms[$form_number]['condition'] = array();
                        $new_forms[$form_number]['condition']['key'] = (isset($form['condition']) && !empty($form['condition'])) ? $form['condition']: 'always';

                        // Condition value
                        if ($new_forms[$form_number]['condition']['key'] == 'pages') {
                            if (isset($form['condition_pages']) && is_array($form['condition_pages']) && !empty($form['condition_pages'])) {
                                foreach ($form['condition_pages'] as $condition_item) {
                                    if (empty($condition_item)) {
                                        continue;
                                    }

                                    $new_forms[$form_number]['condition']['value'][] = $condition_item;
                                }
                            }
                            else {
                                $new_forms[$form_number]['condition']['key'] = 'always';
                                $new_forms[$form_number]['condition']['value'] = '';
                            }
                        }
                        else if ($new_forms[$form_number]['condition']['key'] == 'posts') {
                            if (isset($form['condition_posts']) && is_array($form['condition_posts']) && !empty($form['condition_posts'])) {
                                foreach ($form['condition_posts'] as $condition_item) {
                                    if (empty($condition_item)) {
                                        continue;
                                    }

                                    $new_forms[$form_number]['condition']['value'][] = $condition_item;
                                }
                            }
                            else {
                                $new_forms[$form_number]['condition']['key'] = 'always';
                                $new_forms[$form_number]['condition']['value'] = '';
                            }
                        }
                        else if ($new_forms[$form_number]['condition']['key'] == 'categories') {
                            if (isset($form['condition_categories']) && is_array($form['condition_categories']) && !empty($form['condition_categories'])) {
                                foreach ($form['condition_categories'] as $condition_item) {
                                    if (empty($condition_item)) {
                                        continue;
                                    }

                                    $new_forms[$form_number]['condition']['value'][] = $condition_item;
                                }
                            }
                            else {
                                $new_forms[$form_number]['condition']['key'] = 'always';
                                $new_forms[$form_number]['condition']['value'] = '';
                            }
                        }
                        else if ($new_forms[$form_number]['condition']['key'] == 'url') {
                            if (isset($form['condition_url']) && !empty($form['condition_url'])) {
                                $new_forms[$form_number]['condition']['value'] = $form['condition_url'];
                            }
                            else {
                                $new_forms[$form_number]['condition']['key'] = 'always';
                                $new_forms[$form_number]['condition']['value'] = '';
                            }
                        }
                        else {
                            $new_forms[$form_number]['condition']['value'] = '';
                        }

                        // Color scheme
                        $new_forms[$form_number]['color_scheme'] = (isset($form['color_scheme']) && !empty($form['color_scheme'])) ? $form['color_scheme']: 'cyan';

                        // Override CSS
                        $new_forms[$form_number]['css_override'] = (isset($form['css_override']) && !empty($form['css_override'])) ? $form['css_override']: '';

                    }
                }

                $output['forms'] = $new_forms;
            }

            // Validate other content
            else {

                // Iterate over fields and validate/sanitize input
                foreach ($this->validation[$current_tab] as $field => $rule) {

                    $allow_empty = true;

                    // Conditional validation
                    if (is_array($rule['empty']) && !empty($rule['empty'])) {
                        if (isset($input[$this->prefix . $rule['empty'][0]]) && ($input[$this->prefix . $rule['empty'][0]] != '0')) {
                            $allow_empty = false;
                        }
                    }
                    else if ($rule['empty'] == false) {
                        $allow_empty = false;
                    }

                    // Different routines for different field types
                    switch($rule['rule']) {

                        // Validate numbers
                        case 'number':
                            if (is_numeric($input[$field]) || ($input[$field] == '' && $allow_empty)) {
                                $output[$field] = $input[$field];
                            }
                            else {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'number'));
                            }
                            break;

                        // Validate boolean values (actually 1 and 0)
                        case 'bool':
                            $input[$field] = $input[$field] == '' ? '0' : $input[$field];
                            if (in_array($input[$field], array('0', '1')) || ($input[$field] == '' && $allow_empty)) {
                                $output[$field] = $input[$field];
                            }
                            else {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'bool'));
                            }
                            break;

                        // Validate predefined options
                        case 'option':

                            // Check if this call is for mailing lists
                            if ($field == 'chimpy_list_checkout') {
                                //$this->options[$field] = $this->get_lists();
                                if (is_array($rule['empty']) && !empty($rule['empty']) && $input[$this->prefix.$rule['empty'][0]] != '1' && (empty($input[$field]) || $input[$field] == '0')) {
                                    if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                        $revert[$rule['empty'][0]] = '1';
                                    }
                                    array_push($errors, array('setting' => $field, 'code' => 'option'));
                                }
                                else {
                                    $output[$field] = ($input[$field] == null ? '0' : $input[$field]);
                                }

                                break;
                            }
                            else if (in_array($field, array('chimpy_list_widget', 'chimpy_list_shortcode'))) {
                                //$this->options[$field] = $this->get_lists();
                                if (is_array($rule['empty']) && !empty($rule['empty']) && $input[$this->prefix.$rule['empty'][0]] != '0' && (empty($input[$field]) || $input[$field] == '0')) {
                                    if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                        $revert[$rule['empty'][0]] = '0';
                                    }
                                    array_push($errors, array('setting' => $field, 'code' => 'option'));
                                }
                                else {
                                    $output[$field] = ($input[$field] == null ? '0' : $input[$field]);
                                }

                                break;
                            }

                            if (isset($this->options[$field][$input[$field]]) || ($input[$field] == '' && $allow_empty)) {
                                $output[$field] = ($input[$field] == null ? '0' : $input[$field]);
                            }
                            else {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'option'));
                            }
                            break;

                        // Multiple selections
                        case 'multiple_any':
                            if (empty($input[$field]) && !$allow_empty) {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'multiple_any'));
                            }
                            else {
                                if (is_array($input[$field]) && !empty($input[$field])) {
                                    $temporary_output = array();

                                    foreach ($input[$field] as $field_val) {
                                        $temporary_output[] = htmlspecialchars($field_val);
                                    }

                                    $output[$field] = $temporary_output;
                                }
                                else {
                                    $output[$field] = array();
                                }
                            }
                            break;

                        // Validate emails
                        case 'email':
                            if (filter_var(trim($input[$field]), FILTER_VALIDATE_EMAIL) || ($input[$field] == '' && $allow_empty)) {
                                $output[$field] = esc_attr(trim($input[$field]));
                            }
                            else {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'email'));
                            }
                            break;

                        // Validate URLs
                        case 'url':
                            // FILTER_VALIDATE_URL for filter_var() does not work as expected
                            if (($input[$field] == '' && !$allow_empty)) {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'url'));
                            }
                            else {
                                $output[$field] = esc_attr(trim($input[$field]));
                            }
                            break;

                        // Custom validation function
                        case 'function':
                            $function_name = 'validate_' . $field;
                            $validation_results = $this->$function_name($input[$field]);

                            // Check if parent is disabled - do not validate then and reset to ''
                            if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                if (empty($input[$this->prefix.$rule['empty'][0]])) {
                                    $output[$field] = '';
                                    break;
                                }
                            }

                            if (($input[$field] == '' && $allow_empty) || $validation_results === true) {
                                $output[$field] = $input[$field];
                            }
                            else {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'option', 'custom' => $validation_results));
                            }
                            break;

                        // Default validation rule (text fields etc)
                        default:
                            if (($input[$field] == '' && !$allow_empty)) {
                                if (is_array($rule['empty']) && !empty($rule['empty'])) {
                                    $revert[$rule['empty'][0]] = '0';
                                }
                                array_push($errors, array('setting' => $field, 'code' => 'string'));
                            }
                            else {
                                $output[$field] = esc_attr(trim($input[$field]));
                            }
                            break;
                    }
                }

                // Revert parent fields if needed
                if (!empty($revert)) {
                    foreach ($revert as $key => $value) {
                        $output[$this->prefix.$key] = $value;
                    }
                }

            }

            // Display settings updated message
            add_settings_error(
                $this->prefix . 'settings_updated',
                $this->prefix . 'settings_updated',
                __('Your settings have been saved.', $this->text_domain),
                'updated'
            );

            // Define error messages
            $messages = array(
                'number' => __('must be numeric', $this->text_domain),
                'bool' => __('must be either 0 or 1', $this->text_domain),
                'option' => __('is not allowed', $this->text_domain),
                'email' => __('is not a valid email address', $this->text_domain),
                'url' => __('is not a valid URL', $this->text_domain),
                'string' => __('is not a valid text string', $this->text_domain),
            );

            // Display errors
            foreach ($errors as $error) {

                $message = (!isset($error['custom']) ? $messages[$error['code']] : $error['custom']) . '. ' . __('Reverted to a previous state.', $this->text_domain);

                add_settings_error(
                    $this->prefix . 'settings_updated',
                    //$error['setting'],
                    $error['code'],
                    __('Value of', $this->text_domain) . ' "' . $this->titles[$error['setting']] . '" ' . $message
                );
            }

            return $output;
        }

        /**
         * Custom validation for service provider API key
         * 
         * @access public
         * @param string $key
         * @return mixed
         */
        public function validate_chimpy_api_key($key)
        {
            if (empty($key)) {
                return 'is empty';
            }

            $test_results = $this->test_mailchimp($key);

            if ($test_results === true) {
                return true;
            }
            else {
                return __(' is not valid or something went wrong. More details: ', $this->text_domain) . $test_results;
            }
        }

        /**
         * Load scripts required for admin
         * 
         * @access public
         * @return void
         */
        public function enqueue_admin_scripts_and_styles()
        {
            // Custom jQuery UI script and its styles
            wp_register_script('chimpy-jquery-ui', CHIMPY_PLUGIN_URL . '/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js', array('jquery'));
            wp_register_style('chimpy-jquery-ui-styles', CHIMPY_PLUGIN_URL . '/assets/jquery-ui/css/jquery-ui-1.10.3.custom.min.css');

            // Chosen scripts and styles (advanced form fields)
            wp_register_script('jquery-chimpy-chosen', CHIMPY_PLUGIN_URL . '/assets/js/chosen.jquery.js', array('jquery'));
            wp_register_style('jquery-chimpy-chosen-css', CHIMPY_PLUGIN_URL . '/assets/css/chosen.min.css');

            // Font awesome (icons)
            wp_register_style('chimpy-font-awesome', CHIMPY_PLUGIN_URL . '/assets/css/font-awesome/css/font-awesome.min.css');

            // Our own scripts and styles
            wp_register_script('chimpy-admin-scripts', CHIMPY_PLUGIN_URL . '/assets/js/chimpy-admin.js', array('jquery'));
            wp_register_style('chimpy-admin-styles', CHIMPY_PLUGIN_URL . '/assets/css/style-admin.css');

            // Scripts
            wp_enqueue_script('jquery');
            wp_enqueue_script('chimpy-jquery-ui');
            wp_enqueue_script('jquery-chimpy-chosen');
            wp_enqueue_script('chimpy-admin-scripts');

            // Styles
            wp_enqueue_style('chimpy-jquery-ui-styles');
            wp_enqueue_style('jquery-chimpy-chosen-css');
            wp_enqueue_style('chimpy-font-awesome');
            wp_enqueue_style('chimpy-admin-styles');
        }

        /**
         * Load scripts required for frontend
         * 
         * @access public
         * @return void
         */
        public function enqueue_frontend_scripts_and_styles()
        {
            // Chimpy frontend scripts
            wp_register_script('chimpy-frontend', CHIMPY_PLUGIN_URL . '/assets/js/chimpy-frontend.js', array('jquery'));
            wp_enqueue_script('chimpy-frontend');

            // Chimpy frontent styles
            wp_register_style('chimpy', CHIMPY_PLUGIN_URL . '/assets/css/style-frontend.css');
            wp_enqueue_style('chimpy');

            // Sky Forms scripts
            wp_register_script('chimpy-sky-forms', CHIMPY_PLUGIN_URL . '/assets/forms/js/jquery.form.min.js', array('jquery'));
            wp_enqueue_script('chimpy-sky-forms');

            // Sky Forms scripts - validate
            wp_register_script('chimpy-sky-forms-validate', CHIMPY_PLUGIN_URL . '/assets/forms/js/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('chimpy-sky-forms-validate');

            // Sky Forms scripts - modal
            wp_register_script('chimpy-sky-forms-modal', CHIMPY_PLUGIN_URL . '/assets/forms/js/jquery.modal.js', array('jquery'));
            wp_enqueue_script('chimpy-sky-forms-modal');

            // Sky Forms main styles
            wp_register_style('chimpy-sky-forms-style', CHIMPY_PLUGIN_URL . '/assets/forms/css/sky-forms.css');
            wp_enqueue_style('chimpy-sky-forms-style');

            // Sky Forms color schemes
            wp_register_style('chimpy-sky-forms-color-schemes', CHIMPY_PLUGIN_URL . '/assets/forms/css/sky-forms-color-schemes.css');
            wp_enqueue_style('chimpy-sky-forms-color-schemes');

            // Check browser version
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== false) {
                $ie = 6;
            }
            else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') !== false) {
                $ie = 7;
            }
            else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.') !== false) {
                $ie = 8;
            }
            else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !== false) {
                $ie = 9;
            }
            else {
                $ie = false;
            }

            // For IE < 9
            if ($ie && $ie < 9) {

                // Additional scripts
                wp_register_script('chimpy-sky-forms-ie8', CHIMPY_PLUGIN_URL . '/assets/forms/js/sky-forms-ie8.js', array('jquery'));
                wp_enqueue_script('chimpy-sky-forms-ie8');

                // Additional styles
                wp_register_style('chimpy-sky-forms-style-ie8', CHIMPY_PLUGIN_URL . '/assets/forms/css/sky-forms-ie8.css');
                wp_enqueue_style('chimpy-sky-forms-style-ie8');
            }

            // For IE < 10
            if ($ie && $ie < 10) {

                // Placeholder
                wp_register_script('chimpy-sky-forms-placeholder', CHIMPY_PLUGIN_URL . '/assets/forms/js/jquery.placeholder.min.js', array('jquery'));
                wp_enqueue_script('chimpy-sky-forms-placeholder');

                // HTM5 Shim
                wp_register_script('chimpy-sky-forms-html5shim', CHIMPY_PLUGIN_URL . '/assets/forms/js/html5.js', array('jquery'));
                wp_enqueue_script('chimpy-sky-forms-html5shim');
            }

        }

        /**
         * Add settings link on plugins page
         * 
         * @access public
         * @return void
         */
        public function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=chimpy">'.__('Settings', $this->text_domain).'</a>'; 
            array_unshift($links, $settings_link); 
            return $links; 
        }

        /**
         * Handle plugin uninstall
         * 
         * @access public
         * @return void
         */
        public function uninstall()
        {
            if (defined('WP_UNINSTALL_PLUGIN')) {
                delete_option('chimpy_options');
            }
        }

        /**
         * Get all lists plus groups and fields for selected lists in array
         * 
         * @access public
         * @return void
         */
        public function ajax_get_lists_groups_fields()
        {
            if (isset($_POST['data'])) {
                $data = $_POST['data'];
            }
            else {
                $data = array();
            }

            // Get lists
            $lists = $this->get_lists();

            // Check if we have something pre-selected
            if (!empty($data)) {

                // Get merge vars
                $merge = $this->get_merge_vars($lists);

                $lists_to_get = array();

                // Get groups
                foreach ($data as $form_key => $form) {
                    $lists_to_get[] = $form['list'];
                }

                $groups = $this->get_groups($lists_to_get);
            }
            else {

                $merge = array();
                $groups = array();

                foreach ($lists as $list_key => $list_value) {

                    if ($list_key == '') {
                        continue;
                    }

                    // Blank merge vars
                    $merge[$list_key] = array('' => '');

                    // Blank groups
                    $groups[$list_key] = array('' => '');
                }
            }

            echo json_encode(array('message' => array('lists' => $lists, 'groups' => $groups, 'merge' => $merge)));
            die();
        }

        /**
         * Return all lists from MailChimp to be used in select fields
         * 
         * @access public
         * @return array
         */
        public function get_lists()
        {
            $this->load_mailchimp();

            try {
                if (!$this->mailchimp) {
                    throw new Exception(__('Unable to load lists', $this->text_domain));
                }

                $lists = $this->mailchimp->lists->getList();

                if ($lists['total'] < 1) {
                    throw new Exception(__('No lists found', $this->text_domain));
                }

                $results = array('' => '');

                foreach ($lists['data'] as $list) {
                    $results[$list['id']] = $list['name'];
                }

                return $results;
            }
            catch (Exception $e) {
                return array('' => '');
            }
        }

        /**
         * Return all merge vars for all available lists
         * 
         * @access public
         * @param array $lists
         * @return array
         */
        public function get_merge_vars($lists)
        {
            $this->load_mailchimp();

            // Unset blank list
            unset($lists['']);

            // Pre-populate results array with list ids as keys
            $results = array();

            foreach (array_keys($lists) as $list) {
                $results[$list] = array();
            }

            try {

                if (!$this->mailchimp) {
                    throw new Exception(__('Unable to load merge vars', $this->text_domain));
                }

                $merge_vars = $this->mailchimp->lists->mergeVars(array_keys($lists));

                if (!$merge_vars || empty($merge_vars) || !isset($merge_vars['data'])) {
                    throw new Exception(__('No merge vars found', $this->text_domain));
                }

                foreach ($merge_vars['data'] as $merge_var) {
                    foreach ($merge_var['merge_vars'] as $var) {
                        // Skip standard email var
                        if ($var['tag'] == 'EMAIL') {
                            continue;
                        }

                        $results[$merge_var['id']][$var['tag']] = $var['name'];
                    }
                }

                return $results;
            }
            catch (Exception $e) {
                return $results;
            }
        }

        /**
         * Return all groupings/groups from MailChimp to be used in select fields
         * 
         * @access public
         * @param mixed $list_id
         * @return array
         */
        public function get_groups($list_id)
        {
            $this->load_mailchimp();

            try {

                if (!$this->mailchimp) {
                    throw new Exception(__('Unable to load groups', $this->text_domain));
                }

                // Single list?
                if (in_array(gettype($list_id), array('integer', 'string'))) {
                    $groupings = $this->mailchimp->lists->interestGroupings($list_id);

                    if (!$groupings || empty($groupings)) {
                        throw new Exception(__('No groups found', $this->text_domain));
                    }

                    $results = array('' => '');

                    foreach ($groupings as $grouping) {
                        foreach ($grouping['groups'] as $group) {
                            $results[$grouping['id'] . ':' . htmlspecialchars($group['name'])] = htmlspecialchars($grouping['name']) . ': ' . htmlspecialchars($group['name']);
                        }
                    }
                }

                // Multiple lists...
                else {

                    $results = array();

                    foreach ($list_id as $list_id_value) {

                        $results[$list_id_value] = array('' => '');

                        try {
                            $groupings = $this->mailchimp->lists->interestGroupings($list_id_value);
                        }
                        catch(Exception $e) {
                            continue;
                        }

                        if (!$groupings || empty($groupings)) {
                            continue;
                        }

                        foreach ($groupings as $grouping) {
                            foreach ($grouping['groups'] as $group) {
                                $results[$list_id_value][$grouping['id'] . ':' . htmlspecialchars($group['name'])] = htmlspecialchars($grouping['name']) . ': ' . htmlspecialchars($group['name']);
                            }
                        }
                    }
                }

                return $results;
            }
            catch (Exception $e) {
                return array();
            }
        }

        /**
         * Ajax - Return MailChimp groups and tags as array for multiselect field
         */
        public function ajax_groups_and_tags_in_array()
        {
            // Check if we have received required data
            if (isset($_POST['data']) && isset($_POST['data']['list'])) {
                $groups = $this->get_groups($_POST['data']['list']);
                $merge_vars = $this->get_merge_vars(array($_POST['data']['list'] => ''));
            }
            else {
                $groups = array('' => '');
                $merge_vars = array('' => '');
            }

            echo json_encode(array('message' => array('groups' => $groups, 'merge' => $merge_vars)));
            die();
        }

        /**
         * Test MailChimp key and connection
         * 
         * @access public
         * @return bool
         */
        public function test_mailchimp($key = null)
        {
            // Try to get key from options if not set
            if ($key == null) {
                $key = $this->opt[$this->prefix.'api_key'];
            }

            // Check if api key is set now
            if (empty($key)) {
                return __('No API key provided', $this->text_domain);
            }

            // Check if curl extension is loaded
            if (!function_exists('curl_exec')) {
                return __('PHP Curl extension not loaded on your server', $this->text_domain);
            }

            // Try to initialize MailChimp
            $this->mailchimp = new Mailchimp($key, array('ssl_verifypeer' => false, 'ssl_verifyhost' => false));

            if (!$this->mailchimp) {
                return __('Unable to initialize MailChimp class', $this->text_domain);
            }

            // Ping
            try {
                $results = $this->mailchimp->helper->ping();

                if ($results['msg'] == 'Everything\'s Chimpy!') {
                    return true;
                }

                throw new Exception($results['msg']);  
            }
            catch (Exception $e) {
                return $e->getMessage();
            }

            return __('Something went wrong...', $this->text_domain);
        }

        /**
         * Get MailChimp account details
         * 
         * @access public
         * @return mixed
         */
        public function get_mailchimp_account_info()
        {
            if ($this->load_mailchimp()) {
                try {
                    $results = $this->mailchimp->helper->accountDetails();
                    return $results;
                }
                catch (Exception $e) {
                    return false;
                }
            }

            return false;
        }

        /**
         * Load MailChimp object
         * 
         * @access public
         * @return mixed
         */
        public function load_mailchimp()
        {
            if ($this->mailchimp) {
                return true;
            }

            try {
                $this->mailchimp = new Mailchimp($this->opt[$this->prefix.'api_key'], array('ssl_verifypeer' => false, 'ssl_verifyhost' => false));
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        /**
         * Ajax - Render MailChimp status
         * 
         * @access public
         * @return void
         */
        public function ajax_mailchimp_status()
        {
            if (!$this->opt[$this->prefix.'enabled'] || empty($this->opt[$this->prefix.'api_key'])) {
                $message = '<h4><i class="fa fa-times" style="font-size: 1.5em; color: red;"></i>&nbsp;&nbsp;&nbsp;' . __('Integration not enabled or API key not set', $this->text_domain) . '</h4>';
            }
            else if ($account_info = $this->get_mailchimp_account_info()) {

                // Check if Ecommerce360 is enabled
                if (isset($account_info['modules']) && is_array($account_info['modules'])) {
                    foreach ($account_info['modules'] as $module) {
                        if (isset($module['name']) && $module['name'] == 'MailChimp Ecomm 360') {
                            $ecomm_enabled = true;
                        }
                    }

                    $ecomm_enabled = (isset($ecomm_enabled) && $ecomm_enabled) ? true : false;
                }

                $message =  '<div style="width:400px;float:left;"><h4><i class="fa fa-check" style="font-size: 1.5em; color: green;"></i>&nbsp;&nbsp;&nbsp;' . __('Successfully connected to MailChimp', $this->text_domain) . '</h4>' .
                            '<table class="chimpy-account-info"><tbody><tr>' .
                            '<td><strong>' . __('Account name', $this->text_domain) . ':</strong></td><td>' . $account_info['username'] . '</td>' .
                            '</tr><tr>' .
                            '<td><strong>' . __('Industry', $this->text_domain) . ':</strong></td><td>' . $account_info['industry'] . '</td>' .
                            '</tr><tr>' .
                            '<td><strong>' . __('Plan type', $this->text_domain) . ':</strong></td><td>' . $account_info['plan_type'] . '</td>' .
                            '</tr><tr>' .
                            '<td><strong>' . __('Is trial', $this->text_domain) . ':</strong></td><td>' . ($account_info['is_trial'] ? __('Yes', $this->text_domain) : __('No', $this->text_domain)) . '</td>' .
                            '</tr><tr>' .
                            '<td><strong>' . __('Emails left', $this->text_domain) . ':</strong></td><td>' . $account_info['emails_left'] . '</td>' .
                            '</tr></tbody></table></div><div style="width:100px;float:left;"><img style="width:300px;height:auto;margin-top:60px;" src="'.CHIMPY_PLUGIN_URL.'/assets/img/mailchimp_logo.png" /></div><div style="clear:both;"></div>';
            }
            else {
                $message = '<h4><i class="fa fa-times" style="font-size: 1.5em; color: red;"></i>&nbsp;&nbsp;&nbsp;' . __('Connection to MailChimp failed.', $this->text_domain) . '</h4>';
                $mailchimp_error = $this->test_mailchimp();

                if ($mailchimp_error !== true) {
                    $message .= '<p><strong>' . __('Reason', $this->text_domain) . ':</strong> '. $mailchimp_error .'</p>';
                }
            }

            echo json_encode(array('message' => $message));
            die();
        }

        /**
         * Check if curl is enabled
         * 
         * @access public
         * @return void
         */
        public function curl_enabled()
        {
            if (function_exists('curl_version')) {
                return true;
            }

            return false;
        }

        /**
         * Select form based on conditions and request data
         * 
         * @access public
         * @param array $forms
         * @return mixed
         */
        public static function select_form_by_conditions($forms)
        {
            $selected_form = false;

            // Iterate over forms and return the first form that matches conditions
            foreach ($forms as $form_key => $form) {

                // Check if form is enabled and has mailing list set
                if (!$form['enabled'] || empty($form['list'])) {
                    continue;
                }

                // Switch all possible scenarios
                switch ($form['condition']['key']) {

                    /**
                     * ALWAYS
                     */
                    case 'always':
                        $selected_form[$form_key] = $form;
                        break;

                    /**
                     * PAGES
                     */
                    case 'pages':
                        global $post;

                        // Check if we have any pages selected
                        if (!$post || !isset($post->ID) || !array($form['condition']['value']) || empty($form['condition']['value'])) {
                            break;
                        }

                        // Get posts with all children
                        $posts_with_children = self::get_posts_with_children($form['condition']['value']);

                        // Check if current post is within selected posts
                        if (in_array($post->ID, $posts_with_children)) {
                            $selected_form[$form_key] = $form;
                        }

                        break;

                    /**
                     * POSTS
                     */
                    case 'posts':
                        global $post;

                        // Check if we have any pages selected
                        if (!$post || !isset($post->ID) || !array($form['condition']['value']) || empty($form['condition']['value'])) {
                            break;
                        }

                        // Check if current post is within selected posts
                        if (in_array($post->ID, $form['condition']['value'])) {
                            $selected_form[$form_key] = $form;
                        }

                        break;

                    /**
                     * CATEGORIES
                     */
                    case 'categories':
                        global $post;

                        // Check if we have any categories selected
                        if (!$post || !isset($post->ID) || !array($form['condition']['value']) || empty($form['condition']['value'])) {
                            break;
                        }

                        // Get all categories with children
                        $category_with_children_ids = self::get_categories_with_children($form['condition']['value']);

                        if (!is_array($category_with_children_ids) || empty($category_with_children_ids)) {
                            break;
                        }

                        // Get all categories that this post is associated with
                        $post_category_ids = wp_get_post_categories($post->ID);

                        if (!is_array($post_category_ids) || empty($post_category_ids)) {
                            break;
                        }

                        // Check if there's at least one category match
                        foreach ($category_with_children_ids as $single_cat_id) {
                            if (in_array($single_cat_id, $post_category_ids)) {
                                $selected_form[$form_key] = $form;
                                break;
                            }
                        }

                        break;

                    /**
                     * URL
                     */
                    case 'url':
                        $request_url = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];

                        if (preg_match('/' . preg_quote($form['condition']['value']) . '/i', $request_url)) {
                            $selected_form[$form_key] = $form;
                        }

                        break;

                    /**
                     * DEFAULT
                     */
                    default:
                        break;
                }

                // Check if we have selected this form
                if ($selected_form) {
                    break;
                }
            }

            return $selected_form;
        }

        /**
         * Get array of post ids with all children
         * 
         * @access public
         * @param array $post_ids
         * @return array
         */
        public static function get_posts_with_children($post_ids)
        {
            $posts_with_children = array();

            // Get all child posts
            foreach ($post_ids as $post_id) {
                $posts_with_children[] = $post_id;

                $current_post = get_post($post_id);

                if (!$current_post) {
                    continue;
                }

                $current_post_ids = array($post_id);

                while(!empty($current_post_ids)) {
                    $new_current_post_ids = array();

                    foreach ($current_post_ids as $current_post_id) {
                        $children = get_children(array(
                            'post_parent'   => $current_post_id,
                            'post_type'     => 'page',
                            'numberposts'   => -1,
                            'post_status'   => 'any'
                        ));

                        if (!$children) {
                            continue;
                        }

                        foreach ($children as $child) {
                            $posts_with_children[] = $child->ID;
                            $new_current_post_ids[] = $child->ID;
                        }
                    }

                    $current_post_ids = $new_current_post_ids;
                }

            }

            return $posts_with_children;
        }

        /**
         * Get array of category ids with all child categories
         * 
         * @access public
         * @param array $category_ids
         * @return array
         */
        public static function get_categories_with_children($category_ids)
        {
            $categories_with_children = array();

            // Get all child categories
            foreach ($category_ids as $category_id) {
                $categories_with_children[] = $category_id;

                $current_category = get_category($category_id);

                if (!$current_category) {
                    continue;
                }

                $child_categories = get_categories(array(
                    'type'          => 'post',
                    'child_of'      => $category_id,
                    'hide_empty'    => 0,
                ));

                if (!is_array($child_categories) || empty($child_categories)) {
                    continue;
                }

                foreach ($child_categories as $child_category) {
                    $categories_with_children[] = $child_category->term_id;
                }

            }

            return $categories_with_children;
        }

        /**
         * Display form after content
         * 
         * @access public
         * @param $content
         * @return string
         */
        public function form_after_content($content)
        {
            // Check if integration is enabled and at least one form configured
            if (!$this->opt['chimpy_enabled'] || !$this->opt['chimpy_form_after_posts'] || !isset($this->opt['forms']) || empty($this->opt['forms'])) {
                return $content;
            }

            // Select form that match the conditions best
            $form = self::select_form_by_conditions($this->opt['forms']);

            if (!$form) {
                return $content;
            }

            $form_html = chimpy_prepare_form($form, $this->opt, 'after_posts', $args);

            return $content . $form_html;
        }

        /**
         * Form shortcode handler
         * 
         * @access public
         * @param mixed $attributes
         * @return void
         */
        public function subscription_shortcode($attributes)
        {
            // Check if integration is enabled and at least one form configured
            if (!$this->opt['chimpy_enabled'] || !isset($this->opt['forms']) || empty($this->opt['forms'])) {
                return '';
            }

            // Select form that match the conditions best
            $form = self::select_form_by_conditions($this->opt['forms']);

            if (!$form) {
                return '';
            }

            $form_html = chimpy_prepare_form($form, $this->opt, 'shortcode');

            return $form_html;
        }



        /**
         * Subscribe user to mailing list
         * 
         * @access public
         * @param string $list_id
         * @param string $email
         * @param bool $double_optin
         * @param bool $send_welcome
         * @param array $groups
         * @param bool $replace_groups
         * @param array $custom_fields
         * @return bool
         */
        public function subscribe($list_id, $email, $double_optin, $send_welcome, $groups, $replace_groups, $custom_fields)
        {
            // Load MailChimp
            if (!$this->load_mailchimp()) {
                return false;
            }

            $groupings = array();

            // Any groups to be set?
            if (!empty($groups)) {

                // First make an acceptable structure
                $groups_parent_children = array();

                foreach ($groups as $group) {
                    $parts = preg_split('/:/', htmlspecialchars_decode($group));

                    if (count($parts) == 2) {
                        $groups_parent_children[$parts[0]][] = $parts[1];
                    }
                }

                // Now populate groupings array
                foreach ($groups_parent_children as $parent => $child) {
                    $groupings[] = array(
                        'id' => $parent,
                        'groups' => $child
                    );
                }
            }

            // All merge vars
            $merge_vars = array(
                'groupings' => $groupings,
            );

            foreach ($custom_fields as $key => $value) {
                $merge_vars[$key] = $value;
            }

            // Subscribe
            try {
                $results = $this->mailchimp->lists->subscribe(
                    $list_id,
                    array('email' => $email),
                    $merge_vars,
                    'html',
                    $double_optin,
                    true,
                    $replace_groups,
                    $send_welcome
                );

                return true;
            }
            catch (Exception $e) {
                if (preg_match('/.+is already subscribed to list.+/', $e->getMessage())) {
                    return true;
                }

                return false;
            }
        }

        /**
         * Ajax - process subscription
         * 
         * @access public
         * @return void
         */
        public function ajax_subscribe()
        {
            // Check if integration is enabled
            if (!$this->opt[$this->prefix.'enabled'] || !isset($this->opt['forms']) || !is_array($this->opt['forms']) || empty($this->opt['forms'])) {
                $this->respond_with_error();
            }

            // Check if data has been received
            if (!isset($_POST['data'])) {
                $this->respond_with_error();
            }

            $data = array();
            parse_str($_POST['data'], $data);

            // Get context
            if (isset($data['chimpy_widget_subscribe'])) {
                $context = 'widget';
            }
            else if (isset($data['chimpy_after_posts_subscribe'])) {
                $context = 'after_posts';
            }
            else if (isset($data['chimpy_popup_subscribe'])) {
                $context = 'popup';
            }
            else if (isset($data['chimpy_shortcode_subscribe'])) {
                $context = 'shortcode';
            }
            else {
                $this->respond_with_error();
            }

            $data = $data['chimpy_' . $context . '_subscribe'];

            // Check if email has been received
            if (!isset($data['email']) || empty($data['email'])) {
                $this->respond_with_error();
            }

            $email = $data['email'];

            // Load form
            if (isset($data['form']) && isset($this->opt['forms'][$data['form']])) {
                $form = $this->opt['forms'][$data['form']];
            }
            else {
                $this->respond_with_error();
            }

            // Check if form is enabled
            if (!$form['enabled'] || !isset($form['list']) || empty($form['list'])) {
                $this->respond_with_error();
            }

            // Parse custom fields
            $custom_fields = array();

            if (isset($form['fields']) && is_array($form['fields']) && !empty($form['fields'])) {
                if (!isset($data['custom']) || !is_array($data['custom']) || empty($data['custom'])) {
                    $this->respond_with_error();
                }

                foreach ($form['fields'] as $field) {
                    if (!isset($data['custom'][$field['tag']]) || empty($data['custom'][$field['tag']])) {
                        $this->respond_with_error();
                    }

                    $custom_fields[$field['tag']] = $data['custom'][$field['tag']];
                }
            }

            // Subscribe user
            if ($this->subscribe($form['list'], $email, $form['double'], $form['welcome'], $form['groups'], false, $custom_fields)) {
                echo json_encode(array('error' => 0, 'message' => $this->opt[$this->prefix.'label_success']));
                die();
            }

            $this->respond_with_error();
        }

        /**
         * Respond to signup ajax request with standard error
         * 
         * @access public
         * @return void
         */
        public function respond_with_error()
        {
            echo json_encode(array('error' => 1, 'message' => $this->opt[$this->prefix.'label_error']));
            die();
        }

    }

}

$GLOBALS['Chimpy'] = new Chimpy();

?>

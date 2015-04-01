<?php

/** Plugin options */
$options = array(
    array(
        'name' => __( 'About Attention Grabber', $this->textdomain ),
        'type' => 'opentab'
    ),
    array(
        'type' => 'about'
    ),
    array(
        'type' => 'closetab',
        'actions' => false
    ),
    array(
        'name' => __( 'Primary stuff', $this->textdomain ),
        'type' => 'opentab'
    ),
    array(
        'name' => __( 'Text prompt', $this->textdomain ),
        'desc' => __( 'The text to the left of your email form or call-to-action', $this->textdomain ),
        'std' => '',
        'id' => 'text-prompt',
        'type' => 'text'
    ),
    array(
        'name' => __( 'Additional info', $this->textdomain ),
        'desc' => __( 'The text to the right of your email form or call-to-action', $this->textdomain ),
        'std' => '',
        'id' => 'text-additional',
        'type' => 'text'
    ),
    /*array(
        'name' => __( 'Textarea', $this->textdomain ),
        'desc' => __( 'Textarea description', $this->textdomain ),
        'std' => 'Default value',
        'id' => 'textarea',
        'type' => 'textarea',
        'rows' => 7
    ),*/
    array(
        'name' => __( 'Collect email addresses?', $this->textdomain ),
        'desc' => __( '', $this->textdomain ),
        'std' => 'on',
        'id' => 'collect-emails',
        'type' => 'checkbox',
        'label' => __( 'Yes, ask for an email address', $this->textdomain )
    ),
    array(
        'name' => __( 'Button text', $this->textdomain ),
        'desc' => __( 'If you aren\'t collecting email addresses, this button will just be a link. (If this is blank, we won\'t show a button.)<br />Hint: if you\'re asking for email addresses, your button should not read "Submit"!', $this->textdomain ),
        'std' => '',
        'id' => 'text-cta',
        'type' => 'text'
    ),
    array(
        'name' => __( 'If you <em>are</em> collecting email addresses', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( '"Thanks" text', $this->textdomain ),
        'desc' => __( 'How should we thank users after they sign up?', $this->textdomain ),
        'std' => '',
        'id' => 'text-thanks',
        'type' => 'text'
    ),
    array(
        'name' => __( 'If you\'re <em>not</em> collecting email addresses', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Button link HREF', $this->textdomain ),
        'desc' => __( 'If you aren\'t collecting email addresses, what URL should the button take the user to?', $this->textdomain ),
        'std' => '',
        'id' => 'button-href',
        'type' => 'text'
    ),
    array(
        'name' => __( 'Button link title', $this->textdomain ),
        'desc' => __( 'If you aren\'t collecting email addresses, what should be displayed when you mouse-over the button?', $this->textdomain ),
        'std' => '',
        'id' => 'button-title',
        'type' => 'text'
    ),
    array(
        'name' => __( 'Open link in a new tab?', $this->textdomain ),
        'desc' => __( 'If you aren\'t collecting email addresses, should we open a new tab when the user clicks the button?', $this->textdomain ),
        'std' => 'on',
        'id' => 'new-tab',
        'type' => 'checkbox',
        'label' => __( 'Yes, open the link in a new tab', $this->textdomain )
    ),
    array(
        'type' => 'closetab'
    ),

    array(
        'name' => __( 'Email collection', $this->textdomain ),
        'type' => 'opentab'
    ),
    array(
        'name' => __( 'Choose your email provider', $this->textdomain ),
        'desc' => __( 'Which service do you use to send your emails?', $this->textdomain ),
        'options' => array(
            'customerio' => __( 'Customer.io', $this->textdomain ),
            'mailchimp' => __( 'MailChimp (not currently supported)', $this->textdomain ),
        ),
        'std' => 'customerio',
        'id' => 'email-service-provider',
        'type' => 'radio'
    ),
    array(
        'name' => __( 'If you are using <strong>Customer.io</strong> to send emails', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Customer.io Site ID', $this->textdomain ),
        'desc' => __( 'Find this by logging in to Customer.io and going to the Integration tab', $this->textdomain ),
        'std' => '',
        'id' => 'customer-io-site-id',
        'type' => 'text'
    ),/*
        array(
            'name' => __( 'If you are using <strong>MailChimp</strong> to send emails', $this->textdomain ),
            'type' => 'title'
        ),
        array(
            'name' => __( 'MailChimp API key', $this->textdomain ),
            'desc' => __( 'Find this by <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">following MailChimp\'s instructions</a>', $this->textdomain ),
            'std' => '',
            'id' => 'mailchimp-api-key',
            'type' => 'text'
        ),*/
    array(
        'type' => 'closetab'
    ),
    array(
        'name' => __( 'Appearance', $this->textdomain ),
        'type' => 'opentab'
    ),
    array(
        'name' => __( 'Fonts', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Fonts to use for the Attention Grabber\'s Text', $this->textdomain ),
        'desc' => __( 'Should be a CSS font stack, like this: <code>Helvetica, Arial, sans-serif</code><br />Alternatively, leave it blank to use your site\'s default fonts.', $this->textdomain ),
        'std' => '',
        'id' => 'font-stack',
        'type' => 'text'
    ),
    array(
        'name' => __( 'Primary bar', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Primary color for bar', $this->textdomain ),
        'desc' => __( 'The primary color for the Attention Grabber bar\'s background<br />Default: #0099B5', $this->textdomain ),
        'std' => '#0099B5',
        'id' => 'color-primary-bar',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Secondary color for bar', $this->textdomain ),
        'desc' => __( 'The color that the Attention Grabber bar\'s background fades to. For no gradient, use the primary color above. Or, for a nice effect, choose a monochromatic color to the primary one using <a href="https://kuler.adobe.com/create/color-wheel/">Adobe\'s Kuler tool</a>.<br />Default: #0A7BCC', $this->textdomain ),
        'std' => '#0A7BCC',
        'id' => 'color-secondary-bar',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Button', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Primary color for button', $this->textdomain ),
        'desc' => __( 'The primary color for the button\'s background<br />Default: #E28C05', $this->textdomain ),
        'std' => '#E28C05',
        'id' => 'color-primary-button',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Secondary color for button', $this->textdomain ),
        'desc' => __( 'The color that the button\'s background fades to. For no gradient, use the primary color above. Or, for a nice effect, choose a monochromatic color to the primary one using <a href="https://kuler.adobe.com/create/color-wheel/">Adobe\'s Kuler tool</a>.<br />Default: #E67845', $this->textdomain ),
        'std' => '#E67845',
        'id' => 'color-secondary-button',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Primary color for button (hover)', $this->textdomain ),
        'desc' => __( 'The primary color for the button\'s background when hovering over it<br />Default: #F9B307', $this->textdomain ),
        'std' => '#F9B307',
        'id' => 'color-primary-button-hover',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Secondary color for button (hover)', $this->textdomain ),
        'desc' => __( 'The color that the button\'s background fades to when hovering over it. For no gradient, use the primary color above. Or, for a nice effect, choose a monochromatic color to the primary one using <a href="https://kuler.adobe.com/create/color-wheel/">Adobe\'s Kuler tool</a>.<br />Default: #e58356', $this->textdomain ),
        'std' => '#e58356',
        'id' => 'color-secondary-button-hover',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Primary color for button (active)', $this->textdomain ),
        'desc' => __( 'The primary color for the button\'s background when clicking on it<br />Default: #e58356', $this->textdomain ),
        'std' => '#e58356',
        'id' => 'color-primary-button-active',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Secondary color for button (active)', $this->textdomain ),
        'desc' => __( 'The color that the button\'s background fades to when clicking on it. For no gradient, use the primary color above. Or, for a nice effect, choose a monochromatic color to the primary one using <a href="https://kuler.adobe.com/create/color-wheel/">Adobe\'s Kuler tool</a>.<br />Default: #e39f0d', $this->textdomain ),
        'std' => '#e39f0d',
        'id' => 'color-secondary-button-active',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Checkmark', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( '"Powered By" checkmark color', $this->textdomain ),
        'desc' => __( 'The color for the Conversion Insights checkmark in the left corner of the bar', $this->textdomain ),
        'options' => array(
            'orange' => __( 'Orange', $this->textdomain ),
            'blue' => __( 'Blue', $this->textdomain ),
            'black' => __( 'Black', $this->textdomain )
        ),
        'std' => 'orange',
        'id' => 'checkmark-color',
        'type' => 'select'
    ),
    array(
        'name' => __( 'Text', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'name' => __( 'Text color', $this->textdomain ),
        'desc' => __( 'Default: #ffffff', $this->textdomain ),
        'std' => '#ffffff',
        'id' => 'color-text',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Text color for button', $this->textdomain ),
        'desc' => __( 'Default: #ffffff', $this->textdomain ),
        'std' => '#ffffff',
        'id' => 'color-text-button',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Text color for button (hover)', $this->textdomain ),
        'desc' => __( 'Default: #ffffff', $this->textdomain ),
        'std' => '#ffffff',
        'id' => 'color-text-button-hover',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Text color for button (active)', $this->textdomain ),
        'desc' => __( 'Default: #ffffff', $this->textdomain ),
        'std' => '#ffffff',
        'id' => 'color-text-button-active',
        'type' => 'color'
    ),
    array(
        'type' => 'closetab'
    ),
    /*array(
        'name' => __( 'Radio buttons', $this->textdomain ),
        'desc' => __( 'Radio buttons description', $this->textdomain ),
        'options' => array(
            'option1' => __( 'Option 1', $this->textdomain ),
            'option2' => __( 'Option 2', $this->textdomain ),
            'option3' => __( 'Option 3', $this->textdomain )
        ),
        'std' => 'option1',
        'id' => 'radio',
        'type' => 'radio'
    ),
    array(
        'name' => __( 'Select', $this->textdomain ),
        'desc' => __( 'Select description', $this->textdomain ),
        'options' => array(
            'option1' => __( 'Option 1', $this->textdomain ),
            'option2' => __( 'Option 2', $this->textdomain ),
            'option3' => __( 'Option 3', $this->textdomain )
        ),
        'std' => 'option1',
        'id' => 'select',
        'type' => 'select'
    ),
    /*array(
        'name' => __( 'Additional fields', $this->textdomain ),
        'type' => 'opentab'
    ),
    array(
        'name' => __( 'Title field', $this->textdomain ),
        'type' => 'title'
    ),
    array(
        'html' => '<p>Vestibulum nec quam nisl. Nulla facilisi. Etiam placerat tempor rutrum. Fusce pellentesque tellus adipiscing nulla eleifend pretium. In lacinia lectus et sapien elementum eget sollicitudin ante suscipit. Nunc eu arcu nec risus bibendum mattis. Suspendisse nisi magna, <a href="#">pretium in aliquam viverra</a>, cursus tincidunt quam. Ut nec risus elit, vel pellentesque felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p><p>Fusce venenatis condimentum est, eget gravida erat interdum tristique. In hac habitasse platea dictumst. In hac habitasse platea dictumst. Vestibulum fringilla egestas erat, sit amet ullamcorper nisi placerat vel.</p>',
        'type' => 'html'
    ),
    array(
        'name' => __( 'Checkbox group', $this->textdomain ),
        'desc' => __( 'Checkbox group description', $this->textdomain ),
        'options' => array(
            'option1' => __( 'Option 1', $this->textdomain ),
            'option2' => __( 'Option 2', $this->textdomain ),
            'option3' => __( 'Option 3', $this->textdomain )
        ),
        'std' => array(
            'option1' => '',
            'option2' => 'on',
            'option3' => 'on',
        ),
        'id' => 'checkbox-group',
        'type' => 'checkbox-group'
    ),
    array(
        'name' => __( 'Number', $this->textdomain ),
        'desc' => __( 'Number field description', $this->textdomain ),
        'std' => 100,
        'min' => 0,
        'max' => 1000,
        'units' => __( 'pixels', $this->textdomain ),
        'id' => 'number',
        'type' => 'number'
    ),
    array(
        'name' => __( 'Size', $this->textdomain ),
        'desc' => __( 'Size field description', $this->textdomain ),
        'std' => array( 14, 'px' ),
        'min' => 1,
        'max' => 72,
        'units' => array( 'px', 'em', '%', 'pt' ),
        'id' => 'size',
        'type' => 'size'
    ),
    array(
        'name' => __( 'Upload', $this->textdomain ),
        'desc' => __( 'Upload field description', $this->textdomain ),
        'std' => '',
        'id' => 'upload',
        'type' => 'upload'
    ),
    array(
        'name' => __( 'Color picker', $this->textdomain ),
        'desc' => __( 'Color picker description', $this->textdomain ),
        'std' => '#00bb00',
        'id' => 'color',
        'type' => 'color'
    ),
    array(
        'name' => __( 'Code editor', $this->textdomain ),
        'desc' => __( 'Code editor description', $this->textdomain ),
        'std' => '',
        'rows' => 7,
        'id' => 'code',
        'type' => 'code'
    ),
    array(
        'type' => 'closetab'
    ),*/
);
?>
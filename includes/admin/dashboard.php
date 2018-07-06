<?php

add_action( 'admin_menu', function () {
  $title = 'Magic GDPR Notice Settings';

  $settings = array(
    array(
      'name' => MAGIC_GDPR_SLUG . '_enabled',
      'type' => 'checkbox',
      'default' => false,
      'label' => 'Enable GDPR Notice and Cookie blocking',
    ),
    array (
      'name' => MAGIC_GDPR_SLUG . '_notice_title',
      'type' => 'text',
      'default' => 'Cookie usage notice',
      'label' => 'Title of the gdpr notice field',
    ),
    array (
      'name' => MAGIC_GDPR_SLUG . '_notice_logo',
      'type' => 'image',
      'label' => 'Logo Image to use next to the header text',
    ),

    array (
      'name' => MAGIC_GDPR_SLUG . '_submit_buttons_header',
      'type' => 'header',
      'value' => 'Submit Buttons',
      'label' => 'Shown on the bottom of the notice.',
    ),

    array(
      'name' => MAGIC_GDPR_SLUG . '_submit_button_text',
      'type' => 'text',
      'default' => 'Apply Changes',
      'label' => 'Submit button text',
    ),

    array(
      'name' => MAGIC_GDPR_SLUG . '_accept_all_enabled',
      'type' => 'checkbox',
      'default' => 0,
      'label' => 'Show the Accept All Button',
    ),

    array(
      'name' => MAGIC_GDPR_SLUG . '_accept_all_button_text',
      'type' => 'text',
      'default' => 'Accept All Cookies',
      'label' => 'Accept All Button text',
    ),

    array (
      'name' => MAGIC_GDPR_SLUG . '_notice_content',
      'type' => 'wysiwyg',
      'default' => 'Cookies enable us to provide you with a better experience while using this website.',
      'label' => 'Title of the gdpr notice field',
      'config' => array (
        'textarea_rows' => 3,
        'media_buttons' => false,
      ),
    ),

    array(
      'name' => MAGIC_GDPR_SLUG . '_cookie_header',
      'type' => 'header',
      'value' => 'cookies',
      'label' => 'Cookie settings. These Cookies will be shown in the notice.',
    ),

    array(
      'name' => MAGIC_GDPR_COOKIE_SLUG,
      'type' => 'textarea',
      'default' => MAGIC_GDPR_DEFAULT_COOKIES,
      'label' =>
        'Add one cookie per line. Format: NAME ' .
        MAGIC_DASHBOARD_COOKIE_SEP .
        'SLUG' .
        MAGIC_DASHBOARD_COOKIE_SEP .
        ' DESCRIPTION ' .
        MAGIC_DASHBOARD_COOKIE_SEP .
        ' cookie_name_1,cookie_name2,...' .
        '<br>Possible cookie group: "auth" - removes all auth cookies',
      'config' => array(
        'textarea_rows' => 5,
        'textarea_cols' => 50,
      ),
      // 'type' => 'list',
      // 'fields' => array(
      //   array(
      //     'name' => 'title',
      //     'type' => 'text',
      //     'label' => 'Cookie nicename',
      //     'template' => 'inputs/input.twig',
      //   ),
      //   array(
      //     'name' => 'text',
      //     'type' => 'text',
      //     'label' => 'Cookie description',
      //     'template' => 'inputs/input.twig',
      //   ),
      // ),
      // 'default' => array(
      //   array(
      //     'title' => 'Configuration Cookies',
      //     'text' => 'Remembers your choices and prevents this box from showing up.',
      //   ),
      //   array(
      //     'title' => 'Login Cookies',
      //     'text' => 'Saves your login until you close the site',
      //   ),
      // ),
    ),

    array(
      'name' => MAGIC_GDPR_SLUG . '_style_header',
      'type' => 'header',
      'value' => 'Styles',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_background_color',
      'type' => 'color',
      'default' => '#191919',
      'label' => 'Background color',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_title_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Title color',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_text_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Text color',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_border_style',
      'type' => 'text',
      'default' => '1px solid',
      'label' => 'Border around GDPR Notice',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_border_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Border color of GDPR Notice',
    ),
    array(
      'name' => MAGIC_GDPR_SLUG . '_border_radius',
      'type' => 'text',
      'default' => '1em',
      'label' => 'Border radius of GDPR Notice',
    ),
  );

  magic_dashboard_add_submenu_page( array (
    'link' => 'GDPR',
    'slug' => MAGIC_GDPR_SLUG,
    'title' => $title,
    'settings' => $settings,
   ) );
} );

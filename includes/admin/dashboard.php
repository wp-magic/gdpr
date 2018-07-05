<?php

add_action( 'admin_menu', function () {
  $title = 'Magic GDPR Notice Settings';

  $settings = array(
    array(
      'name' => 'magic_gdpr_enabled',
      'type' => 'checkbox',
      'default' => false,
      'label' => 'Enable GDPR Notice and Cookie blocking',
    ),
    array (
      'name' => 'magic_gdpr_notice_title',
      'type' => 'text',
      'default' => 'Cookie usage notice',
      'label' => 'Title of the gdpr notice field',
    ),
    array (
      'name' => 'magic_gdpr_notice_logo',
      'type' => 'image',
      'label' => 'Logo Image to use next to the header text',
    ),
    array(
      'name' => 'magic_gdpr_submit_button_text',
      'type' => 'text',
      'default' => 'Apply Changes',
      'label' => 'Submit button text',
    ),
    array (
      'name' => 'magic_gdpr_notice_content',
      'type' => 'wysiwyg',
      'default' => 'Cookies enable us to provide you with a better experience while using this website.',
      'label' => 'Title of the gdpr notice field',
      'config' => array (
        'textarea_rows' => 3,
        'media_buttons' => false,
      ),
    ),

    array(
      'name' => 'magic_gdpr_cookie_header',
      'type' => 'header',
      'value' => 'cookies',
      'label' => 'Cookie settings. These Cookies will be shown in the notice.',
    ),
    array(
      'name' => MAGIC_GDPR_COOKIE_SLUG,
      'type' => 'textarea',
      'default' => 'Configuration Cookies - Remembers your choices and prevents this box from showing up. - wordpress_text_cookie,magic_gpdr_settings_cookie
      \nLogin Cookies - Saves your login until you close the site - auth',
      'label' => 'Add one cookie per line. Format: {NAME} - {DESCRIPTION} - cookie_name_1,cookie_name2,...<br>Possible cookie groups: "auth" - removes all auth cookies',
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
      'name' => 'magic_gdpr_style_header',
      'type' => 'header',
      'value' => 'Styles',
    ),
    array(
      'name' => 'magic_gdpr_background_color',
      'type' => 'color',
      'default' => '#191919',
      'label' => 'Background color',
    ),
    array(
      'name' => 'magic_gdpr_title_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Title color',
    ),
    array(
      'name' => 'magic_gdpr_text_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Text color',
    ),
    array(
      'name' => 'magic_gdpr_border_style',
      'type' => 'text',
      'default' => '1px solid',
      'label' => 'Border around GDPR Notice',
    ),
    array(
      'name' => 'magic_gdpr_border_color',
      'type' => 'color',
      'default' => '#ffffff',
      'label' => 'Border color of GDPR Notice',
    ),
    array(
      'name' => 'magic_gdpr_border_radius',
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

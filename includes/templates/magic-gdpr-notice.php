<?php

/**
 * Magic Gdpr Notice
 *
 * @package Magic-Gdpr
 * @since   0.0.1
 */

function magic_gdpr_render_notice () {
  $context = Timber::get_context();

  $user = wp_get_current_user();

  $context['title'] = magic_get_option( MAGIC_GDPR_SLUG . '_notice_title' );
  $context['content'] = magic_get_option( MAGIC_GDPR_SLUG . '_notice_content' );
  $context['image'] = magic_get_option( MAGIC_GDPR_SLUG . '_notice_image' );
  $context['submit_button_text'] = magic_get_option( MAGIC_GDPR_SLUG . '_submit_button_text', 'Apply Changes' );

  $context['details_title'] = magic_get_option( MAGIC_GDPR_SLUG . '_details_title' );

  $default_cookies = 'Configuration Cookies - Remembers your choices and prevents this box from showing up.\nLogin Cookies - Saves your login until you close the site';

  $gdpr_cookies = magic_get_option( MAGIC_GDPR_SLUG . '_cookies', $default_cookies );

  $cookie_strings = explode( PHP_EOL, $gdpr_cookies );

  $context['cookies'] = [];

  foreach ( $cookie_strings as $cookie_string ) {
    $cookie_array = explode( '-', $cookie_string );
    $cookie = array(
      'title' => trim( $cookie_array[0] ),
      'description' => trim( $cookie_array[1] ),
      'slug' => MAGIC_GDPR_SLUG . '_' . str_replace( ' ', '_', strtolower( trim( $cookie_array[0] ) ) ),
    );

    $cookie['on'] = magic_get_option( $cookie['slug'] . '_enabled', false );

    $context['cookies'][] = $cookie;
  }

  $context['form'] = array(
    'url' => esc_url( admin_url('admin-post.php') ),
    'action' => MAGIC_GDPR_SLUG . '_settings',
    'nonce' => wp_create_nonce( MAGIC_GDPR_SLUG . '_settings' ),
  );

  Timber::render( 'views/notice.twig', $context );
}

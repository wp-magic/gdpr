<?php

function magic_gdpr_post_settings() {
  $ref = $_SERVER['HTTP_REFERER'];

  $gdpr_cookies_option_name = MAGIC_GDPR_SLUG . '_cookies';

  $gdpr_cookies = magic_get_option( $gdpr_cookies_option_name );
  $cookie_strings = explode( PHP_EOL, $gdpr_cookies );

  $cookies = [];

  foreach ( $cookie_strings as $cookie_string ) {
    $cookie_array = explode( '-', $cookie_string );
    $cookie_slug = str_replace( ' ', '_', strtolower( trim( $cookie_array[0] ) ) );
    $slug = MAGIC_GDPR_SLUG . '_' . $cookie_slug . '_enabled';

    if ( isset( $_POST[$slug] ) ) {
      $on = false;
      if ( $_POST[$slug] === 'on' ) {
        $on = true;
      }

      $cookies[$slug] = $on;
    }
  }

  print_r($cookies);

  // wp_redirect( $_SERVER['HTTP_REFERER'] );
  exit;
}

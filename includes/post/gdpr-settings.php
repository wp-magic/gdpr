<?php

function magic_gdpr_post_settings() {
  $ref = $_SERVER['HTTP_REFERER'];

  $gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG );
  $cookie_strings = explode( PHP_EOL, $gdpr_cookies );

  $cookies = [];

  foreach ( $cookie_strings as $cookie_string ) {
    $cookie_array = explode( '-', $cookie_string );
    $cookie_slug = magic_slugify( $cookie_array[0] );
    $slug = MAGIC_GDPR_SLUG . '_' . $cookie_slug . '_enabled';

    $on = false;
    if ( isset( $_POST[$slug] ) && $_POST[$slug] === 'on' ) {
      $on = true;
    }

    magic_set_option( $slug, $on );
    $cookies[$cookie_slug] = $on;
  }

  if ( !empty($cookies['configuration_cookies'] ) ) {
    $ar = '';
    foreach ($cookies as $key => $value ) {
      $ar = add_query_arg($key, $value, $ar);
    }
    $ar = str_replace( '?', '', $ar );

    $one_year = 365 * 60 * 60 * 24;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    $secure = isset( $_SERVER['HTTPS'] );
    $http_only = true;
    setcookie( MAGIC_GDPR_COOKIE_SLUG, $ar, time() + $one_year, '/', $domain, $secure, $http_only );
  }

  wp_redirect( $ref );
  exit;
}

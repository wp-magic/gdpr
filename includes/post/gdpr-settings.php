<?php

add_action( 'admin_post_nopriv_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, 'magic_gdpr_post_settings' );
add_action( 'admin_post_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, 'magic_gdpr_post_settings' );

function magic_gdpr_post_settings() {
  $ref = $_SERVER['HTTP_REFERER'];

  $gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );
  $cookie_strings = explode( PHP_EOL, $gdpr_cookies );

  $cookies = magic_deserialize_cookie($gdpr_cookies);

  $cookie_query_string = '';

  foreach ($cookies as $cookie ) {
    if ( empty( $cookie ) || empty( $cookie['slug'] ) ) {
      break;
    }

    if ( !empty( $cookie['on'] ) ) {
      $cookie_query_string = add_query_arg( $cookie['slug'], 1, $cookie_query_string );
    }
  }

  $cookie_query_string = substr( $cookie_query_string, 1 );

  if ( empty( $cookie_query_string ) ) {
    wp_redirect( $ref );
    exit;
  }

  $one_year = 365 * 60 * 60 * 24;
  $path = '/';
  $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
  $secure = isset( $_SERVER['HTTPS'] );
  $http_only = true;

  setcookie(
    MAGIC_GDPR_COOKIE_SLUG,
    $cookie_query_string,
    time() + $one_year,
    $path,
    $domain,
    $secure,
    $http_only
  );

  wp_redirect( $ref );
  exit;
}

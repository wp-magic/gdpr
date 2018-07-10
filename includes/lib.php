<?php

if ( !function_exists( 'magic_gdpr_check_cookies') ) {
  function magic_gdpr_check_cookies() {
    return !empty( $_COOKIE[MAGIC_GDPR_COOKIE_SLUG] );
  }
}

if ( !function_exists( 'magic_gdpr_remove_cookies' ) ) {
  function magic_gdpr_remove_cookies() {
    $gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );
    $cookies = magic_deserialize_cookie( $gdpr_cookies );

    foreach ( $cookies as $cookie ) {
      $allowed_cookies = wp_parse_args( $_COOKIE[MAGIC_GDPR_COOKIE_SLUG] );

      if ( empty( $allowed_cookies[$cookie['slug']] ) ) {
        if ( !current_user_can( 'delete_posts' ) ) {
          if ($cookie['cookies'] === 'auth' ) {
            wp_clear_auth_cookie();
          } else {
            foreach ( $cookie['cookies'] as $cc ) {
              setcookie( magic_slugify($cc), null, 0 );
            }
          }
        }
      }
    }
  }
}

if ( !function_exists( 'magic_gdpr_set_cookies' ) ) {
  function magic_gdpr_set_cookies( array $forced_cookies = [] ) {
    $gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );

    $cookies = magic_deserialize_cookie($gdpr_cookies);

    $cookie_query_string = '';

    foreach ($cookies as $cookie ) {
      $allowed_cookies = wp_parse_args( $_COOKIE[MAGIC_GDPR_COOKIE_SLUG] );

      $slug = $cookie['slug'];

      if ( !empty( $cookie['on'] ) || in_array( $slug, $forced_cookies ) ) {
        $cookie_query_string = add_query_arg( $slug, 1, $cookie_query_string );
      }
    }

    $cookie_query_string = substr( $cookie_query_string, 1 );

    if ( empty( $cookie_query_string ) ) {
      return;
    }

    $one_year = 365 * 60 * 60 * 24;
    $path = '/';
    $domain = ($_SERVER['HTTP_HOST'] !== 'localhost') ? $_SERVER['HTTP_HOST'] : false;
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
  }
}

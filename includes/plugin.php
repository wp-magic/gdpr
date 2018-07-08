<?php
/**
 * Appointment Gdpr Compliance
 *
 * @package   Magic_Gdpr
 * @license   GPL-2.0+
 */

require_once 'post/gdpr-settings.php';
require_once 'templates/magic-gdpr-notice.php';
require_once 'styles/index.php';

if ( is_admin() ) {
  require_once 'admin/requirements.php';
  require_once 'admin/dashboard.php';
}

add_action( 'wp_footer', 'magic_gdpr_render_notice' );
add_action( 'init', 'magic_gdpr_remove_cookies', PHP_INT_MAX - 1 );

add_action( 'init', function () {
  $domain = MAGIC_GDPR_SLUG;
  load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ) . '/languages' );
} );

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
    $ref = $_SERVER['HTTP_REFERER'];

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
}

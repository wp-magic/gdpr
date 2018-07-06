<?php
/**
 * Appointment Gdpr Compliance
 *
 * @package   Magic_Gdpr
 * @license   GPL-2.0+
 */

require_once 'fallback/index.php';
// require_once 'custom-fields/index.php';

require_once 'post/gdpr-settings.php';

require_once 'templates/magic-gdpr-notice.php';
add_action( 'wp_footer', 'magic_gdpr_render_notice' );

require_once 'styles/index.php';

add_action( 'init', function () {
  $domain = MAGIC_GDPR_SLUG;
  load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ) . '/languages' );
} );

function magic_gdpr_unset_cookies( $slug, $category ) {
  if ( !current_user_can( 'delete_posts' ) ) {
    if (trim($category) === 'auth' ) {
      wp_clear_auth_cookie();
    } else {
      $cookies = explode( ',', $category );
      foreach ( $cookies as $cookie ) {
        $cookie = trim( $cookie );
        if (!empty( $cookie ) ) {
          setcookie( $cookie, null, 0 );
        }
      }
    }
  }
}

add_action( 'init', function () {
  $in_one_year = time() + 365 * 60 * 60 * 24;
  $gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG );

  if ( !$gdpr_cookies ) {
    return;
  }

  $cookies = explode( PHP_EOL, $gdpr_cookies );

  foreach ( $cookies as $cookie ) {
    $cookie_array = explode( '-', $cookie );
    if ( empty( $cookie_array ) ) {
      return;
    }

    $slug = str_replace(' ', '_', strtolower( trim( $cookie_array[0] ) ) );

    $option_name = MAGIC_GDPR_SLUG . '_' . $slug . '_enabled';

    $setting = magic_get_option( $option_name );
    if ( empty( $setting ) ) {
      magic_gdpr_unset_cookies( $slug, $cookie_array[2] );
    }
  }
}, PHP_INT_MAX - 1 );


if ( is_admin() ) {
  require_once 'admin/requirements.php';

  require_once 'admin/dashboard.php';
}

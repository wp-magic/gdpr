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
add_action( 'admin_post_nopriv_magic_gdpr_settings', 'magic_gdpr_post_settings' );
add_action( 'admin_post_magic_gdpr_settings', 'magic_gdpr_post_settings' );

require_once 'templates/magic-gdpr-notice.php';
add_action( 'wp_footer', 'magic_gdpr_render_notice' );

require_once 'styles/index.php';

add_action( 'init', function () {
  $domain = MAGIC_GDPR_SLUG;
  load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ) . '/languages' );
} );


add_action( 'init', function () {
  $in_one_year = time() + 365 * 60 * 60 * 24;
  $gdpr_cookies = magic_get_option( MAGIC_GDPR_SLUG . '_cookies' );

  $cookies = explode( PHP_EOL, $gdpr_cookies );

  foreach ( $cookies as $cookie ) {
    // print_r( $cookie );
    // print('<br>');
  }

  // setcookie( 'magic_gdpr_settings', 'cookie_value', $in_one_year );
} );

if ( is_admin() ) {
  require_once 'admin/requirements.php';

  require_once 'admin/dashboard.php';
}

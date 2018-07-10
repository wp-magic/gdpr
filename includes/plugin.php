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

require_once 'lib.php';

if ( is_admin() ) {
  require_once 'admin/requirements.php';
  require_once 'admin/dashboard.php';
}

add_action( 'wp_footer', 'magic_gdpr_render_notice' );
add_action( 'init', 'magic_gdpr_remove_cookies', PHP_INT_MAX - 1 );

add_action('init', function () {
  $domain = MAGIC_GDPR_SLUG;
  load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ) . 'languages' );
} );

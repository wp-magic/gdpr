<?php
/**
 * Gdpr Compliance For WordPress Blogs
 *
 * @package   MagicGdpr
 * @since 0.0.1
 */

/**
 * Require gdpr post request functionality
 */
require_once 'post/gdpr-settings.php';

/**
 * Require timber templates
 */
require_once 'templates/magic-gdpr-notice.php';

/**
 * Enqueue needed styles
 */
require_once 'styles/index.php';

/**
 * Require lib utility files
 */
require_once 'lib.php';

/**
 * Require admin dashboard
 */
if ( is_admin() ) {
	require_once 'admin/dashboard.php';
}

/**
 * Add notice to footer
 */
add_action( 'wp_footer', 'magic_gdpr_render_notice' );

/**
 * Remove all cookies if no consent has been given.
 * Do this last.
 */
add_action( 'init', 'magic_gdpr_remove_cookies', PHP_INT_MAX - 1 );

/**
 * Load plugin textdomain.
 */
add_action(
	'init',
	function () {
		$domain = MAGIC_GDPR_SLUG;
		load_plugin_textdomain( $domain, false, plugin_dir_path( __FILE__ ) . 'languages' );
	}
);

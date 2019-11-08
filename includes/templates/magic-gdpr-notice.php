<?php
/**
 * Magic Gdpr Notice
 *
 * @package MagicGdpr
 * @since   0.0.1
 */

/**
 * Actually render the notice using timber.
 *
 * @since 0.0.1
 */
function magic_gdpr_render_notice() {
	$context = Timber::get_context();

	$cookie_query_string = ! empty( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] )
	? sanitize_text_field( wp_unslash( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) )
	: '';

	$config = wp_parse_args( $cookie_query_string );

	if ( ! empty( $config ) && ! empty( $config['settings'] ) ) {
		return;
	}

	$context['gdpr_enabled'] = magic_get_option( MAGIC_GDPR_SLUG . '_enabled', 0 );
	if ( empty( $context['gdpr_enabled'] ) ) {
		return;
	}

	$context['title']              = magic_get_option( MAGIC_GDPR_SLUG . '_notice_title' );
	$context['content']            = magic_get_option( MAGIC_GDPR_SLUG . '_notice_content' );
	$context['image']              = magic_get_option( MAGIC_GDPR_SLUG . '_notice_image' );
	$context['submit_button_text'] = magic_get_option( MAGIC_GDPR_SLUG . '_submit_button_text', 'Apply Changes' );
	$context['details_title']      = magic_get_option( MAGIC_GDPR_SLUG . '_details_title' );

	$gdpr_cookies       = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );
	$context['cookies'] = magic_deserialize_cookie( $gdpr_cookies );

	$context['accept_all_enabled']     = magic_get_option( MAGIC_GDPR_SLUG . '_accept_all_enabled' );
	$context['accept_all_button_text'] = magic_get_option( MAGIC_GDPR_SLUG . '_accept_all_button_text' );

	$context['form'] = array(
		'url'    => esc_url( admin_url( 'admin-post.php' ) ),
		'action' => MAGIC_GDPR_COOKIE_SETTINGS_ACTION,
		'nonce'  => wp_create_nonce( MAGIC_GDPR_COOKIE_SETTINGS_ACTION ),
	);

	Timber::render( 'views/notice.twig', $context );
}

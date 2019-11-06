<?php
/**
 * Handle cookie accept post requests
 *
 * @package MagicGdpr
 */

add_action( 'admin_post_nopriv_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, 'magic_gdpr_post_cookie_notice' );
add_action( 'admin_post_' . MAGIC_GDPR_COOKIE_SETTINGS_ACTION, 'magic_gdpr_post_cookie_notice' );

/**
 * Handle post request for cookie notice form.
 */
function magic_gdpr_post_cookie_notice() {
	if ( empty( $_POST['nonce'] ) ) {
		exit;
	}

	$nonce_valid = wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), MAGIC_GDPR_COOKIE_SETTINGS_ACTION );

	if ( ! $nonce_valid ) {
		exit;
	}

	if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
		$ref = sanitize_text_field( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
	} else {
		$ref = '/';
	}

	$gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );

	$cookies = magic_deserialize_cookie( $gdpr_cookies, MAGIC_GDPR_COOKIE_SEP );

	foreach ( $cookies as $key => $cookie ) {
		$slug         = $cookie['slug'];
		$cookies[ $key ]['on'] = ! empty( $_POST[ $slug ] ) || ! empty( $_POST['accept-all'] );
	}

	$cookie_query_string = '';

	foreach ( $cookies as $cookie ) {
		$slug = $cookie['slug'];

		if ( ! empty( $cookie['on'] ) ) {
			$cookie_query_string = add_query_arg( $slug, 1, $cookie_query_string );
		}
	}

	$cookie_query_string = substr( $cookie_query_string, 1 );

	if ( empty( $cookie_query_string ) ) {
		wp_safe_redirect( $ref );
		exit;
	}

	$one_year = 365 * 60 * 60 * 24;
	$path     = '/';
	$server   = ! empty( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : 'localhost';

	if ( 'localhost:8080' === $server || 'localhost' === $server ) {
		$domain = 'localhost';
	} else {
		$domain = $server;
	}

	$secure    = isset( $_SERVER['HTTPS'] );
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

	wp_safe_redirect( $ref );
	exit;
}

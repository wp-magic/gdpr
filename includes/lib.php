<?php
/**
 * Various utility functions
 *
 * @package MagicGdpr
 * @since 0.0.1
 */

if ( ! function_exists( 'magic_gdpr_check_cookies' ) ) {
	/**
	 * Check Gdpr Cookie for existance
	 *
	 * @since 0.0.1
	 *
	 * @param string $cookie name of the cookie.
	 *
	 * @return bool true if cookie is set.
	 */
	function magic_gdpr_check_cookies( string $cookie = 'auth' ) {
		if ( empty( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) {
			return false;
		}

		$cookie_vals = wp_parse_args( sanitize_text_field( wp_unslash( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) );
		return ! empty( $cookie_vals[ $cookie ] );
	}
}

if ( ! function_exists( 'magic_gdpr_remove_cookies' ) ) {
	/**
	 * Remove ALL cookies.
	 *
	 * @since 0.0.1
	 */
	function magic_gdpr_remove_cookies() {
		$gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );
		$cookies      = magic_deserialize_cookie( $gdpr_cookies, MAGIC_GDPR_COOKIE_SEP );

		setcookie( 'PHPSESSID', null, 0 );

		foreach ( $cookies as $cookie ) {
			if ( ! empty( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) {
				$allowed_cookies = wp_parse_args( sanitize_text_field( wp_unslash( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) );
			}

			if ( empty( $allowed_cookies[ $cookie['slug'] ] ) ) {
				if ( ! current_user_can( 'delete_posts' ) ) {
					foreach ( $cookie['cookies'] as $cc ) {
						if ( 'auth' === $cc ) {
							wp_clear_auth_cookie();
						} else {
							setcookie( magic_slugify( $cc ), null, 0 );
						}
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'magic_gdpr_set_cookies' ) ) {
	/**
	 * Set Gdpr cookies according to user consent settings.
	 *
	 * @since 0.0.1
	 *
	 * @param array $forced_cookies array of cookies to be force set.
	 */
	function magic_gdpr_set_cookies( array $forced_cookies = [] ) {
		$gdpr_cookies = magic_get_option( MAGIC_GDPR_COOKIE_SLUG, MAGIC_GDPR_DEFAULT_COOKIES );

		$cookies = magic_deserialize_cookie( $gdpr_cookies, MAGIC_GDPR_COOKIE_SEP );

		$cookie_query_string = '';

		foreach ( $cookies as $cookie ) {
			$slug = $cookie['slug'];

			if ( ! empty( $cookie['on'] ) || in_array( $slug, $forced_cookies, true ) ) {
				$cookie_query_string = add_query_arg( $slug, 1, $cookie_query_string );
			}
		}

		$cookie_query_string = substr( $cookie_query_string, 1 );

		if ( empty( $cookie_query_string ) ) {
			return;
		}

		$host = false;

		if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
			$host = esc_url_raw( wp_unslash( $_SERVER['HTTP_HOST'] ) );
		}

		$one_year  = 365 * 60 * 60 * 24;
		$path      = '/';
		$domain    = 'localhost' !== $host ? $host : false;
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
	}
}

if ( ! function_exists( 'magic_gdpr_create_context' ) ) {
	/**
	 * Enhance timber context with cookie information
	 *
	 * @since 0.0.1
	 *
	 * @param array $context timber context.
	 *
	 * @return array timber context with cookies.
	 */
	function magic_gdpr_create_context( array $context = [] ) {
		$context['gdpr_exists'] = true;
		if ( ! empty( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) {
			$enabled_cookies    = wp_parse_args( sanitize_text_field( wp_unslash( $_COOKIE[ MAGIC_GDPR_COOKIE_SLUG ] ) ) );
			$context['cookies'] = $enabled_cookies;
		}

		return $context;
	}
}

<?php
/**
 * Enqueue Gdpr Notice css styles and add less Variables.
 *
 * @package MagicGdpr
 * @since 0.0.1
 */

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( class_exists( 'WPLessPlugin' ) ) {
			$less = WPLessPlugin::getInstance();

			$less->setVariables(
				array(
					'gdpr_background_color'  => magic_get_option( 'magic_gdpr_background_color', '#191919' ),

					'gdpr_text_color'        => magic_get_option( 'magic_gdpr_text_color', '#fff' ),
					'gdpr_text_font_family'  => magic_get_option( 'magic_gdpr_text_font_family', 'inherit' ),

					'gdpr_title_color'       => magic_get_option( 'magic_gdpr_title_font_family', '#fff' ),
					'gdpr_title_font_family' => magic_get_option( 'magic_gdpr_title_font_family', 'inherit' ),

					'gdpr_border_style'      => magic_get_option( 'magic_gdpr_border_style', 'inherit' ),
					'gdpr_border_color'      => magic_get_option( 'magic_gdpr_border_color', '#fff' ),
					'gdpr_border_radius'     => magic_get_option( 'magic_gdpr_border_radius', '0.5em' ),
				)
			);
		}

		magic_register_style( 'magic-gdpr', dirname( plugin_basename( __FILE__ ) ) );
	}
);

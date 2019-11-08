<?php
/**
 * Magic GDPR Notice
 *
 * @package   Magic-Gdpr
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Magic Gdpr Notice
 * Plugin URI:
 * Description: Gdpr Notice for your blog.
 * Version:     0.0.1
 * Author:      Jascha Ehrenreich
 * Author URI:  http://github.com/wp-magic
 * Text Domain: magic_gdpr
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'MAGIC_GDPR_COOKIE_SEP' ) ) {
	define( 'MAGIC_GDPR_COOKIE_SEP', '|||' );
}

define( 'MAGIC_GDPR_SLUG', 'magic_gdpr' );
define( 'MAGIC_GDPR_COOKIE_SLUG', 'magic_gdpr_cookie' );
define( 'MAGIC_GDPR_COOKIE_SETTINGS_SLUG', 'magic_gdpr_cookies' );
define( 'MAGIC_GDPR_COOKIE_SETTINGS_ACTION', 'magic_gdpr_cookies_submit' );
define(
	'MAGIC_GDPR_DEFAULT_COOKIES',
	'Settings' .
	MAGIC_GDPR_COOKIE_SEP .
	'settings' .
	MAGIC_GDPR_COOKIE_SEP .
	'Prevents this box from showing up again.' .
	MAGIC_GDPR_COOKIE_SEP .
	'wordpress_test_cookie, ' . MAGIC_GDPR_COOKIE_SETTINGS_SLUG .
	PHP_EOL .
	'Authentication' .
	MAGIC_GDPR_COOKIE_SEP .
	'auth' .
	MAGIC_GDPR_COOKIE_SEP .
	'These cookies allow you to log in.' .
	MAGIC_GDPR_COOKIE_SEP .
	'auth'
);

define(
	'MAGIC_GDPR_CUSTOM_FIELDS',
	array(
		'tab_cookies'               => array(
			'type'  => 'tab',
			'label' => 'GDPR settings',
		),

		'before_allow_cookies_text' => array(
			'label'         => 'Text before Allow Login Cookie Checkbox',
			'type'          => 'wysiwyg',
			'default_value' => 'Cookies are small pieces of data saved on your computer.

Login Cookies are used to save your session and allow you to stay logged in to our site.

If you do not allow login cookies, the login will not work.',
		),

		'allow_cookies_label'       => array(
			'label'         => 'Text shown next to cookie checkbox',
			'default_value' => 'Accept login cookies',
		),

		'after_allow_cookies_text'  => array(
			'label' => 'Text after Allow Login Cookie Checkbox',
			'type'  => 'wysiwyg',
		),
	)
);

define( 'MAGIC_GDPR_FORM_INPUT_TEMPLATE', 'magic-gdpr-form-inputs.twig' );

require_once plugin_dir_path( __FILE__ ) . 'includes/plugin.php';

register_activation_hook(
	__FILE__,
	function () {
		flush_rewrite_rules();
	}
);

register_deactivation_hook(
	__FILE__,
	function () {
		flush_rewrite_rules();
	}
);

<?php
/**
 * Add admin menu sections for this plugin.
 *
 * @package MagicGdpr
 * @since 0.0.1
 */

add_action(
	'admin_menu',
	function () {
		$title = 'Magic GDPR Settings';

		$settings = array(
			array(
				'name'    => 'enabled',
				'type'    => 'checkbox',
				'default' => false,
				'label'   => 'Enable GDPR Notice and Cookie blocking',
			),
			array(
				'name'    => 'notice_title',
				'type'    => 'text',
				'default' => 'Cookie usage notice',
				'label'   => 'Title of the gdpr notice field',
			),
			array(
				'name'  => 'notice_logo',
				'type'  => 'image',
				'label' => 'Logo Image to use next to the header text',
			),

			array(
				'name'  => 'submit_buttons_header',
				'type'  => 'header',
				'value' => 'Submit Buttons',
				'label' => 'Shown on the bottom of the notice.',
			),

			array(
				'name'    => 'submit_button_text',
				'type'    => 'text',
				'default' => 'Apply Changes',
				'label'   => 'Submit button text',
			),

			array(
				'name'    => 'accept_all_enabled',
				'type'    => 'checkbox',
				'default' => 0,
				'label'   => 'Show the Accept All Button',
			),

			array(
				'name'    => 'accept_all_button_text',
				'type'    => 'text',
				'default' => 'Accept All Cookies',
				'label'   => 'Accept All Button text',
			),

			array(
				'name'    => 'notice_content',
				'type'    => 'wysiwyg',
				'default' => 'Cookies enable us to provide you with a better experience while using this website.',
				'label'   => 'Title of the gdpr notice field',
				'config'  => array(
					'textarea_rows' => 3,
					'media_buttons' => false,
				),
			),

			array(
				'name'  => 'cookie_header',
				'type'  => 'header',
				'value' => 'cookies',
				'label' => 'Cookie settings. These Cookies will be shown in the notice.',
			),

			array(
				'name'    => 'cookie',
				'type'    => 'textarea',
				'default' => MAGIC_GDPR_DEFAULT_COOKIES,
				'label'   =>
					'Add one cookie per line. Format: NAME ' .
					MAGIC_GDPR_COOKIE_SEP .
					'SLUG' .
					MAGIC_GDPR_COOKIE_SEP .
					' DESCRIPTION ' .
					MAGIC_GDPR_COOKIE_SEP .
					' cookie_name_1,cookie_name2,...' .
					'<br>Possible cookie group: "auth" - removes all auth cookies',
				'config'  => array(
					'textarea_rows' => 5,
					'textarea_cols' => 50,
				),
			),

			array(
				'name'  => 'style_header',
				'type'  => 'header',
				'value' => 'Styles',
			),
			array(
				'name'    => 'background_color',
				'type'    => 'color',
				'default' => '#191919',
				'label'   => 'Background color',
			),
			array(
				'name'    => 'title_color',
				'type'    => 'color',
				'default' => '#ffffff',
				'label'   => 'Title color',
			),
			array(
				'name'    => 'text_color',
				'type'    => 'color',
				'default' => '#ffffff',
				'label'   => 'Text color',
			),
			array(
				'name'    => 'border_style',
				'type'    => 'text',
				'default' => '1px solid',
				'label'   => 'Border around GDPR Notice',
			),
			array(
				'name'    => 'border_color',
				'type'    => 'color',
				'default' => '#ffffff',
				'label'   => 'Border color of GDPR Notice',
			),
			array(
				'name'    => 'border_radius',
				'type'    => 'text',
				'default' => '1em',
				'label'   => 'Border radius of GDPR Notice',
			),
		);

		magic_dashboard_add_submenu_page(
			array(
				'link'     => 'GDPR',
				'slug'     => MAGIC_GDPR_SLUG,
				'title'    => $title,
				'settings' => $settings,
				'action'   => MAGIC_GDPR_DASHBOARD_POST_SETTINGS,
			)
		);
	},
	2
);

<?php

class Thim_Login_Popup_Widget extends Thim_Widget {
	function __construct() {
		parent::__construct(
			'login-popup',
			esc_html__( 'Thim: Login Popup', 'eduma' ),
			array(
				'panels_groups' => array( 'thim_widget_group' ),
				'panels_icon'   => 'thim-widget-icon thim-widget-icon-login-popup'
			),
			array(),
			array(
				'text_register' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Register Label', 'eduma' ),
					'default' => 'Register',
				),
				'text_login'    => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Login Label', 'eduma' ),
					'default' => 'Login',
				),
				'text_logout'   => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Logout Label', 'eduma' ),
					'default' => 'Logout',
				),
				'text_profile'  => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Profile Label', 'eduma' ),
					'default' => 'Profile',
				),
				'layout'        => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Layout', 'eduma' ),
					'default' => 'base',
					'options' => array(
						'base' => esc_html__( 'Default', 'eduma' ),
						'icon' => esc_html__( 'Icon', 'eduma' ),
					),
				),
				'captcha'       => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Use captcha?', 'eduma' ),
					'description' => esc_html__( 'Use captcha in register and login form.', 'eduma' ),
					'default'     => false
				),
				'term'          => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Terms of Service link', 'eduma' ),
					'description' => esc_html__( 'Leave empty to disable this field.', 'eduma' ),
					'default'     => '',
				),
				'shortcode'     => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Shortcode', 'eduma' ),
					'description' => esc_html__( 'Enter shortcode to show in form Login.', 'eduma' ),
					'default'     => '',
				)

			)
		);
	}


	/**
	 * Initialize the CTA widget
	 */


	function get_template_name( $instance ) {
		return 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}

}

function thim_login_popup_widget() {
	register_widget( 'Thim_Login_Popup_Widget' );

}

add_action( 'widgets_init', 'thim_login_popup_widget' );


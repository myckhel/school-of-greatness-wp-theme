<div class="thim-link-login thim-login-popup">
	<?php
	$layout               = isset( $instance['layout'] ) ? $instance['layout'] : 'base';
	$profile_text         = $logout_text = $login_text = $register_text = '';
	$registration_enabled = get_option( 'users_can_register' );

	if ( 'base' == $layout ) {
		$profile_text  = isset( $instance['text_profile'] ) ? $instance['text_profile'] : '';
		$logout_text   = isset( $instance['text_logout'] ) ? $instance['text_logout'] : '';
		$login_text    = isset( $instance['text_login'] ) ? $instance['text_login'] : '';
		$register_text = isset( $instance['text_register'] ) ? $instance['text_register'] : '';
	} else {
		$profile_text = '<i class="ion-android-person"></i>';
		$logout_text  = '<i class="ion-ios-redo"></i>';
		$login_text   = '<i class="ion-android-person"></i>';
	}

	// Login popup link output
	if ( is_user_logged_in() ) {
		if ( thim_plugin_active( 'learnpress/learnpress.php' ) && $profile_text ) {
			if ( thim_is_new_learnpress( '1.0' ) ) {
				echo '<a class="profile" href="' . esc_url( learn_press_user_profile_link() ) . '">' . ( $profile_text ) . '</a>';
			} else {
				echo '<a class="profile" href="' . esc_url( apply_filters( 'learn_press_instructor_profile_link', '#', get_current_user_id(), '' ) ) . '">' . ( $profile_text ) . '</a>';
			}
		}

		if ( $login_text ) {
			?>
			<a class="logout" href="<?php echo esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', ( ! empty( $_SERVER['HTTPS'] ) ? "https" : "http" ) . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) ) ); ?>"><?php echo( $logout_text ); ?></a>
			<?php
		}
	} else {
		if ( $registration_enabled && 'base' == $layout ) {
			if ( $register_text ) {
				echo '<a class="register js-show-popup" href="' . esc_url( thim_get_register_url() ) . '">' . ( $register_text ) . '</a>';
			}
		}

		if ( $login_text ) {
			echo '<a class="login js-show-popup" href="' . esc_url( thim_get_login_page_url() ) . '">' . ( $login_text ) . '</a>';
		}
	}
	// End login popup link output
	?>
</div>

<?php if ( ! is_user_logged_in() ): ?>
	<div id="thim-popup-login">
		<div class="thim-login-container<?php echo ( ! empty( $instance['shortcode'] ) ) ? ' has-shortcode' : ''; ?>">
			<?php
			if ( ! empty( $instance['shortcode'] ) ) {
				echo do_shortcode( $instance['shortcode'] );
			}

			$current_page_id = get_queried_object_id();
			?>

			<div class="thim-login">
				<?php
				$login_redirect_option = get_theme_mod( 'thim_login_redirect', false );

				// Set link via priority
				if ( ! empty( $_REQUEST['redirect_to'] ) ) {
					$login_redirect = $_REQUEST['redirect_to'];
				} else if ( ! empty( $login_redirect_option ) ) {
					$login_redirect = $login_redirect_option;
				} else {
					$login_redirect = get_permalink( $current_page_id );
				}

				if ( is_singular( 'lp_course' ) ) {
					if ( get_theme_mod( 'thim_auto_login', true ) ) {
						$login_redirect = add_query_arg( array( 'enroll-course' => $current_page_id ), $login_redirect );
					}
				}
				?>

				<h4 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h4>
				<form name="loginpopopform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">

					<?php do_action( 'thim_before_login_form' ); ?>

					<p class="login-username">
						<input type="text" name="log" placeholder="<?php esc_html_e( 'Username or email', 'eduma' ); ?>" class="input required" value="" size="20" />
					</p>
					<p class="login-password">
						<input type="password" name="pwd" placeholder="<?php esc_html_e( 'Password', 'eduma' ); ?>" class="input required" value="" size="20" />
					</p>

					<?php
					/**
					 * Fires following the 'Password' field in the login form.
					 *
					 * @since 2.1.0
					 */
					do_action( 'login_form' );
					?>

					<?php if ( ! empty( $instance['captcha'] ) ): ?>
						<p class="thim-login-captcha">
							<?php
							$value_1 = rand( 1, 9 );
							$value_2 = rand( 1, 9 );
							?>
							<input type="text" data-captcha1="<?php echo esc_attr( $value_1 ); ?>" data-captcha2="<?php echo esc_attr( $value_2 ); ?>" placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>" class="captcha-result required" />
						</p>
					<?php endif; ?>

					<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'eduma' ) . '">' . esc_html__( 'Lost your password?', 'eduma' ) . '</a>'; ?>
					<p class="forgetmenot login-remember">
						<label for="popupRememberme"><input name="rememberme" type="checkbox" value="forever" id="popupRememberme" /> <?php esc_html_e( 'Remember Me', 'eduma' ); ?>
						</label></p>
					<p class="submit login-submit">
						<input type="submit" name="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Login', 'eduma' ); ?>" />
						<input type="hidden" name="redirect_to" value="<?php echo esc_url( $login_redirect ); ?>" />
						<input type="hidden" name="testcookie" value="1" />
					</p>

					<?php do_action( 'thim_after_login_form' ); ?>

				</form>
				<?php

				if ( $registration_enabled ) {
					echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . '<a class="register" href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>';
				}
				?>
			</div>

			<?php if ( $registration_enabled ): ?>
				<div class="thim-register">
					<?php if ( is_active_sidebar( 'register-widget-manual' ) ) : ?>
						<ul id="sidebar" class="text-center col">
							<?php dynamic_sidebar( 'register-widget-manual' ); ?>
						</ul>
					<?php endif; ?>
				</div>
				<div class="thim-register">
					<?php
					$register_redirect_option = get_theme_mod( 'thim_register_redirect', false );

					// Set link via priority
					if ( ! empty( $_REQUEST['redirect_to'] ) ) {
						$register_redirect = $_REQUEST['redirect_to'];
					} else if ( ! empty( $register_redirect_option ) ) {
						$register_redirect = $register_redirect_option;
					} else {
						$register_redirect = get_permalink( $current_page_id );
					}

					if ( is_singular( 'lp_course' ) ) {
						if ( get_theme_mod( 'thim_auto_login', true ) ) {
							$register_redirect = add_query_arg( array( 'enroll-course' => $current_page_id ), $register_redirect );
						}
					}
					?>

					<h4 class="title"><?php echo esc_html_x( 'Register', 'Login popup form', 'eduma' ); ?></h4>

					<form class="<?php if ( get_theme_mod( 'thim_auto_login', true ) ) {
						echo 'auto_login';
					} ?>" name="registerformpopup" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post" novalidate="novalidate">

						<?php wp_nonce_field( 'ajax_register_nonce', 'register_security' ); ?>

						<p>
							<input placeholder="<?php esc_attr_e( 'Username', 'eduma' ); ?>" type="text" name="user_login" class="input required" />
						</p>

						<p>
							<input placeholder="<?php esc_attr_e( 'Email', 'eduma' ); ?>" type="email" name="user_email" class="input required" />
						</p>

						<!-- start edit -->
						<?php

						/**
						 * Fires and displays any extra member registration details fields.
						 *
						 * @since 1.9.0
						 */
						do_action( 'bp_account_details_fields' ); ?>

						<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

						<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

							<div<?php bp_field_css_class( 'editfield' ); ?>>
								<fieldset>

								<?php
								$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
								if($field_type->category != "Single Fields"):
								$field_type->edit_field_html();
								// var_dump($field_type->category);
							endif;

								/**
								 * Fires before the display of the visibility options for xprofile fields.
								 *
								 * @since 1.7.0
								 */
								do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

								 ?>

								<?php

								/**
								 * Fires after the display of the visibility options for xprofile fields.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_custom_profile_edit_fields' ); ?>

								</fieldset>
							</div>

						<?php endwhile; ?>

						<input placeholder="" type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

						<?php endwhile; endif; endif; ?>
						<!-- end edit -->

						<?php if ( get_theme_mod( 'thim_auto_login', true ) ) { ?>
							<p>
								<input placeholder="<?php esc_attr_e( 'Password', 'eduma' ); ?>" type="password" name="password" class="input required" />
							</p>
							<p>
								<input placeholder="<?php esc_attr_e( 'Repeat Password', 'eduma' ); ?>" type="password" name="repeat_password" class="input required" />
							</p>
						<?php } ?>

						<?php
						if ( is_multisite() && function_exists( 'gglcptch_login_display' ) ) {
							gglcptch_login_display();
						}

						do_action( 'register_form' );
						?>

						<?php if ( ! empty( $instance['captcha'] ) ) : ?>
							<p class="thim-login-captcha">
								<?php
								$value_1 = rand( 1, 9 );
								$value_2 = rand( 1, 9 );
								?>
								<input type="text" data-captcha1="<?php echo esc_attr( $value_1 ); ?>" data-captcha2="<?php echo esc_attr( $value_2 ); ?>" placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>" class="captcha-result required" />
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $instance['term'] ) ): ?>
							<p>
								<input type="checkbox" class="required" name="term" id="termFormFieldPopup">
								<label for="termFormFieldPopup"><?php printf( __( 'I accept the <a href="%s" target="_blank">Terms of Service</a>', 'eduma' ), esc_url( $instance['term'] ) ); ?></label>
							</p>
						<?php endif; ?>
						<p>
							<input type="hidden" name="redirect_to" value="<?php echo esc_url( $register_redirect ); ?>" />
							<input type="hidden" name="modify_user_notification" value="1">
						</p>

						<?php do_action( 'signup_hidden_fields', 'create-another-site' ); ?>

						<p class="submit">
							<input type="submit" name="wp-submit" class="button button-primary button-large" value="<?php echo esc_attr_x( 'Sign up', 'Login popup form', 'eduma' ); ?>" />
						</p>
					</form>
					<?php echo '<p class="link-bottom">' . esc_html_x( 'Are you a member? ', 'Login popup form', 'eduma' ) . '<a class="login" href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html_x( 'Login now', 'Login popup form', 'eduma' ) . '</a></p>'; ?>

					<div class="popup-message"></div>
				</div>
			<?php endif; ?>

			<span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>
			<div class="cssload-container">
				<div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
			</div>
		</div>
	</div>
<?php endif;

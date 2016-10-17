<?php

/**
 * Email login credentials to a newly-registered user.
 *
 * A new user registration notification is also sent to admin email.
 *
 * @since 2.0.0
 * @since 4.3.0 The `$plaintext_pass` parameter was changed to `$notify`.
 * @since 4.3.1 The `$plaintext_pass` parameter was deprecated. `$notify` added as a third parameter.
 *
 * @global wpdb         $wpdb      WordPress database object for queries.
 * @global PasswordHash $wp_hasher Portable PHP password hashing framework instance.
 *
 * @param int    $user_id    User ID.
 * @param null   $deprecated Not used (argument deprecated).
 * @param string $notify     Optional. Type of notification that should happen. Accepts 'admin' or an empty
 *                           string (admin only), or 'both' (admin and user). Default empty.
 */
if( !function_exists( 'wp_new_user_notification' ) ){
	function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
		if ( $deprecated !== null ) {
			_deprecated_argument( __FUNCTION__, '4.3.1' );
		}
		
		global $wpdb, $wp_hasher;
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		// for new user approve plugin to fix bugs
		$plugin = 'new-user-approve/new-user-approve.php';
		$class = 'pw_new_user_approve';
				
		$user = get_userdata( $user_id );
		if( !class_exists( $class ) || !is_plugin_active( $plugin ) ){
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$message  = sprintf( __( 'New user registration on your site %s', 'csds_userRegAide' ), $blogname . "\r\n\r\n" );
			$message .= sprintf( __( 'Username: %s', 'csds_userRegAide' ), $user->user_login . "\r\n\r\n" );
			$message .= sprintf( __( 'E-mail: %s', 'csds_userRegAide' ), $user->user_email . "\r\n\r\n" );
			@wp_mail( get_option( 'admin_email ' ), sprintf( __( '[%s] New User Registration', 'csds_userRegAide' ), $blogname ), $message );
		}
		if ( 'admin' === $notify || ( empty( $deprecated ) && empty( $notify ) ) ) {
			return;
		}
		
		$options = get_option('csds_userRegAide_Options');
		$user = new WP_User( $user_id );
		$fields = get_option( 'csds_userRegAide_registrationFields' );
		$login_url = ( string ) '';
		$url = ( string ) '';
		$page = $options['xwrd_change_name'];
		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );
		
		if( $options['xwrd_change_on_signup'] == 1 ){
			$url = site_url();
			$login_url = $url.'/'.$page.'/?action=new-register';
		}elseif( $options['xwrd_change_on_signup'] == 2 ){
			$login_url = wp_login_url() . "\r\n";
		}
				
		$xwrd = 'User Entered';
		$message = sprintf( __( 'Thank you for registering with %s', 'csds_userRegAide' ), $blogname ). "\r\n\n";
		if( class_exists( 'pw_new_user_approve' ) && is_plugin_active( $plugin ) ){
			$url = site_url();
			$message .= sprintf( __( 'Your new user registration is awaiting an Administrators approval at %s', 'csds_userRegAide' ), $blogname ). "\r\n\n";
			$message .= sprintf( __( 'Site URL: %s', 'csds_userRegAide' ), $url ). "\r\n\n";
		}else{
			$message .= sprintf( __( 'Here are your new login credentials for %s', 'csds_userRegAide' ), $blogname ). "\r\n\n";
		}
		if( class_exists( $class ) && is_plugin_active( $plugin ) ){
			wp_mail( $user_email, sprintf( __( '[%s] Your Registration Awaiting Approval', 'csds_userRegAide'  ), $blogname ), $message );
		}else{
			if( array_key_exists( 'user_pass', $fields ) ){
				$message .= sprintf( __( 'Username: %s', 'csds_userRegAide' ), $user_login ) . "\r\n";
				$message .= sprintf( __( 'Password: %s', 'csds_userRegAide' ), $xwrd ) . "\r\n";
				$message .= sprintf( __( 'Login: %s', 'csds_userRegAide' ), $login_url ) . "\r\n";
			}else{
				// Generate something random for a password reset key.
				$key = wp_generate_password( 20, false );

				/** This action is documented in wp-login.php */
				do_action( 'retrieve_password_key', $user->user_login, $key );

				// Now insert the key, hashed, into the DB.
				if ( empty( $wp_hasher ) ) {
					require_once ABSPATH . WPINC . '/class-phpass.php';
					$wp_hasher = new PasswordHash( 8, true );
				}
				$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
				$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );

				$message .= sprintf( __( 'Username: %s', 'csds_userRegAide' ), $user->user_login ) . "\r\n\r\n";
				$url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . "\r\n\r\n";
				$message .= sprintf( __( 'To set your password, visit the following address: %s', 'csds_userRegAide'  ), $url );
				
			}			
			 
			wp_mail( $user_email, sprintf( __( '[%s] Your username and password', 'csds_userRegAide'  ), $blogname ), $message );
		}
		 
	}
}
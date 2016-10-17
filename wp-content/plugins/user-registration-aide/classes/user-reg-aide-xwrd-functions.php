<?php

/**
 * Class  PASSWORD_FUNCTIONS
 *
 * @category Class
 * @since 1.5.0.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class PASSWORD_FUNCTIONS
{
		
	/**	
	 * function install_xwrd_databases
	 * Install the database for recording password change information
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function install_xwrd_databases(){
		global $wpdb;
		$table_name = $wpdb->prefix . "ura_xwrd_change";
		
		if ( ! empty( $wpdb->charset ) ) {
		  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}

		if ( ! empty( $wpdb->collate ) ) {
		  $charset_collate .= " COLLATE {$wpdb->collate}";
		}
		
		if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
			$sql = "CREATE TABLE " . $table_name . " (
				`xwrd_change_ID` bigint(20) NOT NULL AUTO_INCREMENT,
				`user_ID` bigint(20) NOT NULL,
				`change_date` datetime NOT NULL default '0000-00-00 00:00:00',
				`change_IP` varchar(100) NULL default '',
				`old_password` varchar(100) NOT NULL default '',
				`change_uagent` varchar(100) NULL default '',
				`change_referrer` varchar(100) NULL default '',
				`change_uhost` varchar(100) NULL default '',
				`change_uri_request` varchar(100) NULL default '',
				 PRIMARY KEY  (`xwrd_change_ID`)
				)$charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
	
	// ----------------------------------------     Password Functions     ----------------------------------------
	
	/**	
	 * Function csds_userRegAide_createNewPassword
	 * Filter for the default WordPress create password function
	 * Inserts password entered by user if option chosen to let users enter 
	 * own password instead of using default random password emailing
	 * @since 1.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @Filters 'random_password' line 236 &$this (Priority: 0 - Params: 1)
	 * @params string $password 
	 * @returns string $password
	 */
	
	function csds_userRegAide_createNewPassword( $password ){
		global $wpdb;
		$options = get_option( 'csds_userRegAide_Options' );
		$password1 = '';
		$data_meta = array();
		if( !is_multisite() ) {
			if( isset( $_POST["pass1"] ) ){
				$password = $_POST["pass1"];
			}
			}else{
			if ( !empty( $_GET['key'] ) ){
				$key = $_GET['key'];
				}elseif( !empty( $_POST['key'] ) ){
				$key = $_POST['key'];
			}
			if( !empty( $key ) ){
				// seems useless since this code cannot be reached with a bad key anyway you never know
				$key = $wpdb->escape( $key );
				
				$sql = "SELECT active, meta FROM ".$wpdb->signups." WHERE activation_key='".$key."'";
				$data = $wpdb->get_results( $sql );
				
				// checking to make sure data is not empty
				if( isset( $data[0] ) ){
					// if account not active
					if( !$data[0]->active ){
						$meta = maybe_unserialize( $data[1]->meta );
						
						if ( !empty($meta['pass1'] ) ) {
							$password = $meta['pass1'];
							}else{
							$password = $password;
						}
					}
				}
			}
		}
		return $password;
		
	}
	
	/**	
	 * Function remove_default_password_nag
	 * Remove default password message if user entered own password
	 * @since 1.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles $ura->remove_default_password_nag($user_id) line 319 user-reg-aide-registrationForm.php
	 * @params int $user_id
	 * @returns
	 */
	
	function remove_default_password_nag( $user_id ) {
		global $user_id;
		$options = get_option( 'csds_userRegAide_Options' );
		$password_nag = (int) 0;
		if( $options['user_password'] == 1 ){
			delete_user_setting( 'default_password_nag', $user_id );
			update_user_option( $user_id, 'default_password_nag', false, true );
			$password_nag = 1;
			}else{
			update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.
			$password_nag = 0;
		}
		return $password_nag;
	}	
	
	/**	
	 * function password_change_form
	 * Shortcode for showing and processing password change form
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns string $form ( password change form )
	*/
	
	function password_change_form(){
		global $wpdb, $current_user, $post;
		
		apply_filters( 'force_ssl', false, $post );
		$options = get_option('csds_userRegAide_Options');
		$table_name = ( string ) $wpdb->prefix . "ura_xwrd_change";
		$ip = $this->get_user_ip_address();
		$nonce = wp_nonce_field(  'csds-passChange', 'wp_nonce_csds-passChange' );
		
		// declaring function variables
		$login = ( string ) '';
		$email = ( string ) '';
		$password = ( string ) '';
		$line = ( string ) '';
		$request_uri = ( string ) '';
		$referer = ( string ) '';
		$user_host = ( string ) '';
		$user_agent = ( string ) '';
		$changed = ( string ) '';
		$err = ( int ) 0;
		$xwrd_err = ( int ) 0;
		$ssl = 'NO';
		if( is_ssl() ){
			$ssl = 'YES';
		}
				
		// post id
		$post_id = $post->ID;
		$title_id = $this->title_id( $post );
		
		//server variables
		$method = $_SERVER['REQUEST_METHOD'];
		$request_uri = $_SERVER['REQUEST_URI'];
		$user_host = gethostbyaddr($ip);
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		
		if( isset( $_GET['action'] ) && $_GET['action'] == 'new-register' ){
			$line = '<h2>The Password You Received in the Email Was Temporary and Has Expired, Please Change Your Password Now!</h2>';
		}elseif( isset( $_GET['action'] ) && $_GET['action'] == 'expired-password' ){
			$line = '<h2>Your Password Has Expired, Please Change Your Password!</h2>';
			$referer = $_SERVER['HTTP_REFERER'];
		}elseif( isset( $_GET['action'] ) && $_GET['action'] == 'password-never-changed' ){
			$line = '<h2>You Have Not Changed Your Password Since You Signed Up and Your Password Has Expired, Please Change Your Password Now!</h2>';
		}
		if( isset( $_POST['user_login'] ) ){
			$login = $_POST['user_login'];
		}
		if( isset( $_POST['user_email'] ) ){
			$email = $_POST['user_email'];
		}
		if( isset( $_POST['old_pass1'] ) ){
			$password = $_POST['old_pass1'];
		}
		// form shortcode
		$form = (string) '';
		$form .= '<form method="post" name="change_password" id="change_password">';
		$form .= '<div class="reset-xwrd">';
		$form .= $nonce; //wp_nonce_field( $nonce[0], $nonce[1] );
		$form .= '<h2>Password Change Form</h2>';
		$form .= $line;
		//$form .= 'Post ID: '.$post_id.'<br/>';
		//$form .= 'Post Name: '.$options['xwrd_change_name'].'<br/>';
		//$form .= 'Title ID: '.$title_id.'<br/>';
		$form .= '<table>';
		$form .= '<tr><td><label for="user_email">E-mail:</label></td>';
		$form .= '<td><input type="text" name="user_email" id="user_email" value="'.$email.'" class="reset-xwrd" title="Email Address Used When Registered For Site" /></td></tr>';
		$form .= '<tr><td><label for="user_login">Username:</label>';
		$form .= '</td><td><input type="text" name="user_login" id="user_login" class="reset-xwrd" value="'.$login.'" size="20" title="Login Name For Site" /></td></tr>';
		$form .= '<tr><td><label for="old_pass1">Old Password:</label></td>';
		$form .= '<td><input type="password" name="old_pass1" id="old_pass1" class="reset-xwrd" size="20" value="'.$password.'" autocomplete="off" title="Password Sent to You When Registered OR Current Password For Site" /></td></tr>';
		$form .= '<tr><td><label for="pass1">New Password:</label></td>';
		$form .= '<td><input type="password" name="pass1" id="pass1" class="reset-xwrd" size="20" value="" autocomplete="off" title="Enter Your New Password For This Site,YOU CANNOT USE THE SAME PASSWORD AS BEFORE!" /></td></tr>';
		$form .= '<tr><td colspan="2"><div id="pass-strength-result">Strength indicator</div>';
		$form .= '<p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp</p></td></tr>';
		$form .= '<br class="clear" />';
		$form .= '<tr><td colspan="2"><div class="submit">';
		$form .= '<input type="submit" class="button-primary" name="update_xwrd-reset" id="update_xwrd-reset" value="Change Password" /></td></tr></table>';
		$form .= '</div>';
		$form .= '</div>';
		$form .= '</form>';
		
		// end form shortcode
		
		if( isset( $_POST['update_xwrd-reset'] ) ){
			$wp_error = new WP_Error();
			if( ! wp_verify_nonce( $_POST['wp_nonce_csds-passChange'], 'csds-passChange' ) ){
				exit( 'Failed Security Validation!' );
			}/* -- testing -- else{
				$wp_error->add( 'nonce_verified' , __( "<b>ERROR</b>: Nonce Verified!",'csds_userRegAide' ) );
			} */
			$request_uri = $_SERVER['REQUEST_URI'];
			$referer = $_SERVER['HTTP_REFERER'];
			//$referrer = (string) '';
			$verify_xwrd = array();
			$login = $_POST['user_login'];
			$email = $_POST['user_email'];
			$email2 = ( string ) '';
			$password = $_POST['old_pass1'];
			$pass1 = $_POST['pass1'];
			$user = get_user_by( 'login', $login );
			$check_user = apply_filters( 'authenticate', null, $login, $password );
			
			if( empty( $login ) ){
				$wp_error->add( 'empty_email' , __( "<b>ERROR</b>: Please Enter Your Username!",'csds_userRegAide' ) );
				$err++;
			}elseif( !username_exists( $login ) ){
				$wp_error->add( 'empty_email' , __( "<b>ERROR</b>: Username Does Not Exist!",'csds_userRegAide' ) );
				$err++;
			}
			if( empty( $_POST['user_email'] ) ){
				$wp_error->add( 'empty_email' , __( "<b>ERROR</b>: Please Enter your Email",'csds_userRegAide' ) );
				$err++;
			}elseif( !empty( $email ) && !is_wp_error( $user ) ){
				$email2 = $user->user_email;
				if( $email != $email2 ){
					$wp_error->add( 'emails_not_match', __( "<b>ERROR</b>: Email Associated With This Account And Email Entered Do Not Match!", 'csds_userRegAide' ) );
					$err++;
				}
			}
			if( $password == $pass1 ){
				$wp_error->add( 'old_new_password_match', __( "<b>ERROR</b>: NEW PASSWORD SAME AS OLD PASSWORD, PLEASE ENTER A DIFFERENT PASSWORD!", 'csds_userRegAide' ) );
				$err++;
			}
					
			// filter for password strength and duplicate errors
			$verify = apply_filters( 'custom_password_strength', $pass1, $login, $email, $wp_error, $err );
			$verify_msgs = $verify->get_error_messages();
			$verify_xwrd = apply_filters( 'duplicate_verify', $user, $pass1, $wp_error, $err );
			$verify_xwrd_msgs = $verify_xwrd->get_error_messages();
			
			// Errors Displayed
			if( is_wp_error( $check_user ) ){
				$xwrd_err++;
				$errors = $check_user->get_error_messages();
				foreach( $errors as $error ){
					echo '<div id="my-message" class="my-error">'.$error.'</div>';
				}
			}elseif( !empty( $verify_xwrd_msgs ) ){
				$xwrd_err++;
				foreach( $verify_xwrd_msgs as $error ){
					echo '<div id="my-message" class="my-error">'.$error.'</div>';
				}
			}elseif( !empty( $verify_msgs ) ){
				$xwrd_err++;
				foreach( $verify_msgs as $error ){
					echo '<div id="my-message" class="my-error">'.$error.'</div>';
				}
			}elseif( $err >= 1 ){
				if( !empty( $wp_error ) ){
					$errors = $wp_error->get_error_messages();
					foreach( $errors as $error ){
						echo '<div id="my-message" class="my-error">'.$error.'</div>';
					}
				}
			}elseif( $xwrd_err === 0 && $err === 0 ){
				//wp_die( 'GOOD TO GO!' );
				$user_id = $user->ID;
				$old_pass = $user->user_pass;
				$credentials = array(
					'user_login' => $login,
					'user_password' => $password
				);
									
				// storing password change data in database
				$insert = "INSERT INTO " . $table_name . " ( user_ID, change_date, change_IP, old_password, change_uagent, change_referrer, change_uhost, change_uri_request ) " ."VALUES ( '" . $user_id . "', now(), '%s', '%s', '%s', '%s', '%s', '%s' )";
				
				// for testing previous duplicate passwords
				//$insert = "INSERT INTO " . $table_name . " ( user_ID, change_date, change_IP, old_password, change_uagent, change_referrer, change_uhost, change_uri_request ) " . "VALUES ( '" . $user_id . "', (now() - INTERVAL 360 DAY), '%s', '%s', '%s', '%s', '%s', '%s' )";
				
				$insert = $wpdb->prepare( $insert, $ip, $old_pass, $user_agent, $referer, $user_host, $request_uri );
				$results = $wpdb->query( $insert );
				
				if( $results == 1){
					$changed .= '<div id="my-message" class="my-updated"><b>Updated</b>: Password Change Records Updated!</div>';
				}else{
					$form .= '<div id="my-message" class="my-error"><b>Error</b>: Database Record Failed!</div>';
					$form .= '<div id="my-message" class="my-error"><b>Error</b>: Password Update Failed!</div>';
				}
				
				if( $results == 1 ){
					$results2 = wp_set_password( $pass1, $user_id );
					
					if( is_wp_error( $results2 ) ){
						$errors = $results2->get_error_messages();
						foreach( $errors as $error ){
							$form .= '<div id="my-message" class="my-error">'.$error.'</div>';
						}
						
					}else{
						// shows login form if successful password change - **must log user out to properly change password**
						//$changed .= '<h2>Refer: '.$referer.'</h2>';
						//$changed .= '<h2>Request: '.$request_uri.'</h2>';
						$changed .= '<div id="my-message" class="my-updated"><b>Updated</b>: Password Updated!</div>';
						$changed .= '<div id="my-message" class="my-updated"><b>Message</b>: You Were Logged Out to Change Your Password Properly, Sorry for Any Inconvenience!</div>';
						$args = array(
							'echo'           => true,
							'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
							'form_id'        => 'loginform',
							'label_username' => __( 'Username', 'csds_userRegAide' ),
							'label_password' => __( 'Password', 'csds_userRegAide' ),
							'label_remember' => __( 'Remember Me', 'csds_userRegAide' ),
							'label_log_in'   => __( 'Log In', 'csds_userRegAide' ),
							'id_username'    => 'user_login',
							'id_password'    => 'user_pass',
							'id_remember'    => 'rememberme',
							'id_submit'      => 'wp-submit',
							'remember'       => true,
							'value_username' => NULL,
							'value_remember' => false
						);
						
						$changed .= wp_login_form( $args );
						return $changed;		
							
					}
				}
			}
		}
		
		return $form;
	}
	
	/**	
	 * function get_user_ip_address
	 * Get the user/client IP address
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns string $ip_address
	*/
	
	function get_user_ip_address() {
		$ip_address = (string) '';
		if( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ){
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}elseif( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif( !empty( $_SERVER['HTTP_X_FORWARDED'] ) ){
			$ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
		}elseif( !empty( $_SERVER['HTTP_FORWARDED'] ) ){
			$ip_address = $_SERVER['HTTP_FORWARDED'];
		}elseif( !empty( $_SERVER['REMOTE_ADDR'] ) ){
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip_address = 'UNKNOWN';
		}
		return esc_attr( $ip_address );
	}
	
	/**	
	 * function xwrd_reset_disable
	 * Handles filter to allow password reset and updates settings according to admin choices
	 * Will not disable admin password resets, only non-admins
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns boolean true for not disabled false for disabled
	*/
	
	function xwrd_reset_disable( $allow, $user_id ){
		$options = get_option( 'csds_userRegAide_Options' );
		$reset = $options['allow_xwrd_reset'];
		$user = get_user_by( 'ID', $user_id );
		if( $reset == 1 ){
			return true;
		}elseif( $reset == 2 ){
			if ( !empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] == 'administrator' ){
				return true;
			}else{
				return false;
			}
		}
	}
	
	
		
	/**	
	 * function remove_xwrd_reset_text
	 * Removes the 'Lost your Password' text/link from login form
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $text
	 * @returns string $text
	*/
	
	function remove_xwrd_reset_text( $text ){
		$options = get_option('csds_userRegAide_Options');
		if( array_key_exists( 'allow_xwrd_reset', $options ) ){
			$reset = $options['allow_xwrd_reset'];
		}else{
			$reset = 1;
		}
		if( $reset == 2 ){
			if( is_page( 'login_url' ) ){
				$user_login = $_POST['user_login'];
				$user = get_user_by( 'login', $user_login );
				if( empty( $user ) ){
					$user = get_user_by( 'email', $user_login );
				}
				$cur_user = new WP_User( $user->ID );
				if ( !empty( $cur_user->roles ) && is_array( $cur_user->roles ) && $cur_user->roles[0] == 'administrator' ){
					return $text;
				}else{
					return str_replace( array( 'Lost your password?', 'Lost your password' ), '', trim( $text, '?' ) );
				}
			}else{
				return $text;
			}
			
		}
		
		return $text;
	}
	
	/**	
	 * function xwrd_strength_verify
	 * Checks password fields for strength settings and errors for shortcode and registration form pages
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $pass1, string $login, string $email, WP_Error OBJECT $errors, int $error 
	 * @returns WP_Error OBJECT $errors
	*/
	
	function xwrd_strength_verify( $pass1, $login, $email, $errors, $error ){
		//$errors = new WP_Error();
		$options = get_option('csds_userRegAide_Options');
		$dup_times = trim( $options['xwrd_duplicate_times'] );
		//to check password -- password fields empty
		if( empty( $pass1 ) || $pass1 == '' ){
				$errors->add('empty_password', __( "<strong>ERROR</strong>: Please Enter Your Password!", 'csds_userRegAide' ) );
				$error ++;
				
		}
		 // password same as user login
		if( $pass1 == $login ){
			$errors->add('password_and_login_match', __( "<strong>ERROR</strong>: Username and Password are the Same, They Must be Different!", 'csds_userRegAide' ) );
				$error ++;
		}
		
		// Password strength requirements
		if( strlen( trim( $pass1 ) ) < $options['xwrd_length'] ){ // password length too short
			if($options['default_xwrd_strength'] == 1 || ( $options['custom_xwrd_strength'] == 1 && $options['require_xwrd_length'] == 1 ) ){
				$errors->add( 'password_too_short', sprintf( __( "<strong>ERROR</strong>: Password length too short! Should be at least %d characters long!", 'csds_userRegAide' ), $options['xwrd_length'] ) );
					$error ++;
			}
		// no number in password
		}
		if( $pass1 != '' && !preg_match("/[0-9]/", $pass1 )){
			if( $options['default_xwrd_strength'] == 1 || ( $options['custom_xwrd_strength'] == 1 && $options['xwrd_numb'] == 1 ) ){
				$errors->add('password_missing_number', __( "<strong>ERROR</strong>: There is no number in your password!", 'csds_userRegAide' ) );
					$error ++;
			}
		// no lower case letter in password
		}
		if( $pass1 != '' && !preg_match("/[a-z]/", $pass1 )){
			if( $options['default_xwrd_strength'] == 1 || ( $options['custom_xwrd_strength'] == 1 && $options['xwrd_lc'] == 1 ) ){
				$errors->add( 'password_missing_lower_case_letter', __( "<strong>ERROR</strong>: Password missing lower case letter!", 'csds_userRegAide' ) );
					$error ++;
			}
		// no upper case letter in password
		}
		if( $pass1 != '' && !preg_match("/[A-Z]/", $pass1 ) ){
			if( $options['default_xwrd_strength'] == 1 || ( $options['custom_xwrd_strength'] == 1 && $options['xwrd_uc'] == 1 ) ){
				$errors->add( 'password_missing_upper_case_letter', __( "<strong>ERROR</strong>: Password missing upper case letter!", 'csds_userRegAide' ) );
					$error ++;
			}
		// no special character in password
		}
		if( $pass1 != '' && !preg_match("/.[!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/", $pass1 ) ){
			if( $options['default_xwrd_strength'] == 1 || ( $options['custom_xwrd_strength'] == 1 && $options['xwrd_sc'] == 1 ) ){
				$errors->add( 'password_missing_symbol', __( "<strong>ERROR</strong>: Password missing symbol!", 'csds_userRegAide' ) );
					$error ++;
			}
		}
		//$results = array( $error, $errors );
		//return $results;
		return $errors;
	}
	
	/**	
	 * function xwrd_change_duplicate_verify
	 * Checks password for duplicate password entries
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params WP_User OBJECT $user, string $password, WP_Error OBJECT $errors, int $error
	 * @returns WP_Error OBJECT $errors
	*/
	
	function xwrd_change_duplicate_verify( $user, $password, $errors, $error ){
		global $wpdb;
		$options = get_option('csds_userRegAide_Options');
		$dup_times = $options['xwrd_duplicate_times'];
		$user_id = $user->ID;
		$table_name = $wpdb->prefix . "ura_xwrd_change";
		$sql = "SELECT old_password FROM $table_name WHERE user_ID = '$user_id' ORDER BY change_date DESC LIMIT $dup_times";
		$xwrds = $wpdb->get_results( $sql, ARRAY_A ); 
		$match = (boolean) false;
		$i = (int) 0;
		
		// to check password -- password fields empty
		if( !empty( $xwrds ) ){
			foreach( $xwrds as $xwrds1 ){
				foreach( $xwrds1 as $key => $xwrd ){
					if( $i < $dup_times ){
						$match = wp_check_password( $password, $xwrd, $user_id );
						if( $match != false ){
							$errors->add( 'duplicate_password', sprintf( __( "<strong>ERROR</strong>: Please Change Your New Password! This Password Matches A Previous Password! You Cannot Use Duplicate Passwords for %d Times!", 'csds_userRegAide' ), $dup_times ) );
							return $errors;
						}
					}
					$i++;
				}
			}
		}
		return $errors;
	}
	
	/**	
	 * function non_admin_login_redirect
	 * Redirect non-admin user after successful login.
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $redirect_to, string $request, WP_User OBJECT $user
	 * @return string $redirect_to
	*/
	
	function non_admin_login_redirect( $redirect_to, $request, $user ) {
		global $user;
		$options = get_option('csds_userRegAide_Options');
		$redirect = $options['redirect_login'];
		$redirect_url = $options['login_redirect_url'];
		//echo $redirect_to;
		if( $redirect == 1 ){
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				//check for admins
				if ( in_array( 'administrator', $user->roles ) ) {
					// redirect them to the default redirect page
					return $redirect_to;
				} else {
					// redirect users to the specified page
					return $redirect_url;
				}
			} else {
				// redirect them to the default redirect page
				return $redirect_to;
			}
		}else{
			// redirect them to the default redirect page
			return $redirect_to;
		}
	}
	
	/**	
	 * function xwrd_change_login_check
	 * Checks user for last password change on authentication - if need password change * redirects to password change pag
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $username
	 * @return
	*/
	
	function xwrd_change_login_check( $username ){
		global $wpdb;
		$options = get_option('csds_userRegAide_Options');
		
		if( !username_exists( $username ) ){
			return;
		}
		
		$change = $options['xwrd_require_change'];
		
		if( $change == 2 ){
			return;
		}
		
		// if user never changed password check signup/registration date for when plugin is new users->user_registered
		$days = $options['xwrd_change_interval'];
		$user = get_user_by( 'login', $username );
		$xwrd_chg_name = $options['xwrd_change_name'];
		$expired_password = $options['xwrd_chng_exp_url'];
		$never_changed = $options['xwrd_chng_nc_url'];
		$site = site_url();
		$user_id = $user->ID;
		$table_name = $wpdb->prefix . "ura_xwrd_change";
		$sql_cnt = "SELECT COUNT(user_ID) FROM $table_name WHERE user_ID = '$user_id'";
		$cnt = $wpdb->get_var( $sql_cnt );
		if( empty( $cnt ) || $cnt <= 0 || $cnt == '' ){
			$table_name = $wpdb->prefix . "users";
			$sql = "SELECT ID FROM $table_name WHERE ID = %d AND date_add(user_registered, INTERVAL %d DAY) < NOW()";
			$run_query = $wpdb->prepare( $sql, $user_id, $days );
			$date = $wpdb->get_var( $run_query );
			if( !empty( $date ) ){
				$url = $xwrd_chg_name.$never_changed;
				$redirect = $site.'/'.$url;
				wp_redirect( $redirect );
				exit;
			}
		}else{
			$table_name = $wpdb->prefix . "ura_xwrd_change";
			$sql = "SELECT change_date FROM $table_name WHERE user_ID = %d AND date_add(change_date, INTERVAL %d DAY) > NOW() ORDER BY user_ID DESC";
			$run_query = $wpdb->prepare( $sql, $user_id, $days );
			$run_query = $wpdb->prepare( $sql, $user_id, $days );
			$date = $wpdb->get_var( $run_query );
			if( empty( $date ) ){
				$url = $xwrd_chg_name.$expired_password;
				$redirect = $site.'/'.$url;
				wp_redirect( $redirect );
				exit;
			}
			
		}
		
	}
	
	/**	
	 * function xwrd_chng_ssl_redirect
	 * Redirect to ssl change password page if ssl is available
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @return
	*/
	
	function xwrd_chng_ssl_redirect(){
		global $post, $page;
		if( !empty( $post ) ){
			$id = $post->ID;
		}else{
			return;	
		}
		$xwrd_id = $this->title_id( $post );
		$options = get_option('csds_userRegAide_Options');
		$ssl = $options['xwrd_change_ssl'];
		$name = $options['xwrd_change_name'];
		$action = $options['xwrd_chng_email_url'];
		$action1 = $options['xwrd_chng_exp_url'];
		if( $ssl == 1 ){
			if( $id == $xwrd_id && !is_ssl() ){
				if( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ){
					wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']), 301 );
					exit();

				}else{
					wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
					exit();
				}
			}elseif(  $id != $xwrd_id && is_ssl() && !is_admin() ){

				if( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ){
					wp_redirect( preg_replace( '|^https://|', 'http://', $_SERVER['REQUEST_URI'] ), 301 );
					exit();

				}else{
					wp_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
					exit();
				}

			}
		}

	}
	
	/**	
	 * function title_id
	 * Returns Post ID for checking if page is Password Change Page
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params WP_Post OBJECT $post
	 * @return int $titleid WordPress post_id
	*/
	
	function title_id( $post ){
		global $wpdb, $post;
		$options = get_option('csds_userRegAide_Options');
		$name = $options['xwrd_change_name'];
		$ssl = $options['xwrd_change_ssl'];
		$titleid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $name . "'");
		return $titleid;
	}
	
	/**	
	 * function xwrd_chng_ssl
	 * pre_post_link filter for SSL Change Password Page if used
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $permalink, WP_Post OBJECT $post, bool $leavename
	 * @return string $permalink
	*/
	
	function xwrd_chng_ssl( $permalink, $post, $leavename ) {
		global $wpdb;
		$options = get_option('csds_userRegAide_Options');
		$name = $options['xwrd_change_name'];
		$ssl = $options['xwrd_change_ssl'];
		$titleid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $name . "'");
		
		if( $ssl == 1 ){
			if( $titleid == $post->ID && !is_ssl() ){
				return preg_replace( '|^http://|', 'https://', $permalink );
			}
		}
		
		return $permalink;

	}
	
}
<?php

/**
 * Class CSDS_URA_MESSAGES
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class CSDS_URA_MESSAGES
{
	// ----------------------------------------     Wordpress Message Filters Functions     ----------------------------------------
	
	/** 
	 * function ura_registration_top_message
	 * Changes the default WordPress registration page top message 
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns $message (registration form top message)
	*/

	function ura_registration_top_message(){
		$options = get_option( 'csds_userRegAide_Options' );
		$message = (string)'';
		$show_message = $options['show_login_message'];
		
		if( $show_message == "1" ){
			if( $options['add_security_question'] == "2" ){
				$message = '<p class="message register">'.$options['reg_top_message'].'</p>';
			}else{
				$message = '<p class="message register" style="width: 425px;">'.$options['reg_top_message'].'</p>';
			}
		}
		
		return $message;
	}
		
	/** 
	 * function ura_login_message
	 * Changes the default WordPress login page messages
	 * Sets the <p class="message"> to predefined custom message
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @Filters 'login_message' line 171 &$this
	 * @access public
	 * @params string $message (wp-login.php form messages)
	 * @returns string $message (wp-login.php form messages)
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/
	
	function ura_login_message( $message ){
		$options = get_option( 'csds_userRegAide_Options' );
		$message = '';
		$page = site_url(). $_SERVER['REQUEST_URI'];
		$show_message = $options['show_login_message'];
		$errors = new WP_Error();
		$msg = ( string ) '';
		if( $show_message == 1 ){
			if($page == wp_login_url()){
				$message = '<p class="message">'.$options['login_message'].'<br/>';
				if( "Extra Login messages" != $options['login_messages_login'] ){
					$message .= $options['login_messages_login'].'</p>';
				}
			}
			$plugin = 'new-user-approve/new-user-approve.php';
			$class = 'pw_new_user_approve';
			if( isset( $_GET['action'] ) && $_GET['action'] == 'register' ){
				if( $options['add_security_question'] == "2" ){ // future use
					if( class_exists( $class ) && is_plugin_active( $plugin ) ){
						$msg = apply_filters( 'nua_registration_message', $message );
						$message = '<p class="message register">'.$msg.'</p>';
					}else{
						$message = '<p class="message register">'.$options['reg_top_message'].'</p>';
					}
				}else{
					$message = '<p class="message register" style="width: 450px;">'.$options['reg_top_message'].'</p>';
				}
				
			}
			
			if( isset($_GET['action']) && $_GET['action'] == 'lostpassword' ){
				$message = '<p class="message">'.$options['login_messages_lost_password'].'</p>'; 
			}
			
			if( isset( $_GET['action'] ) && $_GET['action'] == 'resetpass' ){ //after successful reset password
				if( $options['add_security_question'] == "1" ){
					$message = $options['reset_password_success_security']; 
				}else{
					$message = $options['reset_password_success_normal']; 
				}
			}
			
			if( isset( $_GET['action']) && $_GET['action'] == 'rp' ){  // Reset Password Page
				if( $options['add_security_question'] == "1" ){
					$message = $options['reset_password_messages_security']; 
				}else{
					$message = $options['reset_password_messages_normal']; 
				}
			}
		
			if( !empty( $_GET['login'] ) ){
				if( !empty($_GET['key'] ) ){
					$action = $_GET['action'];
					if( $action == 'rp' ){
						if( $options['add_security_question'] == "1" ){
							$message = '<p class="message reset-pass">' . __( $options['reset_password_messages_security'], 'csds_userRegAide').'</p>'; 
						}else{
							$message = '<p class="message reset-pass">' . __($options['reset_password_messages_normal'], 'csds_userRegAide').'</p>'; 
						}
					}elseif( $action == 'resetpass' ){
						if( $options['add_security_question'] == "1" ){
							$message = '<p class="message reset-pass">' . __($options['reset_password_success_security'], 'csds_userRegAide').'</p>';
						}else{
							$message = '<p class="message reset-pass">' . __($options['reset_password_success_normal'], 'csds_userRegAide').'</p>'; 
						}
					}
					
				}
			}
		}
		return $message;
	}
				
	/** 
	 * function my_login_messages
	 * Sets the <p> class="messages" to custom message (2nd message on login form)
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @Filters 'login_messages' line 172 &$this 
	 *
	 * @params string $messages
	 * @returns string $messages (customized messages)
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/
	
	function my_login_messages( $messages ){
		$options = get_option( 'csds_userRegAide_Options' );
		if( $options['show_login_message'] == "1" ){
			$plugin = 'new-user-approve/new-user-approve.php';
			$class = 'pw_new_user_approve';
			if( isset( $_GET['loggedout'] ) && true == $_GET['loggedout'] ){
				$messages = __( $options['login_messages_logged_out'],'csds_userRegAide' );
			}elseif( isset( $_GET['checkemail'] ) && 'registered' == $_GET['checkemail'] ){
				if( class_exists( $class ) && is_plugin_active( $plugin ) ){
					$messages = __( apply_filters( 'nua_success_registration_message', $messages ) );
				}else{
					$messages = __( $options['login_messages_registered'],'csds_userRegAide');
				}
			}elseif( isset( $_GET['checkemail'] ) && $_GET['checkemail'] == 'confirm' ){
				$messages = __( $options['reset_password_confirm'], 'csds_userRegAide' );
			}elseif( isset( $_GET['action'] ) && $_GET['action'] == 'resetpass' ){
				if( $options['add_security_question'] == "1" ){
					$messages = __( $options['reset_password_success_security'],'csds_userRegAide' ); 
				}else{
					$messages = __( $options['reset_password_success_normal'],'csds_userRegAide' ); 
				}
			}elseif( isset($_GET['action'] ) && $_GET['action'] == 'rp' ){
				if( $options['add_security_question'] == "1" ){
					$messages = __($options['reset_password_messages_security'],'csds_userRegAide'); 
				}else{
					$messages = __( $options['reset_password_messages_normal'],'csds_userRegAide'); 
				}
			}
		}
		return $messages;
	}
	
}
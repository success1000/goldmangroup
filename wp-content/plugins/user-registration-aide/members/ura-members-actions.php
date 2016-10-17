<?php

/**
 * Class URA_MEMBERS_ACTIONS
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_MEMBERS_ACTIONS
{
	
	/** 
	 * function verify_email_account
	 * Verifies new user email from email verification page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $key
	 * @returns $message (registration form top message)
	*/
	
	function verify_email_account( $key ){
		global $wpdb;
		$options = get_option( 'csds_userRegAide_Options' );
		$approve = $options['new_user_approve'];
		$verify = $options['verify_email'];
		$msg = (string) '';
		$table = $wpdb->prefix . "users";
		$id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $table WHERE user_activation_key = %s", $key )  );
		//return $id;
		//exit( print_r( $signup ) );
		if ( $id == null ){
			return;
		}else{
			if( $approve == 1 && $verify == 1 ){
				$verified = get_user_meta( $id, 'email_verification', true );
				$approved = get_user_meta( $id, 'approval_status', true );
				if( $verified == 'unverified' && $approved == 'pending' ){
					update_user_meta( $id, 'email_verification', 'verified' );
					$msg = 'Email Was Successfully Verified!<br/>Your Account Still Needs an Administrators Approval Before you can Log In.';
					return $msg;
				}elseif( $verified == 'verified' && $approved == 'pending' ){
					$msg = 'Email Already Verified!<br/>Your Account Still Needs an Administrators Approval Before you can Log In.';
					return $msg;
				}elseif( $verified == 'unverified' && $approved = 'approved' ){
					update_user_meta( $id, 'email_verification', 'verified' );
					$this->update_user_status_field( $id );
					$login = wp_login_url();
					$msg .= 'Your email was successfully confirmed!! You can now <a href="'.$login.'">log in</a> with the username and password you provided when you signed up.';
					return $msg;
				}elseif( $verified == 'verified' && $approved == 'approved' ){
					$this->update_user_status_field( $id );
					$login = wp_login_url();
					$msg .= 'Your email is already confirmed and your account has been approved!! You can now <a href="'.$login.'">log in</a> with the username and password you provided when you signed up.';
					return $msg;
				}
			}elseif( $approve == 2 && $verify == 1 ){
				$verified = get_user_meta( $id, 'email_verification', true );
				$approved = get_user_meta( $id, 'approval_status', true );
				if( $verified == 'unverified' ){
					update_user_meta( $id, 'email_verification', 'verified' );
					$msg = 'Email Was Successfully Verified!';
					return $msg;
				}elseif( $verified == 'verified' ){
					$msg = 'Email Already Verified!';
					return $msg;
				}
			}elseif( $approve == 1 && $verify == 2 ){
				$verified = get_user_meta( $id, 'email_verification', true );
				$approved = get_user_meta( $id, 'approval_status', true );
				if( $approved == 'pending' ){
					update_user_meta( $id, 'email_verification', 'verified' );
					$msg = 'Your Account Needs to be Approved by an Administrator!';
					return $msg;
				}elseif( $approved = 'approved' ){
					update_user_meta( $id, 'email_verification', 'verified' );
					$this->update_user_status_field( $id );
					$msg .= 'Your Account has been Approved by an Administrator! You can now <a href="%s">log in</a> with the username and password you provided when you signed up.'. wp_login_url();
					return $msg;
				}
			}elseif( $approve == 2 && $verify == 2 ){
				$msg .= 'Your Account is all Ready!! You can now <a href="%s">log in</a> with the username and password you provided when you signed up.'. wp_login_url();
				return $msg;
			}
		}
	}	

	/** 
	 * function update_user_activation_key
	 * updates user activation key in database
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params int $user_id
	 * @returns
	*/
		
	function update_user_activation_key( $user_id ){
		global $wpdb;
		//$options = get_option( 'csds_userRegAide_Options' );
		//$approve = $options['new_user_approve'];
		// db steps to update key
		$table_name = $wpdb->prefix.'users';
		//if( $approve == 1 ){
			$update_sql = "UPDATE $table_name SET user_status = 2 WHERE ID = %d";
		//}else{
		//	$update_sql = "UPDATE $table_name SET user_status = 0 WHERE ID = %d";
		//}
		$update = $wpdb->prepare( $update_sql, $user_id );
		$results = $wpdb->query( $update );
		$key = wp_hash( $user_id );
		$update_key = "UPDATE $table_name SET user_activation_key = %s WHERE ID = %d";
		$update_akey = $wpdb->prepare( $update_key, $key, $user_id );
		$results = $wpdb->query( $update_akey );
	}
	
	/** 
	 * function update_user_status_field
	 * Set new user status if needs to be approved or email verified
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params int $user_id
	 * @returns
	*/
		
	function update_user_status_field( $user_id ){
		global $wpdb;
		$options = get_option( 'csds_userRegAide_Options' );
		$approve = $options['new_user_approve'];
		$table = $wpdb->prefix.'users';
		if( $approve == 1 ){
			$data = array(
				'user_status'	=>	2
			);
		}else{
			$data = array(
				'user_status'	=>	0
			);
		}
		$where = array(
			'ID'	=>	$user_id
		);
		$wpdb->update( $table, $data, $where );
		
	}
	
	/** 
	 * function update_user_roles
	 * Updates user role if is from another blog and using one user table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns
	*/
		
	function update_user_roles( ){
		global $user_ID, $wpdb;
		get_currentuserinfo();
		if( !empty( $user_ID ) ){
			$prefix = $wpdb->prefix;
			$base_prefix = $this->get_base_prefix();
			$caps = get_user_meta( $user_ID, $prefix.'capabilities', false  );
			if( !empty( $caps ) ){
				$role = $this->get_user_cap( $user_ID, $prefix );
			}else{
				$caps = get_user_meta( $user_ID, $base_prefix.'capabilities', false  );
				$role = $this->get_user_cap( $user_ID, $base_prefix );
			}
			
			if( !empty( $role ) ){
				if ( !current_user_can( 'read' ) ){
					$user = new WP_User( $user_ID );
					$user->set_role( $role );
				}
			}
		}
		
	}
	
	/** 
	 * function update_users_roles
	 * Updates all users roles if is from another blog and using one user table 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns
	*/
		
	function update_users_roles(){
		global $wpdb;
		$members = $this->get_all_members();
		$base_prefix = $this->get_base_prefix();
		
		foreach ( $members as $user_ID ){
			$user = new WP_User( $user_ID );
			$prefix = $wpdb->prefix;
			$caps = get_user_meta( $user_ID, $prefix.'capabilities', false  );
			
			if( !empty( $caps ) ){
				$role = $this->get_existing_user_cap( $user_ID, $prefix );
			}else{
				$caps = get_user_meta( $user_ID, $base_prefix.'capabilities', false  );
				if( !empty( $caps ) ){
					$role = $this->get_existing_user_cap( $user_ID, $base_prefix );
				}else{
					$prefixes = $this->get_table_prefixes();
					if( !empty( $prefixes ) ){
						if( is_array( $prefixes ) ){
							foreach( $prefixes as $index => $aprefix ){
								$caps = get_user_meta( $user_ID, $aprefix.'capabilities', false  );
								
								if( !empty( $caps ) ){
									
									$role = $this->get_existing_user_cap( $user_ID, $aprefix );
									break;
								}
							}
						}else{
							$caps = get_user_meta( $user_ID, $prefixes.'capabilities', false  );
							if( !empty( $caps ) ){
								$role = $this->get_existing_user_cap( $user_ID, $prefixes );
							}
						}
					}
				}
			}
			
			//exit( 'ROLE: '.$role.'<br/>USER: '.print_r( $user ) );
			if( !empty( $role ) ){
				if ( !$user->has_cap( 'read' ) ){
					$user->set_role( $role );
				}
			}
		}
		//$options = get_option('csds_userRegAide_Options');
		//$options['user_roles_updated'] = "1";
		//update_option( 'csds_userRegAide_Options', $options );
	}
		
	/** 
	 * function roll_update
	 * Updates roles on registration if one user table used for multiple blogs 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params int $user_id
	 * @returns
	*/
		
	function roll_update( $user_ID ){
		global $wpdb;
		$options = get_option( 'csds_userRegAide_Options' );
		$temps = $options['db_prefixes'];
		$prefixes = $this->get_table_prefixes();
		if ( defined( 'CUSTOM_USER_TABLE' ) || !empty( $temps ) ){
			$base_prefix = $this->get_base_prefix();
			$prefix = $wpdb->prefix;
			$pcnt = (int) 0;
			$results = ( boolean ) false;
			if( !empty( $prefixes ) ){
				if( is_array( $prefixes ) ){
					foreach( $prefixes as $index => $aprefix ){
						if( $prefix != $base_prefix ){
							$level = get_user_meta( $user_ID, $prefix.'user_level', true  );
							$role = $this->get_user_cap( $user_ID, $prefix );
							if( $pcnt == 0 ){
								update_user_meta( $user_ID, $base_prefix.'capabilities', $role );
								update_user_meta( $user_ID, $base_prefix.'level', $level );
								$results = true;
							}
							if( $prefix != $aprefix ){
								update_user_meta( $user_ID, $aprefix.'capabilities', $role );
								update_user_meta( $user_ID, $aprefix.'level', $level );
								$results = true;
							}
						}elseif( $prefix == $base_prefix ){
							$level = get_user_meta( $user_ID, $prefix.'user_level', true  );
							$role = $this->get_user_cap( $user_ID, $prefix );
							update_user_meta( $user_ID, $prefixes.'capabilities', $role );
							update_user_meta( $user_ID, $aprefix.'level', $level );
							$results = true;
						}
						$pcnt++;
					}						
				}else{
					if( $prefix != $base_prefix ){
						$level = get_user_meta( $user_ID, $prefix.'user_level', true  );
						$role = $this->get_user_cap( $user_ID, $prefix );
						update_user_meta( $user_ID, $prefixes.'capabilities', $role );
						update_user_meta( $user_ID, $base_prefix.'level', $level );
						$results = true;
					}elseif( $prefix == $base_prefix ){
						$level = get_user_meta( $user_ID, $prefix.'user_level', true  );
						$role = $this->get_user_cap( $user_ID, $prefix );
						update_user_meta( $user_ID, $prefixes.'capabilities', $role );
						update_user_meta( $user_ID, $prefixes.'level', $level );
						$results = true;
					}
				}
			}
		}
		$pcnt = 0;
		return $user_ID;
	}
	
	/** 
	 * function get_user_cap
	 * Gets the role for given user
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params int $user_id, string $prefix ( database prefix )
	 * @returns string $capabilities
	*/
		
	function get_user_cap( $user_id, $prefix ){
		global $wpdb, $wp_roles;
		$user = get_userdata( $user_id );

		$capabilities = $user->{$prefix . 'capabilities'};
		return $capabilities;
		
	}
	
	/** 
	 * function get_existing_user_cap
	 * Gets the role for given existing user
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params int $user_id, string $prefix ( database prefix )
	 * @returns string $role
	*/
		
	function get_existing_user_cap( $user_id, $prefix ){
		global $wpdb, $wp_roles;
		$user = get_userdata( $user_id );

		$caps = $user->{$prefix . 'capabilities'};
		
		if ( !isset( $wp_roles ) ){
			$wp_roles = new WP_Roles();
		}
		
		foreach ( $wp_roles->role_names as $role => $name ) {

			if ( array_key_exists( $role, $caps ) ){
				return $role;
			}
		
		}
		
	}
	
	/** 
	 * function get_table_prefixes
	 * Gets the prefixes for all tables in database if using same database for multiple sites
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $prefixes ( database prefixes )
	*/
		
	function get_table_prefixes(){
		global $wpdb;
		$db_name = DB_NAME;
		$db_object = 'Tables_in_'.$db_name;
		$sql = "show tables from $db_name"; // run the query and assign the result to $result
		$results = $wpdb->get_results( $sql, ARRAY_A );
		$prefixes = array();
		foreach( $results as $result ){
			foreach( $result as $table ){
				$prefix = explode( '_', $table );
				$prefix = $prefix[0].'_';
				if( !in_array( $prefix, $prefixes ) ){
					$prefixes[] = $prefix;
				}
			}
		}
		//exit( print_r( $prefixes ) );
		return $prefixes;
	}
	
	/** 
	 * function get_base_prefix
	 * Gets the base prefix for the primary site when multiple sites using same database
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $prefixes ( database prefixes )
	*/
		
	function get_base_prefix(){
		global $wpdb;
		if ( defined( 'CUSTOM_USER_TABLE' ) ){
			$user_table = CUSTOM_USER_TABLE;
			$temp = explode( '_', $user_table );
			$base_prefix = $temp[0].'_';
		}else{
			$base_prefix = $wpdb->prefix;
		}
		return $base_prefix;
	}
	
	/** 
	 * function get_base_prefix
	 * Gets all members for updating roles if one user table used for multiple blogs
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $results all users ID's
	*/
		
	function get_all_members(){
		global $wpdb;
		$results = $wpdb->get_col( "SELECT ID FROM $wpdb->users" );
		return $results;
	}
	
}
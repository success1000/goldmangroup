<?php

/**
 * Class  REGISTRATION_FORM_MODEL
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class REGISTRATION_FORM_MODEL
{
	
	/**	
	 * function create_field_label
	 * Processes field labels view for registration form fields to save on redundency
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $fieldKey meta_key for field, string $fieldName field Title or Name that users see for field
	 * @returns string $label Label that is uses for field on registration form
	 */
	
	function create_known_field_label( $fieldKey, $fieldName ){
		$label = ( string ) '';
		$optional_fields = get_option( 'csds_ura_optionalFields' );
		$options = get_option('csds_userRegAide_Options');
		if( $fieldKey == 'pass1' ){
			if( $options['reg_form_use_colon'] == 1 ){
				if ( $options['show_asterisk'] == 1 ){
					$label = '*:';
					return $label;
				}else{
					$label = ':';
					return $label;
				}
			}else{
				if ( $options['show_asterisk'] == 1 ){
					$label = '*';
					return $label;
				}else{
					return $label;
				}
			}
		}
		if( !empty( $optional_fields ) && is_array( $optional_fields ) ){
			if( array_key_exists( $fieldKey, $optional_fields ) ){ 
				if( $options['reg_form_use_colon'] == 1 ){
					$label = ':';
					return $label;
				}
			}else{
				if( $options['reg_form_use_colon'] == 1 ){
					if ( $options['show_asterisk'] == 1 ){
						$label = '*:';
						return $label;
					}else{
						$label = ':';
						return $label;
					}
				}else{
					if ( $options['show_asterisk'] == 1 ){
						$label = '*';
						return $label;
					}else{
						return $label;
					}
				}
			}
			
		}
		return $label;
			
	}
		
	/**	
	 * function create_field_label
	 * Processes field labels view for registration form fields to save on redundency
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $fieldKey meta_key for field, string $fieldName field Title or Name that users see for field
	 * @returns string $label Label that is uses for field on registration form
	*/
	
	function create_field_label( $fieldKey, $fieldName ){
		$label = ( string ) '';
		$rfields = array();
		$optional_fields = get_option( 'csds_ura_optionalFields' );
		if( get_option( 'csds_userRegAide_registrationFields' ) ){
			$rFields = get_option( 'csds_userRegAide_registrationFields' );
		}
		$options = get_option('csds_userRegAide_Options');
		
		$label = $fieldName;
		if( !empty( $rfields ) ){
			if( is_array( $rfields ) && array_key_exists( $fieldKey, $rFields ) ){
				if( !empty( $optional_fields ) && is_array( $optional_fields ) ){
					if( array_key_exists( $fieldKey, $optional_fields ) ){ 
						if( $options['reg_form_use_colon'] == 1 ){
							$label .= ':';
							return $label;
						}
					}else{
						if( $options['reg_form_use_colon'] == 1 ){
							if ( $options['show_asterisk'] == 1 ){
								$label .= '*:';
								return $label;
							}else{
								$label .= ':';
								return $label;
							}
						}else{
							if ( $options['show_asterisk'] == 1 ){
								$label .= '*';
								return $label;
							}else{
								return $label;
							}
						}
					}
				}else{
					if( array_key_exists( $fieldKey, $rFields ) ){
						if( $options['reg_form_use_colon'] == 1 ){
							$label .= '*:';
						}else{
							$label .= '*';
						}
					}
				}
				return $label;
			}
		}
		$field = new FIELDS_DATABASE();
		$fields = $field->get_registration_fields();
		if( !empty( $fields ) ){
			foreach( $fields as $object ){
				if( $object->meta_key == $fieldKey ){
					if( $object->field_required == 1 ){
						if ( $options['show_asterisk'] == 1 ){
							if( $options['reg_form_use_colon'] == 1 ){
								$label .= '*:';
								return $label;
							}else{
								$label .= '*';
								return $label;
							}
						}else{
							return $label;
						}
					}else{
						if( $options['reg_form_use_colon'] == 1 ){
							$label .= ':';
							return $label;
						}else{
							return $label;
						}
					}
				}
				/*
				 * else{
					if( $options['reg_form_use_colon'] == 1 ){
						$label = $fieldName.':';
						return $label;
					}
					
				}
				*/
				//return $label;
			}
			//return $label;
		}		
	}
	
	/**	
	 * function reg_fields_array
	 * Processes field labels view for registration form fields to save on redundency
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $reg_form_fields array of fields selected for use on registration form
	*/
	
	function reg_fields_array(){
		$regFields = array();
		$regFields = get_option( 'csds_userRegAide_registrationFields' );
		$reg_form_fields = array();
		$fields = new FIELDS_DATABASE();
		$ura_reg_fields = $fields->get_registration_fields();
		if( get_option( 'csds_userRegAide_registrationFields' ) ){
			foreach( $regFields as $key => $title ){
				$reg_form_fields[$key] = $title;
			}
		}
		foreach( $ura_reg_fields as $object ){
			$reg_form_fields[$object->meta_key] = $object->field_name;
		}
		return $reg_form_fields;
	}
	
	/**	
	 * function update_registration_fields
	 * Updates fields for use on registration form
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns 
	*/
	
	function update_registration_fields(){
		$rfields = array();
		$kfields = array();
		if( get_option( 'csds_userRegAide_registrationFields' ) ){
			$rFields = get_option( 'csds_userRegAide_registrationFields' );
			$kFields = get_option( 'csds_userRegAide_knownFields' );
			if( !empty( $rfields ) || is_array( $rfields ) ){
				foreach( $rFields as $key => $title ){
					if( !array_key_exists( $key, $kFields ) ){
						unset( $rFields[$key] );
					}
				}
				update_option( 'csds_userRegAide_registrationFields', $rFields );
			}
		}
	}
	
	/**	
	 * function process_field_viewing
	 * Processes field viewing functionality and which function to call to show field to eliminate redundancy
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $fieldKey field key name, string $fieldName field name title for displaying to end user, 
	 * @params string $value field value entered by user
	 * @returns
	 */
	 
	function process_field_viewing( $fieldKey, $fieldName, $value ){
		$kf = get_option( 'csds_userRegAide_knownFields' ); 
		if( !is_plugin_active('theme-my-login/theme-my-login.php' ) ){ // Compensates for theme my login bug
			if( $fieldKey == 'user_pass' ){ // adding password fields to form
				do_action( 'password_input' );
			}elseif( $fieldKey == 'description' ){
				do_action( 'ta_input', $fieldKey, $fieldName, $value );
			}elseif( array_key_exists( $fieldKey, $kf ) ){
				do_action( 'known_fields_rf', $fieldKey, $fieldName, $value );
			}else{
				do_action( 'fields_input', $fieldKey, $fieldName, $value );
			}
		}else{
			if( $fieldKey == 'user_pass' ){
				do_action( 'password_input' );
			}elseif( $fieldKey == 'description' ){
				do_action( 'tml_ta_input', $fieldKey, $fieldName, $value );
			}elseif( array_key_exists( $fieldKey, $kf ) ){
				do_action( 'tml_known_fields_rf', $fieldKey, $fieldName, $value );
			}else{
				do_action( 'tml_fields_input', $fieldKey, $fieldName, $value );
			}
		}
	}
	
	/**	
	 * function update_new_user_fields
	 * Add the additional metadata into the database after the new user is created from registration form
	 * @since 1.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles action 'user_register' line 218 user-registration-aide.php (Priority: 1 - Params: 1)
	 * @params int $user_id
	 * @returns 
	*/
	
	function update_new_user_fields( $user_id ){

		global $regFields, $wpdb, $table_prefix;
		$options = get_option('csds_userRegAide_Options');
		$approve = ( int ) 0;
		$approve = $options['new_user_approve'];
		$verify = $options['verify_email'];
		$approval = $options['buddy_press_approval'];
		$field_key = ( string ) '';
		$field_type = ( string ) '';
		$fieldKey = ( string ) '';
		$fieldName = ( string ) '';
		$newValue = ( string ) '';
		$newPass = ( string ) '';
		$addData = ( string ) '';
		$newWebsite = ( string ) '';
		$newCredentials = ( string ) '';
		$fname = ( string ) '';
		$lname = ( string ) '';
		$tmp_str = ( string ) '';
		$tmp_array = array();
		$type = array();
		$users_table = $wpdb->prefix . "users";
		$plugin = 'buddypress/bp-loader.php';
		
		$regFields = array();
		$regFields = get_option( 'csds_userRegAide_registrationFields' );
		$reg_form_fields = array();
		$fields = new FIELDS_DATABASE();

		$ms = array();
		$newValue1 = ( string ) '';
		$newValueA = array();
		$nvKey = ( string ) '';
		$nvvalue = ( string ) '';
		$count = ( int ) 0;
		$index = ( int ) 0;
		$meta = array();
		$xwrd_nag = ( int ) 0;
		// new user approval update
		if( $approve == 1 ){
			update_user_meta( $user_id, 'approval_status', 'pending' );
		}else{
			update_user_meta( $user_id, 'approval_status', 'approved' );
			$user_data = array(
				'user_status' => 0
			);
			wp_update_user( $user_data );
			
		}
		
		if( $verify == 1 ){
			update_user_meta( $user_id, 'email_verification', 'unverified' );
			do_action( 'update_member_key', $user_id );
		}else{
			update_user_meta( $user_id, 'email_verification', 'verified' );
		}
		
		if( is_plugin_active( $plugin ) ){
			do_action( 'update_member_key', $user_id );
		}
		
		$members = new URA_MEMBERS_ACTIONS();
		$user_email = $_POST['user_email'];
		
		if( $approve != 1 && $verify != 1 ){
			$members->update_user_status_field( $user_id );
		}
		
		
		
		// fields updates for new users
		$reg_form_fields = $this->reg_fields_array();
		if( !empty( $reg_form_fields ) ){
			if( wp_verify_nonce( $_POST['userRegAide_RegFormNonce'], 'userRegAideRegForm_Nonce' ) ){
				foreach( $reg_form_fields as $fieldKey => $fieldName ){
					if( !empty( $regFields ) && is_array( $regFields ) ){
						if( array_key_exists( $fieldKey, $regFields ) ){
							$field_type = 'text';
						}else{
							$field_type = $fields->get_field_type( $fieldKey );
						}
						if( $fieldKey == 'user_pass' ){
							$field_type = 'password';
						}
					}
					if( $_POST[$fieldKey] != '' ){
						if( $fieldKey == "first_name" ){
							$newValue = apply_filters('pre_user_first_name', $_POST[$fieldKey]);
							$newValue = sanitize_text_field( $newValue );
							$fname = apply_filters('pre_user_first_name', $_POST[$fieldKey]);
							$fname = sanitize_text_field( $fname );
						}elseif( $fieldKey == "last_name" ){
							$newValue = apply_filters('pre_user_last_name', $_POST[$fieldKey]);
							$newValue = sanitize_text_field( $newValue );
							$lname = apply_filters('pre_user_first_name', $_POST[$fieldKey]);
						}elseif( $fieldKey == "nickname" ){
							$newValue = apply_filters('pre_user_nickname', $_POST[$fieldKey]);
							$newValue = sanitize_text_field( $newValue );
						}elseif( $fieldKey == "description" ){
							$newValue = apply_filters('pre_user_description', $_POST[$fieldKey]);
							$newValue = sanitize_text_field( $newValue );
						}elseif( $fieldKey == "user_url" ){
							$newWebsite = apply_filters( 'pre_user_url', $_POST[$fieldKey] );
							$addData = $wpdb->prepare( "UPDATE $users_table SET user_url =('$newWebsite') WHERE ID = '$user_id'" );
							$wpdb->query($addData);
						}elseif( $fieldKey == "user_pass" ){
							$newPass = $_POST['pass1'];
							$newPass = wp_hash_password( $newPass );
							//$addData = $wpdb->prepare("UPDATE $wpdb->users SET user_pass = md5('$newPass') WHERE ID = $user_id");
							$addData = $wpdb->prepare( "UPDATE $users_table SET user_pass = %s WHERE ID = %d", $newpass, $user_id );
							$wpdb->query( $addData );
							$xwrdf = new PASSWORD_FUNCTIONS();
							$xwrd_nag = $xwrdf->remove_default_password_nag( $user_id );  // to  remove password nag from new users who fill out own password if this bullsit even works wordpress is sucky this way line 926 &$ura
						}else{
							if( $field_type == 'multiselectbox' || $field_type = 'checkbox' ){
								
								$temp = $_POST[$fieldKey];
								//exit( print_r( $temp ) );
								//$ms = true;
								/*
								if( !empty( $temp ) ){
									if( is_array( $temp ) ){
										foreach( $temp as $tkey => $tvalue ){
											$tvalue = apply_filters( 'pre_user_description', $tvalue );
											$temp[$tkey] = $tvalue;
										}
									}else{
										$temp = apply_filters( 'pre_user_description', $temp );
									}
									
								}
								*/
								$newValue = maybe_serialize( $temp );
							}else{
								$newValue = apply_filters( 'pre_user_description', $newValue );
								$newValue = sanitize_text_field( $newValue );
							}
							update_user_meta( $userID, $fieldKey, $newValue );
							
							
						}
						
						update_user_meta( $user_id, $fieldKey, $newValue);
						
						// updating buddypress field data
						$plugin = 'buddypress/bp-loader.php';
						if( is_plugin_active( $plugin ) ){
														
							if( !empty( $fname ) && !empty( $lname ) ){
								xprofile_set_field_data( '1', $user_id, $fname.' '.$lname, $is_required = true );
							}else{
								xprofile_set_field_data( '1', $user_id, $_POST['user_login'], $is_required = true );
							}
							
							// BP Fields Update Data
							$field = new FIELDS_DATABASE();
							$field_id = $field->get_bp_id_by_meta_key( $fieldKey );
							if( !empty( $field_id ) ){
								$fid = 'field_'.$field_id;
								$meta[$fid] = $newValue;
								//xprofile_set_field_data( $field_id, $user_id, $newValue, $is_required = false );
							}
						}
						
					} // end if check for empty post
				}  // end foreach
				
				if( $options['show_custom_agreement_checkbox'] == 1 ){
					if( $_POST['csds_userRegAide_agree'] == "1" ){
						update_user_meta( $user_id, 'new_user_agreed', "Yes" );
					}
				}
				
				// updates custom display name fields as needed
				if( $options['custom_display_name'] == 1 ){
					
					$current_role = get_option('default_role');
					$selRole = $options['display_name_role'];
					$selField = $options['custom_display_field'];
					foreach( $selRole as $role_key => $role_value ){
						if( $role_value == 'all_roles' || $role_value == $current_role ){
							if( $selField == 'first_last_name' ){
								$display_name = $_POST['first_name'].' '.$_POST['last_name'];
								$display_name = apply_filters( 'pre_user_display_name', $display_name );
								$add_display_name = $wpdb->prepare("UPDATE $users_table SET display_name = %s WHERE ID = %d", $display_name, $user_id);
								$wpdb->query( $add_display_name );
							}elseif( $selField == 'last_first_name' ){
								$display_name = $_POST['last_name'].' '.$_POST['first_name'];
								$display_name = apply_filters( 'pre_user_display_name', $display_name );
								$add_display_name = $wpdb->prepare("UPDATE $users_table SET display_name = %s WHERE ID = %d", $display_name, $user_id);
								$wpdb->query( $add_display_name );
							}else{
								$display_name = $_POST[$selField];
								$display_name = apply_filters( 'pre_user_display_name', $display_name );
								$add_display_name = $wpdb->prepare("UPDATE $users_table SET display_name = %s WHERE ID = %d", $display_name, $user_id);
								$wpdb->query( $add_display_name );
							}
						}
					}
					
					$field = $_POST['user_login'];
					if( !empty( $field ) ){
						update_user_meta( $user_id, 'default_display_name', $field );
					}
				}
				if( $options['add_security_question'] == "1" ){
					$sqc = new SECURITY_QUESTIONS_CONTROLLER();
					$questions = $sqc->questions_array();
					$answers = $sqc->answers_array();
					foreach( $questions as $index => $question ){
						if( isset( $_POST[$question] ) ){
							$sqc->update_security_questions_user_profile( $user_id, $question, $_POST[$question] );
						}
					}
					foreach( $answers as $index => $answer ){
						if( isset( $_POST[$answer] ) ){
							$sqc->update_security_questions_user_profile( $user_id, $answer, $_POST[$answer] );
						}
					}
				}
				// for multiple sites using same users table and same database with different prefix
				$temps = $options['db_prefixes'];
				if ( defined( 'CUSTOM_USER_TABLE' ) || !empty( $temps ) ){
					$uma = new URA_MEMBERS_ACTIONS();
					$results = $uma->roll_update( $user_id );
					/*$user_table = CUSTOM_USER_TABLE;
					$temp = explode( '_', $user_table );
					$base_prefix = $temp[0].'_';
					$prefix = $wpdb->prefix;
					
					$prefixes = explode( ',', $temps );
					$pcnt = ( int ) 0;
					if( !empty( $prefixes ) ){
						if( is_array( $prefixes ) ){
							foreach( $prefixes as $index => $aprefix ){
								if( $prefix != $base_prefix ){
									$caps = get_user_meta( $user_id, $prefix.'capabilities', false  );
									$level = get_user_meta( $user_id, $prefix.'user_level', true  );
									if( $pcnt == 0 ){
										update_user_meta( $user_id, $base_prefix.'capabilities', $caps );
										update_user_meta( $user_id, $base_prefix.'level', $level );
									}
									if( $prefix != $aprefix ){
										update_user_meta( $user_id, $aprefix.'capabilities', $caps );
										update_user_meta( $user_id, $aprefix.'level', $level );
									}
								}elseif( $prefix == $base_prefix ){
									$caps = get_user_meta( $user_id, $prefix.'capabilities', false  );
									$level = get_user_meta( $user_id, $prefix.'user_level', true  );
									update_user_meta( $user_id, $aprefix.'capabilities', $caps );
									update_user_meta( $user_id, $aprefix.'level', $level );
								}
								$pcnt++;
							}						
						}else{
							if( $prefix != $base_prefix ){
								$caps = get_user_meta( $user_id, $prefix.'capabilities', false  );
								$level = get_user_meta( $user_id, $prefix.'user_level', true  );
								update_user_meta( $user_id, $base_prefix.'capabilities', $caps );
								update_user_meta( $user_id, $base_prefix.'level', $level );
							}elseif( $prefix == $base_prefix ){
								$caps = get_user_meta( $user_id, $prefix.'capabilities', false  );
								$level = get_user_meta( $user_id, $prefix.'user_level', true  );
								update_user_meta( $user_id, $prefixes.'capabilities', $caps );
								update_user_meta( $user_id, $prefixes.'level', $level );
							}
						}
					}
					$pcnt = 0;*/
				}
			}else{
				exit( __( 'Failed Security Verification', 'csds_userRegAide' ) );
			}
		} // end if empty registraion form extra fields
				
		if( is_plugin_active( $plugin ) ){
			do_action( 'new_user_email_verified', $user_id );
			$user = get_user_by( 'id', $user_id );
			if ( bp_is_active( 'xprofile' ) ) {
				$meta['field_1'] = $_POST['first_name'].' '.$_POST['last_name'];
			}
			$meta['password'] = $user->user_pass;
			BP_Signup::add( array(
				'user_login'     => $user->user_login,
				'user_email'     => $user->user_email,
				'registered'     => $user->user_registered,
				'activation_key' => $user->user_activation_key,
				'meta'           => $meta
			) );
			do_action( 'delete_bp_signup', $user->user_email );
		}else{
			if( $options['verify_email'] == 1 || $options['new_user_approve'] == 1 ){
				do_action( 'update_member_status', $user_id );
				do_action( 'user_email', $user_id );
				do_action( 'admin_email', $user_id );
			}
		}
		
	} // end function
	
	/**	
	 * function verify_new_user_fields
	 * Check the new user registration form for errors
	 * @since 1.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @Filters 'registration_errors' line 219 user-registration-aide.php (Priority: 1 - Params: 3)
	 * @params WP_Error OBJECT $errors, string $username, string $email
	 * @returns WP_Error OBJECT $errors of missing required fields
	*/
	
	function verify_new_user_fields( $errors, $username, $email ){
		global $errors;
		$error = ( int ) 0;
		$pwd = '';
		$fieldKey = '';
		$fieldName1 = '';
		$reg_fields = array();
		$reg_fields = get_option( 'csds_userRegAide_registrationFields' );
		$options = get_option('csds_userRegAide_Options');
		$field = new FIELDS_DATABASE();
		$fields = $field->get_registration_fields();
		$data = ( string ) '';
		$xwrd = ( string ) '';
		$login = ( string ) '';
		$email = ( string ) '';
		$reg_form_fields = $this->reg_fields_array();
		// fix reg_fields[$fieldKey] not work for $fields object
		if( !empty( $reg_form_fields ) ){
			foreach( $reg_form_fields as $reg_key => $reg_name ){
				if( $reg_key != "user_pass" ){
					if( empty( $_POST[$reg_key] ) ) { 
						$errors->add('empty_'.$reg_key , __("<strong>ERROR</strong>: Please enter your ".$reg_name.".",'csds_userRegAide'));
						$error ++;
					}else{ // checking for duplicate entries to weed out spammers
						foreach( $reg_form_fields as $reg_key1 => $reg_name1 ){
							$fieldKey1 = $reg_key1;
							$fieldName2 = $reg_name1;
							$type1 = 'text';
							$post_key1 = $reg_key1;
							
							if( $post_key1 != "user_pass" ){
								if( $reg_key != $reg_key1 ){
									if( isset( $_POST[$reg_key] ) && isset( $_POST[$reg_key1] ) ){
										if( !empty( $_POST[$reg_key] ) && !empty( $_POST[$reg_key1] ) ){
											if( $_POST[$reg_key] == $_POST[$reg_key1] ){
												$errors->add( 'duplicate_spam_check'.$fieldKey , __( "<strong>ERROR</strong>: Your ".$reg_name." and ".$reg_name1." are the same, please enter different values!",'csds_userRegAide' ) );
											}
										}
									}
								}
							}
						}
					}
				}elseif( $reg_key == "user_pass" ){
					if( !empty( $_POST['pass1'] ) ){
						$xwrd = $_POST['pass1'];
					}
					if( !empty( $_POST['user_login'] ) ){
						$login = $_POST['user_login'];
					}
					if( !empty( $_POST['user_email'] ) ){
						$email = $_POST['user_email'];
					}
					$errors = apply_filters( 'xwrd_strength_checker', $errors, $xwrd, $login, $email );
				
				}
			}
		}
				
		if( $options['show_custom_agreement_checkbox'] == "1" ){
			if( $_POST['csds_userRegAide_agree'] == "2" ){
				$errors->add('agreement_confirmation', __( "<strong>ERROR</strong>: You must agree to the terms and conditions!", 'csds_userRegAide' ) );
				$error ++;
			}elseif( empty( $_POST['csds_userRegAide_agree'] ) ){
				$errors->add( 'agreement_confirmation', __( "<strong>ERROR</strong>: You must agree to the terms and conditions!", 'csds_userRegAide' ) );
				$error ++;
			}
		}
				
		// anti-spam math problem
		if( $options['activate_anti_spam'] == "1" ){
			$options = get_option( 'csds_userRegAide_Options' );
			$num1 = $options['math_num1'];
			$num2 = $options['math_num2'];
			$oper = $options['math_oper'];
			$answer = $options['math_answer'];
			$math = new URA_MATH_FUNCTIONS();
			$operator = $math->get_operator( $oper );
			$math_answer = ( double ) 0;
			
			if( $operator == "+" ){
				$math_answer = round( $num1 + $num2, 1 );
			}elseif( $operator == "-" ){
				$math_answer = round( $num1 - $num2, 1 );
			}elseif( $operator == "*" ){
				$math_answer = round( $num1 * $num2, 1 );
			}elseif( $operator == "/"){
				$math_answer = round( $num1 / $num2, 1 );
			}
			
			if( empty( $_POST[$answer] ) ){
				$errors->add( 'anti_spammer_security', __( "<strong>ERROR</strong>: You must enter the anti-spam math problem answer!", 'csds_userRegAide' ) );
				$error ++;
			}elseif( $_POST[$answer] != $math_answer ){
				$errors->add( 'anti_spammer_security', __( "<strong>ERROR</strong>: Your anti-spam math problem answer is incorrect! Try using your calculator if you are having problems!", 'csds_userRegAide' ) );
				$error ++;
			}
			
			$math = new URA_MATH_FUNCTIONS();
			$scramble = $math->scramble_variables();
		}
		
		if( $options['add_security_question'] == "1" ){
			$name_1 = 'security_question_1';
			$a_name_1 = 'security_answer_1';
			$name_2 = 'security_question_2';
			$a_name_2 = 'security_answer_2';
			$name_3 = 'security_question_3';
			$a_name_3 = 'security_answer_3';
			for( $index = 1; $index <= 3; $index++ ){
				if( $index == 1 ){
					$name = $name_1;
					$a_name = $a_name_1;
				}elseif( $index == 2 ){
					$name = $name_2;
					$a_name = $a_name_2;
				}elseif( $index == 3 ){
					$name = $name_3;
					$a_name = $a_name_3;
				}
					
				if( $_POST[$name] == null ){
					$errors->add( $name, __( "<strong>ERROR</strong>: You have not selected a question for ".strtoupper( $name ), 'csds_userRegAide' ) );
					$error ++;
				}
				if( $_POST[$a_name] == null ){
					$errors->add( $a_name, __( "<strong>ERROR</strong>: There is no answer for ".strtoupper( $name ), 'csds_userRegAide' ) );
					$error ++;
				}
				
			}
		}
		
		if( empty( $_POST['user_login'] ) ){
			$error ++;
		}
		if( empty( $_POST['user_email'] ) ){
			$error ++;
		}
		
		return $errors;
	}

	// ----------------------------------------     Login-Registration Redirects Functions     ----------------------------------------
	
	/**	
	 * Function ura_registration_redirect
	 * Redirects after successful new user registration
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles filter 'registration_redirect' line 220 &$this 
	 * @params string $redirect_to (url)
	 * @returns string $redirect_to New url to redirect to after successful registration 
	 * if user chooses option or same url if option not chosen
	 */
	
	function ura_registration_redirect( $redirect_to ){
		
		$options = get_option( 'csds_userRegAide_Options' );
		if( $options['redirect_registration'] == "1" ){
			$redirect_to = $options['registration_redirect_url'];
			}else{
			$redirect_to = $redirect_to;
		}
		
		return $redirect_to;
		
	}
	
	/**	
	 * Function ura_login_redirect
	 * Redirects after successful user login
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles filter 'registration_redirect' line 224 &$this 
	 * @params string $redirect_to (url)
	 * @returns string $redirect_to New url to redirect to after successful login if user chooses option
	 */
	
	function ura_login_redirect( $redirect_to ){
		
		$options = get_option( 'csds_userRegAide_Options' );
		if( $options['redirect_login'] == "1" ){
			$redirect_to = $options['login_redirect_url'];
			}else{
			$redirect_to = $redirect_to;
		}
		
		return $redirect_to;
		
	}
	
}
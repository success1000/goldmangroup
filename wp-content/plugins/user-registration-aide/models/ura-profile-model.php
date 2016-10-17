<?php

/**
 * Class URA_PROFILE_MODEL
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.6
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_PROFILE_MODEL
{
	
	/** 
	 * function csds_update_user_profile
	 * Updates the additional fields data added to the user profile page
	 * @since 1.0.0
	 * @updated 1.5.2.6
	 * @access public
	 * @params WP USER OBJECT $user
	 * @returns 
	*/	
	
	 function csds_update_user_profile( $user ){
		global $wpdb, $current_user, $pagename, $errors, $post, $wp_query, $screen;
		$current_user = wp_get_current_user();
		$c_user_id = $current_user->ID;
		$screen = get_current_screen();
		$screen_id = ( string ) '';
		if( !empty( $screen ) ){
			$screen_id = $screen->id;
			//wp_die( $screen_id );
		}
		$fieldKey = '';
		$fieldName = '';
		$newValue = '';
		$newDate = '';
		$newValue1 = ( string ) '';
		$newValue2 = ( string ) '';
		$options = get_option( 'csds_userRegAide_Options' );
		$temp = array();
		$tmp_str = (string) '';
		$ms = ( boolean ) false;
		$postKey = (string) '';
		$bpValue = (string) '';
		$cnt = ( int ) 0;
		$field = ( int ) 0;
		$user_id = ( int ) 0;
		$value = ( string ) '';
		$url = ( string ) '';
		$SQ = $options['add_security_question'];
		$plugin = ( string ) 'buddypress/bp-loader.php';
		$field = new FIELDS_DATABASE();
		$ura_fields = $field->get_all_fields();
		if( current_user_can( 'edit_user', $current_user->ID )  || current_user_can( 'create_users', $current_user->ID ) ){
			
			// making sure $user is not empty
			$c_user_id = $current_user->ID;
		
			if( empty( $user ) ){
				if( isset( $_GET['user_id'] ) ){
					$user_id = $_GET['user_id'];
				}elseif( isset( $_POST['user_id'] ) ){
					$user_id = $_POST['user_id'];
				}else{
					$user_id = $c_user_id;
				}
			}else{
				$user_id = $user;
			}
			if( is_int( $user_id ) ){
				$user_id = $user_id;
			}else{
				$user_id = $c_user_id;
			}
			
			//handles security questions if used
			
			if( $options['add_security_question'] == "1" ){
				$sq_question = (string) '';
				$sq_answer = (string) '';
				$sqc = new SECURITY_QUESTIONS_CONTROLLER();
				$questions = $sqc->questions_array();
				$answers = $sqc->answers_array();
				foreach( $questions as $index => $question ){
					if( isset( $_POST[$question] ) ){
						$sq_question = sanitize_text_field( $_POST[$question] );
						$sqc->update_security_questions_user_profile( $user_id, $question, $sq_question );
					}
				}
				foreach( $answers as $index => $answer ){
					if( isset( $_POST[$answer] ) ){
						$sq_answer = sanitize_text_field( $_POST[$answer] );
						$sqc->update_security_questions_user_profile( $user_id, $answer, $sq_answer );
					}
				}
			}
			
			// handles custom profile fields
			
			if( !empty( $ura_fields ) ){
				$plugin1 = ( string ) 'wp-symposium-pro/wp_symposium_pro.php';
				$plugin2 = ( string ) 'asgaros-forum/asgaros-forum.php';
				$title = get_the_title();
				$slug = basename( get_permalink() );
				if( isset( $_GET['page'] ) ){
					$page = $_GET['page'];
				}else{
					$url = $_SERVER['REQUEST_URI'];
					$pages = explode( "/", $url );
					$page = $pages[1];
				}
				if( !empty( $screen_id ) && $screen_id == 'profile' || $screen_id == 'user-edit' ){
					if( $slug != 'register' ) {
						if( $title != 'Check Your Email To Activate Your Account!' ){
							if( $page != 'bp-profile-edit' && $page != 'members' && $page != 'new-user-approval' ){
								if( !is_plugin_active( $plugin2 ) ){
									if( !is_plugin_active( $plugin1 ) ){
										if( !wp_verify_nonce( $_POST['userRegAideProfileNonce'], 'userRegAideProfileForm' ) ){
											exit( __( 'Failed Nonce Security!', 'csds_userRegAide' ) );
										}
									}
								}
							}
						}
					}
					foreach( $ura_fields as $object ){
						
						$type = $object->data_type;
						$fieldKey = $object->meta_key;
						$postKey = $fieldKey;
						if( isset( $_POST[$postKey] ) ){
							if( $type == 'textbox' ){
								$newValue = sanitize_text_field( $_POST[$postKey] );
							}elseif( $type == 'url' ){
								$newValue = sanitize_text_field( $_POST[$postKey] );
								$newValue = esc_url_raw( $newValue );
							}elseif( $type == 'textarea' ){	
								$newValue = sanitize_text_field( $_POST[$postKey] );
							}elseif( $type == 'datebox' ){	
								$newValue =  $_POST[$postKey];
							}elseif( $type == 'number' ){	
								$newValue =  $_POST[$postKey];
							}elseif( $type == 'radio' ){	
								$newValue = sanitize_text_field( $_POST[$postKey] );
							}elseif( $type == 'selectbox' ){	
								$newValue = sanitize_text_field( $_POST[$postKey] );
							}elseif( $type == 'multiselectbox' || $type = 'checkbox' ){
								$temp = $_POST[$postKey];
								$ms = true;
								if( !empty( $temp ) ){
									if( is_array( $temp ) ){
										foreach( $temp as $tkey => $tvalue ){
											$tvalue = sanitize_text_field( $tvalue );
											$temp[$tkey] = $tvalue;
										}
										$newValue1 = serialize( $temp );
									}else{
										$temp = sanitize_text_field( $temp );
										$newValue1 = $temp;
									}
									
								}
								
							}
							//exit( 'NEW VALUE: '.$newValue );
							if( $ms == false ){
								update_user_meta( $user_id, $fieldKey, $newValue );
							}elseif( $ms == true ){
								update_user_meta( $user_id, $fieldKey, $newValue1 );
							}
							
							
							// update buddy press field data
							if( is_plugin_active( $plugin ) ){
								$id = $object->bp_ID;
								$bpf = new URA_BP_FUNCTIONS();
								if( $ms == true ){
									$bpf->update_bp_profile( $user_id, $id, $newValue1 );
									$ms = false;
								}else{
									$bpf->update_bp_profile( $user_id, $id, $newValue );
								}
								$ms = false;
							}
							$ms = false;
						}else{
							
						}
					}
					
				}
				
			}
			
		}else{
			if( is_user_logged_in() ){ // wordpress or theme bug for some
				exit( __( 'You do not have sufficient permissions to edit this user, contact a network administrator if this is an error!', 'csds_userRegAide' ) );
			}else{
				wp_safe_redirect( wp_login_url() );
				//exit;
			}
		}
		
		/*
	 
		global $wpdb, $current_user, $pagename, $errors;
		
		$csds_userRegAide_NewFields = get_option('csds_userRegAide_NewFields');
		$userID = $user;
		$fieldKey = '';
		$fieldName = '';
		$newValue = '';
		$newValue1 = (string) '';
		$newValue2 = (string) '';
		$current_user = wp_get_current_user();
		$options = get_option('csds_userRegAide_Options');
		
		if( current_user_can( 'edit_user', $current_user->ID)  || current_user_can('create_users', $current_user->ID ) ){
			if( !empty( $csds_userRegAide_NewFields ) && is_array( $csds_userRegAide_NewFields ) ){
				if( !is_multisite() ){
					if( wp_verify_nonce($_POST["userRegAideProfileNonce"], 'userRegAideProfileForm' ) ){
						foreach( $csds_userRegAide_NewFields as $fieldKey => $fieldName ){
							if( isset( $_POST[$fieldKey] ) ){
								$newValue = sanitize_text_field( $_POST[$fieldKey] );
								$newValue = apply_filters( 'pre_user_description', $newValue );
								update_user_meta($userID, $fieldKey, $newValue);
							}else{
								//exit(__('New Value empty!'));
							}
						}
					}else{
						exit( __( 'Failed Security Check', 'csds_userRegAide' ) );
					}
				
				}else{
					if( wp_verify_nonce( $_POST["userRegAideProfileNonce"], 'userRegAideProfileForm' ) ){
						foreach( $csds_userRegAide_NewFields as $fieldKey => $fieldName ){
							if( isset( $_POST[$fieldKey] ) ){
								$newValue = sanitize_text_field( $_POST[$fieldKey] );
								$newValue = apply_filters( 'pre_user_description', $newValue );
								update_user_meta($userID, $fieldKey, $_POST[$fieldKey]);
							}
							else{
								//exit(__('New Value empty!'));
							}
						}
					}else{
						exit( __( 'Failed Security Check', 'csds_userRegAide' ) );
					}
				}
			}
			
		}else{
			if( is_user_logged_in() ){ // wordpress or theme bug for some
				exit( __( 'You do not have sufficient permissions to edit this user, contact a network administrator if this is an error!', 'csds_userRegAide' ) );
			}else{
				wp_safe_redirect( wp_login_url() );
				//exit;
			}
		}
		*/
		
	}
	
	// ----------------------------------------     Admin User Table Functions     ----------------------------------------
	
	/**	
	 * Function csds_userRegAide_addUserFields
	 * Adds the extra fields to the default WordPress User Fields Screen 
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @Filters 'manage_users_columns' line 270 &$this (Priority: 0 - Params: 1)
	 * @Filters 'wpmu_users_columns' for multisite line 273 &$this (Priority: 0 - Params: 1)
	 * @Filters 'manage_users_columns' for multisite line 274 &$this (Priority: 0 - Params: 1)
	 * @params array $columns Columns for admin user table view
	 * @returns array $columns Returns extra columns not included in original admin user table view
	 */
	
	function csds_userRegAide_addUserFields( $columns ){
		
		$fields = get_option( 'csds_userRegAideFields' );
		$new_fields = get_option( 'csds_userRegAide_NewFields' );
		
		if( !empty( $fields ) ){		
			foreach( $fields as $key => $value ){
				if( $key != "user_pass" ){
					$columns[$key] = __( $value, 'csds_userRegAide' );
				}
			}
		}
		
		$field = new FIELDS_DATABASE();
		$ura_fields = $field->get_all_fields();
		if( !empty( $ura_fields ) ){
			foreach( $ura_fields as $object ){
				$fieldKey = $object->meta_key;
				$fieldName = $object->field_name;
				$atype = $object->data_type;
				$label = $fieldName;
				$name = $fieldKey;
				$id = $fieldKey;
				$columns[$id] = __( $label, 'csds_userRegAide' );
			}
		}
		
		return $columns;
	}
	
	/**	
	 * Function csds_userRegAide_fillUserFields
	 * Controls new fields filters for new fields inputs 
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @Filters  'manage_users_custom_column' line 271 &$this (Priority: 0 - Params: 3)
	 * @params string $value(column value), $column_name, $user_id
	 * @params string $column_name Name of new column to add to admin users table view
	 * @params int $user_id Unique user id given by WordPress
	 * @returns $data User data for specified column ($column_name)
	 * @website http://creative-software-design-solutions.com
	 */
	
	function csds_userRegAide_fillUserFields( $value, $column_name, $user_id ){
		$values = ( string ) '';
		$cnt = ( int ) 0;
		$data = get_user_option( $column_name, $user_id, false );
		$data = maybe_unserialize( $data );
		if( is_array( $data ) ){
			foreach( $data as $index => $field ){
				if( $cnt == 0 ){
					$values = $field;
				}else{
					$values .= ', '.$field;
				}
				$cnt++;
			}
			return $values;
		}else{
			return $data;
		}
	}
	
	/**
	 * function csds_add_field_to_users_meta
	 * Adds all the additional fields created to existing users meta
	 * @since 1.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles csds_add_field_to_users_meta($results) line 279 &$admin
	 * @params string $field
	 * @returns
	 */
	
	function csds_add_field_to_users_meta( $field ){
		global $wpdb;
		$ids = $wpdb->get_col( "SELECT ID FROM $wpdb->users;" );
		$count = ( int ) 0;
		$count = count( $ids );
		$i = ( int ) 0;
		if( $count >= 2 && is_array( $ids ) ){
			foreach( $ids as $index => $value ){
				$user_id = $value;
				update_user_meta( $user_id, $field, "" );
				$i++;
			}
		}
		if( $i >= 1 ){
			return true;
		}else{
			return false;
		}
	} // end function
	
	/**
	 * function csds_delete_field_from_users_meta
	 * Deletes the additional fields from existing users meta
	 * @since 1.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles csds_delete_field_from_users_meta($results1) line 106 &$URA_NEW_FIELDS
	 * @params string $field
	 * @returns
	 */
	
	function csds_delete_field_from_users_meta( $field ){
		global $wpdb;
		$table = $wpdb->prefix . "usermeta";
		$where = array(
			'meta_key'	=>  '%s',
		);
		$ids = $wpdb->get_col( "SELECT ID FROM $wpdb->users;" );
		$count = ( int ) 0;
		$count = count( $ids );
		$i = ( int ) 0;
		if( $count >= 2 && is_array( $ids ) ){
			foreach( $ids as $index => $value ){
				$user_id = $value;
				delete_user_meta( $user_id, $field, "" );
				$wpdb->delete( $table, array( 'meta_key' => $field, 'user_id' => $user_id )  );
				$i++;
			}
		}
		if( $i >= 1 ){
			return true;
		}else{
			return false;
		}
		
		
	} // end function
	
}
<?php

/**
 * Class URA_DASH_MSGS
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_DASH_MSGS
{
		
	/** 
	 * function show_urgent_message
	 * Sets the <p> class="messages" to custom message (2nd message on login form)
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @Filters 'login_messages' line 172 &$this 
		*
	 * @params string $msg, boolean $error_msg
	 * @returns nothing prints urgent message
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function show_urgent_message( $msg, $error_msg = false ){
		$cnt = ( int ) 0;
		$cnt = $this->error_page_define();
		if( $cnt == 0 ){
			if ( $error_msg == true ) {
				echo '<div id="message" class="notice notice-error"><p><strong>'.$msg.'</strong></p></div>';
			}
			else {
				echo '<div id="message" class="updated fade"><p><strong>'.$msg.'</strong></p></div>';
			}
			//echo "<p><strong>$msg</strong></p></div>";
		}
	}
	
	/** 
	 * function no_options_msg
	 * shows urgent message if user changed a field with no options in it
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @params 
	 * @returns string urgent message
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function no_options_msg(){
		$msg = ( string ) '';
		$msg = apply_filters( 'no_options_msg_string', $msg );
		//$msg = __(  'You changed a data type to a type that requires options and do not have any options for it.</p><p>To use it properly please add some options <a href="'.admin_url( 'admin.php?page=edit-new-fields&tab=add_options' ).'"> HERE </a> or change the field type <a href="'.admin_url( 'admin.php?page=edit-new-fields&tab=field_type' ).'"> HERE </a> to one that does not require options!',  'csds_userRegAide' );
		$this->show_urgent_message( $msg, false );
	}
	
	/** 
	 * function get_no_options_msg_string
	 * shows urgent message if user changed a field with no options in it
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @params 
	 * @returns string $msg urgent message
	 * @access public
	 */
	
	function get_no_options_msg_string(){
		$msg = ( string ) '';
		//$msg = apply_filters( 'no_options_msg_string', $msg );
		$msg = __(  'You changed a data type to a type that requires options and do not have any options for it.</p><p>To use it properly please add some options <a href="'.admin_url( 'admin.php?page=edit-new-fields&tab=add_options' ).'"> HERE </a> or change the field type <a href="'.admin_url( 'admin.php?page=edit-new-fields&tab=field_type' ).'"> HERE </a> to one that does not require options!',  'csds_userRegAide' );
		return $msg;
	}
	
	/** 
	 * function show_admin_message
	 * shows urgent message if user changed a field with no options in it
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
		*
	 * @params string $msg
	 * @returns string $msg to $this->show_urgent_message
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function show_admin_message( $msg ){
		$this->show_urgent_message( $msg );
	}
	
	/** 
	 * function ura_option_missing_error
	 * checks for a field with missing options and returns an error message 
	 * to display if their is one or more fields missing required options
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $msg
	 * @returns string $msg 
	*/
	
	function ura_option_missing_error( $msg ){
		$missing = ( int ) 0;
		$msg1 = ( string ) '';
		$msg2 = ( string ) '';
		$missing = apply_filters( 'missing_options', $missing );
		//exit( '----------MISSING----------'.$missing );
		if( $missing >= 1 ){
			if( empty( $msg ) ){
				//$msg1 = '<div id="message" class="update-nag"><p><strong>';notice notice-error
				$msg1 = '<div id="message" class="notice notice-error"><p><strong>';
				$msg1 .= apply_filters( 'no_options_msg_string', $msg );
				//$msg1 .= __( 'You changed a data type to a type that requires options and do not have any options for it.</p><p>To use it properly please add some options or change the field type <a href="'.admin_url( 'admin.php?page=edit-new-fields' ).'"> HERE </a> to one that does not require options!', 'csds_userRegAide' );
				$msg1 .= '</strong></p></div>';
				return $msg1;
				}else{
				$msg2 = '<div id="message" class="notice notice-error"><p><strong>';
				$msg2 .= apply_filters( 'no_options_msg_string', $msg );
				//$msg2 .= __( 'You changed a data type to a type that requires options and do not have any options for it.</p><p>To use it properly please add some options or change the field type <a href="'.admin_url( 'admin.php?page=edit-new-fields' ).'"> HERE </a> to one that does not require options!', 'csds_userRegAide' );
				$msg2 .= '</strong></p></div>';
				return $msg2;
			}
			}else{
			return $msg;
		}
		//$msg .= '</strong></p></div>';
		
	}
	
	/** 
	 * function option_missing_errors
	 * checks for a field with missing options and returns an admin notice error message 
	 * to display if their is one or more fields missing required options
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @handles action 'admin-notices' line 585 &$this
	 * @access public
	 * @params
	 * @returns string $msg 
	 */
	
	function option_missing_errors(){
		//$ura_msg = new CSDS_URA_MESSAGES();
		$missing = ( int ) 0;
		$msg = ( string ) '';
		$msg = apply_filters( 'no_options_msg_string', $msg );
		//$msg = __( 'You changed a data type to a type that requires options and do not have any options for it.</p><p>To use it properly please add some options or change the field type <a href="'.admin_url( 'admin.php?page=edit-new-fields' ).'"> HERE </a> to one that does not require options!', 'csds_userRegAide' );
		$missing = apply_filters( 'missing_options', $missing );
		//exit( '----------MISSING----------'.$missing );
		if( $missing >= 1 ){
			apply_filters( 'no_options_admin_msg', $msg, true );
		}
	}
	
	/** 
	 * function error_page_define
	 * confirms if page is a ura settings page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @params 
	 * @returns int $cnt for confirmation page is a ura settings page or not
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function error_page_define(){
		$cnt = ( int ) 0;
		if( isset( $_GET['page'] ) && $_GET['page'] == 'user-registration-aide' ){
			$cnt++;
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'edit-new-fields' ){
			$cnt++;
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'registration-form-options' ){
			$cnt++;
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'registration-form-css-options' ){
			$cnt++;
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'custom-options' ){
			$cnt++;
		}
		return $cnt;
	}
	
	/** 
	 * function my_help_setup
	 * Adds a help option to the plugins page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */
	
	function my_help_setup(){
		global $ura_settings_0, $ura_settings_1, $ura_settings_2, $ura_settings_3, $ura_settings_4, $ura_settings_5;
		
		/* Custom help sidebar message. */
		$help_0 = '<p>'. __( 'For More Help and Instructions Visit Our Plugin Page:', 'csds_userRegAide' );
		$help_1 = ( string ) '<p>'. __( '<a href="http://creative-software-design-solutions.com/wordpress-user-registration-aide-force-add-new-user-fields-on-registration-form/" target="blank">User Registration Aide Home Page', 'csds_userRegAide' ).'</a></p>';
		
		$screen = get_current_screen();
		if( !empty( $screen ) ){
			// Add my_help_tab if current screen is My Admin Page
			$screen->add_help_tab( array(
			'id'		=> 	'ura_help_tab',
			'title'		=>	__( 'User Registration Aide Help Tab', 'csds_userRegAide' ),
			'content'	=>	'<p style="text-align:center;"><b>'. __( 'User Registration Aide Help', 'csds_userRegAide' ).'</b></p>',
			'callback'	=>	array( &$this, 'my_help_message' ) )
			);
			$screen->set_help_sidebar( $help_0.$help_1 );
		}
		
	}
	
	/** 
	 * function my_help_message
	 * Adds to the help message on this plugins page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */
	
	function my_help_message(){
		global $ura_settings_0, $ura_settings_1, $ura_settings_2, $ura_settings_3, $ura_settings_4, $ura_settings_5;
		$screen = get_current_screen();
		if( $screen->base == $ura_settings_0 ){
			echo '<p style="text-align:center;"><b>'. __( 'User Registration Aide: Input New Fields Here', 'csds_userRegAide' ).'</b></p>';
			echo '<ul><li>'. __( 'Change Dashboard Widget Settings and Add New Fields On This Page', 'csds_userRegAide' ).'</li>';
		}
		
		if( $screen->base == $ura_settings_3 ){
			echo '<p style="text-align:center;"><b>'. __( 'User Registration Aide: Edit New Fields Here', 'csds_userRegAide' ).'</b></p>';
			echo '<ul><li>'. __( 'Edit Custom Registration Form Fields, Delete Fields and Edit New Fields Options On This Page', 'csds_userRegAide' ).'</li>';
		}
		
		if( $screen->base == $ura_settings_1 ){
			echo '<p style="text-align:center;"><b>'. __( 'User Registration Aide: Edit Registration Form Options Here', 'csds_userRegAide' ).'</b></pi>';
			echo '<ul><li>'. __( 'Change Password Strength Requirements, Custom Redirects, Agreement Message, Anti_Spam Math Problem & Profile Page Title Options On This Page', 'csds_userRegAide' ).'</li>';
		}
		
		if( $screen->base == $ura_settings_2 ){
			echo '<p style="text-align:center;"><b>'. __( 'User Registration Aide: Edit Registration Form Messages & CSS Here', 'csds_userRegAide' ).'</b></p>';
			echo '<ul><li>'. __( 'Change Registration Form Messages and CSS Options On This Page', 'csds_userRegAide' ).'</li>';
		}
		
		if( $screen->base == $ura_settings_4 ){
			echo '<p style="text-align:center;"><b>'. __( 'User Registration Aide: Edit Custom Option Settings Here', 'csds_userRegAide' ).'</b></p>';
			echo '<ul><li>'. __( 'Update Password Change Options, User Display Name & Plugin Style Options On This Page', 'csds_userRegAide' ).'</li>';
		}
		
		echo '<li>'. __( 'For Most Help Options Just Hover Over the Input Box Area or Selection You Wish to Make', 'csds_userRegAide' ).'</li>';
		echo '<li>'. __( 'A Help Box Pop-up Will Appear And Give You More Specific Instructions For That Specific Field Selection Or Option', 'csds_userRegAide' ).'</li>';
		echo '<li>'. __( 'If You Still Cannot Find The Help You Need See Sidebar For Link to Plugin Homepage', 'csds_userRegAide' ).'</li></ul>';
		
	}

}
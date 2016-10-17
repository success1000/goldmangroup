<?php

/**
 * Class URA_STYLES
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_STYLES
{
		
	// ----------------------------------------     WordPress Enqueue Scripts & Styles Functions     ----------------------------------------
	
	/** Registers the main admin pages stylesheet for the plugin
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @handles action 'wp_enqueue_scripts' line 167 &$this
	 * @handles action 'admin_init' line 168 &$this
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function csds_userRegAide_stylesheet(){
		wp_register_style( 'user_regAide_style', plugins_url( 'user-registration-aide/css/user-reg-aide-style.php' ) );
		wp_register_style( 'user_regAide_menu_style', plugins_url( 'user-registration-aide/css/wp-admin-menu-stylesheet.css' ) );
		wp_register_style( 'user_regAide_admin_style', plugins_url( 'user-registration-aide/css/csds_ura_only_stylesheet.css' ) );
		wp_register_style( 'user_regAide_lost_pass_style', plugins_url( 'user-registration-aide/css/regist_login_stylesheet.css' ) );
		wp_register_style( 'templates_style', plugins_url( 'user-registration-aide/css/templates-style.css' ) );
	}
	
	/** Enqueues CSS stylesheet for settings menu on all plugins admin page
	 * 
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @handles action 'admin_print_styles' line 229 &$this
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	 */
	
	function add_settings_css(){
		wp_enqueue_style( 'user_regAide_menu_style', plugins_url( 'user-registration-aide/css/wp-admin-menu-stylesheet.css' ) );
	}
	
	/**	
	 * Function add_admin_settings_css
	 * Enqueues CSS stylesheet for my menu settings on my pages
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles action 'admin_print_styles' line 140, 144, 148, 152 &$this
	 * @params 
	 * @returns 
	 */
	
	function add_admin_settings_css(){
		wp_enqueue_style( 'user_regAide_admin_style', plugins_url( 'user-registration-aide/css/csds_ura_only_stylesheet.css' ) );
	}
	
	/**	
	 * Function add_lostpassword_css
	 * Enqueues CSS stylesheet for lost password form
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @handles action 'login_enqueue_scripts' line 191, 193, 197, 201 &$this
	 * @params 
	 * @returns 
	 */
	
	function add_lostpassword_css(){
		$options = get_option( 'csds_userRegAide_Options' );
		if( $options['add_security_question'] == "1" ){
			wp_enqueue_style( 'user_regAide_lost_pass_style', plugins_url( 'user-registration-aide/css/regist_login_stylesheet.css' ) );
		}
	}
	
	/** 
	 * function enqueueXwrdStyles
	 * Enqueues the stylesheet for the password change page
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */ 
	
	function enqueueXwrdStyles(){
		$request = $_SERVER['REQUEST_URI'];
		
		if( $request == '/reset-password/' ){
			wp_enqueue_style( 'user_regAide_style' );
		}
	}
	
	/** 
	 * function csds_userRegAide_enqueueMyStyles
	 * Enqueues the stylesheet for the plugin
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */ 
	
	function csds_userRegAide_enqueueMyStyles(){
		wp_enqueue_style( 'user_regAide_style' );
		
	}
	
	/** 
	 * function my_style_color_function
	 * Enqueues color picker for stylesheet settings page custom stylesheet settings
	 * @since 1.4.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */ 
	
	function my_style_color_function(){
		$url = JS_PATH.'ura-screen-options.js';
		wp_enqueue_script('screen-options-custom-autosave', $url, array( 'jquery' ) );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		
	}
	
}
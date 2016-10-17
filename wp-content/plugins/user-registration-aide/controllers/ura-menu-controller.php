<?php

/**
 * Class URA_MENU_CONTROLLER
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_MENU_CONTROLLER
{
		
	/** 
	 * function set_admin_menus
	 * Sets admin menus for administartion settings pages
	 * @since 1.5.1.4
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function set_admin_menus(){
		// Single Site Administration Menus
		$mm = new URA_MENU_MODEL();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_menu', array( &$mm, 'csds_userRegAide_optionsPage' ) ); // Line 646 &$this
		add_action( 'admin_menu', array( &$mm, 'csds_userRegAide_editNewFields_optionsPage' ) ); // Line 712 &$this
		add_action( 'admin_menu', array( &$mm, 'csds_userRegAide_regFormOptionsPage' ) ); // Line 669 &$this
		add_action( 'admin_menu', array( &$mm, 'csds_userRegAide_regFormCSSOptionsPage' ) ); // Line 690 &$this
		add_action( 'admin_menu', array( &$mm, 'csds_userRegAide_customOptionsPage' ) ); // Line 690 &$this
		add_action( 'admin_menu', array( &$dm, 'my_help_setup' ) );
		/*
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_optionsPage' ) ); // Line 646 &$this
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_editNewFields_optionsPage' ) ); // Line 712 &$this
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_regFormOptionsPage' ) ); // Line 669 &$this
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_regFormCSSOptionsPage' ) ); // Line 690 &$this
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_customOptionsPage' ) ); // Line 690 &$this
		add_action( 'add_users_page', array( &$mm, 'csds_userRegAide_debugPage' ) ); // Line 690 &$this
		*/
		// filter for footer removal in admin pages
		add_filter( 'admin_footer_text', array( &$mm, 'remove_admins_footer' ) );
		unset( $mm );
	}
}
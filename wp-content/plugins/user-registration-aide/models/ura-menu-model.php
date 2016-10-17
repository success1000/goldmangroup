<?php

/**
 * Class URA_MENU_MODEL
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/


class URA_MENU_MODEL
{
	
	// Admin menus and mini menus
	
	/** 
	 * function display_messages
	 * Creates array for menu tabs titles
	 * @since 1.5.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $tabs - array of menu tabs Titles for plugin
	 */
	
	function menu_tabs_array(){
		$tabs = array(
		'registration_fields' 			=> __( 'Add New Fields', 'csds_userRegAide' ),
		'edit_new_fields' 				=> __( 'Edit New Fields', 'csds_userRegAide' ),
		'registration_form_options' 	=> __( 'Registration Form Options', 'csds_userRegAide' ),
		'registration_form_css_options' => __( 'Registration Form Messages & CSS Options', 'csds_userRegAide' ),
		'custom_options'				=> __( 'Custom Options', 'csds_userRegAide' )
		);
		
		return $tabs;
	}
	
	/** 
	 * function display_messages
	 * Creates array for menu tabs titles
	 * @since 1.5.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $tabs - array of descriptions for menu tabs for plugin
	 */
	
	function menu_titles_array(){
		$tabs = array(
		'registration_fields' 			=> __( 'Set Dashboard Widget Options & Select Fields to add to Registration Form or Add New Custom Fields Here', 'csds_userRegAide' ),
		'edit_new_fields' 				=> __( 'Edit New Fields For Registration Form/User Profile Here Like Field Order, Field Titles Or Delete Fields', 'csds_userRegAide' ),
		'registration_form_options' 	=> __( 'Customize Bottom Registration Form Message, Password Strength Options, Custom Redirects, Agreement Message, Anti-Bot Spammer & Title for Profile Pages Here', 'csds_userRegAide' ),
		'registration_form_css_options' => __( 'Customize Registration Form Messages & Custom Registration Form CSS Options Here', 'csds_userRegAide' ),
		'custom_options'				=> __( 'Password Change Settings Options, Change Display Name Options or URA Admin Page Style Sheet Settings Here', 'csds_userRegAide' )
		);
		
		return $tabs;
	}
	
	/** 
	 * function display_messages
	 * Creates array for menu tabs links
	 * @since 1.5.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $menu_links - array of links for menu tabs
	 */
	
	function menu_links_array(){
		/*$menu_links = array(
			'registration_fields' 			=> 'admin.php?page=user-registration-aide', 
			'edit_new_fields' 				=> 'admin.php?page=user-registration-aide&tab=edit-new-fields', 
			'registration_form_options'     => 'admin.php?page=user-registration-aide&tab=registration-form-options', 
			'registration_form_css_options' => 'admin.php?page=user-registration-aide&tab=registration-form-css-options',
			'custom_options' 				=> 'admin.php?page=user-registration-aide&tab=custom-options'
			);
		 */
		$menu_links = array(
		'registration_fields' 			=> 'admin.php?page=user-registration-aide', 
		'edit_new_fields' 				=> 'admin.php?page=edit-new-fields', 
		'registration_form_options'     => 'admin.php?page=registration-form-options', 
		'registration_form_css_options' => 'admin.php?page=registration-form-css-options',
		'custom_options' 				=> 'admin.php?page=custom-options'
		);
		
		return $menu_links;
	}
	
	/** 
	 * function msg_options_tabs_page
	 * Shows tabs menu at top of options pages with admin messages for easier user access ---
	 * --- wont work for different pages so i do it separately on each page
	 * @since 1.5.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $current_page ( current menu page ), string $msg, string $msg1
	 * @returns
	 */
	
	function msg_options_tabs_page( $current_page, $msg, $msg1 ){
		$tabs = $this->menu_tabs_array();  // line 71 &$this
		$menu_links = $this->menu_links_array(); // line 88 &$this
		$tab_links = array();
		$titles = $this->menu_titles_array();
		$current_tab = isset( $_GET['tab'] );
		foreach( $menu_links as $menu_key => $menu_name ){
			foreach( $tabs as $tab_key => $tab_name ){
				//if( $menu_key == $tab_key && $tab_key == $current_tab ){
				if( $menu_key == $tab_key && $tab_key == $current_page ){
					$tab_links[$tab_key] = '<a class="nav-tab nav-tab-active" title="'.$titles[$tab_key].'" href="'.admin_url( $menu_name ).'">'.$tab_name.'</a>';
					}elseif( $menu_key == $tab_key ){
					$tab_links[$tab_key] = '<a class="nav-tab" title="'.$titles[$tab_key].'" href="'.admin_url( $menu_name ).'">'.$tab_name.'</a>';
				}
			}
		}
		//echo '</div></div>';
		echo $msg;
		if( empty( $msg ) & !empty( $msg1 ) ){
			echo $msg1;
		}
		echo '</div>';
		echo '<h3>';
		foreach( $tab_links as $link_key => $link_name ){
			echo $link_name;
		}
		echo '</h3>';
		echo '<br/>';
		
	}
	
	/**
	 * function add_fields_minitab_array
	 * mini tabs for user registration aide first admin page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array of mini tabs for add fields admin page
	*/

	function add_fields_minitab_array(){
		$minitabs = array(
			'add_new_fields'	=> 'Add New Fields',
			'dash_widget'		=> 'Dashboard Widget'
			
		);
		return $minitabs;
	}
	
	/**
	 * function add_fields_minitab_titles_array
	 * mini tabs titles for user registration aide first admin page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array of mini tabs for add fields admin page
	 */
	
	function add_fields_minitab_titles_array(){
		$minitabs = array(
			'add_new_fields'	=> __( 'Add Your New Fields for User Profiles and Registration Form  Here', 'csds_userRegAide' ),
			'dash_widget'		=> __( 'Edit and Change all the Dashboard Widget Settings Here', 'csds_userRegAide' )
		);
		return $minitabs;
	}
	
	/**
	 * function edit_fields_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function edit_fields_minitab_array(){
		$minitabs = array(
			'reg_form_fields'	=>	'Registration Fields',
			'field_order'		=>  'Field Order & Title',
			'option_order'		=>	'Option Order',
			'option_titles'		=>	'Delete Options & Edit Option Titles',
			'add_options'		=>	'Add Options',
			'field_type'		=>	'Change Field Type',
			'edit_numbers'		=>	'Edit Number Fields'
		);
		return $minitabs;
	}
	
	/**
	 * function edit_fields_titles_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function edit_fields_titles_minitab_array(){
		$minitabs = array(
			'reg_form_fields'	=>	__( 'Delete Fields, Add or Remove Registration Form Fields & Change Required Fields Here', 'csds_userRegAide' ),
			'field_order'		=>  __( 'Edit Field Orders & Titles Here', 'csds_userRegAide' ),
			'option_order'		=>	__( 'Edit Field Options Orders Here', 'csds_userRegAide' ),
			'option_titles'		=>	__( 'Delete Options & Edit Option Titles Here', 'csds_userRegAide' ),
			'add_options'		=>	__( 'Add New Field Options Here', 'csds_userRegAide' ),
			'field_type'		=>	__( 'Change Fields Data Types Here', 'csds_userRegAide' ),
			'edit_numbers'		=>	__( 'Edit Number Type Fields Here', 'csds_userRegAide' )
		);
		return $minitabs;
	}
	
	/**
	 * function rf_options_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function rf_options_minitab_array(){
		$minitabs = array(
			'xwrd_strength'	=>	'Password Strength Requirements',
			'redirects'		=>  'Custom Redirects',
			'agreement'		=>	'Agreement Message',
			'math_problem'	=>	'Anti-Bot Anti-Spam Math Problem',
			'pp_title'		=>	'Profile Page Title'
		);
		return $minitabs;
	}
	
	/**
	 * function rf_options_titles_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function rf_options_titles_minitab_array(){
		$minitabs = array(
			'xwrd_strength'	=>	__( 'Edit Password Strength Requirement Options Here', 'csds_userRegAide' ),
			'redirects'		=>  __( 'Edit Custom Redirect Options Here', 'csds_userRegAide' ),
			'agreement'		=>	__( 'Edit Your Custom Agreement Message Options Here', 'csds_userRegAide' ),
			'math_problem'	=>	__( 'Edit Your Anti-Bot Anti-Spam Math Problem Options Here', 'csds_userRegAide' ),
			'pp_title'		=>	__( 'Edit Your Profile Page Title Options Here', 'csds_userRegAide' )
		);
		return $minitabs;
	}
	
	/**
	 * function rf_msgs_css_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function rf_msgs_css_minitab_array(){
		$minitabs = array(
			'msgs'		=>	'Registration Form Messages',
			'css'		=>  'Registration Form CSS Customizations'
		);
		return $minitabs;
	}
	
	/**
	 * function rf_msgs_css_titles_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function rf_msgs_css_titles_minitab_array(){
		$minitabs = array(
			'msgs'		=>	__( 'Edit Your Custom Registration Form Message Options Here', 'csds_userRegAide' ),
			'css'		=>  __( 'Edit Your Registration Form CSS Customization Options Here', 'csds_userRegAide' )
		);
		return $minitabs;
	}
	
	/**
	 * function custom_options_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function custom_options_minitab_array(){
		$minitabs = array(
			'xwrd_change'		=>	'Password Change Options',
			'display_name'		=>  'Display Name Options',
			'ura_css'			=>	'URA CSS Style Settings'
		);
		return $minitabs;
	}
	
	/**
	 * function custom_options_titles_minitab_array
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array $minitabs array orf mini tabs for add fields admin page
	 */
	
	function custom_options_titles_minitab_array(){
		$minitabs = array(
			'xwrd_change'		=>	__( 'Edit & Change Your Password Change Options Here', 'csds_userRegAide' ),
			'display_name'		=>  __( 'Edit & Change Your Display Name Options Here', 'csds_userRegAide' ),
			'ura_css'			=>	__( 'Edit & Change Your URA CSS Style Options Here',  'csds_userRegAide' )
		);
		return $minitabs;
	}
			
	/**
	 * function show_mini_tabs
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $tab, string $minitab
	 * @returns 
	*/
	
	function show_mini_tabs( $tab, $minitab  ){
		$menu_links = $this->menu_links_array(); // line 88 &$this
		$mini_tab_links = array();
		
		if( $tab == 'registration_fields' ){
			$mini_tabs = $this->add_fields_minitab_array();
			$mini_tab_titles = $this->add_fields_minitab_titles_array();
		}elseif( $tab == 'edit_new_fields' ){
			$mini_tabs = $this->edit_fields_minitab_array();
			$mini_tab_titles = $this->edit_fields_titles_minitab_array();
		}elseif( $tab == 'registration_form_options' ){
			$mini_tabs = $this->rf_options_minitab_array();
			$mini_tab_titles = $this->rf_options_titles_minitab_array();
		}elseif( $tab == 'registration_form_css_options' ){
			$mini_tabs = $this->rf_msgs_css_minitab_array();
			$mini_tab_titles = $this->rf_msgs_css_titles_minitab_array();
		}elseif( $tab == 'custom_options' ){
			$mini_tabs = $this->custom_options_minitab_array();
			$mini_tab_titles = $this->custom_options_titles_minitab_array();
		}
		
		foreach( $mini_tabs as $key => $title ){
			if( $minitab == $key ){
				$mini_tab_links[$key] = '<a class="nav-tab nav-tab-active" title="'.$mini_tab_titles[$key].'" href="'.admin_url( $menu_links[$tab].'&tab='.$key ).'">'.$title.'</a>';
				}else{
				$mini_tab_links[$key] = '<a class="nav-tab" title="'.$mini_tab_titles[$key].'" href="'.admin_url( $menu_links[$tab].'&tab='.$key ).'">'.$title.'</a>';
			}
		}
		echo '<h3>';
		foreach( $mini_tab_links as $link_key => $link_name ){
			echo $link_name;
		}
		echo '</h3>';
		echo '<br/>';
	}
	
	/** 
	 * function options_tabs_page
	 * Shows tabs menu at top of options pages with admin messages for easier user access ---
	 * --- wont work for different pages so i do it separately on each page
	 * @since 1.5.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $current_page ( current menu page )
	 * @returns
	 */
	
	function options_tabs_page( $current_page ){
		$tabs = $this->menu_tabs_array();  // line 71 &$this
		$menu_links = $this->menu_links_array(); // line 88 &$this
		$tab_links = array();
		$titles = $this->menu_titles_array();
		
		foreach( $menu_links as $menu_key => $menu_name ){
			foreach( $tabs as $tab_key => $tab_name ){
				
				if( $menu_key == $tab_key && $tab_key == $current_page ){
					$tab_links[$tab_key] = '<a class="nav-tab nav-tab-active" title="'.$titles[$tab_key].'" href="'.admin_url($menu_name).'">'.$tab_name.'</a>';
				}elseif( $menu_key == $tab_key ){
					$tab_links[$tab_key] = '<a class="nav-tab" title="'.$titles[$tab_key].'" href="'.admin_url($menu_name).'">'.$tab_name.'</a>';
				}
			}
		}
		echo '<h3>';
		foreach( $tab_links as $link_key => $link_name ){
			echo $link_name;
		}
		echo '</h3>';
		echo '<br/>';
	}
	
	// ----------------------------------------     Admin Menu Pages & Links Functions     ----------------------------------------
	
	/** 
	 * function add_plugins_settings_link
	 * Adds a setting page option to the plugins page
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @Filters 'plugin_action_links' line 228 &$this (Priority: 10 - Params: 2)
	 * @params array $links Array of links for admin plugins page links for all plugins
	 * @params $file This plugin filename
	 * @returns array of menu links $links
	*/
			
	function add_plugins_settings_link( $links, $file ){
		$admin = new INPUT_NEW_FIELDS_CONTROLLER();
		$this_file = 'user-registration-aide/user-registration-aide.php';
		if( $file == $this_file ){
			$plugin_settings = '<ul class="settings_menu"><li><a href="#">Settings</a>';
			$plugin_settings .= '<ul><li><a href="admin.php?page=user-registration-aide">'.__( 'Registration Fields', 'csds_userRegAide' ).'</a></li>';
			$plugin_settings .= '<li><a href="admin.php?page=edit-new-fields">'.__( 'Edit New Fields', 'csds_userRegAide' ).'</a></li>';
			$plugin_settings .= '<li><a href="admin.php?page=registration-form-options">'.__( 'Registration Form Options', 'csds_userRegAide' ).'</a></li>';
			$plugin_settings .= '<li><a href="admin.php?page=registration-form-css-options">'.__( 'Registration Form Messages & CSS Options', 'csds_userRegAide' ).'</a></li>';
			$plugin_settings .= '<li><a href="admin.php?page=custom-options">'.__( 'Custom Options', 'csds_userRegAide' ).'</a></li></ul></li></ul>';
			array_unshift( $links, $plugin_settings );
		}
		return $links;
	}
	
	
	/** 
	 * function csds_userRegAide_optionsPage
	 * Add the primary settings management page menu item to the admin side panel
	 * @since 1.0.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function csds_userRegAide_optionsPage(){
		global $ura_settings_0;
		$admin_settings = new INPUT_NEW_FIELDS_CONTROLLER();
		if( function_exists( 'add_menu_page' ) ){
			//if(!is_multisite()){
			$ura_settings_0 = add_menu_page( __( 'User Registration Aide', 'csds_userRegAide' ), __( 'User Registration Aide', 'csds_userRegAide' ), 'manage_options', 'user-registration-aide', array( &$admin_settings, 'initiate_new_fields_input_page' ), 'dashicons-admin-users', 71 ) ; // line 71 &$admin_settings
		}
		$uras = new URA_STYLES();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_print_styles-'.$ura_settings_0, array( &$uras, 'csds_userRegAide_enqueueMyStyles' ) );
		add_action( 'load-'.$ura_settings_0, array( &$dm, 'my_help_setup' ) );
	}
		
	/** 
	 * function csds_userRegAide_regFormOptionsPage
	 * Add options page menu item for the Registration Form options
	 * @since 1.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function csds_userRegAide_regFormOptionsPage(){
		global $ura_settings_1;
		$rfo = new REGISTRATION_FORM_OPTIONS_CONTROLLER();
		if( function_exists( 'add_submenu_page' ) ){
			$ura_settings_1 = add_submenu_page( 'user-registration-aide', __( 'Registration Form Options', 'csds_userRegAide' ), __( 'Registration Form Options', 'csds_userRegAide' ), 'manage_options', 'registration-form-options', array( &$rfo, 'initiate_reg_form_options_view' ) ); // line 69 &$rfo
		}
		$uras = new URA_STYLES();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_print_styles-'.$ura_settings_1, array( &$uras, 'csds_userRegAide_enqueueMyStyles' ) );
		add_action( 'load-'.$ura_settings_1, array( &$dm, 'my_help_setup' ) );
	}
		
	/** 
	 * function csds_userRegAide_regFormCSSOptionsPage
	 * Add options page menu item for the Registration Form CSS Options
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function csds_userRegAide_regFormCSSOptionsPage(){
		global $ura_settings_2;
		$rfco = new REG_FORM_MESSAGES_CONTROLLER();
		if( function_exists( 'add_submenu_page' ) ){
			$ura_settings_2 = add_submenu_page( 'user-registration-aide', __( 'Registration Form Messages & CSS Options', 'csds_userRegAide' ), __( 'Registration Form Messages & CSS Options', 'csds_userRegAide' ), 'manage_options', 'registration-form-css-options', array( &$rfco, 'initiate_rf_msgs_view' ) ); // line 67 &$rfco
		}
		$uras = new URA_STYLES();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_print_styles-'.$ura_settings_2, array( &$uras, 'csds_userRegAide_enqueueMyStyles' ) );
		add_action( 'load-'.$ura_settings_2, array( &$dm, 'my_help_setup' ) );
	}
	
	/** 
	 * function csds_userRegAide_editNewFields_optionsPage
	 * Add the Add-Edit New Fields management page menu item to the user settings bar
	 * @since 1.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function csds_userRegAide_editNewFields_optionsPage(){
		global $ura_settings_3;
		$new_fields = new URA_EDIT_NEW_FIELDS_CONTROLLER();
		if( function_exists( 'add_submenu_page' ) ){
			$ura_settings_3 = add_submenu_page( 'user-registration-aide',__( 'Edit New Fields', 'csds_userRegAide' ), __( 'Edit New Fields', 'csds_userRegAide' ), 'manage_options', 'edit-new-fields', array( &$new_fields, 'edit_new_fields_controller' ) );  // Line 46 &$new_fields
		}
		$uras = new URA_STYLES();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_print_styles-'.$ura_settings_3, array( &$uras, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		add_action( 'load-'.$ura_settings_3, array( &$dm, 'my_help_setup' ) );
		
	}
	
	/** 
	 * function csds_userRegAide_customOptionsPage
	 * Add the custom options management page menu item to the user settings bar
	 * @since 1.1.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	
	function csds_userRegAide_customOptionsPage(){
		global $ura_settings_4;
		$custom_options = new URA_CUSTOM_OPTIONS_CONTROLLER();
		if( function_exists( 'add_submenu_page' ) ){
			$ura_settings_4 = add_submenu_page( 'user-registration-aide',__( 'Custom Options', 'csds_userRegAide' ), __( 'Custom Options', 'csds_userRegAide' ), 'manage_options', 'custom-options', array( &$custom_options, 'custom_options_views' ) );  // Line 46 &$new_fields
		}
		$uras = new URA_STYLES();
		$dm = new URA_DASH_MSGS();
		add_action( 'admin_print_styles-'.$ura_settings_4, array( &$uras, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		add_action( 'load-'.$ura_settings_4, array( &$dm, 'my_help_setup' ) );
	}
		
	/** 
	 * function remove_admins_footer
	 * Removes admin footer which displayed in middle of some of my pages and looked funky
	 * @since 1.4.0.0
	 * @updated 1.5.2.0
	 * @handles filter 'admin_footer_text' line 291 &$this
	 * @access public
	 * @params
	 * @returns
	*/
	
	function remove_admins_footer(){
		$link = 'Powered By: <a href="http://creative-software-design-solutions.com/">Creative Software Design Solutions</a>';
		if( isset( $_GET['page'] ) && $_GET['page'] == 'user-registration-aide' ){
			echo '';
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'edit-new-fields' ){
			echo '';
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'registration-form-options' ){
			echo '';
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'registration-form-css-options' ){
			echo '';
		}
		
		if( isset( $_GET['page'] ) && $_GET['page'] == 'custom-options' ){
			echo '';
		}
	}
	
	/** 
	 * function ura_loginProtection
	 * Add options page menu item for login protection
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	/*
	function ura_loginProtection(){
		
		global $login_protection_page;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if(function_exists('add_menu_page')){
			$login_protection_page = add_menu_page( __('Login Protection', 'csds_userRegAide'), __('Login Protection', 'csds_userRegAide'), 'manage_options', 'login-protection', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$login_protection_page", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$login_protection_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_failed_logins
	 * Add viewing page menu item for failed logins
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/
	/*
	function ura_failed_logins(){
		
		global $failed_login_page;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if(function_exists('add_submenu_page')){
			$failed_login_page = add_submenu_page( 'login-protection', __( 'Failed Login Attempts', 'csds_userRegAide' ), __( 'Failed Login Attempts', 'csds_userRegAide' ), 'manage_options', 'login-protection-failed-login', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$failed_login_page", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$failed_login_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_lockedout_user
	 * Add viewing page menu item for locked out users
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/  
	/*
	function ura_lockedout_users(){
		
		global $lockedout_users;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if(function_exists('add_submenu_page')){
			$lockedout_users = add_submenu_page( 'login-protection', __( 'Lockedout Users', 'csds_userRegAide' ), __( 'Lockedout Users', 'csds_userRegAide' ), 'manage_options', 'login-protection-lockedout-user', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$lockedout_users", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$lockedout_users, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_user_activity
	 * Add viewing page menu item for viewing user activity
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/  
	/*
	function ura_user_activity(){
		
		global $users_activity;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if(function_exists('add_submenu_page')){
			$users_activity = add_submenu_page( 'login-protection', __( 'User Activity', 'csds_userRegAide' ), __( 'User Activity', 'csds_userRegAide' ), 'manage_options', 'login-protection-user-activity', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$users_activity", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$users_activity, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_lost_password
	 * Add viewing page menu item for users requesting lost password resets
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/  
	/*
	function ura_lost_password(){
		
		global $lost_password;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if(function_exists('add_submenu_page')){
			$lost_password = add_submenu_page( 'login-protection', __( 'Lost Password', 'csds_userRegAide' ), __( 'Lost Password', 'csds_userRegAide' ), 'manage_options', 'login-protection-lost-xwrd', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$lost_password", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$lost_password, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_manual_lockout
	 * Add viewing page menu item for manually locking out users
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/  
	/*
	function ura_manual_lockout(){
		
		global $manual_lockout;
		$lpm = new URA_TAB_MENU_HANDLER();
		$lph = new URA_LOGIN_PROTECTION_HELPER();
		$lpv = new URA_LOGIN_PROTECTION_VIEW();	
		//$sc = new URA_LP_SCREEN_OPTIONS();
		if( function_exists( 'add_submenu_page' ) ){
			$manual_lockout = add_submenu_page( 'login-protection', __( 'Manual Lockout', 'csds_userRegAide' ), __( 'Manual Lockout', 'csds_userRegAide' ), 'manage_options', 'login-protection-manual-lockout', array( &$lpm, 'ura_tab_menu_page' ));  // 
		}
		add_action( "load-$manual_lockout", array( &$lpv, 'lockdown_list_screen_options' ) );
		//add_action( "load-$login_protection_page", 'add_screen_options_panel' );
		//add_action( "load-$login_protection_page", 'add_lp_ua_options' );
		add_action( 'admin_print_styles-'.$manual_lockout, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) );
		
		
	}
	*/
	/** 
	 * function ura_newUserApprovalList
	 * Add the New User Approval management page menu item to the user settings bar
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/ 
	/*
	function ura_newUserApprovalList(){
		global $new_user_pending_approval_page;
		$nuac = new NEW_USER_APPROVE_CONTROLLER();
		if( function_exists( 'add_users_page' ) ){
			$new_user_pending_approval_page = add_users_page( __( 'Pending Approval', 'csds_userRegAide' ), __( 'Pending Approval', 'csds_userRegAide' ), 'manage_options', 'pending-approval', 'new_user_pending_approval_wp_list_view' );  // Line 46 &$new_fields
			//add_users_page( __( 'New User Approval', 'csds_userRegAide' ), __( 'New User Approval', 'csds_userRegAide' ), 'manage_options', 'new-user-approval', array( &$nuac, 'unapproved_user_controller' ) );
		}
		//add_action( "load-$new_user_approve_page", 'new_user_pending_approval_wp_list_view' );
		add_action( 'admin_print_styles-'.$new_user_pending_approval_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		//add_filter( 'manage_new-user-approval_columns', array( &$nuac, 'approve_users_metaboxes_table' ) );
		
	}
	*/
	/** 
	 * function ura_newUserDeleteList
	 * Add the Delete New User management page menu item for denied users to the user settings bar
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/ 
	/*
	function ura_newUserDeleteList(){
		global $new_user_pending_deletion_page;
		//$nudc = new NEW_USER_DENIED_CONTROLLER();
		if( function_exists( 'add_users_page' ) ){
			$new_user_pending_deletion_page = add_users_page( __( 'Pending Deletion', 'csds_userRegAide' ), __( 'Pending Deletion', 'csds_userRegAide' ), 'manage_options', 'pending-deletion', 'new_user_pending_approval_wp_list_view' );  // Line 46 &$new_fields
			//add_users_page( __( 'New User Approval', 'csds_userRegAide' ), __( 'New User Approval', 'csds_userRegAide' ), 'manage_options', 'new-user-approval', array( &$nuac, 'unapproved_user_controller' ) );
		}
		//add_action( "load-$new_user_denied_page", 'new_user_pending_approval_wp_list_view' );
		add_action( 'admin_print_styles-'.$new_user_pending_deletion_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		//add_filter( 'manage_new-user-approval_columns', array( &$nuac, 'approve_users_metaboxes_table' ) );
		
	}
	*/
	/** 
	 * function ura_newUserDeleteList
	 * Add the Pending Verification User page menu item for unverified email users to the user settings bar
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	*/ 
	/*
	function ura_newUserVerificationList(){
		global $new_user_pending_verification_page;
		//$nudc = new NEW_USER_DENIED_CONTROLLER();
		if( function_exists( 'add_users_page' ) ){
			$new_user_pending_verification_page = add_users_page( __( 'Pending Verification', 'csds_userRegAide' ), __( 'Pending Verification', 'csds_userRegAide' ), 'manage_options', 'pending-verification', 'new_user_pending_approval_wp_list_view' );  // Line 46 &$new_fields
			//add_users_page( __( 'New User Approval', 'csds_userRegAide' ), __( 'New User Approval', 'csds_userRegAide' ), 'manage_options', 'new-user-approval', array( &$nuac, 'unapproved_user_controller' ) );
		}
		//add_action( "load-$new_user_denied_page", 'new_user_pending_approval_wp_list_view' );
		add_action( 'admin_print_styles-'.$new_user_pending_verification_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		//add_filter( 'manage_new-user-approval_columns', array( &$nuac, 'approve_users_metaboxes_table' ) );
	}
	*/
	/**
	 * Lost Password Table View management page for users requesting new password to the user settings bar 
	 *
	 * @since 1.6.0.0
	 * @updated 1.6.0.0
	 * @handles action 'admin_menu' line 235
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/
/*
	function ura_lostPasswordAttempts(){
		global $lost_password_attempts_page;
		//$nudc = new NEW_USER_DENIED_CONTROLLER();
		if( function_exists( 'add_users_page' ) ){
			$lost_password_attempts_page = add_users_page( __( 'Lost Password Attempts', 'csds_userRegAide' ), __( 'Lost Password Attempts', 'csds_userRegAide' ), 'manage_options', 'lost-password-attempts', 'new_user_pending_approval_wp_list_view' );  // Line 46 &$new_fields
			//add_users_page( __( 'New User Approval', 'csds_userRegAide' ), __( 'New User Approval', 'csds_userRegAide' ), 'manage_options', 'new-user-approval', array( &$nuac, 'unapproved_user_controller' ) );
		}
		//add_action( "load-$new_user_denied_page", 'new_user_pending_approval_wp_list_view' );
		add_action( 'admin_print_styles-'.$lost_password_attempts_page, array( &$this, 'csds_userRegAide_enqueueMyStyles' ) ); // Line 795 &$this
		//add_filter( 'manage_new-user-approval_columns', array( &$nuac, 'approve_users_metaboxes_table' ) );
		
	}
	*/
		
}
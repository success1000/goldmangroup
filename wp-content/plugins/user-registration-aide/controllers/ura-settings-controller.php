<?php

/**
 * Class URA_SETTINGS_PAGE_CONTROLLER
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_SETTINGS_PAGE_CONTROLLER
{

	/** 
	 * function edit_reg_form_fields_view
	 * Shows view for selecting fields for registration form
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns
	 */
	
	function ura_settings_page( $current = 'general'){
		$tabs = array( 
			'registration_fields' 			=> __( 'Add New Fields', 'csds_userRegAide' ),
			'edit_new_fields' 				=> __( 'Edit New Fields', 'csds_userRegAide' ),
			'registration_form_options' 	=> __( 'Registration Form Options', 'csds_userRegAide' ),
			'registration_form_css_options' => __( 'Registration Form Messages & CSS Options', 'csds_userRegAide' ),
			'custom_options'				=> __( 'Custom Options', 'csds_userRegAide' ) 
		);
		$links = array();
		foreach( $tabs as $tab => $name ) :
		if ( $tab == $current ) :
		$links[] = "<a class='nav-tab nav-tab-active' href='?page=mytheme_options&tab=$tab'>$name</a>";
		else :
		$links[] = "<a class='nav-tab' href='?page=mytheme_options&tab=$tab'>$name</a>";
		endif;
		endforeach;
		echo '<h2>';
		foreach ( $links as $link )
		echo $link;
		echo '</h2>';
		
	}
	
	function show_settings_pages(){
		global $pagenow;
		if ( $pagenow == 'user-registration-aide.php' && $_GET['page'] == 'user-registration-aide' ) :
		if ( isset ( $_GET['tab'] ) ) :
		$tab = $_GET['tab'];
		else:
		$tab = 'user-registration-aide';
		endif;
		$as = new INPUT_NEW_FIELDS_CONTROLLER();
		$as->initiate_new_fields_input_page(); // this is where to call the function which makes the tabs and also pass $tab as the current tab...
		switch ( $tab ) :
		case 'edit_new_fields' :
		mytheme_general_options();
		break;
		case 'layout' :
		mytheme_layout_options();
		break;
		case 'advanced' :
		mytheme_advanced_options();
		break;
		endswitch;
		endif;
	}
}
<?php

/**
 * Class  URA_STYLE_OPTIONS_MODEL
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_STYLE_OPTIONS_MODEL
{
	
	/**	
	 * function ura_border_collapse_array
	 * returns array of border collapse styles
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params array $collapse
	 * @returns array $collapse array of obrder collapse options
	*/
		
	function ura_border_collapse_array( $collapse ){
		$collapse = array(
			"separate"	=>	__( 'Borders are detached (border-spacing and empty-cells properties will not be ignored). This is default', 'csds_userRegAide' ),
			"collapse"	=>	__( 'Borders are collapsed into a single border when possible (border-spacing and empty-cells properties will be ignored)', 'csds_userRegAide' ),
			"initial"	=>	__( 'Sets this property to its default value', 'csds_userRegAide' ),
			"inherit"	=>	__( 'Inherits this property from its parent element', 'csds_userRegAide' )
		);
		
		return $collapse;			
			
	}
	
	/**	
	 * function ura_border_style_array
	 * returns array of border styles
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params array $border_styles
	 * @returns array $border_styles array of all table border styles and descriptions
	*/
	
	function ura_border_style_array( $border_styles ){
		$border_styles = array(
			"none"			=>	__( 'Default value. Specifies no border', 'csds_userRegAide' ),
			"hidden"		=>	__( 'The same as none, except in border conflict resolution for table elements', 'csds_userRegAide' ),
			"dotted"		=>	__( 'Specifies a dotted border', 'csds_userRegAide' ),
			"dashed"		=>	__( 'Specifies a dashed border', 'csds_userRegAide' ),
			"solid"			=>	__( 'Specifies a solid border', 'csds_userRegAide' ),
			"double"		=>	__( 'Specifies a double border', 'csds_userRegAide' ),	
			"groove"		=>	__( 'Specifies a 3D grooved border. The effect depends on the border-color value', 'csds_userRegAide' ),
			"ridge"			=>	__( 'Specifies a 3D ridged border. The effect depends on the border-color value', 'csds_userRegAide' ),
			"inset"			=>	__( 'Specifies a 3D inset border. The effect depends on the border-color value', 'csds_userRegAide' ),
			"outset"		=>	__( 'Specifies a 3D outset border. The effect depends on the border-color value', 'csds_userRegAide' ),
			"initial"		=>	__( 'Sets this property to its default value', 'csds_userRegAide' ),
			"inherit"		=>	__( 'Inherits this property from its parent element', 'csds_userRegAide' )			
		);
		return $border_styles;
	}
	
	/**	
	 * function style_options_page_update
	 * Handles Displays settings and options updates for plugin style settings updates
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $msg1
	 * @returns string $msg ( results of function success or failure ) 
	*/
	
	function style_options_page_update( $msg1 ){
		global $wp_roles, $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			$err = ( int ) 0;
			$msg = ( string ) '';
			$class = ( string ) '';
			$pre_msg = ( string ) '<div id="message" class="'.$class.'"><p>';
			$mid_msg = ( string ) '';
			$mid_msg = __( 'Style Options Updated Successfully!', 'csds_userRegAide' );
			$err_msg = ( string ) '';
			$post_msg = ( string ) '</p></div>';
			if ( isset( $_POST['ura_update_style'] ) ){
				if( wp_verify_nonce( $_POST['wp_nonce_csds-customOptions'], 'csds-customOptions' ) ){
					$options = get_option('csds_userRegAide_Options');
					if( !empty( $_POST['ura_tbl_border_style'] ) ){
						$options['border-style'] = sanitize_text_field( $_POST['ura_tbl_border_style'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Border Style Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_border_collapse'] ) ){
						$options['border-collapse'] = sanitize_text_field( $_POST['ura_tbl_border_collapse'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Border Collapse Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_border_width'] ) ){
						$options['tbl_border-width'] = sanitize_text_field( $_POST['ura_tbl_border_width'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Border Width Missing! ', 'csds_userRegAide' );
						$pre_msg = ( string ) '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_border_color_picker'] ) ){
						$options['border-color'] = sanitize_text_field( $_POST['ura_border_color_picker'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Border Color Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_bckgrd_color_picker'] ) ){
						$options['tbl_background_color'] = sanitize_text_field( $_POST['ura_tbl_bckgrd_color_picker'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Table Background Color Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_color_picker'] ) ){
						$options['tbl_color'] = sanitize_text_field( $_POST['ura_tbl_color_picker'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Table Color Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_border_spacing'] ) ){
						$options['border-spacing'] = sanitize_text_field( $_POST['ura_tbl_border_spacing'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Border Spacing Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_div_color_picker'] ) ){
						$options['div_stuffbox_bckgrd_color'] = sanitize_text_field( $_POST['ura_div_color_picker'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Division Color Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					if( !empty( $_POST['ura_tbl_padding'] ) ){
						$options['tbl_padding']  = sanitize_text_field( $_POST['ura_tbl_padding'] );
						$class = 'updated';
					}else{
						$err_msg += __( ' Table Padding Missing! ', 'csds_userRegAide' );
						$pre_msg = '<div id="message" class="error"><p>';
						$msg = $pre_msg.$err_msg.$post_msg;
						return $msg;
					}
					
					update_option( "csds_userRegAide_Options", $options );
					$msg = '<div id="message" class="updated"><p>'. $mid_msg .'</p></div>'; 
					return $msg; //Report to the user that the data has been updated successfully
				}else{
						wp_die( __( 'Invalid Security Check!', 'csds_userRegAide' ) );
				}
			}
		}
		return $msg;
	}
	
}
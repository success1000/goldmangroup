<?php

/**
 * Class REGISTRATION_FORM_CSS_VIEW
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/
	
class REGISTRATION_FORM_CSS_VIEW
{	
	
	/**	
	 * Function image_position_array
	 * creates array for all different image postitions for css settings select box field
	 * @since 1.3.0
	 * @updated 1.5.2.0
	 * @params
	 * @returns array $position
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/
	
	function image_position_array(){
		$position = array(
			'left top'		=>	'Left Top',
			'left center'	=>	'Left Center',
			'left bottom'	=>	'Left Bottom',
			'right top'		=>	'Right Top',
			'right center'	=>	'Right Center',
			'right bottom'	=>	'Right Bottom',
			'center top'	=>	'Center Top',
			'center center'	=>	'Center Center',
			'center bottom'	=>	'Center Bottom'
		);
		return $position;
	}
	
	/**	
	 * Function rf_css_options_view
	 * Displays view for the registration form css options settings page
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @params 
	 * @returns 
	 * @access public
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/
	
	function rf_css_options_view(){
		global $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			//$ura_options = new URA_OPTIONS(); 
			$options = get_option('csds_userRegAide_Options');
			if( $options['csds_userRegAide_db_Version'] != "1.5.2.0" ){
				
				//do_action( 'update_options' );
					
			}
		
			// Form area for adding custom logo
			$span = array( 'regForm', __( 'Add Your Own Logo and Registration Form Customizations:', 'csds_userRegAide' ), 'csds_userRegAide' );
			do_action( 'start_mini_wrap', $span );
			$logo_url = (string) '';
			$size_error = ( int ) 0;
			if( !empty( $options['logo_url'] )  && $options['show_logo'] == 1 ){
				$logo_url = $options['logo_url'];
				$size = getimagesize( esc_url( $logo_url ) );
				$size_error = ( int ) 0;
				if( !empty( $size ) && is_array( $size ) ){
					$width = $size[0].'px';
					$height = $size[1].'px';
				}else{
					$width = $options['logo_width'];
					$height = $options['logo_height'];
					$size_error = 1;
				}
			}elseif( !empty( $options['logo_url'] )  && $options['show_logo'] == 2 ){
				$logo_url = $options['logo_url'];
				$size = getimagesize( esc_url( $logo_url ) );
				if( !empty( $size ) && is_array( $size ) ){
					$width = $size[0].'px';
					$height = $size[1].'px';
				}else{
					$width = $options['logo_width'];
					$height = $options['logo_height'];
					$size_error = 1;
				}
			}elseif( empty( $options['logo_url'] ) && $options['show_logo'] == 1 ){
				$logo_url = home_url('/wp-admin/images/wordpress-logo.png');
				$size = getimagesize( esc_url( $logo_url ) );
				if( !empty( $size ) && is_array( $size ) ){
					$width = $size[0].'px';
					$height = $size[1].'px';
				}else{
					$width = $options['logo_width'];
					$height = $options['logo_height'];
					$size_error = 1;
				}
			}
			?>
			<table class="regFormCustom" width="100%">
				<tr>
					<th colspan="4">
						<?php _e( 'Add Your Own Logo and Registration Form CSS Style Customizations Here:', 'csds_userRegAide' );?>
					</th>
				</tr>
				<tr>
				<?php
				// Custom Logo
				?>
					<td class="regFormCustom"><?php _e( 'Show Custom Logo: ', 'csds_userRegAide' ); ?>
					<br/>
					<span title="<?php _e( 'Select this option to show your own logo on the login-registration pages', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_logo" name="csds_userRegAide_logo" value="1"
					<?php if ( $options['show_logo'] == 1 ) echo 'checked' ;?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to show the default WordPress logo on the login-registration pages', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_logo" name="csds_userRegAide_logo"  value="2" <?php
					if ( $options['show_logo'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom">
					<?php _e( 'Change Custom Logo Link: ', 'csds_userRegAide' );?>
					<br/>
					<span title="<?php _e( 'Select this option to add your own logo link to the logo on the login-registration pages, automatically defaults to your site homepage!', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_change_logo_link" name="csds_userRegAide_change_logo_link" value="1" <?php
					if ( $options['change_logo_link'] == 1 ) echo 'checked' ;?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress logo link on the logo on the login-registration pages', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_change_logo_link" name="csds_userRegAide_change_logo_link"  value="2" <?php
					if ( $options['change_logo_link'] == 2 ) echo 'checked' ;?>/><?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom"><?php _e( 'Custom Logo Width: ', 'csds_userRegAide' ) ; ?>
					<br/>
					<?php
					if( $size_error != 1){
						?>
						<span title="<?php _e( 'Change this option to modify your own logo size ( width ) on the login-registration pages', 'csds_userRegAide');?>">
						<input type="text" title="<?php esc_url( _e( 'This is done automatically and is read only unless it cannot get your image size, then you can enter the correct width size in px format here for your new logo for your register/login page -- ( 220px ), otherwise it may screw up your logo image', 'csds_userRegAide' ) );?>" value="<?php _e( $width, 'csds_userRegAide' );?>" name="csds_logo_width" id="csds_logo_width" readonly />
						</span>
						</td>
						<?php
					}else{
						?>
						<span title="<?php _e( 'Change this option to modify your own logo size ( width ) on the login-registration pages', 'csds_userRegAide');?>">
						<select name="csds_logo_width" title="<?php _e( 'Select the correct width size here for your new logo for your register/login page -- ( 220px )', 'csds_userRegAide' );?>">
							<?php
								for( $i = 0; $i < 1601; $i++ ){
									$value = $i.'px';
									if( $width == $value ){
										$selected = "selected=\"selected\"";
									}else{
										$selected = NULL;
									}
								?>
								<option value="<?php echo $value ;?>" <?php echo $selected ;?> ><?php echo $value; ?></option>
								<?php
								}
							?>
						</select>
						</span>
						</td>
						<?php
					}
					?>
					<td class="regFormCustom"><?php _e( 'Custom Logo Height: ', 'csds_userRegAide') ; ?>
					<br/>
					<?php 
					if( $size_error != 1){
						?>
						<span title="<?php _e( 'logo size ( height ) on the login-registration pages', 'csds_userRegAide');?>">
						<input type="text" title="<?php esc_url( _e( 'This is done automatically and is read only unless it cannot get your image size, then you can manually enter the correct height size in px format here for your new logo for your register/login page -- ( 110px ), otherwise it may screw up your logo image', 'csds_userRegAide' ) );?>" value="<?php _e( $height, 'csds_userRegAide' );?>" name="csds_logo_height" id="csds_logo_height" readonly />
						</span>
						</td>
						<?php
					}else{
						?>
						<span title="<?php _e( 'Change this option to modify your own logo size ( height ) on the login-registration pages', 'csds_userRegAide' );?>">
						<select name="csds_logo_height" title="<?php _e( 'Select the correct height size in here for your new logo for your register/login page -- ( 110px )', 'csds_userRegAide' );?>">
							<?php
								for( $i = 0; $i < 1201; $i++ ){
									$value = $i.'px';
									if( $height == $value ){
										$selected = "selected=\"selected\"";
										}else{
										$selected = NULL;
									}
								?>
								<option value="<?php echo $value ;?>" <?php echo $selected ;?> ><?php echo $value; ?></option>
								<?php
								}
							?>
						</select>
						</span>
						</td>
						<?php
					}
					$size_error = 0;
					?>
				</tr>
				<tr>
					<td class="regFormCustom" colspan="4"><?php _e( 'New Logo URL: ', 'csds_userRegAide' );?>
					<br/>
					<input  style="width: 95%;" type="text" title="<?php esc_url( _e( 'Enter the URL where your new logo is for your register/login page -- (http://mysite.com/wp-content/uploads/9/5/thislogo.png)', 'csds_userRegAide' ) );?>" value="<?php _e( esc_url( $logo_url ), 'csds_userRegAide' );?>" name="csds_userRegAide_newLogoURL" id="csds_userRegAide_newLogoURL" />
					</td>
				</tr>
				</table>
				<br/>
				<table class="style">	
				<?php // Form Background Image
				$bckgrd_image_url = (string) '';
				if( !empty( $options['background_image_url'] ) ){
					$bckgrd_image_url = $options['background_image_url'];
				}else{
					$bckgrd_image_url = home_url('/add-background-image-location-here.img');
				}?>
				
				<tr>
					<td class="regFormCustom"><?php _e( 'Show Custom Background Image: ', 'csds_userRegAide' ); ?>
					<br/>
					<span title="<?php _e( 'Select this option to add your own custom background image on the login-registration form', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_background_image" name="csds_userRegAide_background_image" value="1" <?php
					if ( $options['show_background_image'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress background image on the login-registration form', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_background_image" name="csds_userRegAide_background_image" value="2"
					<?php if ( $options['show_background_image'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom"><?php _e( 'Repeat Custom Background Image: ', 'csds_userRegAide' ); ?>
					<br/>
					<span title="<?php _e( 'Select this option to repeat ( tile ) your own custom background image on the login-registration form', 'csds_userRegAide');?>">
					<input type="radio" id="csds_repeat_background_image" name="csds_repeat_background_image" value="1" <?php
					if ( $options['background_image_repeat'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to not repeat ( tile ) the custom background image on the login-registration form', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_repeat_background_image" name="csds_repeat_background_image" value="2"
					<?php if ( $options['background_image_repeat'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td colspan="2" class="regFormCustom"><?php _e( 'New Background Image URL: ', 'csds_userRegAide' );?>
					<input  style="width: 550px;" type="text" title="<?php esc_url( _e( 'Enter the URL where your new background image is for your login/register forms --  (http://mysite.com/wp-content/uploads/9/5/this-background-image.png)', 'csds_userRegAide' ) );?>" value="<?php _e( esc_url( $bckgrd_image_url ), 'csds_userRegAide' );?>" name="csds_userRegAide_newBackgroundImageURL" id="csds_userRegAide_newBackgroundImageURL" />
					</td>
				</tr>
				</table>
				<br/>
				<table class="style">	
				<?php
				// Page Background Image 	
				$pg_bckgrd_image_url = ( string ) '';
				if( !empty( $options['reg_form_page_image'] ) ){
					$pg_bckgrd_image_url = $options['reg_form_page_image'];
				}else{
					$pg_bckgrd_image_url = home_url( '/enter-new-page-background-image-location-here.img' );
				}
				?>
				<tr>
					<td class="regFormCustom"><?php _e( 'Show Custom Page Background Image: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to add your own custom background image on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_page_background_image" name="csds_userRegAide_page_background_image" value="1"
					<?php if ( $options['show_reg_form_page_image'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress background image on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_page_background_image" name="csds_userRegAide_page_background_image" value="2" 
					<?php if ( $options['show_reg_form_page_image'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom"><?php _e( 'Repeat Custom Page Background Image: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to repeat ( tile ) your own custom background image on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_repeat_page_background_image" name="csds_repeat_page_background_image" value="1"
					<?php if ( $options['reg_form_page_image_repeat'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to repeat your custom background image on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_repeat_page_background_image" name="csds_repeat_page_background_image" value="2" 
					<?php if ( $options['reg_form_page_image_repeat'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom" colspan="2"><?php _e( 'Custom Page Background Image Position: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to position your own custom background image on the login-registration page', 'csds_userRegAide' );?>">
					<select name="image_position" id="csds_image_position" title="<?php _e( 'You can select where to place your image here', 'csds_userRegAide' );?>" size="8" style="height:50px">
					<?php
					$current_position = $options['background_image_position'];
					$position = $this->image_position_array();
					foreach( $position as $key => $value ){
						if( $current_position == $key ){
							$selected = "selected=\"selected\"";
						}else{
							$selected = NULL;
						}
						echo "<option value=\"$key\" $selected >$value</option>";
					}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td class="regFormCustom"><?php _e( 'Repeat Custom Page Background Image Horizontally Only: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to repeat ( tile ) your own custom background image on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_repeat_page_bkgrd_image_hor" name="csds_repeat_page_bkgrd_image_hor" value="1"
					<?php if ( $options['hor_bckgrnd_image_repeat'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to repeat your custom background image horizontally only on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_repeat_page_bkgrd_image_hor" name="csds_repeat_page_bkgrd_image_hor" value="2" 
					<?php if ( $options['hor_bckgrnd_image_repeat'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom" colspan="3"><?php _e( 'New Page Background Image URL: ', 'csds_userRegAide' );?>
					<br/>
					<input  style="width: 95%;" type="text" title="<?php esc_url( _e( 'Enter the new page background image url for your register/login pages (http://mysite.com/content/uploads/myimage.png)', 'csds_userRegAide' ) );?>" value="<?php _e( esc_url( $pg_bckgrd_image_url ), 'csds_userRegAide' );?>" name="csds_userRegAide_newPageBackgroundImage" id="csds_userRegAide_newPageBackgroundImage" />
					</td>
				</tr>
				</table>
				<br/>
				<table class="style">	
				<?php						
				// Form Background Color
				?>
				<tr>
					<td class="regFormCustom"><?php _e( 'Show Custom Form Background Color: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to add your own custom background color on the login-registration form', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_background_color" name="csds_userRegAide_background_color" value="1"
					<?php if ( $options['show_background_color'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress background color on the login-registration form', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_background_color" name="csds_userRegAide_background_color" value="2" 
					<?php if ( $options['show_background_color'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom">
						
						<script type='text/javascript'>
							jQuery(document).ready(function($) {
								$('#csds_userRegAide_newBackgroundColor').wpColorPicker();
							});
						</script>
						
						<label for="csds_userRegAide_newBackgroundColor"> <?php _e( 'New Background Color: ', 'csds_userRegAide' ); ?> </label>
						<br/>
						<input type="text" id="csds_userRegAide_newBackgroundColor" name="csds_userRegAide_newBackgroundColor" title="<?php _e( sanitize_text_field( 'Select the new background color for your login/register form here' ), 'csds_userRegAide' );?>" value="<?php _e( sanitize_text_field( $options['reg_background_color'] ), 'csds_userRegAide' );?>" />
					</td>	
					
				<?php
					// Page Background Color
				?>
				
					<td class="regFormCustom"><?php _e( 'Show Custom Page Background Color: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to add your own custom background color on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_page_background_color" name="csds_userRegAide_page_background_color" value="1"
					<?php if ( $options['show_reg_form_page_color'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress background color on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_page_background_color" name="csds_userRegAide_page_background_color" value="2" 
					<?php if ( $options['show_reg_form_page_color'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom">
						
						<script type='text/javascript'>
							jQuery(document).ready(function($) {
								$('#csds_userRegAide_newPageBackgroundColor').wpColorPicker();
							});
						</script>
						
						<label for="csds_userRegAide_newBackgroundColor"> <?php _e( 'New Page Background Color: ', 'csds_userRegAide' ); ?> </label>
						<br/>
						<input type="text" id="csds_userRegAide_newPageBackgroundColor" name="csds_userRegAide_newPageBackgroundColor" title="<?php _e( sanitize_text_field( 'Select the new page background color for your login/register form here' ), 'csds_userRegAide' );?>" value="<?php _e( sanitize_text_field( $options['reg_form_page_color'] ), 'csds_userRegAide' );?>" />
					</td>	
				</tr>
				</table>
				<br/>
				<table class="style">	
				<?php
					// Text label and link colors	?>
				<tr>
					<td class="regFormCustom"><?php _e( 'Show Custom Text/Links Colors: ', 'csds_userRegAide' );?><br/>
					<span title="<?php _e( 'Select this option to add your own custom text and link colors on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_text_color" name="csds_userRegAide_text_color" value="1"
					<?php if ( $options['show_login_text_color'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress text and link colors on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_text_color" name="csds_userRegAide_text_color" value="2" 
					<?php if ( $options['show_login_text_color'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</span>
					</td>
					<td class="regFormCustom">
						
						<script type='text/javascript'>
							jQuery(document).ready(function($) {
								$('#csds_userRegAide_newTextColor').wpColorPicker();
							});
						</script>
						
						<label for="csds_userRegAide_newTextColor"><?php _e( 'New Text/Links Color: ', 'csds_userRegAide' );?></label>
						<br/>
						<input type="text" id="csds_userRegAide_newTextColor" name="csds_userRegAide_newTextColor" title="<?php _e( sanitize_text_field( 'Select the new text/links color for your login/register form here' ), 'csds_userRegAide' );?>" value="<?php _e( sanitize_text_field( $options['login_text_color'] ), 'csds_userRegAide' );?>" />
					</td>
					<td class="regFormCustom">
						
						<script type='text/javascript'>
							jQuery(document).ready(function($) {
								$('#csds_userRegAide_newHoverTextColor').wpColorPicker();
							});
						</script>
						
						<label for="csds_userRegAide_newHoverTextColor"><?php _e( 'New Links Hover Color: ', 'csds_userRegAide' );?></label>
						<br/>
						<input type="text" id="csds_userRegAide_newHoverTextColor" name="csds_userRegAide_newHoverTextColor" title="<?php _e( sanitize_text_field( 'Select the new text/links color for your login/register form here' ), 'csds_userRegAide' );?>" value="<?php _e( sanitize_text_field( $options['hover_text_color'] ), 'csds_userRegAide' );?>" />
					</td>						
					
				</tr>
				</table>
				<br/>
				<table class="style">	
				<?php
				// Link Shadow Size & colors
				?>
				<tr>
					<td class="regFormCustom" title="<?php _e( 'If you select this option to add your own custom link shadow size and colors on the login-registration page you must change shadow size from 0px too!', 'csds_userRegAide' );?>"><?php _e( 'Show Link Shadows: ', 'csds_userRegAide' );?>
					<br/>
					<span title="<?php _e( 'Select this option to add your own custom link shadow size and colors on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_show_shadow" name="csds_userRegAide_show_shadow" value="1"
					<?php if ( $options['show_shadow'] == 1 ) echo 'checked';?>/> <?php _e( 'Yes', 'csds_userRegAide' ); ?>
					</span>
					<span title="<?php _e( 'Select this option to use the default Wordpress link shadow size and colors on the login-registration page', 'csds_userRegAide' );?>">
					<input type="radio" id="csds_userRegAide_show_shadow" name="csds_userRegAide_show_shadow" value="2" 
					<?php if ( $options['show_shadow'] == 2 ) echo 'checked' ;?>/> <?php _e( 'No', 'csds_userRegAide' ); ?>
					</td>
					<td class="regFormCustom" title="<?php _e( 'If you select to show link shadows this must be higher than 0px, you must change it to at least 1px otherwise the program will automatically adjust it to 1px!', 'csds_userRegAide' );?>"><?php _e( 'Shadow Size in PX: ', 'csds_userRegAide' );?>
					<select name="csds_userRegAide_shadowSize" title="<?php _e( 'Enter the new size of shadow for login/registration page links in PX for your site! Example: 2px NOTE: Must be higher than default 0px if you choose to show link shadows! It will automatically adjust this to 1px if you do not, but you may want a different size so make sure you add your own size here!', 'csds_userRegAide' );?>">
					<?php
					for( $i = 0; $i < 16; $i++ ){
						$value = $i.'px';
						if( $options['shadow_size'] == $value ){
							$selected = "selected=\"selected\"";
						}else{
							$selected = NULL;
						}
						?>
						<option value="<?php echo $value ;?>" <?php echo $selected ;?> ><?php echo $value; ?></option>
						<?php
					}
					?>
					</select>
					</td>
					<td class="regFormCustom">
						
						<script type='text/javascript'>
							jQuery(document).ready(function($) {
								$('#csds_userRegAide_shadowColor').wpColorPicker();
							});
						</script>
						
						<label for="csds_userRegAide_shadowColor"><?php _e( 'Shadow Color: ', 'csds_userRegAide' );?></label>
						<br/>
						<input type="text" id="csds_userRegAide_shadowColor" name="csds_userRegAide_shadowColor" title="<?php _e( sanitize_text_field( 'Select the new color for your login page links shadows here' ), 'csds_userRegAide' );?>" value="<?php _e( sanitize_text_field( $options['shadow_color'] ), 'csds_userRegAide' );?>" />
					</td>			
				</tr>
				</table>
				<br/>
				<table class="style">	
				<tr>
				<td>
				<div class="submit">
				<input type="submit" class="button-primary" name="csds_userRegAide_logo_update" id="csds_userRegAide_logo_update" value="<?php _e( 'Update Login-Reg Form Style Options', 'csds_userRegAide' );?>" />
				</div>
				</td>
				</tr>
				</table>
				<?php
				
		}
	}
}
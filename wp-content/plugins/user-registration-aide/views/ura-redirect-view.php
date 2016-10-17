<?php

/**
 * Class URA_REDIRECTS_VIEW
	*
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
 */

class URA_REDIRECTS_VIEW
{
	
	/**	
	 * Function rf_redirect_view
	 * URA registration form redirect options editing view
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params array $options options settings for plugin page
	 * @returns 
	 */

	function rf_redirect_view( $options ){
		global $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			$reg_redirect_url = (string) '';
			$login_redirect_url = (string) '';
			//Form for adding redirects to registration and login pages 
			if(!empty($options['registration_redirect_url'])){
				$reg_redirect_url = $options['registration_redirect_url'];
				}else{
				$reg_redirect_url = home_url('/wp-login.php?checkemail=registered');
			}
			if(!empty($options['login_redirect_url'])){
				$login_redirect_url = $options['login_redirect_url'];
				}else{
				$login_redirect_url = home_url('/wp-admin/');
			}
			?>
			<table class="regForm" width="100%">
				<tr>
					<th colspan="2">
						<?php _e( 'Add Custom Redirects After Users Login or a New User Registers Here:', 'csds_userRegAide' );?>
					</th>
				</tr>
				<tr>
					<td width="60%"><?php _e( 'Choose to redirect users to a different page than default WordPress page after successful registration: ', 'csds_userRegAide' );?>
						<br/>
						<span title="<?php _e( 'Select this option to redirect new user to custom page after successsful new registration signup',  'csds_userRegAide' );?>">
							<input type="radio" name="csds_registration_redirect_option" id="csds_registration_redirect_option" value="1" <?php
							if ( $options['redirect_registration'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' );?></span>
						<span title="<?php _e( 'Select this option to redirect new user to default WordPress page after successful new user registration sign-up',  'csds_userRegAide' );?>">
							<input type="radio" name="csds_registration_redirect_option" id="csds_registration_redirect_option" value="2" <?php
							if ( $options['redirect_registration'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?></span></td>
					
				<td width="40%"><?php _e( 'Enter new successful Registration form redirect url below: ', 'csds_userRegAide' );?></td></tr>
				<tr>
					<td colspan="2"><input type="text" name="csds_registration_redirect_url" id="csds_registration_redirect_url" class="regFormRedirect" width="75%" title="<?php _e( 'Enter a new url here to redirect users to after a successful registration has been completed!', 'csds_userRegAide' );?>" value="<?php _e( esc_url( $reg_redirect_url ),'csds_userRegAide' );?>" />
					</td>
				</tr>
				<tr>
					<td width="60%"><?php  _e( 'Choose to redirect users to a different page than default WordPress page after successful login: ', 'csds_userRegAide' );?>
						<span title="<?php _e( 'Select this option to redirect new user to custom page after successful login',  'csds_userRegAide' );?>">
							<input type="radio" name="csds_login_redirect_option" id="csds_login_redirect_option" value="1" <?php
							if ( $options['redirect_login'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' );?></span>
						<span title="<?php _e( 'Select this option to redirect new user to default WordPress page after successful login',  'csds_userRegAide' );?>">
							<input type="radio" name="csds_login_redirect_option" id="csds_login_redirect_option" value="2" <?php
							if ( $options['redirect_login'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?></td></span>
					
				<td width="40%"><?php _e( 'Enter new successful login redirect url below: ', 'csds_userRegAide' );?></td></tr>
				<tr>
					<td colspan="2">
					<input type="text" name="csds_login_redirect_url" id="csds_login_redirect_url" class="regFormRedirect" width="75%" title="<?php _e( 'Enter a new url here to redirect users to after a successful login has been completed!', 'csds_userRegAide' );?>" value="<?php _e( esc_url( $login_redirect_url ),'csds_userRegAide' );?>" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<input type="submit" class="button-primary" name="redirects_update" value="<?php _e( 'Update Redirects Options', 'csds_userRegAide' );?>"  />
					</td>
				</tr>
			</table>
			<?php
		}
		
	}
}
<?php

/**
 * Class URA_PROFILE_TITLE_VIEW
	*
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
 */

class URA_PROFILE_TITLE_VIEW
{
	
	/**	
	 * Function prof_title_view
	 * URA profile extra fields title options editing view
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params array $options options settings for plugin page
	 * @returns 
	 */
	
	function prof_title_view( $options ){
		global $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			//Form for changing profile extra fields title 
			//$span = array( 'regForm', __( 'Change Title For User Profiles Page:', 'csds_userRegAide' ), 'csds_userRegAide' );
			//do_action( 'start_mini_wrap', $span ); ?>
			<table class="regForm" width="100%">
				<tr>
					<th colspan="2">
					<?php _e( 'Change Extra Field Title Options For User Profile Pages:', 'csds_userRegAide' );?>
					</th>
				</tr>
				<tr>
					<td width="40%"><?php _e('Choose to change the title for extra fields on the users profile page: ', 'csds_userRegAide'); ?>
						<br />
						<span title="<?php _e('Select this option to add your own special title to the extra fields portion of the users profile',  'csds_userRegAide');?>">
							<input type="radio" name="csds_change_profile_title" id="csds_change_profile_title" value="1" <?php
							if ($options['change_profile_title'] == 1) echo 'checked' ;?> /> <?php _e('Yes', 'csds_userRegAide');?></span>
						<span title="<?php _e('Select this option to keep the default title to the extra fields portion of the users profile',  'csds_userRegAide');?>">
							<input type="radio" name="csds_change_profile_title" id="csds_change_profile_title" value="2" <?php
							if ($options['change_profile_title'] == 2) echo 'checked' ;?> /> <?php _e('No', 'csds_userRegAide'); ?></span></td>
					<td width=60%><?php _e('Extra Fields Title: ', 'csds_userRegAide');?>
						<br />
					<input style="width: 90%;" type="text" title="<?php _e(esc_attr('Enter the new title that you would like to have for the extra fields portion on the users profile page here:'), 'csds_userRegAide');?>" value="<?php _e(esc_attr($options['profile_title']), 'csds_userRegAide');?>" name="csds_profile_title" id="csds_profile_title" /></td>
				</tr>
				<tr>
					<td colspan="2">
					<input type="submit" class="button-primary" name="update_profile_title" value="<?php _e('Update Profile Title Options', 'csds_userRegAide'); ?>"  />
					</td>
				</tr>
			</table>
			<?php
		}
	}
}
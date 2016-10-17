<?php

/**
 * Class URA_EDIT_REGISTRATION_FORM_FIELDS_VIEW
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_EDIT_REGISTRATION_FORM_FIELDS_VIEW
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
	
	function edit_reg_form_fields_view(){
		global $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			$field = new FIELDS_DATABASE();
			$ura_fields = $field->get_all_fields();
			$options = get_option( 'csds_userRegAide_Options' );
			?>
			<table class="newFields">
				<tr>
					<th colspan="3"><?php _e( 'Delete Fields & Change Fields Required for Registration Form:', 'csds_userRegAide' );?> </th>
				</tr>
				<tr>
					<td><?php
					//if( !empty( $newFields ) ){
					if( !empty( $ura_fields ) ){
						echo '<p class="deleteFields">'.__( 'Delete Fields: <br/>Here you can select the new additional fields you added that you want to delete.', 'csds_userRegAide' ).'</p>';
						echo '<select name="deleteNewFields" id="csds_userRegMod_delete_Select" title="'.__( 'Please choose a field to delete here, you can only select one field at a time to delete however', 'csds_userRegAide' ).'" size="8"  class="deleteFields">';
						
						foreach( $ura_fields as $object ){
							echo '<option value="'.$object->meta_key.'">'.$object->field_name.'</option>';
						}
						echo '</select>';
						?>
						<br/>
						<input type="submit" class="button-primary" name="delete_field" value="<?php _e( 'Delete New Field', 'csds_userRegAide' );?>"/></p>
						<?php	
					}else{
						echo '<p class="deleteFields">'.__( 'No new fields currently exist, you have to add new fields on the main page before you can delete any!', 'csds_userRegAide' ).'</p>';
					}?>
				</td>
				<td>
				<p class="adminPage"><?php _e( 'By default, Wordpress will only require an email address and username to register an account. Here, you can select additional fields that will be added for new user registration.', 'csds_userRegAide' );?>
				<br/>
				</p>
				<p class="adminPage"><?php _e( 'Select Additional Fields to add to the Registration Form:', 'csds_userRegAide' );?>
				<br/>
				<select name="additionalFields[]" id="csds_userRegMod_Select" title="<?php _e( 'You can select as many fields here as you want, just hold down the control key while selecting multiple fields. These fields are required on the registration form, so if you can do without them and just have them on the user profile page then leave them out of the registration form!', 'csds_userRegAide' );?>" size="8" multiple style="height:100px">
				<?php
				$regFields = get_option( 'csds_userRegAide_registrationFields' );
				$knownFields = get_option( 'csds_userRegAide_knownFields' );
				$field = new FIELDS_DATABASE();
				$ura_fields = $field->get_all_fields(); 
				if( !empty( $knownFields ) ){
					if( !empty( $regFields ) ){
						if( is_array( $regFields ) ){
							foreach( $knownFields as $key1 => $value1 ){
								if( array_key_exists( $key1, $regFields ) ){
									$selected = "selected=\"selected\"";
								}else{
									$selected = NULL;
								}
								
								?>
								<option value="<?php echo $key1 ;?>" <?php echo $selected ;?> ><?php _e( $value1, 'csds_userRegAide' );?></option>
								
							<?php
							}
							
						}else{
							//exit();
						}
					}else{
						foreach( $knownFields as $key1 => $value1 ){
							$selected = NULL;
						
							?>
							<option value="<?php echo $key1 ;?>" <?php echo $selected ;?> ><?php _e( $value1, 'csds_userRegAide' );?></option>
							
							<?php
						}
						//echo "<option value=\"$key1\" $selected >$value1</option>";
							
					}
					
					if( !empty( $ura_fields ) ){
						//foreach( $newFields as $key2 => $value2 ){
						foreach( $ura_fields as $object ){
							$meta_key = $object->meta_key;
							$name = $object->field_name;
							//$reg_form = $object->registration_form;
							if( $object->registration_field == 1 ){
								//exit( "SELECTED" );
								$selected = "selected=\"selected\"";
							}else{
								//exit( "UNSELECTED" );
								$selected = NULL;
							}
							?>
							<option value="<?php echo $meta_key ;?>" <?php echo $selected ;?> ><?php _e( $name, 'csds_userRegAide' );?></option>
							
							<?php
							//echo "<option value=\"$meta_key\" $selected >$name</option>";
						
						}
					}
				}
				?>	
				</select>
				<br/>
				<b><?php _e( 'Hold down "Ctrl" button on keyboard to select or unselect multiple options!', 'csds_userRegAide' );?>
				</b>
				</p>
				<div class="submit">
				<input type="submit" name="select_none" class="button-primary" value="<?php _e('Select None', 'csds_userRegAide'); ?>" />
				</div>
			<div class="submit"><input type="submit" class="button-primary" name="reg_fields_update" value="<?php _e('Update Registration Form Fields', 'csds_userRegAide');?>"/></div>
				</td>
				<td>
				<p class="adminPage"><?php _e( 'Here you can select whether Registration Form Fields are required or not', 'csds_userRegAide' );?>
				<br/>
				</p>
				<p class="adminPage"><?php _e( 'Select Registration Form Fields That Will NOT BE REQUIRED for Users to Fill out When Registering:', 'csds_userRegAide' );?>
				<br/>
				<select name="requiredFields[]" id="required_fields" title="<?php _e( 'You can select as many fields here as you want, just hold down the control key while selecting multiple fields. Selecting these fields makes them so they are NOT REQUIRED FIELDS on the registration form!', 'csds_userRegAide' );?>" size="8" multiple style="height:100px">
				<?php
				$optional_fields = get_option( 'csds_ura_optionalFields' );
				$regFields = get_option( 'csds_userRegAide_registrationFields' );
				$knownFields = get_option( 'csds_userRegAide_knownFields' );
				$field = new FIELDS_DATABASE();
				$ura_fields = $field->get_registration_fields(); 
				$opt_fields = $field->get_optional_fields();
				if( !empty( $regFields ) ){
					if( is_array( $regFields ) ){
						foreach( $knownFields as $key1 => $value1 ){
							if( !empty( $regFields ) ){
								if( !empty( $optional_fields ) ){
									if( array_key_exists( $key1, $optional_fields ) ){
										$selected = "selected=\"selected\"";
									}else{
										$selected = NULL;
									}
								}else{
									$selected = NULL;
								}
								if( $key1 != 'user_pass' ){
									if( array_key_exists( $key1, $regFields ) ){
										?>
										<option value="<?php echo $key1 ;?>" <?php echo $selected ;?> ><?php _e( $value1, 'csds_userRegAide' );?></option>
										<?php
									}
								}
							}else{
								_e( 'There currently are no fields selected for the Registration Form, Select some fields for the Registration Form first before you can make them optional or required!', 'csds_userRegAide' );
							}
								
								
						}
						
						
					}else{
						//exit();
					}
				}
				if( !empty( $ura_fields ) ){
					foreach( $ura_fields as $object ){
						$meta_key = $object->meta_key;
						$name = $object->field_name;
						//$reg_form = $object->registration_field;
						if( $object->field_required == 0 ){
							//exit( "SELECTED" );
							$selected = "selected=\"selected\"";
						}else{
							//exit( "UNSELECTED" );
							$selected = NULL;
						}
						if( $object->registration_field == 1 ){
							?>
							<option value="<?php echo $meta_key ;?>" <?php echo $selected ;?> ><?php _e( $name, 'csds_userRegAide' );?></option>
							<?php
						}
						
					} // end foreach
				}else{
					if( empty( $regFields ) ){
						?>
						<option value="<?php _e( 'no_fields_0', 'csds_userRegAide' );?>"><?php _e( 'No Registration Form Fields', 'csds_userRegAide' );?></option>
						<option value="<?php _e( 'no_fields_1', 'csds_userRegAide' );?>"><?php _e( 'Have Been Added Yet!', 'csds_userRegAide' );?></option>
						<?php
					}
				}
				?>							
				</select>
				<br/>
				<b><?php _e( 'Hold down "Ctrl" button on keyboard to select or unselect multiple options!', 'csds_userRegAide' );?>
				</b>
				</p>
				<div class="submit">
				<input type="submit" name="select_required_none" class="button-primary" value="<?php _e( 'Select None', 'csds_userRegAide' ); ?>" /></div>
				<div class="submit">
				<input type="submit" class="button-primary" name="required_fields_update" value="<?php _e( 'Required Fields Update', 'csds_userRegAide' );?>"/>
				</div>
				</td>
			</tr>
			</table>
			<br/>
			<table class="style">	
			<tr>
				<th colspan="3"><?php _e( 'Registration Form Field Title Punctuation', 'csds_userRegAide' );?> </th>
			</tr>
			<tr>
				<td colspan="2">
				<?php _e( 'Use the * ( Asterisk ) on the Registration Form to Designate a Field is Required', 'csds_userRegAide' );?>
				</td>
				<td>
				<span title="<?php _e( 'Select this option to use the * ( Asterisk ) to Designate a Required Field on the Registration Form( Field Title:* ( if using colon, you can remove that too! ), otherwise Field Title* )', 'csds_userRegAide' );?>">
				<input type="radio" name="use_asterisk" id="use_asterisk" value="1" <?php
				if ( $options['designate_required_fields'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' );?>
				</span>
				<span title="<?php _e( 'Select this option not to use the * ( Asterisk ) to Designate a Required Field on the Registration Form ( Field Title: ( if using colon, you can remove that too! ), otherwise Field Title )',  'csds_userRegAide' );?>">
				<input type="radio" name="use_asterisk" id="use_asterisk" value="2" <?php
				if ( $options['designate_required_fields'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?>
				</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<?php _e( 'Use the : ( Colon ) on the Registration Form after Field Title', 'csds_userRegAide' );?>
				</td>
				<td>
				<span title="<?php _e( 'Select this option to use the : ( Colon ) After the Field Title on the Registration Form ( Field Title: )', 'csds_userRegAide' );?>">
				<input type="radio" name="use_colon" id="use_colon" value="1" <?php
				if ( $options['reg_form_use_colon'] == 1 ) echo 'checked' ;?> /> <?php _e( 'Yes', 'csds_userRegAide' );?>
				</span>
				<span title="<?php _e( 'Select this option to not use the : ( Colon ) After the Field Title on the Registration Form ( Field Title )',  'csds_userRegAide' );?>">
				<input type="radio" name="use_colon" id="use_colon" value="2" <?php
				if ( $options['reg_form_use_colon'] == 2 ) echo 'checked' ;?> /> <?php _e( 'No', 'csds_userRegAide' ); ?>
				</span>
				</td>
			<tr>
				<td colspan="3">
				<input type="submit" class="button-primary" name="update-asterisk-colon" value="<?php _e( 'Update Field Title Punctuation Option', 'csds_userRegAide' );?>"/>
				</td>
			</tr>
			</table>
			<br/>
		<?php
		}
	}
	
	
} // end class
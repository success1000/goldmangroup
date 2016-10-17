<?php

/**
 * Class INPUT_NEW_FIELDS_VIEW
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class INPUT_NEW_FIELDS_VIEW
{
	
	/**	
	 * function new_fields_input_viewer
	 * Handles new fields input admin form options and settings view
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params string $msg
	 * @returns 
	*/

	function new_fields_input_viewer(){
		global $current_user;
		$current_user = wp_get_current_user();
		if( !current_user_can( 'manage_options', $current_user->ID ) ){
			wp_die( __( 'You do not have permissions to activate this plugin, sorry, check with site administrator to resolve this issue please!', 'csds_userRegAide' ) );
		}else{
			do_action( 'database_update' );
			$class = ( string ) 'BuddyPress';
			$plugin = ( string ) 'buddypress/bp-loader.php';
			$newField = ( string ) '';
			$newFieldKey = ( string ) '';
			$reg_form_use = ( string ) '';
			$required = ( string ) '';
			$field_data_type = ( string ) '';
			$fieldOptions = ( string ) '';
			$msg1 = ( string ) '';
			$minNumb = ( int ) 0;
			$maxNumb = ( int ) 0;
			$stepNumb = ( int ) 0;
			$nfc = new INPUT_NEW_FIELDS_MODEL();
			$input = $nfc->input_options_array();
			$span = array( 'regForm', 'Add Custom Fields With Own Input Option Here:', 'csds_userRegAide');
			
			if( !empty( $_POST['ura_newField'] ) ){
				$newField = sanitize_text_field( $_POST['ura_newField'] );
			}
			if( !empty( $_POST['ura_newFieldKey'] ) ){
				$newFieldKey = sanitize_key( $_POST['ura_newFieldKey'] );
			}
			if( !empty( $_POST['reg_form_use'] ) ){
				$reg_form_use = sanitize_key( $_POST['reg_form_use'] );
			}
			if( !empty( $_POST['required'] ) ){
				$required = sanitize_key( $_POST['required'] );
			}
			if( !empty( $_POST['input_type'] ) ){
				$field_data_type = sanitize_key( $_POST['input_type'] );
			}
			if( !empty( $_POST['ura_fieldOptions'] ) ){
				$fieldOptions = sanitize_text_field( $_POST['ura_fieldOptions'] );
			}
			if( !empty( $_POST['ura_minNumb'] ) ){
				$minNumb = sanitize_text_field( $_POST['ura_minNumb'] );
			}
			if( !empty( $_POST['ura_maxNumb'] ) ){
				$maxNumb = sanitize_text_field( $_POST['ura_maxNumb'] );
			}
			if( !empty( $_POST['ura_stepNumb'] ) ){
				$stepNumb = sanitize_text_field( $_POST['ura_stepNumb'] );
			}
			
			$select_options = array(
				"1"	=>	"Yes",
				"0"	=>	"No"
			);
			
			// Shows Aministration Page 
			
			?>
			<br />
				
			<table class="newInputFields">
				<tr>
					<th colspan="4"  class="newInputFields"><?php _e( 'Create Custom Fields Of Various Input Types Here:', 'csds_userRegAide' );?> </th>
				</tr>
				<tr>
				
				<?php
					// Form for adding new fields for users profile and registration
					?>							
					<td colspan="4">
					<?php _e( 'Here is where you can enter your custom additional fields, the key name should be lower ', 'csds_userRegAide' ); ?>
					<br/>
					<?php _e( 'case and correlate to the field name that the user sees on the registration form and profile.','csds_userRegAide' ); ?>
					<br/>
					<?php _e( 'Examples:','csds_userRegAide' ); ?>
					</td>
				</tr>
			</table>
			<br/>
				
			<table class="newInputFields">
				<tr>
					<td width="25%"><?php _e( 'Field Key Name: dob','csds_userRegAide' );?></td>
					<td width="25%"><?php _e( 'Field Type: Select (Drop Down)','csds_userRegAide' );?></td>
					<td width="25%"><?php _e( 'Registration Form: Yes/No','csds_userRegAide' );?></td>
					<td width="25%"><?php _e( 'Field Required: Yes/No','csds_userRegAide' ); ?></td>
				</tr>
				<tr>
					<td align="left">
					<fieldset>
					<legend>Field Key Name: </legend>
					<?php
					echo '<input  style="width: 100%;" type="text" title="'.__( 'Enter the database name for your field here, like dob for Date of Birth or full_name, use lower case letters and _ (underscores) ONLY! Keep it short and simple and relative to the field you are creating!', 'csds_userRegAide' ) . '" value="'. $newFieldKey . '" name="ura_newFieldKey" id="ura_newFieldKey" maxlength="30" />';
					?>
					</fieldset>
					</td>
					<td align="left">
					<fieldset>
					<legend>Field Type:</legend>
					<select name="input_type" id="input_type" title="<?php _e( 'Select the input type for your new custom field here from select, text, textarea, radio or checkbox', 'csds_userRegAide' );?>" >
					<?php
					foreach( $input as $key	=>	$title ){
						if( $key == $field_data_type ){
							echo "<option selected=".$field_data_type." value=\"$key\">$title</option>";
						}else{
							echo "<option value=\"$key\">$title</option>";
						}
					}
					?>
					</select>
					</fieldset>
					</td>
					<td align="left">
					<fieldset>
					<legend>Use on Registration Form:</legend>
					<select name="reg_form_use" id="reg_form_use" title="<?php _e( 'Choose Yes to use this field on the Registration Form or No not to use it on Registration Form','csds_userRegAide' );?>" >
					<?php
					foreach( $select_options as $key =>	$title ){
						if( $key == $reg_form_use ){
							echo "<option selected=".$reg_form_use." value=\"$key\">$title</option>";
						}else{
							echo "<option value=\"$key\">$title</option>";
						}
					}
					?>
					</select>
					</fieldset>
					</td>
					<td>
					<fieldset>
					<legend>Field Requirement:</legend>
					<select name="required" id="required" title="<?php _e( 'Select whether the new field is required or not here', 'csds_userRegAide' );?>" >
					<?php
					foreach( $select_options as $key =>	$title ){
						if( $key == $required ){
							echo "<option selected=".$required." value=\"$key\">$title</option>";
						}else{
							echo "<option value=\"$key\">$title</option>";
						}
					}
					?>
					</select>
					</fieldset>
					</td>
				</tr>
			</table>
			<br/>
			<table class="newInputFields">
				<tr>
					<td align="left">
					<fieldset>
					<legend>Input Type Number: </legend>
					<p title="<?php _e( 'You can select the minimum number to display, maximum number to display and the step, or increment to use, like 5,10,15 for 5 or 2,4,6,8 for 2 or 1,2,3 for 1.', 'csds_userRegAide' );?>" >
					<?php _e( 'Only use these choices if your Field Type is a number', 'csds_userRegAide' ); ?>
					</p>
					</fieldset>
					</td>
					<td align="left">
					<fieldset>
					<legend>Minimum Number: </legend>
					<?php
					echo '<input  style="width: 100%;" type="number" title="'.__( 'Enter the minimum number to use for your number input box', 'csds_userRegAide' ) . '" value="'. $minNumb . '" name="ura_minNumb" id="ura_minNumb" maxlength="30" />';
					?>
					</fieldset>
					</td>
					<td align="left">
					<fieldset>
					<legend>Maximum Number: </legend>
					<?php
					echo '<input  style="width: 100%;" type="number" title="'.__( 'Enter the maximum number to use for your number input box', 'csds_userRegAide' ) . '" value="'. $maxNumb . '" name="ura_maxNumb" id="ura_maxNumb" maxlength="30" />';
					?>
					</fieldset>
					</td>
					<td align="left">
					<fieldset>
					<legend>Number Step By: </legend>
					<?php
					echo '<input  style="width: 100%;" type="number" title="'.__( 'Enter the number to increment by in your number select box ( 1, 2, 5 which are the numbers that would be used, like 5 would be 5,10,15,20 like that )', 'csds_userRegAide' ) . '" value="'. $stepNumb . '" name="ura_stepNumb" id="ura_stepNumb" maxlength="30" />';
					?>
					</fieldset>
					</td>
				</tr>
			</table>
			<br/>
			<table class="newInputFields">
				<tr>
					<td colspan="4" align="left">
					<fieldset title="">
					<legend>Field Title:</legend>
					<?php
					echo '<input  style="width: 100%;" type="text" title="'.__( 'Enter the user friendly name for your field here, like Date of Birth for dob, ect. Keep it short & simple and relative to the field you are creating!', 'csds_userRegAide' ) . '" value="'. $newField . '" name="ura_newField" id="ura_newField" maxlength="50" />';
					?>
					</fieldset>
					</td>
				</tr>
			</table>
			<br/>
			<table class="newInputFields">
				<tr>
					<td colspan="4" align="left">
					<fieldset title="NOTE: DO NOT USE COMMAS in your field options please! It will mess up your whole array of options strings!!">
					<legend title="NOTE: DO NOT USE COMMAS in your field options please! It will mess up your whole array of options strings!!">Field Options:</legend>
					<?php
					$texts = $nfc->options_text_inputs();
					$text_keys = $nfc->options_keys_array();
					$space = '&nbsp';
					$double_space = '&nbsp;&nbsp;';
					$triple_space = '&nbsp;&nbsp;&nbsp;&nbsp;';
					$quad_space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$i = ( int ) 1;
					$index = ( int ) 0;
					?>
					<table class="options-number" style="width:95%;">
					<tr>
					<th class="options-number" style="width:5%">
					Option Number:
					</th>
					<th style="width:22.5%;">
					Option Key:
					</th>
					<th style="width:22.5%;">
					Option Name:
					</th>
					<th class="options-number" style="width:5%;">
					Option Number:
					</th>
					<th style="width:22.5%;">
					Option Key:
					</th>
					<th style="width:22.5;%">
					Option Name:
					</th>
					</tr>
					<?php
					for( $x = 1; $x <= 8; $x++ ){
					//foreach( $texts as $id	=> $label ){
						echo '<tr>';
						echo '<td class="options-number">'.$i.':</td>';
						echo '<td width="22.5%">'.$text_keys[$index].'</td>';
						echo '<td width="22.5%">'.$texts[$index].'</td>';
						$i++;
						$index++;
						echo '<td class="options-number">'.$i.':</td>';
						echo '<td width="22.5%">'.$text_keys[$index].'</td>';
						echo '<td width="22.5%">'.$texts[$index].'</td>';
						$i++;
						$index++;
						echo '</tr>';
					}
					?>
			</table>
					</fieldset>
					</td>
				</tr>
			
			<?php
			if ( class_exists( $class ) ){
				if( is_plugin_active( $plugin ) ){
				?>
			</table>
			<br/>
			<table class="newInputFields">
				<tr>
					<td colspan="4" align="left">
					<fieldset>
					<legend>BuddyPress Fields:</legend>
					<fieldset>
					<legend>Field Description:</legend>
					<input  style="width: 100%;" type="textarea" title="'.__( 'Enter the field description to describe in detail the field you are creating here!', 'csds_userRegAide' ) . '" value="" name="ura_newFieldDesc" id="ura_newFieldDesc" />
					</fieldset>
					<fieldset>
					<legend>Default Visibility:</legend>
					<input type="radio" name="default_visibility" value="public" checked> Everyone<br>
					<input type="radio" name="default_visibility" value="adminsonly"> Only Me<br>
					<input type="radio" name="default_visibility" value="loggedin"> All Members<br>
					</fieldset>
					<fieldset>
					<legend>Per Member Visibility:</legend>
					<input type="radio" name="allow_custom_visibility" value="allowed" checked> Let members change this field's visibility<br>
					<input type="radio" name="allow_custom_visibility" value="disabled"> Enforce the default visibility for all members<br>
					</fieldset>
					</fieldset>
					</td>
				</tr>
					
					<?php
				}
			}
			?>
			</table>
			<br/>
			<table class="newInputFields">
				<tr>
					<td style="text-align:center;" colspan="4">
					<input type="submit" class="button-primary" name="new_fields_update" value="<?php _e( 'Add New Field', 'csds_userRegAide' );?>" />
					</td>
				</tr>
			</table>
			
			<?php
		}
	}
}
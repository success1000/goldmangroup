<?php
/*  Copyright 2012 Webhead LLC (email: info at webheadcoder.com)
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

/**
 * Initialize this form shortcode.
 */
function cf7msm_add_shortcode_form_field() {
    if ( function_exists( 'wpcf7_add_shortcode' ) ) {
        wpcf7_add_shortcode( 
            array( 'form', 'form*', 'multiform', 'multiform*' ), 
            'wpcf7_form_shortcode_handler', 
            true 
        );
    }
}
add_action( 'wpcf7_init', 'cf7msm_add_shortcode_form_field' );

/* Shortcode handler */

function wpcf7_form_shortcode_handler( $tag ) {
	if ( ! is_array( $tag ) )
		return '';
	$type = $tag['type'];
	$name = $tag['name'];
	$options = (array) $tag['options'];
	$values = (array) $tag['values'];

    if ( !empty( $values ) ) {
        $field_name = current( $values );
    }
	else if ( !empty( $name ) ) {
        $field_name = $name;
    }

    if ( empty( $field_name ) )
		return '';

	$atts = '';
	$id_att = '';
	$class_att = '';
	$size_att = '';
	$maxlength_att = '';
	$tabindex_att = '';
	$title_att = '';

	$class_att .= ' wpcf7-form';

	foreach ( $options as $option ) {
		if ( preg_match( '%^id:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$id_att = $matches[1];
		}
	}

	if ( $id_att ) {
		$id_att = trim( $id_att );
	}
	
	$value = '';
	//return raw value, let filters sanitize if needed.
	$cf7msm_posted_data = cf7msm_get('cf7msm_posted_data');

	if ( !empty( $cf7msm_posted_data ) && is_array( $cf7msm_posted_data ) ) {
		$value = isset( $cf7msm_posted_data[$field_name] ) ? $cf7msm_posted_data[$field_name] : '';	
		//check for free_text
		if ( !empty( $value ) ) {
		    // if value is selected/not empty, set it to the free_text value.
		    if ( isset( $cf7msm_posted_data[CF7MSM_FREE_TEXT_PREFIX_RADIO . $field_name] ) ) {
		    	$value = $cf7msm_posted_data[CF7MSM_FREE_TEXT_PREFIX_RADIO . $field_name];
		    }
		    else if ( isset( $cf7msm_posted_data[CF7MSM_FREE_TEXT_PREFIX_CHECKBOX . $field_name] ) ) {
		    	if ( is_array( $value ) ) {
		    		end($value);
		    		$last_key = key( $value );
		    		reset($value);
		    		$value[$last_key] = $cf7msm_posted_data[CF7MSM_FREE_TEXT_PREFIX_CHECKBOX . $field_name];
		    	}
		    	else {
		    		$value = $cf7msm_posted_data[CF7MSM_FREE_TEXT_PREFIX_CHECKBOX . $field_name];	
		    	}
		    }
		}
	}
	if (is_array($value)) {
	    $value = implode(", ", $value);
	}
	$value = apply_filters('wpcf7_form_field_value', apply_filters('wpcf7_form_field_value_'.$id_att, $value));

	return $value;
}

/**
 * Add to the wpcf7 tag generator.
 */
function cf7msm_add_tag_generator_form_field() {
    if ( class_exists( 'WPCF7_TagGenerator' ) ) {
        $tag_generator = WPCF7_TagGenerator::get_instance();
        $tag_generator->add( 'form-field', __( 'form field', 'cf7msm' ), 'cf7msm_form_field_tag_pane' );
    }
    else if ( function_exists( 'wpcf7_add_tag_generator' ) ) {
        wpcf7_add_tag_generator( 'form', __( 'Form value', 'wpcf7' ),
        'wpcf7-tg-pane-form', 'wpcf7_tg_pane_form' );
    }
}
add_action( 'admin_init', 'cf7msm_add_tag_generator_form_field', 30 );

/**
 * Form tag pane.
 */
function cf7msm_form_field_tag_pane( $contact_form, $args = '' ) {

    $args = wp_parse_args( $args, array() );

?>
<div class="control-box cf7msm-multistep">
    <fieldset>
        <legend><?php cf7msm_form_tag_header_text( 'Generate a form-tag to show a field from a previous form in a multistep form' ); ?></legend>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
                    <td><input type="text" name="values" class="tg-name oneline" id="tag-generator-panel-name" />
                        <br>
                        <label for="tag-generator-panel-name">
                            <span class="description">The name of the field from a form in a previous step.</span>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>
    <div class="insert-box">
        <input type="hidden" name="values" value="" />
        <input type="text" name="multiform" class="tag code" readonly="readonly" onfocus="this.select()" />

        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
        </div>

        <br class="clear" />

        <p class="description mail-tag"><label><?php echo esc_html( __( "This field should not be used on the Mail tab.", 'cf7msm' ) ); ?></label>
        </p>
        <?php cf7msm_form_tag_footer_text();?>
    </div>
<?php
}

/**
 * Deprecated way to generate form tag
 */
function wpcf7_tg_pane_form() {
?>
<div id="wpcf7-tg-pane-form" class="hidden">
<form action="">

<table>
<tr><td><?php echo esc_html( __( 'Name of previous form field', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>

<tr>
<td><code>id</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="id" class="idvalue oneline option" /></td>
</tr>
</table>

<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="form" class="tag" readonly="readonly" onfocus="this.select()" /></div>

<div class="tg-mail-tag"><?php echo esc_html( __( "Mail fields currently not supported.", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" readonly="readonly" /></div>
</form>
</div>
<?php
}

?>
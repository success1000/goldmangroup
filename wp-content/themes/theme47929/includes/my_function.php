<?php

	add_filter( 'cherry_slider_params', 'child_slider_params' );
	function child_slider_params( $params ) {
	    $params['minHeight'] = '"100px"';
	    $params['height'] = '"23.71%"';
	return $params;
	}


	function content_plane_shortcode($atts, $content = null) {

	    extract(shortcode_atts(
	        array(
	        'class' => ''
	    ), $atts));

	    $output = '<div class="content_plane '.$class.'">';
	    $output .= do_shortcode($content);
	    $output .= '<div class="clear"></div>';
	    $output .= '</div>';

	    return $output;
	}
	add_shortcode('content_plane', 'content_plane_shortcode');

	function shortcode_recenttesti($atts, $content = null) {
		extract(shortcode_atts(array(
				'num'           => '5',
				'thumb'         => 'true',
				'excerpt_count' => '30',
				'custom_class'  => '',
		), $atts));

		// WPML filter
		$suppress_filters = get_option('suppress_filters');

		$args = array(
				'post_type'        => 'testi',
				'numberposts'      => $num,
				'orderby'          => 'post_date',
				'suppress_filters' => $suppress_filters
			);
		$testi = get_posts($args);

		$output = '<div class="testimonials '.$custom_class.'">';
		
		global $post;
		global $my_string_limit_words;

		foreach ($testi as $k => $post) {
			// Unset not translated posts
			if ( function_exists( 'wpml_get_language_information' ) ) {
				global $sitepress;

				$check              = wpml_get_language_information( $post->ID );
				$language_code      = substr( $check['locale'], 0, 2 );
				if ( $language_code != $sitepress->get_current_language() ) unset( $testi[$k] );

				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, 'testi', true ) );
			}
			setup_postdata($post);
			$excerpt        = get_the_excerpt();
			$testiname      = get_post_meta(get_the_ID(), 'my_testi_caption', true);
			$testiurl       = get_post_meta(get_the_ID(), 'my_testi_url', true);
			$testiinfo      = get_post_meta(get_the_ID(), 'my_testi_info', true);
			$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$url            = $attachment_url['0'];
			$image          = aq_resize($url, 280, 240, true);

			$output .= '<div class="testi-item">';

				$output .= '<div class="testi-meta">';
					if( isset($testiname) ) { 
						$output .= '<div class="user">';
							$output .= $testiname;
						$output .= '</div>';
					}
					
					if( isset($testiinfo) ) { 
						$output .= '<div class="info">(';
							$output .= $testiinfo;
						$output .= ')</div>';
					}
					
				$output .= '</div>';

				$output .= '<blockquote class="testi-item_blockquote">';
					if ($thumb == 'true') {
						if ( has_post_thumbnail($post->ID) ){
							$output .= '<figure class="featured-thumbnail">';
							$output .= '<img src="'.$image.'" alt="" />';
							$output .= '</figure>';
						}
					}
					$output .= '<a href="'.get_permalink($post->ID).'">';
						$output .= my_string_limit_words($excerpt,$excerpt_count);
					$output .= '</a><span class="close_quote"></span><div class="clear"></div>';

				$output .= '</blockquote>';

					
			$output .= '</div>';

		}
		wp_reset_postdata(); // restore the global $post variable

		$output .= '</div>';
		return $output;
	}
	add_shortcode('recenttesti', 'shortcode_recenttesti');

?>
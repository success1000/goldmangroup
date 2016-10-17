<?php
/*
Plugin Name: Profile Link Shortcode
Plugin URI: http://wordpress.org/extend/plugins/profile-link-shortcode/
Description: This plugin adds a shortcode to WordPress with which you can easily display the link to a user's profile.
Version: 0.1
Author: Hannes Hofmann
Author URI: http://uwr1.de/
License: MIT
*/

$hh_profileLinkShortcodeURLTemplate = '<a href="http://uwr1.de/forum/profile/%s">%s</a>';

// [profile user='user_login']
function hh_profile_link_shortcode($atts) {
	global $hh_profileLinkShortcodeURLTemplate;
	extract(shortcode_atts(array(
		'user' => '',
	), $atts));

	if (!$user) { return ''; }

	$u = get_userdatabylogin($user);
	if (!$u) { return ''; }

	$link = sprintf($hh_profileLinkShortcodeURLTemplate, $u->user_nicename, $u->display_name);
	return $link;
}
add_shortcode('profile', 'hh_profile_link_shortcode');

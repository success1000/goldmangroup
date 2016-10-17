=== Profile Link Shortcode ===
Contributors: f00f
Donate link: 
Tags: posts, profiles, shortcode
Requires at least: 2.5
Tested up to: 3.3.2
Stable tag: 0.1

This plugin adds a shortcode to WordPress with which you can easily display the link to a user's profile.

== Description ==

Profile Link Shortcode adds a shortcode to easily display links to user profiles in your blog posts.
This comes handy, e.g., if you want to thank a user for a contribution to the post.

== Installation ==

There are two ways to install this plugin. No matter which method you choose, you have to edit the source code in this version to make it work for you. This does not hurt, see Section Configuration.

Method 1: Use the "Install Plugin" feature of WordPress.

Method 2: Manual installation.
Unzip all files to a folder in your wp-content/plugins directory, go to the plugins page in your admin panel and activate it.

To use the shortcode, add to your posts something like [profile user='admin'].

== Configuration ==

This plugin involves manual configuration.
In the plugin source code file, there is one configuration variable, `$hh_profileLinkShortcodeURLTemplate`, which contains the HTML code template for the profile links. It's a string containing two '%s', the first one gets replaced by the user's login (user_nicename, to be precise), the second one by his/her display name.

== Changelog ==
Version 0.1 (2010-12-20)
Initial plugin version.
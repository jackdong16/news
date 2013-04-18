<?php 
/*
Plugin Name: Chinese UserName
Plugin URI: http://www.01on.com/?p=654
Description: 允许用a-z0-9_.-@和汉字作为用户名
Author: 白云山
Version: 1.0
Author URI: http://www.01on.com/
*/


add_filter( 'sanitize_user', 'ys_sanitize_user',3,3);


function ys_sanitize_user($username, $raw_username, $strict){
	$username = $raw_username;
	$username = strip_tags($username);
	// Kill octets
	$username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
	$username = preg_replace('/&.+?;/', '', $username); // Kill entities

	// If strict, reduce to ASCII and chinese for max portability.
	if ( $strict )
		$username = preg_replace('|[^a-z0-9 _.\-@\x80-\xFF]|i', '', $username);

	// Consolidate contiguous whitespace
	$username = preg_replace('|\s+|', ' ', $username);
	
	return $username;
}
?>
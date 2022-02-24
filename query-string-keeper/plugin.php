<?php
/*
Plugin Name: Query String Keeper
Plugin URI: https://github.com/jessemaps/yourls-query-string-keeper
Description: With this plugin, add a query string to the short URL and it will be included in the long url.
Version: 1.0
Author: Jesse Wickizer
Author URI: http://www.jessewickizer.com
*/

// Hook our custom function into the 'pre_redirect' event
yourls_add_filter( 'redirect_location', 'qs_keeper_redirect' );

// Our custom function that will be triggered when the event occurs
function qs_keeper_redirect($long_url) {
    $query_string = $_SERVER['QUERY_STRING'];
	
	//If original URL doesn't have a query string, return the unaltered original url.
	if ( ! isset( $query_string ) || ( $query_string == '' ) ) {
		return $long_url;
	}

	if ( strpos( $long_url, '?' ) !== false ) {
		$query_string = '&'. $query_string;
	} else {
		$query_string = '?'. $query_string;
	}

	$frag = '';
	// When there is a fragment we need to keep it separate.
	if ( false !== strpos( $long_url, '#' ) ) {
		$frag = explode( '#', $long_url );
		$frag = end( $frag );
	}
	
	return $long_url . $query_string . $frag;
}

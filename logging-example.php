<?php
/*
Plugin Name: Iterators and Variadics
Description: An example of the iterator interface and splat operator (variadics)
Author:      Gary Kovar
Version:     1.0
Author URI:  https://bethematch.org/
*/

// I'm totally dependent on composer for mapping.
require_once trailingslashit( __DIR__ ) . 'vendor/autoload.php';

// Start the core plugin
add_action( 'plugins_loaded', function () {
	logger_example()->init();
}, 1, 0 );

// Normal singleton pattern.
function logger_example() {
	return \Logger\Plugin::instance();
}

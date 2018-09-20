<?php


namespace Logger;

use Logger\Loggers\CLI;
use Logger\Loggers\Database;
use Logger\Loggers\Email;
use Logger\Loggers\Error_Log;

class Plugin {

	protected static $_instance;

	/**
	 * @var Logger_Collection
	 */
	protected $logger_collection;

	public function init() {
		global $wpdb;

		// The Logger_Collection implements iterator and uses a variadic constructor.
		$this->logger_collection = new Logger_Collection(
			new Error_Log(),
			new Email(),
			new Database( $wpdb ),
			new CLI()
		);

		// Simple WP action to distibute logging stuff.
		add_action( 'log_this', [ $this, 'log' ], 10, 3 );

		// These are just examples.
		add_action( 'shutdown', function() {
			do_action( 'log_this', 'Shutdown Action', 'success', 1 );
			do_action( 'log_this', 'Shutdown Action', 'failure', 1 );
			do_action( 'log_this', 'Shutdown Action', 'information', 1 );
		} );
	}

	// If a dev wants to add logging, they can simply: logger_example()->add_logger( new My_New_Logger() );
	// The only requirement is that My_New_Logger must implement the Logger_Interface.
	public function add_logger( $logger ) {
		$this->logger_collection->add( $logger );
	}

	// Here's the iterator in action.
	public function log( $message, $type, $id = 0 ) {
		// Iterate through all Loggers in the collection.
		foreach ( $this->logger_collection  as $logger ) {
			// If the type that was passed is a legit log type, we run that method.
			// The method is known to exist because the list of types matches the methods in the Interface we extend.
			if ( in_array( $type, Logger_Collection::LOG_TYPES, true ) ) {
				$logger->$type( $message, $id );
			}
		}
	}

	// Singleton
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {

			$className       = __CLASS__;
			self::$_instance = new $className();
		}

		return self::$_instance;
	}
}
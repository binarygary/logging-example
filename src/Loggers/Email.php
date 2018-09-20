<?php

namespace Logger\Loggers;

// This logger only does something on failure.
// Note that the methods are required, but they can be empty.
class Email implements Logger_Interface {

	public function success( $message, $id = 0 ) {}

	public function failure( $message, $id = 0 ) {
		wp_mail(
			get_option( 'admin_email' ),
			__( 'Failure Logging', 'logging-example' ),
			sprintf( 'Failure: %s %s', $id, $message )
		);
	}

	public function information( $message, $id = 0 ) {}
}
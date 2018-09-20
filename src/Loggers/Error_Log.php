<?php

namespace Logger\Loggers;

// This is a very standard and simple logger.
class Error_Log implements Logger_Interface {

	public function information( $message, $id = 0 ) {
		error_log( sprintf( 'Information: %s %s', $id, $message ) );
	}

	public function failure( $message, $id = 0 ) {
		error_log( sprintf( 'Failure: %s %s', $id, $message ) );
	}

	public function success( $message, $id = 0 ) {
		error_log( sprintf( 'Success: %s %s', $id, $message ) );
	}

}
<?php

namespace Logger\Loggers;

// Another more complex logger.
class CLI implements Logger_Interface {

	public function information( $message, $id = 0 ) {
		$this->display_message( $message, $id, 'information' );
	}

	public function failure( $message, $id = 0 ) {
		$this->failure_message( $message, $id );
	}

	public function success( $message, $id = 0 ) {
		$this->display_message( $message, $id, 'success' );
	}

	protected function display_message( $message, $id, $type ) {
		if ( ! $this->doing_wp_cli() ) {
			return;
		}

		if ( 'success' === $type ) {
			\WP_CLI::success( $message );
			return;
		}

		\WP_CLI::line( $message );
	}

	protected function failure_message( $message, $id ) {
		if ( ! $this->doing_wp_cli() ) {
			return;
		}

		// Note for testing that an error message in WP_CLI halts execution.
		// You can set a 2nd arg here to false to prevent exit.
		// \WP_CLI::error( $message, false );
		\WP_CLI::error( $message );
	}

	protected function doing_wp_cli() {
		return ( defined( 'WP_CLI' ) && WP_CLI );
	}

}
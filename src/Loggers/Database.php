<?php

namespace Logger\Loggers;

// This shows some more complex logic built around the same 3 methods.
class Database implements Logger_Interface {

	const LOG_TABLE     = 'log_table';
	const TABLE_VERSION = 1;

	protected $wpdb;

	// Inject the dependency.
	public function __construct( \wpdb $wpdb ) {
		$this->wpdb = $wpdb;
	}

	public function success( $message, $id = 0 ) {
		$this->insert( $message, $id, 'success' );
	}

	public function failure( $message, $id = 0 ) {
		$this->insert( $message, $id, 'failure' );
	}

	public function information( $message, $id = 0 ) {
		$this->insert( $message, $id, 'information' );
	}

	// Ultimately all 3 methods call this.
	// Which makes it a great place to create the table.
	protected function insert( $message, $id, $type ) {
		$this->create_table();

		$this->wpdb->insert(
			$this->table_name(),
			[
				'error_id'   => $id,
				'error_type' => $type,
				'message'    => $message,
			]
		);
	}

	protected function table_name() {
		return $this->wpdb->base_prefix . self::LOG_TABLE;
	}

	// I use this pattern a lot when creating tables.
	// Increment the TABLE_VERSION constant if you need to change something.
	public function create_table() {
		$table_version = (int) get_option( self::LOG_TABLE, 0 );
		if ( $table_version === self::TABLE_VERSION ) {
			return;
		}

		$sql =
			"CREATE TABLE {$this->table_name()} (
         id INT(8) NOT NULL auto_increment,
         error_id INT(8) NOT NULL,
         error_type VARCHAR (16),
         message VARCHAR (256),
         PRIMARY KEY  (id)
         )
         COLLATE {$this->wpdb->collate}";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
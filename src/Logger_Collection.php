<?php

namespace Logger;


use Logger\Loggers\Logger_Interface;

// Implement Iterator requires the following methods: current, next, key, valid, rewind.
class Logger_Collection implements \Iterator {

	// Note that these 3 strings match the 3 methods in the Logger_Interface
	const LOG_TYPES = [ 'information', 'success', 'failure' ];

	private $loggers        = [];
	private $current_logger = 0;

	// And here is the variadic (or splat).
	// We can accept any number of args and we've type hinted them as Logger_Interface.
	public function __construct( Logger_Interface ...$loggers ) {
		$this->loggers = $loggers;
	}

	// Enforce the correct type on any future loggers added.
	public function add( Logger_Interface $logger ) {
		$this->loggers[] = $logger;
	}

	public function current() {
		return $this->loggers[ $this->current_logger ];
	}

	public function key() {
		return $this->current_logger;
	}

	public function next() {
		$this->current_logger ++;
	}

	public function rewind() {
		$this->current_logger = 0;
	}

	public function valid() {
		return isset( $this->loggers[ $this->current_logger ] );
	}

}
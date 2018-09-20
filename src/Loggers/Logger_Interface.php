<?php

namespace Logger\Loggers;

// Not a ton happening in here. Note that the 3 methods match the LOG_TYPES array constant in Logger_Collection
interface Logger_Interface {

	public function information( $message, $id = 0 );

	public function success( $message, $id = 0 );

	public function failure( $message, $id = 0 );

}
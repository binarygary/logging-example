# logging-example
An example of the iterator interface and splat operator (variadics).

## Where to look
`src/Logger_Collection.php` \
implements iterator and uses a variadic arg in the constructor. Note that the constructor is type hinted for Logger_Interface.

`src/Plugin.php` \
*line 24:* Creates the Logger_Collection object and passes a bunch of objects. Note that all objects it passes implement the Logger_Interface. \
*line 32:* Handles calls to the logger. Note you could also just `logger_example()->log( $message, $type, $id )`\
*line 48:* In this method, the iterator actually iterates. Because we know the object type we will have available on each loop, we know the available methods.

<?php

namespace JSWrapper\Exceptions;

use Exception;

class UndefinedDefinitionException extends Exception {
    public function __construct($key,$code = 0,Exception $previous = null) {
        $message = "The key [ $key ] is not defined in your definitions";
        parent::__construct($message,$code,$previous);
    }
}
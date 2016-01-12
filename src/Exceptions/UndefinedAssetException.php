<?php

namespace Assets\Exceptions;

use Exception;

class UndefinedAssetException extends Exception
{
    public function __construct($key,$code = 0,Exception $previous = null)
    {
        $message = "This asset was not defined: [ $key ]";
        parent::__construct($message,$code,$previous);
    }
}
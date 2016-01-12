<?php

namespace AssetsWrapper;

use AssetsWrapper\Exceptions\UndefinedDefinitionException;
use Http\Response;

class Engine {

    private $response;
    private $wrapper;
    private $definitions = [];

    public function __construct(Response $response,Wrapper $wrapper,$iniFilePath) {
        $this->response = $response;
        $this->wrapper = $wrapper;
        $this->definitions = parse_ini_file($iniFilePath,false);
    }

    public function serve($key) {
        if (!isset($this->definitions[$key])) throw new UndefinedDefinitionException($key);
        $filenames = explode(" ", $this->definitions[$key]);
        $this->response->setContent($this->wrapper->wrap($filenames));
    }

}
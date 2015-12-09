<?php

namespace JSWrapper;

use Http\Response;
use JSWrapper\Exception\UndefinedDefinitionException;
use Storage\Loader;

class Engine {

    private $response;
    private $loader;
    private $definitions = [];

    public function __construct(Response $response,Loader $loader,$iniFilePath) {
        $this->response = $response;
        $this->loader = $loader;
        $this->definitions = parse_ini_file($iniFilePath,false);
    }

    public function serve($key) {
        if (!isset($this->definitions[$key])) throw new UndefinedDefinitionException($key);
        $content = "";
        foreach (explode(" ",$this->definitions[$key]) as $filename) {
            $content.= $this->loader->load($filename);
        }
        $this->response->setContent($content);
    }

}
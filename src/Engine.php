<?php

namespace Assets;

use Assets\Exceptions\UndefinedDefinitionException;
use Http\Response;

class Engine {

    private $response;
    private $wrapper;
    private $definitions = [];

    /**
     *
     * the Engine serves as base to serve different types of assets
     * an asset consists of an identifier (javascript, stylesheets)
     * associated with a folder path and possibly an extension
     * the engine will create as much assets wrappers as necessary to serve those associations
     * and react to a route like this:
     *
     * /assets/{assetIdentifier}/{specific asset}
     *
     * the Assets can also wrap multiple specific assets through the use of an ini file
     * mapping a specific asset identifier to multiple different files from the folder path
     *
     */

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
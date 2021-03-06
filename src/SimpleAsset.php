<?php

namespace Assets;

use Storage\Loader;

class SimpleAsset implements Asset
{
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function get($what)
    {
        return $this->loader->getAsString($what);
    }

}
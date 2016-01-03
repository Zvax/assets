<?php


namespace JSWrapper;

use Storage\Loader;

class Wrapper
{
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function wrap(array $filenames)
    {
        $js = "";
        foreach($filenames as $file)
        {
            $js.= $this->loader->getAsString($file);
        }
        return $js;
    }

}
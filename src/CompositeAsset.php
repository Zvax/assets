<?php

namespace Assets;

class CompositeAsset implements Asset
{
    private $wrapper;
    private $map;

    public function __construct(Wrapper $wrapper, AssetsMap $map)
    {
        $this->wrapper = $wrapper;
        $this->map = $map;
    }


    public function get($what)
    {
        return $this->wrapper->wrap($this->map->getAssetsFilesArray($what));
    }

}
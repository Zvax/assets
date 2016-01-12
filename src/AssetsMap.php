<?php

namespace Assets;

use Assets\Exceptions\UndefinedDefinitionException;

class AssetsMap
{
    private $map = [];

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function getAssetsFilesArray($key)
    {
        if (!isset($this->map[$key]))
        {
            throw new UndefinedDefinitionException($key);
        }
        return $this->map[$key];
    }

}
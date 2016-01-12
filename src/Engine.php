<?php

namespace Assets;

use Assets\Exceptions\UndefinedAssetException;
use Storage\Loader;

class Engine {

    private $assets = [];

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
     *
     *
     */



    /**
     * @param string $identifier
     * @param Loader $loader
     */

    public function addSimpleAsset($identifier,Loader $loader)
    {
        $this->assets[$identifier] = new SimpleAsset($loader);
    }



    /**
     * @param string $identifier
     * @param array $map
     * @param Loader $loader
     */

    public function addCompositeAsset($identifier,array $map,Loader $loader)
    {
        $wrapper = new Wrapper($loader);
        $assetsMap = new AssetsMap($map);
        $this->assets[$identifier] = new CompositeAsset($wrapper, $assetsMap);
    }

    /**
     * @param string $identifier
     * @param string $key
     * @return string
     * @throws UndefinedAssetException
     */
    public function serve($identifier, $key) {

        if (!isset($this->assets[$identifier]))
        {
            throw new UndefinedAssetException($identifier);
        }

        /** @var Asset $asset */
        $asset = $this->assets[$identifier];
        return $asset->get($key);

    }

}
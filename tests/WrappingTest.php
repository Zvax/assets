<?php

namespace Tests;

use Assets\Engine;
use Assets\Wrapper;
use Storage\FileLoader;

class WrappingTest extends \PHPUnit_Framework_TestCase
{

    private function makeWrapper()
    {
        $loader = new FileLoader(__DIR__."/testjs","js");
        return new Wrapper($loader);
    }

    public function testSimpleAsset()
    {
        $engine = new Engine();
        $engine->addSimpleAsset('javascript', new FileLoader(__DIR__.'/testjs', 'js'));

        $jsString = $engine->serve('javascript', 'base');
        $this->assertInternalType('string', $jsString);

        $this->assertContains("testJsFunction",$jsString);
    }

    /**
     * @expectedException \Assets\Exceptions\UndefinedAssetException
     */
    public function testException()
    {
        $engine = new Engine();
        $engine->serve('javascript', 'base');

        $engine->addSimpleAsset('javascript', new FileLoader(__DIR__.'/testjs', 'js'));

    }

    public function testCompositeAsset()
    {
        $engine = new Engine();
        $map = [
            'default' => [
                'base',
                'base2',
            ],
        ];
        $engine->addCompositeAsset('javascript',$map,new FileLoader(__DIR__.'/testjs', 'js'));

        $jsString = $engine->serve('javascript', 'default');
        $this->assertInternalType('string', $jsString);

        $this->assertContains("testJsFunction",$jsString);
        $this->assertContains("testFunctionSecondFile",$jsString);
    }

}
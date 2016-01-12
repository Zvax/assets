<?php

namespace Tests;

use Assets\Engine;
use Assets\Wrapper;
use Http\HttpResponse;
use Storage\FileLoader;

class WrappingTest extends \PHPUnit_Framework_TestCase
{

    private function makeWrapper()
    {
        $loader = new FileLoader(__DIR__."/testjs","js");
        return new Wrapper($loader);
    }

    public function testBase()
    {
        $response = new HttpResponse();
        $engine = new Engine($response,$this->makeWrapper(),__DIR__."/test.ini");
        $this->assertInstanceOf("\\Assets\\Engine",$engine);

        $engine->serve('default');

        $jsString = $response->getContent();
        $this->assertContains("testJsFunction",$jsString);
    }

    /**
     * @expectedException \Assets\Exceptions\UndefinedDefinitionException
     */
    public function testException()
    {
        $response = new HttpResponse();
        $engine = new Engine($response,$this->makeWrapper(),__DIR__."/test.ini");
        $engine->serve('not-existant');
    }

    public function testWrapping()
    {
        /** @var Wrapper $wrapper */
        $wrapper = $this->makeWrapper();

        $defaultJs = $wrapper->wrap(['base']);
        $this->assertContains("testJsFunction",$defaultJs);

        $defaultJs = $wrapper->wrap(['base','base2']);
        $this->assertContains("testJsFunction",$defaultJs);
        $this->assertContains("testFunctionSecondFile",$defaultJs);

    }

}
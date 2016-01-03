<?php

class WrappingTest extends PHPUnit_Framework_TestCase
{

    private function makeWrapper()
    {
        $loader = new \Storage\FileLoader(__DIR__."/testjs","js");
        return new \JSWrapper\Wrapper($loader);
    }

    public function testBase()
    {
        $response = new \Http\HttpResponse();
        $engine = new \JSWrapper\Engine($response,$this->makeWrapper(),__DIR__."/test.ini");
        $this->assertInstanceOf("\\JSWrapper\\Engine",$engine);

        $engine->serve('default');

        $jsString = $response->getContent();
        $this->assertContains("testJsFunction",$jsString);

        $this->setExpectedException("\\JSWrapper\\Exceptions\\UndefinedDefinitionException");

        $engine->serve('not-existant');
    }

    public function testWrapping()
    {
        /** @var \JSWrapper\Wrapper $wrapper */
        $wrapper = $this->makeWrapper();

        $defaultJs = $wrapper->wrap(['base']);
        $this->assertContains("testJsFunction",$defaultJs);

        $defaultJs = $wrapper->wrap(['base','base2']);
        $this->assertContains("testJsFunction",$defaultJs);
        $this->assertContains("testFunctionSecondFile",$defaultJs);

    }

}
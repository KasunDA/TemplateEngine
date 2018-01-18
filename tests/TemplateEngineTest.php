<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TemplateEngine\TemplateEngine;

class TemplateEngineTest extends TestCase
{
    /*
     * @var TemplateEngine
     */
    private $templateEngine;

    public function setUp()
    {
        $fileLoader = $this->getMockBuilder("\TemplateEngine\FileLoader\FileLoader")->getMock();
        $fileLoader->expects($this->any())
            ->method('load')
            ->with('test.tmpl')
            ->will($this->returnValue(""));

        $expressionParser = $this->getMockBuilder("\TemplateEngine\Expression\ExpressionParser\ExpressionParser")
            ->getMock();
        $expressionParser->expects($this->any())
            ->method('parse')
            ->with(['name' => 'Magdy'])
            ->will($this->returnValue([]));

        $templateRenderer = $this->getMockBuilder("\TemplateEngine\TemplateRenderer\TemplateRenderer")->getMock();
        $templateRenderer->expects($this->any())
            ->method('render')
            ->with('', [])
            ->will($this->returnValue('hello Magdy'));

        $this->templateEngine = new TemplateEngine(
            $expressionParser,
            $templateRenderer,
            $fileLoader
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testViewWithInvalidData()
    {
        $this->templateEngine->view('template.tmpl', []);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testViewWithInvalidTemplateFile()
    {
        $this->templateEngine->view('', ["name" => "Magdy"]);
    }

    /**
     * @dataProvider providerTestViewWithValidParameters
     */
    public function testViewWithValidParameters($templateFile, $data, $expected)
    {
        $this->expectOutputString($expected);
        $this->templateEngine->view($templateFile, $data);
    }

    public function providerTestViewWithValidParameters()
    {
        return [
            'testing a simple case' => [
                'templateFile' => 'test.tmpl',
                'data' => ['name' => 'Magdy'],
                'expected' => 'hello Magdy',
            ],
        ];
    }
}
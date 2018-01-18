<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TemplateEngine\TemplateRenderer\TemplateRenderer;

class TemplateRendererTest extends TestCase
{
    /**
     * @var TemplateRenderer
     */
    private $templateRenderer;

    public function setUp()
    {
        $this->templateRenderer = new TemplateRenderer();
    }

    public function testRenderWithEmptyExpressions()
    {
        $actual = $this->templateRenderer->render('template', []);
        $this->assertEquals('template', $actual);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRenderWithEmptyTemplate()
    {
        $this->templateRenderer->render('', []);
    }

    public function testRenderWithValidParameters()
    {
        $variableExp = $this->getMockBuilder('TemplateEngine\Expression\VariableExpression')
            ->disableOriginalConstructor()
            ->getMock();

        $variableExp->expects($this->any())
            ->method('evaluate')
            ->will($this->returnValue('hello Magdy'));

        $actual = $this->templateRenderer->render('template', [$variableExp]);
        $this->assertEquals('hello Magdy', $actual);
    }
}
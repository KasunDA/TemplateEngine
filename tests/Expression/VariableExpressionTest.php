<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TemplateEngine\Expression\VariableExpression;

class VariableExpressionTest extends TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateWithEmptyParameter()
    {
        $variableExp = new VariableExpression('', '', '');
        $variableExp->evaluate('');
    }

    /**
     * @dataProvider providerTestEvaluateWithValidParameter
     */
    public function testEvaluateWithValidParameter($template, $pattern, $name, $value, $expected)
    {
        $variableExp = new VariableExpression($pattern, $name, $value);
        $actual = $variableExp->evaluate($template);
        $this->assertEquals($expected, $actual);
    }

    public function providerTestEvaluateWithValidParameter()
    {
        return [
            'testing a simple case' => [
                'template' => 'hello {{name}}',
                'pattern' => '/\{\{%s\}\}/',
                'name' => 'name',
                'value' => 'Magdy',
                'expected' => 'hello Magdy',
            ],
            'testing multiple variables' => [
                'template' => 'hello {{firstName}}, {{lastName}}',
                'pattern' => '/\{\{%s\}\}/',
                'name' => 'firstName',
                'value' => 'Magdy',
                'expected' => 'hello Magdy, {{lastName}}',
            ],
            'testing template with new line' => [
                'template' => 'hello
                
                {{NAME}}',
                'pattern' => '/\{\{%s\}\}/',
                'name' => 'NAME',
                'value' => 'Magdy',
                'expected' => 'hello
                
                Magdy',
            ],
        ];
    }
}
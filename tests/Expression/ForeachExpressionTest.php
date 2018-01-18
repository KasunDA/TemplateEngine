<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use TemplateEngine\Expression\ForeachExpression;

class ForeachExpressionTest extends TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateWithEmptyParameter()
    {
        $foreachExp = new ForeachExpression([], '', []);
        $foreachExp->evaluate('');
    }

    /**
     * @dataProvider providerTestEvaluateWithValidParameter
     */
    public function testEvaluateWithValidParameter($template, $patterns, $name, $values, $expected)
    {
        $foreachExp = new ForeachExpression($patterns, $name, $values);
        $actual = $foreachExp->evaluate($template);
        $this->assertEquals($expected, $actual);
    }

    public function providerTestEvaluateWithValidParameter()
    {
        return [
            'testing a simple case' => [
                'template' => '{{#each Stuff}}{{Thing}} are {{Desc}} {{/each}}',
                'patterns' => ['foreach' =>'/\{\{#each %s\}\}.*\{\{\/each\}\}/s'],
                'name' => 'Stuff',
                'values' => [['Thing' => 'roses', 'Desc' => 'red'], ['Thing' => 'violets', 'Desc' => 'blue']],
                'expected' => 'roses are red violets are blue ',
            ],
            'testing unless' => [
                'template' => '{{#each Stuff}}{{Thing}} are {{Desc}}{{#unless @last}},{{else}}!{{/unless}}{{/each}}',
                'patterns' => [
                    'foreach' =>'/\{\{#each %s\}\}.*\{\{\/each\}\}/s',
                    'unless' => '/\{\{#unless @last\}\}.*\{\{else\}\}.*{\{\/unless\}\}/s'
                ],
                'name' => 'Stuff',
                'values' => [['Thing' => 'roses', 'Desc' => 'red'], ['Thing' => 'violets', 'Desc' => 'blue']],
                'expected' => 'roses are red,violets are blue!',
            ]
        ];
    }
}
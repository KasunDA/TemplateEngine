<?php
namespace Tests;

use TemplateEngine\Expression\ExpressionParser\ExpressionParser;
use PHPUnit\Framework\TestCase;

class ExpressionParserTest extends TestCase
{
    public function testParseWithEmptyData()
    {
        $expressionParser = new ExpressionParser();
        $actual = $expressionParser->parse([]);
        $this->assertEquals([], $actual);
    }

    public function testParseWithValidData()
    {
        $expFactory = $this->getMockBuilder('TemplateEngine\Expression\ExpressionFactory\ExpressionFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $ref = new \ReflectionProperty('TemplateEngine\Expression\ExpressionFactory\ExpressionFactory', 'self');
        $ref->setAccessible(true);
        $ref->setValue(null, $expFactory);

        $expFactory->expects($this->any())
            ->method('createVariableExpression')
            ->will($this->returnValue(''));

        $expFactory->expects($this->any())
            ->method('createForeachExpression')
            ->will($this->returnValue(''));

        $expressionParser = new ExpressionParser();
        $actual = $expressionParser->parse(['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3']);
        $this->assertEquals(3, count($actual));
    }

    public function tearDown()
    {
        $ref = new \ReflectionProperty('TemplateEngine\Expression\ExpressionFactory\ExpressionFactory', 'self');
        $ref->setAccessible(true);
        $ref->setValue(null, null);
    }
}
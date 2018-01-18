<?php
namespace TemplateEngine\Expression\ExpressionParser;

use TemplateEngine\Expression\ExpressionFactory\ExpressionFactory;

class ExpressionParser implements ExpressionParserInterface
{
    /**
     * parses the data into array of expressions
     * @param array $data to parse
     * @return array of ExpressionInterface
     */
    public function parse(array $data) : array
    {
        $expressions = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $expressions[] = ExpressionFactory::instance()->createForeachExpression($key, $value);
            } else {
                $expressions[] = ExpressionFactory::instance()->createVariableExpression($key, $value);
            }
        }
        return $expressions;
    }
}
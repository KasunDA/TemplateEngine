<?php
namespace TemplateEngine\Expression\ExpressionParser;

interface ExpressionParserInterface
{
    public function parse(array $data) : array;
}
<?php
namespace TemplateEngine\Expression;

interface ExpressionInterface
{
    public function evaluate(string $template) : string;
}
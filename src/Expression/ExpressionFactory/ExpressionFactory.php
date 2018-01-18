<?php
namespace TemplateEngine\Expression\ExpressionFactory;

use TemplateEngine\Expression\ExpressionInterface;
use TemplateEngine\Expression\VariableExpression;
use TemplateEngine\Expression\ForeachExpression;

class ExpressionFactory
{
    /**
     * This is a Singleton Class
     * @var ExpressionFactory
     */
    protected static $self;

    /**
     * ExpressionFactory constructor made hidden from public use in the Singleton
     */
    protected function __construct()
    {
    }

    /**
     * Only Possible way to access the Factory Class
     * @return ExpressionFactory
     */
    public static function instance()
    {
        if (empty(static::$self)) {
            static::$self = new ExpressionFactory();
        }
        return static::$self;
    }

    /**
     * Create a Variable Expression (assuming a variable can only have letters)
     * @param string $name used for evaluating the expression
     * @param string $value used for replacing the name
     * @throws \InvalidArgumentException
     * @return ExpressionInterface
     */
    public function createVariableExpression(string $name, string $value)
    {
        if (empty($name) || empty($value)) {
            throw new \InvalidArgumentException();
        }

        return new VariableExpression("/\{\{%s\}\}/", $name, $value);
    }

    /**
     * Create a Foreach Expression using given pattern
     * @param string $name used for evaluating the expression
     * @param array $values used for replacing the name
     * @throws \InvalidArgumentException
     * @return ExpressionInterface
     */
    public function createForeachExpression(string $name, array $values)
    {
        if (empty($name) || empty($values)) {
            throw new \InvalidArgumentException();
        }

        return new ForeachExpression(
            [
                'foreach' => "/\{\{#each %s\}\}.*\{\{\/each\}\}/s",
                'unless' => "/\{\{#unless @last\}\}.*\{\{else\}\}.*{\{\/unless\}\}/s"
            ],
            $name,
            $values
        );
    }
}

<?php
namespace TemplateEngine\Expression;

class VariableExpression implements ExpressionInterface
{
    /**
     * The expression pattern
     * @var string
     */
    private $pattern;

    /**
     * The expression name
     * @var string
     */
    private $name;

    /**
     * The expression value
     * @var string
     */
    private $value;

    /**
     * Constructor that passes the dependencies
     * @param string $pattern used for matching the expression
     * @param string $name used for evaluating the expression
     * @param string $value used for replacing the name
     * @throws \InvalidArgumentException
     */
    public function __construct(string $pattern, string $name, string $value)
    {
        if (empty($pattern) || empty($name) || empty($value)) {
            throw new \InvalidArgumentException();
        }

        $this->pattern = $pattern;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Evaluates the expression inside the given template
     * @param string $template before evaluating the expressions inside it
     * @return string the template including the evaluated expressions
     * @throws \InvalidArgumentException
     */
    public function evaluate(string $template) : string
    {
        if (empty($template)) {
            throw new \InvalidArgumentException();
        }

        $pattern = sprintf($this->pattern, $this->name);

        return preg_replace($pattern, $this->value, $template);
    }
}
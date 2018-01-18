<?php
namespace TemplateEngine\Expression;

use TemplateEngine\Expression\ExpressionException\ExpressionMatchingFailedException;

class ForeachExpression implements ExpressionInterface
{
    /**
     * The expression pattern
     * @var array
     */
    private $patterns;

    /**
     * The expression name
     * @var string
     */
    private $name;

    /**
     * The expression values
     * @var array
     */
    private $values;

    /**
     * Constructor that passes the dependencies
     * @param array $patterns used for matching the expression
     * @param string $name used for evaluating the expression
     * @param array $values used for replacing the name
     * @throws \InvalidArgumentException
     */
    public function __construct(array $patterns, string $name, array $values)
    {
        if (empty($patterns) || empty($name) || empty($values)) {
            throw new \InvalidArgumentException();
        }

        $this->patterns = $patterns;
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * constructor description
     * @param string $template before evaluating the expressions inside it
     * @return string the template including the evaluated expressions
     * @throws \InvalidArgumentException
     * @throws  ExpressionMatchingFailedException
     */
    public function evaluate(string $template): string
    {
        if (empty($template)) {
            throw new \InvalidArgumentException();
        }

        $pattern = sprintf($this->patterns['foreach'], $this->name);

        $matched = preg_match($pattern, $template, $match);

        if (!$matched) {
            throw new ExpressionMatchingFailedException();
        }

        $foreachBody = substr($match[0], strpos($match[0], "}}") + 2);
        $foreachBody = substr($foreachBody, 0, strrpos($foreachBody, "{{"));

        $evaluatedExp = "";
        for ($i = 0; $i < count($this->values); $i++) {
            $foreachBodyCopied = $foreachBody;
            foreach ($this->values[$i] as $key => $value) {
                $foreachBodyCopied = str_replace("{{{$key}}}", $value, $foreachBodyCopied);
            }

            if (key_exists('unless', $this->patterns)) {
                $match = [];
                $matched = preg_match($this->patterns['unless'], $foreachBodyCopied, $match);

                if ($matched) {
                    $unlessBody = substr($match[0], strpos($match[0], "@last}}") + 7);
                    $firstArg = substr($unlessBody, 0, strpos($unlessBody, "{{else}}"));

                    $unlessBody = substr($match[0], strpos($match[0], "{{else}}") + 8);
                    $secondArg = substr($unlessBody, 0, strpos($unlessBody, "{{/unless}}"));

                    if ($i + 1 == count($this->values)) {
                        $foreachBodyCopied = preg_replace($this->patterns['unless'], $secondArg, $foreachBodyCopied);
                    } else {
                        $foreachBodyCopied = preg_replace($this->patterns['unless'], $firstArg, $foreachBodyCopied);
                    }
                }
            }

            $evaluatedExp .= $foreachBodyCopied;
        }
        return preg_replace($pattern, $evaluatedExp, $template);
    }
}
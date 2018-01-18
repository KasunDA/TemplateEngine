<?php
namespace TemplateEngine\TemplateRenderer;

class TemplateRenderer implements TemplateRendererInterface
{
    /**
     * evaluating expressions logic
     * @param string $template loaded into memory
     * @param array $expressions of ExpressionInterface
     * @throws \InvalidArgumentException
     * @return string evaluated template
     */
    public function render(string $template, array $expressions) : string
    {
        if (empty($template)) {
            throw new \InvalidArgumentException();
        }

        foreach ($expressions as $exp) {
            $template = $exp->evaluate($template);
        }
        return $template;
    }
}
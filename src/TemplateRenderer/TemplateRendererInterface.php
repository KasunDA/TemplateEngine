<?php
namespace TemplateEngine\TemplateRenderer;

interface TemplateRendererInterface
{
    public function render(string $template, array $expressions) : string;
}
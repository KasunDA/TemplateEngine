<?php
namespace TemplateEngine;

use TemplateEngine\FileLoader\FileLoaderInterface;
use TemplateEngine\Expression\ExpressionParser\ExpressionParserInterface;
use TemplateEngine\TemplateRenderer\TemplateRendererInterface;

class TemplateEngine
{
    /**
     * This service is responsible for parsing correct data into expressions
     * @var ExpressionParserInterface
     */
    private $expressionParser;

    /**
     * This service is responsible for calling the rendering logic of the expressions
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * This service is responsible for loading the file template into memory
     * @var FileLoaderInterface
     */
    private $fileLoader;

    /**
     * constructor that passes dependencies to the class
     * @param ExpressionParserInterface $expressionParser
     * @param TemplateRendererInterface $templateRenderer
     * @param FileLoaderInterface $fileLoader
     * @throws \InvalidArgumentException
     */
    public function __construct(
        ExpressionParserInterface $expressionParser,
        TemplateRendererInterface $templateRenderer,
        FileLoaderInterface $fileLoader
    ) {
        if (empty($expressionParser) || empty($templateRenderer) || empty($fileLoader)) {
            throw new \InvalidArgumentException();
        }

        $this->expressionParser = $expressionParser;
        $this->templateRenderer = $templateRenderer;
        $this->fileLoader = $fileLoader;
    }

    /**
     * view the file template with data
     * @param string $templateFile template file name
     * @param array $data to parse into expressions
     * @throws /InvalidArgumentException
     */
    public function view(string $templateFile, array $data)
    {
        if (empty($data) || empty($templateFile)) {
            throw new \InvalidArgumentException();
        }

        $template = $this->fileLoader->load($templateFile);
        $expressions = $this->expressionParser->parse($data);
        $evaluatedTemplate = $this->templateRenderer->render($template, $expressions);
        echo nl2br($evaluatedTemplate);
    }
}
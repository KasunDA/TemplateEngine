<?php
require_once(__DIR__ . '/vendor/autoload.php');

use TemplateEngine\TemplateEngine;
use TemplateEngine\FileLoader\FileLoader;
use TemplateEngine\Expression\ExpressionParser\ExpressionParser;
use TemplateEngine\TemplateRenderer\TemplateRenderer;

$templateEngine = new TemplateEngine(
    new ExpressionParser(),
    new TemplateRenderer(),
    new FileLoader()
);

$data = [
    'Name' => 'Magdy',
    'Stuff' => [
        ['Thing' => 'roses', 'Desc' => 'red'],
        ['Thing' => 'violets', 'Desc' => 'blue'],
        ['Thing' => 'you', 'Desc' => 'able to solve this'],
        ['Thing' => 'we', 'Desc' => 'interested in you'],
    ]
];

$templateEngine->view('template.tmpl', $data);
$templateEngine->view('extra.tmpl', $data);
$templateEngine->view('test.tmpl', ['var1' => 'Magdy', 'var2' => 'Youssef']);

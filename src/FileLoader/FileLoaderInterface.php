<?php
namespace TemplateEngine\FileLoader;

interface FileLoaderInterface
{
    public function load(string $templateFileName) : string;
}
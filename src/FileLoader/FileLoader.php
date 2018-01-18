<?php
namespace TemplateEngine\FileLoader;

class FileLoader implements FileLoaderInterface
{
    /**
     * The directory to fetch the template files from
     * @var string
     */
    private $templatesDirectory;

    /**
     * Constructor that passes dependencies to the class
     * @param string $templatesDirectory or default to "views"
     */
    public function __construct(string $templatesDirectory = "views")
    {
        $this->templatesDirectory = $templatesDirectory;
    }

    /**
     * Load the template file from the templates directory
     * @param string $templateFileName
     * @throws \InvalidArgumentException
     * @return string template read in memory
     */
    public function load(string $templateFileName) : string
    {
        if (empty($templateFileName)) {
            throw new \InvalidArgumentException();
        }

        return @file_get_contents(getcwd().'\\'. $this->templatesDirectory .'\\'. $templateFileName);
    }
}
<?php
namespace Tests;

use TemplateEngine\FileLoader\FileLoader;
use PHPUnit\Framework\TestCase;

class FileLoaderTest extends TestCase
{
    public function testLoadWithExistingFile()
    {
        $fileLoader = new FileLoader('views');
        $template = $fileLoader->load('simple.tmpl');
        $this->assertEquals('hello world', $template);
    }

    public function testLoadWithNonExistingFile()
    {
        $fileLoader = new FileLoader('views');
        $actual = $fileLoader->load('invalid.tmpl');
        $this->assertEquals(false, $actual);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadWithEmptyParameter()
    {
        $fileLoader = new FileLoader();
        $fileLoader->load('');
    }
}
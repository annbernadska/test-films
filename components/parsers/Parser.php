<?php


abstract class Parser
{
    protected $filePath;

    public function __construct($path)
    {
        $this->filePath = $path;
    }

    abstract public function getContent();
}
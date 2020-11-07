<?php

class ParserTxt extends Parser
{
    public function getContent()
    {
        return file_get_contents($this->filePath);
    }
}

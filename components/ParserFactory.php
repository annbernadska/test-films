<?php


class ParserFactory
{
    public static function getParserObj($data)
    {
        switch ($data['type']){
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return new ParserDoc($data['tmp_name']);
                break;
            case 'text/plain':
                return new ParserTxt($data['tmp_name']);
                break;
            default:
                return false;
                break;
        }
    }
}
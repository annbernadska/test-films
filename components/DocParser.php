<?php

class DocParser
{
    private $filePath;

    public function __construct($path)
    {
        $this->filePath = $path;
    }


    public function getFilms()
    {
        $result = [];
        $fileContent = trim($this->getContent());

        preg_match_all("/Title:([^&]*?)Release Year:/", $fileContent, $titles);
        preg_match_all("/Release Year:([^&]*?)Format:/", $fileContent, $years);
        preg_match_all("/Format:([^&]*?)Stars:/", $fileContent, $format);
        preg_match_all("/Stars:([^&]*?)(Title:|$)/", $fileContent, $stars);

        foreach ($titles[1] as $key => $value) {
            $result[$key]['title'] = trim($value);
            $result[$key]['release_date'] = trim($years[1][$key]);
            $result[$key]['format'] = trim($format[1][$key]);
            $result[$key]['stars'] = explode(',', $stars[1][$key]);
        }

        return $result;
    }

    private function getContent()
    {
        $content = '';
        $filename = $this->filePath;

        $zip = zip_open($filename);

        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
        }
        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
}

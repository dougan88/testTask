<?php

namespace Parser;

interface CsvParserInterface
{
    public function parse();

    public static function fromFile($file, array $option = []);
}
<?php

namespace Parser;

use Parser\Iterator\CsvIterator;
use Parser\Iterator\FileIterator;

class CsvParser implements \IteratorAggregate, CsvParserInterface
{

    /**
     * @var CsvIterator;
     */
    private $iterator;

    /**
     * Returns new instance from CSV file
     *
     * @param string $file   The CSV string to parse
     * @param array  $option Options
     *
     * @throws \InvalidArgumentException
     *
     * @return CsvParser
     */
    public static function fromFile($file, array $option = [])
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException('File not found: ' . $file);
        }

        return new self(new FileIterator($file), $option);
    }

    /**
     * Constructor
     *
     * @param \Iterator $csv The lines of CSV to parse
     * @param array     $option
     */
    public function __construct(\Iterator $csv = null, array $option = array())
    {
        $option = array_merge(array(
            'offset' => 0,
            'limit'  => -1
        ), $option);

        $this->iterator = new CsvIterator($csv, $option);

        if ($option['offset'] > 0 || $option['limit'] > -1) {
            $this->iterator = new \LimitIterator(
                new \CachingIterator($this->iterator, \CachingIterator::FULL_CACHE), $option['offset'], $option['limit']
            );
        }
    }

    /**
     * Parse CSV lines
     *
     * @return array
     */
    public function parse()
    {
        return iterator_to_array($this->iterator);
    }

    /**
     * Retrieve an external iterator
     *
     * @return \Traversable An instance of an object implementing <b>Iterator</b> or <b>Traversable</b>
     */
    public function getIterator()
    {
        return $this->iterator;
    }

}
<?php

namespace Parser;

class RestaurantsProvider
{
    const THROW_INCORRECT_DATA_EXCEPTION = [
        'throw' => true,
        'skip'  => false,
    ];

    const SKIP_BLANK_LINE = [
        'throw' => false,
        'skip'  => true,
    ];

    private $restaurants = [];

    public function __construct(CsvParserInterface $parser,
                                int $dropIncorrectData = self::THROW_INCORRECT_DATA_EXCEPTION['throw'],
                                int $skipBlankLine = self::SKIP_BLANK_LINE['skip'])
    {
        $this->restaurants = $this->removeBlankFields($parser->parse());
        $this->restaurants = $this->removeBlankLines($this->restaurants, $skipBlankLine);
        $this->restaurants = $this->validateDataFormat($this->restaurants, $dropIncorrectData);
    }

    public function getRestaurants()
    {
        return $this->restaurants;
    }

    private function removeBlankFields(array $restaurants)
    {
        foreach ($restaurants as &$restaurant) {
            $restaurant = array_filter($restaurant, function ($value) {
                return (bool)trim($value) ? true : false;
            });

            array_walk($restaurant, function (&$value) {
                $value = trim($value);
            });
        }

        return $restaurants;
    }

    private function removeBlankLines(array $restaurants = [], bool $skipBlankLine = self::SKIP_BLANK_LINE['skip'])
    {
        return array_filter($restaurants, function ($value) use ($skipBlankLine) {
            if(!count($value) && !$skipBlankLine) {
                throw new \Exception('Invalid data format: blank line is forbidden.');
            }

            return count($value) ? true : false;
        });
    }

    private function validateDataFormat(array $restaurants = [], int $dropIncorrectData = self::THROW_INCORRECT_DATA_EXCEPTION['throw'])
    {
        return array_filter($restaurants, function ($value) use ($dropIncorrectData) {

            if (!isset($value[0]) || !isset($value[1]) || !count(array_slice($value, 2))) {

                if ($dropIncorrectData) {
                    throw new \Exception('Invalid data format: required data is missing.');
                } else {
                    return false;
                }
            }

            if (!preg_match('/^\d+$/', $value[0])
                || (!preg_match('/^\d+(\.\d+)?$/', $value[1]))
                || !preg_match('/^[a-z_]+$/', implode('', array_slice($value, 2)))) {

                if ($dropIncorrectData) {
                    throw new \Exception('Invalid data format: incorrect data specified.');
                } else {
                    return false;
                }
            }

            return true;
        });
    }

}
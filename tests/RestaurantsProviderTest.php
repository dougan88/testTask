<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 23.06.17
 * Time: 19:33
 */

use PHPUnit\Framework\TestCase;
use Parser\RestaurantsProvider;

class RestaurantsProviderTest extends TestCase {

    private $parser;

    public function setUp()
    {
        $this->parser = $this->getMockBuilder('Parser\CsvParser')
            ->setMethods(['parse'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    /**
     * @dataProvider getRestaurantsList
     */
    public function testGetRestaurants($restaurantsInput, $restaurantsOutput, $message)
    {
        $this->parser->method('parse')
            ->will($this->returnValue($restaurantsInput));

        $restaurantsProvider = new RestaurantsProvider($this->parser, RestaurantsProvider::THROW_INCORRECT_DATA_EXCEPTION['skip']);

        $this->assertEquals($restaurantsOutput, array_values($restaurantsProvider->getRestaurants()), $message);

    }

    public function getRestaurantsList()
    {
        return [
            [
                [
                    ['1', '0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    ['1', '0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
                'Nothing should be changed here.'
            ],
            [
                [
                    ['1', '0.5', 'fancy_european_water'],
                    [],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    ['1', '0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
                'Blank lines should be removed.'
            ],
            [
                [
                    ['1', '0.5'],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    ['1', '2.5', 'hot_dog'],
                ],
                'Input with no meals specified.'
            ],
            [
                [
                    ['', ''],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    ['1', '2.5', 'hot_dog'],
                ],
                'Data with empty values.'
            ],
            [
                [
                    ['1aaa', 'bbb0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    ['1', '2.5', 'hot_dog'],
                ],
                'Incorrect data types.'
            ]
        ];
    }

    /**
     * @dataProvider getCorruptedRestaurantsList
     */
    public function testCorruptedRestaurantsData($restaurantsInput)
    {
        $this->parser->method('parse')
            ->will($this->returnValue($restaurantsInput));

        $this->expectException(Exception::class);

        $restaurantsProvider = new RestaurantsProvider($this->parser,
            RestaurantsProvider::THROW_INCORRECT_DATA_EXCEPTION['throw'],
            RestaurantsProvider::SKIP_BLANK_LINE['throw']);

        $restaurantsProvider->getRestaurants();
    }

    public function getCorruptedRestaurantsList()
    {
        return [
            [
                [
                    ['1', '0.5', 'fancy_european_water'],
                    [],
                    ['1', '2.5', 'hot_dog'],
                ],
            ],
            [
                [
                    ['1', '0.5'],
                    ['1', '2.5', 'hot_dog'],
                ],
            ],
            [
                [
                    ['', ''],
                    ['1', '2.5', 'hot_dog'],
                ],
            ],
            [
                [
                    ['1aaa', 'bbb0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
            ]
        ];
    }
}
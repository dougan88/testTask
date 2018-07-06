<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 23.06.17
 * Time: 19:33
 */

use PHPUnit\Framework\TestCase;
use PriceCalculator\Calculator;

class CalculatorTest extends TestCase {

    private $restaurantsList;

    public function setUp()
    {
        $this->restaurantsList = $this->getMockBuilder('Formatter\Restaurant')
            ->setMethods(['getRestaurantsList'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        unset($this->restaurantsList);
    }

    /**
     * @dataProvider getRestaurantsList
     */
    public function testCalculateMealsPrices($restaurantsInput, $restaurantsOutput, $suitableRestaurantsIdList, $mealsList)
    {
        $this->restaurantsList->method('getRestaurantsList')
            ->will($this->returnValue($restaurantsInput));

        $priceCalculator = new Calculator($this->restaurantsList);

        $this->assertEquals($restaurantsOutput, $priceCalculator->getPriceList($suitableRestaurantsIdList, $mealsList));
    }

    public function getRestaurantsList()
    {
        return [
            [
                [
                    '1' => [
                        [
                            'meals' => ['fancy_european_water'],
                            'price' => '0.5',
                        ],
                        [
                            'meals' => ['hot_dog'],
                            'price' => '2.5',
                        ]
                    ],
                    '2' => [
                        [
                            'meals' => ['hot_dog'],
                            'price' => '4.5',
                        ]
                    ],
                ],
                [
                    '1' => 2.5
                ],
                [1, 2],
                ['hot_dog'],
            ],
            [
                [
                    '1' => [
                        [
                            'meals' => ['fancy_european_water'],
                            'price' => '0.5',
                        ],
                        [
                            'meals' => ['hot_dog'],
                            'price' => '2.5',
                        ],
                        [
                            'meals' => ['hot_dog', 'fancy_european_water', 'jalapeno_poppers'],
                            'price' => '4.5',
                        ]
                    ],
                    '2' => [
                        [
                            'meals' => ['hot_dog', 'fancy_european_water'],
                            'price' => '3.5',
                        ]
                    ],
                    '3' => [
                        [
                            'meals' => ['test_meal'],
                            'price' => '4.5',
                        ]
                    ],
                ],
                [
                    '1' => 3.0
                ],
                [1, 2],
                ['hot_dog', 'fancy_european_water'],
            ],
            [
                [
                    '1' => [
                        [
                            'meals' => ['fancy_european_water'],
                            'price' => '0.5',
                        ],
                        [
                            'meals' => ['hot_dog'],
                            'price' => '2.5',
                        ],
                        [
                            'meals' => ['hot_dog', 'fancy_european_water', 'jalapeno_poppers'],
                            'price' => '4.5',
                        ]
                    ],
                    '2' => [
                        [
                            'meals' => ['hot_dog', 'fancy_european_water'],
                            'price' => '2.5',
                        ],
                        [
                            'meals' => ['hot_dog', 'fancy_european_water', 'jalapeno_poppers'],
                            'price' => '4.5',
                        ]
                    ],
                    '3' => [
                        [
                            'meals' => ['test_meal'],
                            'price' => '4.5',
                        ]
                    ],
                ],
                [
                    '2' => 2.5
                ],
                [1, 2],
                ['hot_dog', 'fancy_european_water'],
            ],
        ];
    }
}
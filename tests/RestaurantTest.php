<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 23.06.17
 * Time: 19:33
 */

use PHPUnit\Framework\TestCase;
use Formatter\Restaurant;

class RestaurantTest extends TestCase {

    /**
     * @dataProvider restaurantDataProvider
     */
    public function testRestaurantFormatting($restaurantInput, $restaurantOutput)
    {
        $restaurantsList = new Restaurant($restaurantInput);

        $this->assertEquals($restaurantOutput, $restaurantsList->getRestaurantsList());
    }

    public function restaurantDataProvider()
    {
        return [
            [
                [
                    ['1', '0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                ],
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
                ],
            ],
            [
                [
                    ['1', '0.5', 'fancy_european_water'],
                    ['1', '2.5', 'hot_dog'],
                    ['2', '4.5', 'hot_dog'],
                ],
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
            ],
            [
                [
                    ['1', '5.5', 'fancy_european_water', 'jalapeno_poppers', 'extra_salsa'],
                    ['1', '2.5', 'hot_dog'],
                ],
                [
                    '1' => [
                        [
                            'meals' => ['fancy_european_water', 'jalapeno_poppers', 'extra_salsa'],
                            'price' => '5.5',
                        ],
                        [
                            'meals' => ['hot_dog'],
                            'price' => '2.5',
                        ]
                    ],
                ],
            ],
        ];
    }
}
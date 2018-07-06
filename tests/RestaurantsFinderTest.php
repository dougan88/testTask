<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 23.06.17
 * Time: 19:33
 */

use PHPUnit\Framework\TestCase;
use Finder\RestaurantFinder;

class RestaurantsFinderTest extends TestCase {

    public function testGetSuitableRestaurant()
    {

        $restaurantsList = $this->getMockBuilder('Formatter\Restaurant')
            ->setMethods(['getRestaurantMealsList'])
            ->disableOriginalConstructor()
            ->getMock();

        $restaurantsList->method('getRestaurantMealsList')
            ->will($this->returnValue([
                '1' => ['fancy_european_water', 'extra_salsa', 'jalapeno_poppers'],
                '2' => ['fancy_european_water', 'jalapeno_poppers', 'steak_salad_sandwich'],
                '3' => ['steak_salad_sandwich'],

            ]));

        $this->assertEquals([1,2], (new RestaurantFinder())->getSuitableRestaurant($restaurantsList, ['fancy_european_water', 'jalapeno_poppers']));
        $this->assertEquals([], (new RestaurantFinder())->getSuitableRestaurant($restaurantsList, ['hot_dog']));
    }


}
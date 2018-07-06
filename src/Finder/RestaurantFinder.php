<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 16.06.17
 */

namespace Finder;

use Formatter\RestaurantInterface;

class RestaurantFinder
{
    public function getSuitableRestaurant (RestaurantInterface $restaurant, array $mealsQuery = []) : array
    {
        $suitableRestaurants = [];

        $restaurantsList = $restaurant->getRestaurantMealsList();

        foreach ($restaurantsList as $id => $restaurant) {
            if (!count(array_diff($mealsQuery, $restaurant))) {
               array_push($suitableRestaurants, $id);
            }
        }

        return $suitableRestaurants;
    }

}
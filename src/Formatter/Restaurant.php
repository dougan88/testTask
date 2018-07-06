<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 16.06.17
 */

namespace Formatter;

class Restaurant implements RestaurantInterface
{
    private $restaurantsList = [];

    public function __construct(array $restaurantData = [])
    {
        $this->restaurantsList = $this->formatRestaurantData($restaurantData);
    }

    public function getRestaurantsList()
    {
        return $this->restaurantsList;
    }

    public function getRestaurantMealsList()
    {
        $result = [];

        foreach ($this->restaurantsList as $id => $restaurant) {

            $meals = [];

            foreach ($restaurant as $meal) {
                $meals = array_merge($meals, $meal['meals']);
            }
            $result[$id] = array_unique($meals);
        }

        return $result;
    }

    private function formatRestaurantData(array $restaurantData = []) : array
    {
        $restaurantsList = [];

        foreach ($restaurantData as $item) {
            $restaurantId = $this->getRestaurantId($item);

            if (!array_key_exists($restaurantId, $restaurantsList)) {
                $restaurantsList[$restaurantId] = [];
            }
            array_push($restaurantsList[$restaurantId], $this->getMeals($item));
        }

        return $restaurantsList;
    }

    private function getRestaurantId(array $item) : int
    {
        return (int)$item[0];
    }

    private function getMeals(array $item) : array
    {
        $item = array_filter($item);

        $meals = array_slice($item, 2);
        $price = (float)$item[1];

        return [
            'meals' => $meals,
            'price' => $price,
        ];
    }

}
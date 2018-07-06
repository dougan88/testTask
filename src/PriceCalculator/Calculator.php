<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 16.06.17
 */

namespace PriceCalculator;

use Formatter\RestaurantInterface;

class Calculator implements CalculatorInterface
{
    private $restaurantsList = [];

    public function __construct(RestaurantInterface $formatter)
    {
        $this->restaurantsList = $formatter->getRestaurantsList();
    }

    public function getPriceList (array $restaurantsIdList = [], array $mealsQuery = []) : array
    {
        $prices = [];

        foreach ($restaurantsIdList as $id) {
            $pricePositions = $this->getPricePositions($this->restaurantsList[$id], $mealsQuery);
            $positionsMatrix = $this->removeDuplicatesFromPositionsMatrix($this->getPositionsMatrix($pricePositions));
            $minPrice = min($this->calculatePrices($positionsMatrix, $this->restaurantsList[$id]));
            $prices[$id] = $minPrice;
        }

        return $this->getMinimalPrices($prices);
    }

    private function getMinimalPrices(array $prices = []) : array
    {
        if(!count($prices)) {
            return [];
        }

        $minimalPrice = min($prices);

        return array_filter($prices, function ($value) use ($minimalPrice) {
            return $value == $minimalPrice ? true : false;
        });
    }

    private function calculatePrices(array $positionsList = [], array $restaurantMenu = []) : array
    {
        return array_unique(array_map(function ($value) use ($restaurantMenu) {
            $price = 0;

            foreach ($value as $item) {
                $price += $restaurantMenu[$item]['price'];
            }

            return $price;
        }, $positionsList));
    }

    private function getPricePositions (array $restaurant = [], array $meals = []) : array
    {
        $mealsPositions = [];

        foreach ($meals as $meal) {
            $mealsPositions[$meal] = [];
            foreach ($restaurant as $key => $item) {
                if (in_array($meal, $item['meals'])) {
                    array_push($mealsPositions[$meal], $key);
                }
            }
        }

        return $mealsPositions;
    }

    private function getPositionsMatrix(array $mealsPositions = []) : array
    {
        $result = [];
        $mealsPositions = array_values($mealsPositions);

        if (count($mealsPositions) == 1) {
            return $mealsPositions[0];
        }

        $firstMealPositions = array_shift($mealsPositions);
        $otherPositions = $this->getPositionsMatrix($mealsPositions);

        foreach ($firstMealPositions as $firstPosition) {
            foreach ($otherPositions as $otherPosition) {
                $result[] = array_merge((array)$firstPosition, (array)$otherPosition);
            }
        }
        return $result;
    }

    private function removeDuplicatesFromPositionsMatrix(array $positionsMatrix) : array
    {
        return array_map(function ($value) {
            return array_unique((array)$value);
        }, $positionsMatrix);
    }

}
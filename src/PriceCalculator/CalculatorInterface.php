<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 16.06.17
 */

namespace PriceCalculator;

interface CalculatorInterface
{
    public function getPriceList (array $restaurantsIdList = [], array $mealsQuery = []) : array;
}
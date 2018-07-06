<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 16.06.17
 * Time: 13:51
 */

require 'autoload.php';

$mealQuery = $argv[1] ?? null;
$dataFile = $argv[2] ?? null;

if (!$mealQuery || !$dataFile) {
    echo 'Meals list and data file should be specified.' . PHP_EOL;
    die;
}

$mealQuery = explode(',', $mealQuery);
$dataFile = getcwd() . '/' . $dataFile;

try {
    $provider = new Parser\RestaurantsProvider(Parser\CsvParser::fromFile($dataFile));
    $result = $provider->getRestaurants();
} catch (Exception $exception) {
    echo 'Csv parsing error: ' . $exception->getMessage() . PHP_EOL;
    die;
}

$restaurants = new \Formatter\Restaurant($result);
$suitableRestaurants = (new \Finder\RestaurantFinder())->getSuitableRestaurant($restaurants, $mealQuery);

$calc = new \PriceCalculator\Calculator($restaurants);

$priceList = $calc->getPriceList($suitableRestaurants, $mealQuery);

echo 'Program Input ' . PHP_EOL;
echo 'Data file:    ' . $dataFile . PHP_EOL;
echo 'Dinner items: ' . implode(', ', $mealQuery) . PHP_EOL;
echo PHP_EOL;
echo 'Result: ' . PHP_EOL;
if (count($priceList)) {
    foreach ($priceList as $restaurant => $price) {
        echo 'Restaurant: ' . $restaurant . PHP_EOL;
        echo 'Total cost: ' . $price . PHP_EOL;
    }
} else {
    echo 'No matching restaurant could be found.' . PHP_EOL;
}


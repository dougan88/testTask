CLI usage:

php index.php [meal1,meal2,...] [path_to_csv_file]

Example:

php index.php fancy_european_water,extra_salsa testData/test_data.csv

    - Developed using php7.1

    - Program is not suitable for processing huge amounts of data. For processing big data it should be used as a worker for data chunks.

    - Program calculates best price even if one restaurant contains a lot of occurrences of specified meals. Example:

    php index.php fancy_european_water,extra_salsa testData/multiple_occurrences.csv

    1,5.00,fancy_european_water,,
    1,5.00,extra_salsa,,
    1,7.05,fancy_european_water,jalapeno_poppers,extra_salsa
    1,6.05,fancy_european_water,extra_salsa

    Output is:
    Result:
    Restaurant: 1
    Total cost: 6.05

    Works fine for any combinations.

    - Folders structure:
        - Parser - parses csv, returns array.
        - Formatter gets the array and returns formatted objects for restaurants.
        - Finder - gets restaurants objects and finds those which contain specified meals.
        - PriceCalculator - calculates best price for specified restaurants.


Running Tests:
    composer install
    vendor/bin/phpunit tests/

    (tests covering is partial, for real project this would be more solid)
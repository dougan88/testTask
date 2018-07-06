Contents:
1. Test task description.
2. Usage instructions.

1. Test task description:

Instruction:
You have 48 hours to make the solution up to your own standards though I think this is a
problem that can be solved in two to four hours. We will be verifying that your code properly
solves the problem, and also examining the design decisions that you made when writing your
code.
In some cases, I have asked candidates to submit an improved version after their first
submission because the solution doesn&#39;t show any good design though their original solution
works.
Feel free to ask me any questions for clarification of the problem. If you need to make your own
assumptions, please make sure you include them in your submission.
Please submit your solution in PHP.
Challenge:
The mayor of the town of Invoiceville has decided to publish the prices of every item on every
menu of every restaurant in town, all in a single CSV file (Invoiceville is not quite up to date with
modern data serialization methods). In addition, the restaurants of Invoiceville also offer Value
Meals, which are groups of several items, at a discounted price. The mayor has also included
these Value Meals in the file. The file&#39;s format is:
for lines that define a price for a single item:
restaurant ID, price, item label
for lines that define the price for a Value Meal (there can be any number of items in a value
meal)
restaurant ID, price, item 1 label, item 2 label, ...
All restaurant IDs are integers, all item labels are lower case letters and underscores, and the
price is a decimal number.
Because you are an expert software engineer, you decide to write a program that allows the
town to upload their price file and specify a list of item that someone wants to eat for dinner, and
outputs the restaurant they should go to, and the total price it will cost them. It is okay to
purchase extra items, as long as the total cost is minimized.
To clarify:
Your application should accept as input:
● The CSV file containing the list of restaurant item prices
● The items that they would like to eat for dinner
Your application should output:
● The identifier of the restaurant they should visit for dinner
● The total cost of their dinner

Here are some sample data sets, program inputs, and the expected result:
----------------------------
Data File data.csv
1, 4.00, hot_dog
1, 8.00, hamburger
2, 5.00, hot_dog
2, 6.50, hamburger
Program Input
Data file: data.csv
Dinner items: hot_dog, hamburger
Expected Output
Restaurant: 2
Total cost: 11.50
---------------------------
----------------------------
Data File data.csv
3, 4.00, salad
3, 8.00, steak_salad_sandwich
4, 5.00, steak_salad_sandwich
4, 2.50, wine_spritzer
Program Input
Data file: data.csv
Dinner items: salad, wine_spritzer
Expected Output
Restaurant: none (or null or false or something to indicate that no matching restaurant could be
found)
---------------------------
----------------------------
Data File data.csv
5, 4.00, extreme_fajita
5, 8.00, fancy_european_water
6, 5.00, fancy_european_water
6, 6.00, extreme_fajita, jalapeno_poppers, extra_salsa
Program Input
Data file: data.csv
Dinner items: fancy_european_water, extreme_fajita

Expected Output
Restaurant: 6
Total cost: 11.00
---------------------------
I have included all these samples in a single data file, sample_data.csv, which you can
download here.
Please include instructions for how to run your program with your submission.
I look forward to seeing your solution!
_________________________________________________________

2. Usage instructions(CLI):

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
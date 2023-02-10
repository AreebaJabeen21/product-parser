<?php

if ($argc < 2) {
    echo "Usage: php parser.php [file path]\n";
    exit(1);
}

$filePath = $argv[1];

$file = fopen($filePath, 'r');

if (!$file) {
    echo "Unable to open file: $filePath\n";
    exit(1);
}

class Product
{
    public $make;
    public $model;
    public $color;
    public $capacity;
    public $network;
    public $grade;
    public $condition;
}

$header = fgetcsv($file);

$products = [];

while ($data = fgetcsv($file)) {
    $product = new Product();
    $product->make = $data[0];
    $product->model = $data[1];
    $product->color = $data[2];
    $product->capacity = $data[3];
    $product->network = $data[4];
    $product->grade = $data[5];
    $product->condition = $data[6];

    echo "Make: $product->make\n";
    echo "Model: $product->model\n";
    echo "Color: $product->color\n";
    echo "Capacity: $product->capacity\n";
    echo "Network: $product->network\n";
    echo "Grade: $product->grade\n";
    echo "Condition: $product->condition\n";
    echo "\n";

    $products[] = $product;
}

$groupedCount = [];

foreach ($products as $product) {
    $key = "$product->make , $product->model, $product->color, $product->capacity, $product->network, $product->grade, $product->condition";

    if (!isset($groupedCount[$key])) {
        $groupedCount[$key] = 0;
    }

    $groupedCount[$key]++;
}

$groupedCountFile = 'Unique_Combinations.csv';

file_put_contents($groupedCountFile, '');
$counter = 0;
foreach ($groupedCount as $key => $count) {
    $counter ++;
    if ($counter == 1) {
        file_put_contents($groupedCountFile, "Make, Model, Color, Capacity, Network, Grade, Condition, Count \n", FILE_APPEND);
    } else {
        file_put_contents($groupedCountFile, "$key, $count\n", FILE_APPEND);
    }
}

fclose($file);

echo "Grouped count results written to $groupedCountFile\n";

<?php
// Database information.
$serverName ='127.0.0.1';
$userName = 'dbman';
$pass = 'w3Xp7Ug7ZtNQAT5h';
$db_name = 'karlis_barbars';

try {
    // Connect to database
    $conn = new mysqli($serverName, $userName, $pass, $db_name);
    $jsondata = json_decode(file_get_contents('http://lax.lv/nordpool.json'), true);
// If connection wasnt possible, throw out exception.
} catch(SQLException $e){
    echo "Connection failed: " . $e->getMessage();
}

// Current nordpool price
$result = $conn->query("SELECT price FROM nordpool WHERE `time` = ".date('H')."");
$priceNow = $result->fetch_array();
$result = $conn->query("SELECT price FROM nordpool WHERE `time` = ".date('H', strtotime('next hour'))."");
$priceNext = $result->fetch_array();

// The Graph
$data = $jsondata['byPriceToday'];
$graphDate = [];
$graphPrice = [];
foreach($data as $key => $value) {
    $graphDate[] = date('H', strtotime($key)).":00";
    $graphPrice[] = $value;
}
array_multisort($graphDate, $graphPrice);

$frames = [];

$frames[] =  ['text' => "Nordpool"];

$frames[] =  ['icon' => "18854", 
             'text' => date('G:i')];

$frames[] =  ['text' => "Current"];

$frames[] =  ['icon' => "10304", 
             'text' => $priceNow['price']];
        
$frames[] =  ['text' => "Next"];

$frames[] =  ['icon' => "10304", 
             'text' => $priceNext['price']];

$frames[] =  ['chartData' => $graphPrice];


output(['frames' => $frames]);


function output($data) {
    header('Content-Type: application/json');
    die(json_encode($data));
}
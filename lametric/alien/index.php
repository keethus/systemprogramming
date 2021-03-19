<?php 

//$jsonString = file_get_contents('jsonfile.json');
//$jsonData = json_decode($jsonString, true);

// Get the data from particle-argon.
if(empty($_POST['event'])) {
    //echo "No webhooks recieved. <br>";
} elseif($_POST['event'] == 'hook-range') {
    
	$eventData = $_POST['data'];
    $eventData = json_decode($eventData);

    file_put_contents('alien-webhook.json', json_encode($eventData));
}

$jsonData = json_decode(file_get_contents('alien-webhook.json'), true);

if($jsonData['sosmode'] == 0) {
    $sosIcon = "10912";
    $sosMode = "SOS OFF";
} else {
    $sosIcon = "10911";
    $sosMode = "SOS ON";
}

if($jsonData['photosensor'] <= 10) {
    $timeIcon = "1985";
} elseif($jsonData['photosensor'] <= 20) {
    $timeIcon = "26086";
} elseif($jsonData['photosensor'] <= 30) {
    $timeIcon = "8756";
} elseif($jsonData['photosensor'] <= 40) {
    $timeIcon = "11201";
} else {
    $timeIcon = "18854";
}

$seconds_ago = (time() - $jsonData['updated']);

if($seconds_ago >= 31536000) {
    $timeAgo = intval($seconds_ago / 31536000)." years";
} elseif($seconds_ago >= 2419200) {
    $timeAgo = intval($seconds_ago / 2419200)." months";
} elseif($seconds_ago >= 86400) {
    $timeAgo = intval($seconds_ago / 86400)." days";
} elseif($seconds_ago >= 3600) {
    $timeAgo = intval($seconds_ago / 3600)." hours";
} elseif($seconds_ago >= 60) {
    $timeAgo = intval($seconds_ago / 60)." min";
} elseif($seconds_ago >= 30) { 
    $timeAgo = "few sec";
} else {
    $timeAgo = "now";
}

$frames = [];

$frames[] =  ['icon' => "28259",
             'text' => "ALIEN"];

$frames[] =  ['icon' => $timeIcon, 
             'text' => date('G:i')];
        
$frames[] =  ['icon' => $sosIcon, 
             'text' => $sosMode];

$frames[] =  ['icon' => "12110",
             'text' => $jsonData['range']."cm"];

$frames[] =  ['icon' => "8643", 
             'text' => $timeAgo];



output(['frames' => $frames]);


function output($data) {
    header('Content-Type: application/json');
    die(json_encode($data));
}
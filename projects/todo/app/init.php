<?php
// Database details.
$serverName ='127.0.0.1';
$userName = 'dbman';
$pass = 'pass';
$db_name = 'dbname';

// Try to connect to database.
try {
    $conn = new PDO("mysql:host=$serverName;dbname=$db_name", $userName, $pass);

    // Enable Error reporting, and throwing exceptions.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// If connection wasnt possible, throw out exception.
} catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

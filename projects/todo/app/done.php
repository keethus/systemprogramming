<?php

if(!isset($_POST['id'])) {
    // Import database details.
    require './init.php';
    
    $id = $_GET['id'];

    // If empty id echo an error.
    if(empty($id)) {
        echo 'Error! No id was given.';
    } else {
        // Prepare item for changing its done value (Boolean).
        $items = $conn->prepare("SELECT id, done FROM todo WHERE id=?");
        // Pass in the ID, execute action.
        $items->execute([$id]);

        // Fetch item from database.
        $item = $items->fetch();
        $uId = $item['id'];

        $done = $item['done'];

        // Toggle value from 0 to 1 depending on current value stored in database.
        $uDone = $done ? 0 : 1;

        // Push updated information to database.
        $res = $conn->query("UPDATE todo SET done=$uDone WHERE id=$uId");

        // Go back to index.php
        if($res){
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php?mess=error");
        }

    }
// If nothing worked go back to index.php, change link to an error.
} else {
    header("Location: ../index.php?mess=error");
}
<?php

if(!isset($_POST['id'])) {
    // Import database details.
    require './init.php';
    
    $id = $_GET['id'];

    // If empty id echo an error.
    if(empty($id)) {
        echo "Errror! No id was given.";
    } else { 
        // Prepare item for deleting from database.
        $stmt = $conn->prepare("DELETE FROM todo WHERE id=?");
        // Pass in the ID, execute action.
        $res = $stmt->execute([$id]);

        // Go back to index.php
        if($res){
            header("Location: ../index.php");
        } else {
            header("Location: ../index.php?mess=error");
        }
        // Break connection.
        $conn = null;
        exit();
    }
// If nothing worked go back to index.php, change link to an error.
} else {
    header("Location: ../index.php?mess=error");
}
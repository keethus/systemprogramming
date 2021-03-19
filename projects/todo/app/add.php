<?php

if(isset($_POST['item'])) {
    require './init.php';
    
    $name = $_POST['item'];

    if(empty($name)) {
        header("Location: ./index.php?mess=error");
    } else {
        $stmt = $conn->prepare("INSERT INTO todo(name) VALUE(?)");
        $res = $stmt->execute([$name]);

        if($res){
            header("Location: ../index.php");
        } else {
            header("Location: ./index.php");
        }
        $conn = null;
        exit();
    }
} else {
    header("Location: ./index.php?mess=error");
}
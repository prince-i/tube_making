<?php
    $servername = 'localhost';
    $username = 'root';
    $pass = '';
    date_default_timezone_set('Asia/Manila');
    try {
        $conn = new PDO ("mysql:host=$servername;dbname=tube_making",$username,$pass);
    }catch(PDOException $e){
        echo 'NO CONNECTION'.$e->getMessage();
    }
?>
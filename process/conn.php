<?php
    $servername = 'localhost';
    $username = 'root';
    $pass = '';
    date_default_timezone_set('Asia/Manila');
    $server_date = date('Y-m-d H:i:s');
    try {
        $conn = new PDO ("mysql:host=$servername;dbname=tube_making",$username,$pass);
    }catch(PDOException $e){
        echo 'NO CONNECTION'.$e->getMessage();
    }
?>
<?php
    require 'login.php';
    if(isset($_SESSION['username'])){
        $userID = $_SESSION['username'];
        $query = "SELECT *FROM tb_users WHERE userid = '$userID'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchALL() as $x){
                $full_name = $x['full_name'];
                $user_type = $x['user_type'];
            }
        }else{
            session_unset();
            session_destroy();
            header('location: ../index.php');
        }
    }else{
        session_unset();
        session_destroy();
        header('location: ../index.php');
    }
?>
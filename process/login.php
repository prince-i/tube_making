<?php
    require 'conn.php';
    session_start();
    if(isset($_POST['login_btn'])){
       $username = trim($_POST['userID']);
       $pass = trim($_POST['userPass']);
       if(empty($username)){
           echo '<b class="red-text"><center>PLEASE ENTER USER ID</center></b>';
       }elseif(empty($pass)){
            echo '<b class="red-text"><center>PLEASE ENTER PASSWORD</center></b>';
       }else{
        //    CHECK IF EXISTS
        $checkQuery = "SELECT id,user_type FROM tb_users WHERE userid ='$username' AND password = '$pass'";
        $stmt = $conn->prepare($checkQuery);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            // FETCH USER TYPE COLUMN
            foreach($stmt->fetchALL() as $x){
                $userType = $x['user_type'];
                $full_name = $x['full_name'];
            }
            if($userType == 'normal'){
                $_SESSION['username'] = $username;
                header('location: Page/dashboard.php');
            }else{
                $_SESSION['username'] = $username;
                header('location: Page/admin.php');
            }
        }else{
            echo '<center class="red-text" style="font-weight:bold;">WRONG USERNAME/PASSWORD!</center>';
        }
       }
    }

    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header('location: ../index.php');
    }
?>
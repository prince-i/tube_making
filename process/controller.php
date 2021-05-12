<?php
    require 'conn.php';
    $method = $_POST['method'];
    if($method == 'fetch_details_plan'){
        $parts_code_get = trim($_POST['parts_code']);
        // CHECK
        $sql = "SELECT partname,packing_quantity FROM kanban_masterlist WHERE partcode = '$parts_code_get'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        foreach($stmt->fetchALL() as $x){
            echo $x['partname'].'~!~'.$x['packing_quantity'];
        }
    }
?>
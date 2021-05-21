<?php
    include 'conn.php';
    $method = $_POST['method'];
    if($method == 'print_kanban'){
        $partscode = $_POST['partscode'];
        $order_code = $_POST['order_code'];
        $plan_code = $_POST['plan_code'];
        $name = $_POST['name'];
        // SELECT TO SEQUENCE
        $sql = "SELECT *FROM tb_sequence WHERE order_code = '$order_code' AND plan_code ='$plan_code'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchAll() as $x){
                $print_status = $x['print_status'];
            }
            if($print_status == 'new plan'){
                $print_status_new = 'printed';
            }
            if($print_status == 'printed'){
                $print_status_new = 'reprinted';
            }
            if($print_status == 'reprinted'){
                $print_status_new = 'reprinted';
            }
            // SQL
            $update = "UPDATE tb_sequence SET print_status = '$print_status_new', last_print_date ='$server_date' WHERE order_code= '$order_code' AND plan_code = '$plan_code'";
            $upstmt = $conn->prepare($update);
            // $upstmt->execute();
            if($upstmt->execute()){
                // INSERT LOGS
                $logdetail = $name.' print kanban with parts code: '.$partscode. ' and order code: '.$order_code;
                $log = "INSERT INTO tb_history_logs VALUES ('0','$logdetail','$server_date')";
                $stmt=$conn->prepare($log);
                $stmt->execute();
            }
        }else{
        }
    }

    if($method == 'reprint_kanban'){
       $id = $_POST['id_string'];
       $partscode = $_POST['partscode'];
       $order_code = $_POST['order_code'];
       $incharge = $_POST['incharge'];

       $explodedID = explode(",",$id);
       foreach($explodedID as $x){
           $sql  = "SELECT *FROM tb_sequence WHERE id = '$x'";
           $stmt = $conn->prepare($sql);
           $stmt->execute();
           foreach($stmt->fetchAll() as $c){
               $printStat = $c['print_status'];
               $lotNumber = $c['lot_number'];
           }
           if($printStat == 'new plan'){
               $printStat_new = 'printed';
           }
           if($printStat == 'printed'){
            $printStat_new = 'reprinted';
           }
           if($printStat == 'reprinted'){
            $printStat_new = 'reprinted';
           }
        //    SQL
        $update = "UPDATE tb_sequence SET print_status = '$printStat_new', last_print_date ='$server_date' WHERE  id = '$x'";
        $stmt = $conn->prepare($update);
        // $stmt->execute();
        if($stmt->execute()){
            // lOG TO HISTORY
            $msg = $incharge.' reprint a kanban with parts code: '.$partscode. 'and lot number: '.$order_code.'-'.$lotNumber;
            $sql = "INSERT INTO tb_history_logs VALUES ('0','$msg','$server_date')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
       }
    }

?>
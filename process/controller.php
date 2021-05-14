<?php
    include 'conn.php';
    $method = $_POST['method'];
    if($method == 'fetch_details_plan'){
        $parts_code_get = trim($_POST['parts_code']);
        // CHECK
        $sql = "SELECT partname,packing_quantity,qr_code FROM kanban_masterlist WHERE partcode = '$parts_code_get'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        foreach($stmt->fetchALL() as $x){
            echo $x['partname'].'~!~'.$x['packing_quantity'].'~!~'.$x['qr_code'];
        }
    }

    if($method == 'create_plan_method'){
        $partscode = $_POST['partscode'];
        $partsname = $_POST['partsname'];
        $length = $_POST['length'];
        $shift = $_POST['shift'];
        $machine_number = $_POST['machine_number'];
        $setup_number = $_POST['setup_number'];
        $plan = $_POST['plan'];
        $qrcode = $_POST['qrcode'];
        $incharge = $_POST['inCharge'];
        // ORDER CODE
        $initial = 'FL';
        $yearCode = substr(date('y'),-2);
        $monthCode = date('m');
        $dateCode = date('d');
        $order_code = $initial."-".$yearCode."".$monthCode."".$dateCode.$shift."-".$machine_number."".$setup_number;
    
        // VERIFY IF EXISTED
        $verQL = "SELECT parts_code,order_code FROM tb_order WHERE parts_code = '$partscode' AND order_code = '$order_code'";
        $stmt = $conn->prepare($verQL);
        $stmt->execute();
        $stmt->fetchALL();
        if($stmt->rowCount() > 0){
            echo 'exists';
        }else{
        // QUERY FOR TB_ORDER
       $orderQL = "INSERT INTO tb_order (`parts_name`,`parts_code`,`length`,`plan_qty`,`in_charge`,`shift`,`machine_number`,`setup_number`,`order_code`,`qr_code`,`order_date`) VALUES ('$partsname','$partscode','$length','$plan','$incharge','$shift','$machine_number','$setup_number','$order_code','$qrcode','$server_date')";
       $stmt = $conn->prepare($orderQL);
       if($stmt->execute()){
           // GENERATE SEQUENCE
           for($x = 1;$x <= $plan;$x++){
               if(strlen($x) == 1){
                   $seqNum = "00".$x;
               }elseif(strlen($x) == 2){
                   $seqNum = "0".$x;
               }else{
                   $seqNum = $x;
               }
               $sequenceQL = "INSERT INTO tb_sequence (`order_code`,`plan_qty`,`lot_number`,`print_status`) VALUES ('$order_code','$plan','$seqNum','new plan')";
               $stmt = $conn->prepare($sequenceQL);
               $stmt->execute();
           }
           if($x = $plan){
               echo 'done';
           }
       }
     }
    }

?>
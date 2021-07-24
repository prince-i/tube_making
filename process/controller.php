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
        $partscode = strtoupper($_POST['partscode']);
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
        $planCode = date('ymd').'-'.uniqid();
        // VERIFY IF EXISTED
        $verQL = "SELECT parts_code,order_code FROM tb_order WHERE parts_code = '$partscode' AND order_code = '$order_code'";
        $stmt = $conn->prepare($verQL);
        $stmt->execute();
        $stmt->fetchALL();
        if($stmt->rowCount() > 0){
            echo 'exists';
        }else{
        // QUERY FOR TB_ORDER
       $orderQL = "INSERT INTO tb_order (`parts_name`,`parts_code`,`length`,`plan_qty`,`in_charge`,`shift`,`machine_number`,`setup_number`,`order_code`,`qr_code`,`plan_code`,`order_date`) VALUES ('$partsname','$partscode','$length','$plan','$incharge','$shift','$machine_number','$setup_number','$order_code','$qrcode','$planCode','$server_date')";
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
               $sequenceQL = "INSERT INTO tb_sequence (`order_code`,`plan_code`,`plan_qty`,`lot_number`,`print_status`) VALUES ('$order_code','$planCode','$plan','$seqNum','new plan')";
               $stmt = $conn->prepare($sequenceQL);
               $stmt->execute();
           }
           if($x = $plan){
            //    echo 'done';
            $log = $incharge. ' created a plan for '.$partscode. ' with an order code of ' .$order_code;
            $sql = "INSERT INTO tb_history_logs VALUES ('0','$log','$server_date')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            echo 'done';
           }
       }
     }
    }

    if($method == 'fetch_plan'){
        $date_from = $_POST['dateFrom'];
        $date_to = $_POST['dateTo'];
        $code = $_POST['code'];

        $query = "SELECT *FROM tb_order WHERE order_date >= '$date_from 00:00:00' AND order_date <='$date_to 23:59:59' AND parts_code LIKE '$code%'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $c = 0;
            foreach($stmt->fetchALL() as $x){
                $c++;
                echo '<tr style="cursor:pointer;" onclick="get_order_code(&quot;'.$x['order_code'].'~!~'.$x['parts_code'].'~!~'.$x['plan_code'].'&quot;)" class="modal-trigger" data-target="plan_menu">';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$x['parts_name'].'</td>';
                echo '<td>'.$x['parts_code'].'</td>';
                echo '<td>'.$x['length'].'</td>';
                echo '<td>'.$x['plan_qty'].'</td>';
                echo '<td>'.$x['in_charge'].'</td>';
                echo '<td>'.$x['shift'].'</td>';
                echo '<td>'.$x['machine_number'].'</td>';
                echo '<td>'.$x['setup_number'].'</td>';
                echo '<td>'.$x['order_code'].'</td>';
                echo '<td>'.$x['order_date'].'</td>';
                echo '</tr>';
            }
        }else{
            echo '<tr>';
            echo '<td colspan="10">NO DATA</td>';
            echo '</tr>';
        }
    }
    if($method == 'view_master'){
        $key = $_POST['x'];
        $query = "SELECT *FROM kanban_masterlist WHERE partcode LIKE '$key%' OR partname LIKE '$key%' OR qr_code LIKE '$key%'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
           foreach($stmt->fetchALL() as $m){
            echo '<tr>';
            echo '<td>'.$m['partcode'].'</td>';
            echo '<td>'.$m['partname'].'</td>';
            echo '<td>'.$m['packing_quantity'].'</td>';
            echo '<td>'.$m['qr_code'].'</td>';
            echo '</tr>';
           }
        }else{
            echo '<tr>';
            echo '<td colspan="4">NO DATA</td>';
            echo '</tr>';
        }
    }
    if($method == 'prevSequence'){
        $orderCode = trim($_POST['orderCode']);
        $planCode= trim($_POST['planCode']);
        $partsCode = trim($_POST['partsCode']);
        // FETCH ORDERCODE 
        $orderQL = "SELECT parts_code,length,in_charge,plan_qty,plan_code FROM tb_order WHERE order_code = '$orderCode' AND plan_code='$planCode' AND parts_code = '$partsCode'";
        $stmt =$conn->prepare($orderQL);
        $stmt->execute();
        foreach($stmt->fetchALL() as $o){
            $partscode = $o['parts_code'];
            $length = $o['length'];
            $pic = $o['in_charge'];
            $qty = $o['plan_qty'];
        }
    
        $query = "SELECT id,order_code,plan_qty,lot_number, print_status, last_print_date FROM tb_sequence WHERE order_code ='$orderCode' AND plan_code = '$planCode'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchALL() as $x){
                echo '<tr>';
                echo '<td>';
                echo '<p>
                        <label>
                            <input type="checkbox" name="" id="selectLot" class="singleCheck" value="'.$x['id'].'">
                            <span></span>
                        </label>
                    </p>';
                echo '</td>';
                echo '<td>'.$partscode.'</td>';
                echo '<td>'.$x['order_code'].'-'.$x['lot_number'].'</td>';
                echo '<td>'.$length.'</td>';
                echo '<td>'.$pic.'</td>';
                echo '<td>'.strtoupper($x['print_status']).'</td>';
                echo '<td>'.$x['last_print_date'].'</td>';
                echo '</tr>';
            }
        }
    }

    
    // KILL CONNECTION
    $conn = null;
?>
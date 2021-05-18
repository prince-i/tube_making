<?php
    include 'conn.php';
    $method = $_POST['method'];
    if($method == 'displayPlanList'){
        $from = $_POST['dateFrom'];
        $to = $_POST['dateTo'];
        $partsCode = $_POST['partsCode'];
        $shiftCode = $_POST['shiftCode'];
        // QUERY
        $qry = "SELECT *FROM tb_order WHERE order_date >='$from 00:00:00' AND order_date <= '$to 23:59:59' AND parts_code LIKE '$partsCode%' AND shift LIKE '$shiftCode%'";
        $stmt = $conn->prepare($qry);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchALL() as $x){
                echo '<tr style="cursor:pointer;" class="modal-trigger" data-target="plan_menu_admin" onclick="get_plan_del(&quot;'.$x['parts_code'].'~!~'.$x['order_code'].'~!~'.$x['plan_code'].'~!~'.$x['in_charge'].'~!~'.$x['plan_qty'].'~!~'.$x['parts_name'].'&quot;)">';
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

    if($method == 'delete_plan_sequence'){
        $parts_code = $_POST['partsCode'];
        $order_code = $_POST['orderCode'];
        $plan_code = $_POST['planCode'];
        // DELETE FROM TB_ORDER
        $delOrder = "DELETE FROM tb_order WHERE parts_code = '$parts_code' AND order_code ='$order_code' AND plan_code = '$plan_code'";
        $stmt = $conn->prepare($delOrder);
        if($stmt->execute()){
            // DELETE FROM SEQUENCE
            $delSeq = "DELETE FROM tb_sequence WHERE order_code = '$order_code' AND plan_code='$plan_code'";
            $stmt = $conn->prepare($delSeq);
            if($stmt->execute()){
                echo 'deleted';
            }
        }
    }
?>
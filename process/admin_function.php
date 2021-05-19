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

    if($method == 'load_masterlist_admin'){
        $keyword = $_POST['keyword'];
        // QUERY
        $sql = "SELECT *FROM kanban_masterlist WHERE partcode LIKE '$keyword%' OR partname LIKE '$keyword%' OR qr_code LIKE '$keyword%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
           foreach($stmt->fetchAll() as $x){
            echo '<tr>';
            echo '<td>';
                echo '<p>
                        <label>
                            <input type="checkbox" name="" id="selectItem" class="singleCheckMaster" value="'.$x['id'].'" onclick="get_checked_length()">
                            <span></span>
                        </label>
                    </p>';
                echo '</td>';
            echo '<td>'.$x['partcode'].'</td>';
            echo '<td>'.$x['partname'].'</td>';
            echo '<td>'.$x['packing_quantity'].'</td>';
            echo '<td>'.$x['qr_code'].'</td>';
            echo '</tr>';
           }
        }else{
            echo '<tr>';
            echo '<td colspan="4">NO DATA</td>';
            echo '</tr>';
        }
    }
    if($method == 'add_part'){
        $partscode = $_POST['partscode'];
        $partsname = $_POST['partsname'];
        $packing = $_POST['packing'];
        $qr = $_POST['qrCode'];
        // INSERT
        $sql = "INSERT INTO kanban_masterlist (`partcode`,`partname`,`packing_quantity`,`qr_code`) VALUES ('$partscode','$partsname','$packing','$qr')";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    if($method == 'delete_kanban_master_item'){
        $arrayID = [];
        $arrayID = $_POST['arrID'];
        $selectedCount = count($arrayID);
        foreach($arrayID as $x){
            $sql = "DELETE FROM kanban_masterlist WHERE id='$x'";
            $stmt = $conn->prepare($sql);
            if($stmt->execute()){
                $selectedCount = $selectedCount - 1;
            }
        }
        $selectedCount;
        if($selectedCount == 0){
            echo 'done';
        }else{
            echo 'error';
        }
    }

    if($method == 'fetch_users'){
        $x = $_POST['userSearch'];
        $query = "SELECT *FROM tb_users WHERE userid LIKE '$x%' OR full_name LIKE '$x%' OR user_type LIKE '$x%'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchALL() as $x){
                echo '<tr>';
                echo '<td>
                <p>
                    <label>
                        <input type="checkbox" name="" id="checkUser" class="singleCheckUser" onclick="get_user_select()">
                        <span></span>
                    </label>
                </p>    
                </td>';
                echo '<td>'.$x['userid'].
                '</td>';
                echo '<td>'.$x['password'].
                '</td>';
                echo '<td>'.$x['full_name'].
                '</td>';
                echo '<td>'.$x['user_type'].
                '</td>';
                echo '</tr>';
            }
        }else{

        }
    }
?>
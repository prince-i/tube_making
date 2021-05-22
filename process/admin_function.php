<?php
    include 'conn.php';
    require 'session.php';
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
        $name = $_POST['name'];
        // DELETE FROM TB_ORDER
        $delOrder = "DELETE FROM tb_order WHERE parts_code = '$parts_code' AND order_code ='$order_code' AND plan_code = '$plan_code'";
        $stmt = $conn->prepare($delOrder);
        if($stmt->execute()){
            // DELETE FROM SEQUENCE
            $delSeq = "DELETE FROM tb_sequence WHERE order_code = '$order_code' AND plan_code='$plan_code'";
            $stmt = $conn->prepare($delSeq);
            if($stmt->execute()){
                $msg = $name.' deleted a plan with parts code: '.$parts_code. ' and order code: '.$order_code;
                $sql = "INSERT INTO tb_history_logs (`log_detail`,`date_log`) VALUES ('$msg','$server_date')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
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
            $msg = $full_name.' added a new item in kanban masterlist for tube making. Parts code: '.$partscode.' /parts name: '.$partsname.' /packing quantity: '.$packing. ' /QR code: '.$qr;
            $x = "INSERT INTO tb_history_logs (`log_detail`,`date_log`) VALUES ('$msg','$server_date')";
            $stmt = $conn->prepare($x);
            $stmt->execute();
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
            $msg = $full_name. ' deleted data from masterlist';
            $logQL = "INSERT INTO tb_history_logs (`log_detail`,`date_log`) VALUES ('$msg','$server_date')";
            $stmt = $conn->prepare($logQL);
            $stmt->execute();
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
                echo '<tr >';
                echo '<td>
                <p>
                    <label>
                        <input type="checkbox" name="" id="checkUser" class="singleCheckUser" value="'.$x['id'].'" onclick="get_user_select()">
                        <span></span>
                    </label>
                </p>    
                </td>';
                echo '<td class="modal-trigger" data-target="editusermodal" onclick="get_data_user(&quot;'.$x['id'].'~!~'.$x['userid'].'~!~'.$x['password'].'~!~'.$x['full_name'].'~!~'.$x['user_type'].'&quot;)" style="cursor:pointer;">'.$x['userid'].
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
            echo '<tr>';
            echo '<td colspan="5">NO DATA</td>';
            echo '</tr>';
        }
    }

    if($method == 'addUser'){
        $userID = $_POST['userid'];
        $password = $_POST['passwd'];
        $fullname = $_POST['fullname'];
        $usertype = $_POST['usertype'];
        // CHECK USER ID IF EXISTS
        $query = "SELECT *FROM tb_users WHERE userid =  '$userID'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo 'exists';
        }else{
            // INSERT TO DB
            $save = "INSERT INTO tb_users (`userid`,`password`,`full_name`,`user_type`) VALUES ('$userID','$password','$fullname','$usertype')";
            $stmt = $conn->prepare($save);
            if($stmt->execute()){
                // LOGS
                $msg = $full_name.' successfully added '.$fullname.' as '.$usertype.' user.';
                $logQL = "INSERT INTO tb_history_logs (`log_detail`,`date_log`) VALUES ('$msg','$server_date')";
                $stmt = $conn->prepare($logQL);
                $stmt->execute();
            }else{
                echo 'fail';
            }
        }
    }

    if($method == 'deleteUser'){
        $users = [];
        $users = $_POST['userArray'];
        // COUNT ALL USERS TO DELETE
        $selectedUser = count($users);
        foreach($users as $x){
           $sql = "DELETE FROM tb_users WHERE id = '$x'";
           $stmt = $conn->prepare($sql);
           if($stmt->execute()){
            //    EVERY SUCCESSFUL QUERY DEDUCT THE USER COUNT INSIDE THE ARRAY
               $selectedUser = $selectedUser - 1;
           }
        }
        if($selectedUser == 0){
            echo 'done';
        }else{
            echo 'error';
        }
    }

    if($method == 'update_user'){
        $id = $_POST['ref_id'];
        $userid = $_POST['new_userid'];
        $password = $_POST['new_password'];
        $fullname = $_POST['new_fullname'];
        $usertype = $_POST['new_usertype'];
        $sql = "UPDATE tb_users SET userid ='$userid', password ='$password', full_name = '$fullname', user_type = '$usertype' WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'fail';
        }
    }
    if($method == 'output_history'){
        $log_from = $_POST['log_from'];
        $log_to = $_POST['log_to'];
        $search = $_POST['history_key'];
        // SELECT QUERY
        $sql = "SELECT log_detail,date_log FROM tb_history_logs WHERE date_log >= '$log_from 00:00:00' AND date_log<= '$log_to 23:59:59' AND log_detail LIKE '%$search%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $c = 0;
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchAll() as $x){
                $c = $c + 1;
                echo '<tr>';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$x['log_detail'].'</td>';
                echo '<td>'.$x['date_log'].'</td>';
                echo '</tr>';
            }
        }
    }

?>
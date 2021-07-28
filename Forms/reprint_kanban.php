<?php
    include '../process/session.php';
    clearstatcache();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <title>Kanban</title>
    <style>
        table{
            border-collapse:collapse;
            font-family:arial;
            min-height:100vh;
            font-size:20px;
        }
        table, tr, td{
			color:black;
			border: 1px solid black;
			border-width: medium;
		}
        .tubemaking{
            background-color:white;
        }
        @page{
            /*TOP RIGHT BOTTOM LEFT*/
            margin:  1in 1.25in 0.1in 0in;
        }
    </style>
    <script src="../Component/jquery.min.js"></script>
    <script src="../jqueryqrcode/jquery.qrcode.min.js"></script>
    
</head>
<body onafterprint = "log_print()">
<?php

        $idList = $_GET['id'];
        $id = explode(",",$idList);
        $qrID = 0;
        foreach($id as $x){
           $ql = "SELECT plan_code FROM tb_sequence WHERE id = '$x'";
           $stmt = $conn->prepare($ql);
           $stmt->execute();
           foreach($stmt->fetchALL() as $s){
            
              $planUniqList = $s['plan_code'];
           } 
          
        //    ORDER DETAILS
           $order = "SELECT *FROM tb_order WHERE plan_code = '$planUniqList'";
           $stmt = $conn->prepare($order);
           $stmt->execute();
           foreach($stmt->fetchALL() as $order){
               $detail_plan_code = $order['plan_code'];
               $detail_partsname = $order['parts_name'];
               $detail_parts_code = $order['parts_code'];
               $detail_length = $order['length'];
               $detail_inCharge = $order['in_charge'];
               $detail_qrCode = $order['qr_code'];
            

            // LOT NUMBER FETCH
            $lotQL = "SELECT order_code,lot_number FROM tb_sequence WHERE plan_code = '$detail_plan_code' AND id ='$x'";
            $stmt=$conn->prepare($lotQL);
            $stmt->execute();
            foreach($stmt->fetchALL() as $l){
               
        ?>
        
        <!-- <table style="table-layout: fixed; width: 446px;height:200px;" border="1"> -->
        <table style="height:100%;width:100%;table-layout:fixed;" border="1">
        <colgroup>
        <col style="width: 185px">
        <col style="width: 125px">
        <col style="width: 130px">
        <col style="width: 28px">
        </colgroup>
        <tbody>
        <tr>
            <td colspan="">
                Parts Code: 
                <b style="font-size:2.5em;"><?=$detail_parts_code;?></b>
            </td>
            <td>
                Length:
                <b style="font-size:2.5em;">
                    <?=$detail_length;?>
                </b>
            </td>
            <td rowspan="2">
               <center id="qrcode<?=$qrID;?>" ></center>
            </td>
            <td rowspan="5" class="tubemaking">
                <span style="writing-mode:vertical-rl;color:black;font-size:18px;font-weight:bold;">TUBEMAKING</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Parts Name: <b style="font-size:2em;"><?=$detail_partsname;?></b></td>
        </tr>
        <tr style="height:10vh;font-size:1em;font-weight:   bold;">
            <td><center>Inspector Name</center></td>
            <td><center>Operator Name</center></td>
            <td><center>Date</center></td>
        </tr>
        <tr style="height:35vh;">
            <td>
                <center>
                
                </center>
            </td>
            <td>
                <center>
                <!-- <?php
                    if(strlen($detail_inCharge) > 10){
                        echo '<b>'.$detail_inCharge.'</b>';
                    }else{
                        echo '<b style="font-size:30px;">
                        '.$detail_inCharge.'</b>';
                    }
                ?> -->
                </center>
            </td>
            <td>
                <center>
                <b style="font-size:30px;">
                <?=$server_date_only;?>
                </b>
                </center>
                </td>
        </tr>
        <tr style="height:5vh;">
            <td colspan="3" style="background: black;">
                <center style="font-size:30px;color:white;font-weight:bold;">Lot#: <?=$l['order_code']."-".$l['lot_number'];?></center>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
            // ADDED DYNAMIC KANBAN NUMBER BASED TO PLAN
            var qr = '<?=$detail_qrCode?>';
            var qr_kanban = qr.replace('*','<?=$l['lot_number'];?>');
            console.log(qr_kanban);
            generate_qr(qr_kanban);
            function generate_qr(code){
                // $('#qrcode'+<?=$qrID;?>).html(code);
                $('#qrcode'+<?=$qrID;?>).qrcode({
                    text:code,
                    width: 165,
                    height: 165
                });
            }
        </script>
    <?php
        $qrID++;
    }
}
}
?>
    <script src="../Component/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            localStorage.clear();
            window.print();
        });

        function log_print(){
            var id_string = '<?=$idList;?>';
            var partscode = '<?=$detail_parts_code;?>';
            var order_code = '<?=$l['order_code'];?>';
            var incharge = '<?=$detail_inCharge;?>';
            $.ajax({
                url: '../process/log_print.php',
                type: 'POST',
                cache:false,
                data:{
                    method: 'reprint_kanban',
                    id_string:id_string,
                    partscode:partscode,
                    order_code:order_code,
                    incharge:incharge
                },success:function(response){
                    console.log(response);
                }
            });
        }
    </script>

</body>
</html>
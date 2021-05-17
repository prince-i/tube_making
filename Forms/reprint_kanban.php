<?php
    include  '../process/conn.php';
    // $ref = $_GET['order_code'];
    // $parts = $_GET['partscode'];
    // $plancode = $_GET['plancode'];
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
            /* margin-bottom:0.5%; */
            min-height:100vh;
            font-size:20px;
        }
        table, tr, td{
			color:black;
			border: 1px solid black;
			border-width: medium;
		}
        .tubemaking{
            background-color:black;
        }
    </style>
    <script src="../Component/jquery.min.js"></script>
    <script src="../jqueryqrcode/jquery.qrcode.min.js"></script>
    
</head>
<body>
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
        <col style="width: 173px">
        <col style="width: 150px">
        <col style="width: 130px">
        <col style="width: 28px">
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2"><b>Parts Code:</b> <?=$detail_parts_code;?></td>
            <td rowspan="2">
               <center id="qrcode<?=$qrID;?>" ></center>
            </td>
            <td rowspan="5" class="tubemaking">
                <span style="writing-mode:vertical-rl;color:white;font-size:18px;">TUBEMAKING</span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>Parts Name:</b> <?=$detail_partsname;?></td>
        </tr>
        <tr style="height:10px;">
            <td><b><center>Length</center></b></td>
            <td><b><center>PIC</center></b></td>
            <td><b><center>Date</center></b></td>
        </tr>
        <tr>
            <td><center><?=$detail_length;?></center></td>
            <td><center><?=$detail_inCharge;?></center></td>
            <td><center><?=$server_date_only;?></center></td>
        </tr>
        <tr>
            <td colspan=3>
                <center>Lot#: <?=$l['order_code']."-".$l['lot_number'];?></center>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
            generate_qr("<?=$detail_qrCode;?>");
            function generate_qr(code){
                $('#qrcode'+<?=$qrID;?>).qrcode({
                    text:code,
                    width: 128,
                    height: 128
                });
            }
        </script>
    <?php
        $qrID++;
    }
}
}
    ?>
   
    
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>

</body>
</html>
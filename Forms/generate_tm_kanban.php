<?php
    include  '../process/session.php';
    $ref = $_GET['order_code'];
    $parts = $_GET['partscode'];
    $plancode = $_GET['plancode'];
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
<body onafterprint="log_print()">
<?php
        
        $sql = "SELECT parts_name,parts_code,length,in_charge,order_code,qr_code,plan_code FROM tb_order WHERE order_code ='$ref' AND parts_code = '$parts' AND plan_code = '$plancode'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        foreach($stmt->fetchALL() as $x){
            $partsname = $x['parts_name'];
            $parts_code = $x['parts_code'];
            $length = $x['length'];
            $inCharge = $x['in_charge'];
            $orderCode = $x['order_code'];
            $qrcode = $x['qr_code'];
            $planUniq = $x['plan_code'];
        }

        $fetch_sequence = "SELECT lot_number FROM tb_sequence WHERE plan_code = '$planUniq'";
        $stmt = $conn->prepare($fetch_sequence);
        $stmt->execute();
        $id = 0;
        foreach($stmt->fetchALL() as $r){
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
                <b style="font-size:2.5em;"><?=$parts_code;?></b>
            </td>
            <td>  
                Length:
                <b style="font-size:2.5em;"><?=$length;?></b>
            </td>
            <td rowspan="2">
               <center id="qrcode<?=$id;?>" ></center>
            </td>
            <td rowspan="5" class="tubemaking">
                <span style="writing-mode:vertical-rl;color:black;font-size:18px;font-weight:bold;">TUBEMAKING</span>
            </td>
        </tr>
        <tr style="">
            <td colspan="2">Parts Name: <b style="font-size:2em;"><?=$partsname;?></b></td>
        </tr>
        <tr style="height:10vh;font-size:1em;font-weight:   bold;">
            <td><center>Inspector Name</center></td>
            <td><center>Operator Name</center></td>
            <td><center>Date</center></td>
        </tr>
        <tr style="height:35vh;">
            <td>
                <center>
                <!-- <b style="font-size:30px;"><?=$length;?></b> -->
                
                </center>
            </td>
            <td>
                <center>
                    <!-- <?php
                        if(strlen($inCharge) > 10){
                            echo '<b>'.$inCharge.'</b>';
                        }else{
                            echo '<b style="font-size:30px;">'.$inCharge.'</b>';
                        }
                    ?> -->
                </center>
            </td>
            <td>
                <center>
                <b style="font-size:30px;"><?=$server_date_only;?></b>
                </center>
            </td>
        </tr>
        <tr style="height:5vh;">
            <td colspan="3" style="background: black;">
                <center style="font-size:30px;color:white;font-weight:bold;">Lot#: <?=$orderCode."-".$r['lot_number'];?></center>
            </td>
        </tr>
      
        </tbody>
        </table>
        <script>
            // ADDED NEW DYNAMIC QR CODE VALUE COUNT
            // ADDED KANBAN NUMBER
            var qr = '<?=$qrcode;?>';
            var qr_kanban = qr.replace('*','<?=$r['lot_number'];?>');
            console.log(qr_kanban);
            generate_qr(qr_kanban);
            function generate_qr(code){
                // $('#qrcode'+<?=$id;?>).html(code);
                $('#qrcode'+<?=$id;?>).qrcode({
                    text:code,
                    width: 165,
                    height: 165
                });
            }
        </script>
    <?php
        $id++;
        }
    ?>
   
    <script src="../Component/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            localStorage.clear();
            window.print();
        });

        function log_print(){
            var partscode = '<?=$parts_code;?>';
            var order_code = '<?=$ref;?>';
            var plan_code = '<?=$plancode;?>';
            var name = '<?=$full_name;?>';
            $.ajax({
                url: '../process/log_print.php',
                type : 'POST',
                cache: false,
                data:{
                    method:'print_kanban',
                    partscode:partscode,
                    order_code:order_code,
                    plan_code:plan_code,
                    name:name
                },success:function(response){
                    // console.log(response);
                }
            });
        }
    </script>
</body>
</html>
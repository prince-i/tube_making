<?php
    include  '../process/session.php';
    $ref = $_GET['order_code'];
    $parts = $_GET['partscode'];
    $plancode = $_GET['plancode'];
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
        <col style="width: 173px">
        <col style="width: 150px">
        <col style="width: 130px">
        <col style="width: 28px">
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2">Parts Code: <b style="font-size:30px;"><?=$parts_code;?></b></td>
            <td rowspan="2">
               <center id="qrcode<?=$id;?>" ></center>
            </td>
            <td rowspan="5" class="tubemaking">
                <span style="writing-mode:vertical-rl;color:white;font-size:18px;">TUBEMAKING</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Parts Name: <b style="font-size:30px;"><?=$partsname;?></b></td>
        </tr>
        <tr style="height:10px;">
            <td><center>Length</center></td>
            <td><center>PIC</center></td>
            <td><center>Date</center></td>
        </tr>
        <tr>
            <td>
                <center>
                <b style="font-size:30px;"><?=$length;?></b>
                </center>
            </td>
            <td>
                <center>
                    <b style="font-size:30px;"><?=$inCharge;?></b>
                </center>
            </td>
            <td>
                <center>
                <b style="font-size:30px;"><?=$server_date_only;?></b>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan=3>
                <center>Lot#: <?=$orderCode."-".$r['lot_number'];?></center>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
            generate_qr("<?=$qrcode;?>");
            function generate_qr(code){
                $('#qrcode'+<?=$id;?>).qrcode({
                    text:code,
                    width: 128,
                    height: 128
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
                    console.log(response);
                }
            });
        }
    </script>
</body>
</html>
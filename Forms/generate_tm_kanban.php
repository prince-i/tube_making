<?php
    include  '../process/conn.php';
    $ref = $_GET['order_code'];
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
        }
        table, tr, td{
			color:black;
			border: 1px solid black;
			border-width: medium;
		}
        @media print {
            table{
                min-width:100%;
            }
        }
        
    </style>
       <script src="../Component/jquery.min.js"></script>
    <script src="../jqueryqrcode/jquery.qrcode.min.js"></script>
    
</head>
<body>
<?php
        
        $sql = "SELECT parts_name,parts_code,length,in_charge,order_code,qr_code FROM tb_order WHERE order_code ='$ref'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        foreach($stmt->fetchALL() as $x){
            $partsname = $x['parts_name'];
            $parts_code = $x['parts_code'];
            $length = $x['length'];
            $inCharge = $x['in_charge'];
            $orderCode = $x['order_code'];
            $qrcode = $x['qr_code'];
        }

        $fetch_sequence = "SELECT lot_number FROM tb_sequence WHERE order_code = '$ref'";
        $stmt = $conn->prepare($fetch_sequence);
        $stmt->execute();
        $id = 0;
        foreach($stmt->fetchALL() as $r){
        ?>
        
        <!-- <table style="table-layout: fixed; width: 446px;height:200px;" border="1"> -->
        <table style="height:100%;width:100%;table-layout: fixed;" border="1">
        <colgroup>
        <col style="width: 173px">
        <col style="width: 150px">
        <col style="width: 95px">
        <col style="width: 28px">
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2"><b>Parts Code:</b> <?=$parts_code;?></td>
            <td rowspan="2">
               <p class="qr" id="qrcode<?=$id;?>" style="width:100px;"></p>
            </td>
            <td rowspan="5"></td>
        </tr>
        <tr>
            <td colspan="2"><b>Parts Name:</b> <?=$partsname;?></td>
        </tr>
        <tr style="height:10px;">
            <td><b><center>Length</center></b></td>
            <td><b><center>PIC</center></b></td>
            <td><b><center>Date</center></b></td>
        </tr>
        <tr>
            <td><center><?=$length;?></center></td>
            <td><center><?=$inCharge;?></center></td>
            <td><center></center></td>
        </tr>
        <tr>
            <td colspan=3>
                <center><?=$orderCode."-".$r['lot_number'];?></center>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
        generate_qr("<?=$qrcode;?>");
        function generate_qr(code){
                $('#qrcode'+<?=$id;?>).qrcode(code);
            }
        </script>
    <?php
        $id++;
        }
    ?>
   
    

</body>
</html>
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
    <title>Kanban</title>
    <style>
        table{
            border-collapse:collapse;
            font-family:arial;
            margin-bottom:0.5%;
        }
    </style>
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
        foreach($stmt->fetchALL() as $r){
    ?>
        <table style="undefined;table-layout: fixed; width: 446px;height:200px;" border="1">
        <colgroup>
        <col style="width: 173px">
        <col style="width: 150px">
        <col style="width: 95px">
        <col style="width: 28px">
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2"><b>Parts Code:</b> <?=$parts_code;?></td>
            <td rowspan="2" id="qrcode"></td>
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
    <?php
        }
    ?>
    <script src="../Component/jquery.min.js"></script>
    <script>
        generate_qr();
        function generate_qr(){
            var text_qr = '<?=$qrcode;?>';
            
        }
    </script>

</body>
</html>
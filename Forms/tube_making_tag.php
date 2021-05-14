<?php
    include '../process/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tubemaking Tag</title>
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
</head>
<body>
    <div class="row">
    <div class="col s12">
    <?php
        $reference = $_GET['ref'];
        $sql = "SELECT parts_name,parts_code,length,in_charge,order_code FROM tb_order WHERE order_code ='$reference'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        foreach($stmt->fetchALL() as $x){
            $partsname = $x['parts_name'];
            $parts_code = $x['parts_code'];
            $length = $x['length'];
            $inCharge = $x['in_charge'];
            $orderCode = $x['order_code'];
        }

        $fetch_sequence = "SELECT lot_number FROM tb_sequence WHERE order_code = '$reference'";
        $stmt = $conn->prepare($fetch_sequence);
        $stmt->execute();
        foreach($stmt->fetchALL() as $r){
    ?>
    <div class="col s6">
        <div class="card">
            <table style="border:1px solid black;font-size:10px;">
                <tr>
                    <th colspan="3">FURUKAWA</th>
                </tr>
                <tr>
                    <th colspan="3">TUBE MAKING TAG</th>
                </tr>
                <tr >
                    <td>PART NAME</td>
                    <td colspan="2"><?=$partsname;?></td>
                </tr>
                <tr>
                    <td>PARTCODE</td>
                    <td colspan="2"><?=$parts_code;?></td>
                </tr>
                <tr>
                    <td>LENGTH</td>
                    <td colspan="2"><?=$length;?></td>
                </tr>
                <tr>
                    <td>LOT NO.</td>
                    <td colspan="2"><?=$orderCode."-".$r['lot_number'];?></td>
                </tr>
                <tr style="font-size:10px;">
                    <td>
                        <center>
                        <b>PRODUCTION DATE</b>
                        <br>

                        </center>
                    </td>
                    <td>
                        <center>
                        <b>OPERATOR NAME</b>
                        <br>
                        <?=$inCharge;?>
                        </center>
                    </td>
                    <td>
                        <center><b>INSPECTOR NAME</b><br></center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
        }
    ?>
     </div>
    </div>
</body>
</html>
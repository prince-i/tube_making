<?php
    // error_reporting(0);
    require 'conn.php';
    if(isset($_POST['upload'])){
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                //READ FILE
                $csvFile = fopen($_FILES['file']['tmp_name'],'r');
                // SKIP FIRST LINE
                fgetcsv($csvFile);
                // PARSE
                $error = 0;
                while(($line = fgetcsv($csvFile)) !== false){
                    $partcode = $line[0];
                    $partname = $line[1];
                    $qty = $line[2];
                    $qrcode = $line[3];
                    // CHECK IF BLANK DATA
                    if($line[0] == '' || $line[1] == '' || $line[2] == '' || $line[3] == ''){
                        // IF BLANK DETECTED ERROR += 1
                        $error = $error + 1;
                    }else{
                        // CHECK DATA
                    $prevQuery = "SELECT id FROM kanban_masterlist WHERE partcode = '$line[0]'";
                    $res = $conn->query($prevQuery);
                    if($res->rowCount() > 0){
                        $update = "UPDATE kanban_masterlist SET partname = '$partname', packing_quantity = '$qty' , qr_code ='$qrcode' WHERE partcode ='$partcode'";
                        $stmt = $conn->prepare($update);
                        if($stmt->execute()){
                            $error = 0;
                        }else{
                            $error = $error + 1;
                        }
                        
                    }else{
                        $insert = "INSERT INTO kanban_masterlist (`partcode`,`partname`,`packing_quantity`,`qr_code`) VALUES ('$partcode','$partname','$qty','$qrcode')";
                        $stmt = $conn->prepare($insert);
                        if($stmt->execute()){
                            $error = 0;
                        }else{
                            $error = $error + 1;
                        }
                    }
                    }
                }
                
                fclose($csvFile);
               if($error == 0){
                    echo '<script>
                    var x = confirm("SUCCESS! # OF ERRORS '.$error.' ");
                    if(x == true){
                        location.replace("../Page/admin.php");
                    }else{
                        location.replace("../Page/admin.php");
                    }
                </script>'; 
               }else{
                    echo '<script>
                    var x = confirm("WITH ERROR! # OF ERRORS '.$error.' ");
                    if(x == true){
                        location.replace("../Page/admin.php");
                    }else{
                        location.replace("../Page/admin.php");
                    }
                </script>'; 
               }
            }else{
                echo '<script>
                        var x = confirm("CSV FILE NOT UPLOADED! # OF ERRORS '.$error.' ");
                        if(x == true){
                            location.replace("../Page/admin.php");
                        }else{
                            location.replace("../Page/admin.php");
                        }
                    </script>';
            }
        }else{
            echo '<script>
                        var x = confirm("INVALID FILE FORMAT! # OF ERRORS '.$error.' ");
                        if(x == true){
                            location.replace("../Page/admin.php");
                        }else{
                            location.replace("../Page/admin.php");
                        }
                    </script>';
        }
        
    }

    // KILL CONNECTION
    $conn = null;
?>
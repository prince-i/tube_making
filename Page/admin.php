<?php
    require '../process/session.php';
    include '../Component/Modals/logout-modal.php';
    include '../Component/Modals/plan_admin_modal.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../Image/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tube Making Admin | <?=$full_name;?></title>
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <link rel="stylesheet" href="../Component/main.css">
</head>
<body>
<nav class="#263238 blue-grey darken-4">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo"><?=$full_name;?></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#" data-target="master_view_only" class="modal-trigger" onclick="load_masterlist()">Master List</a></li>
        <li><a href="">History Logs</a></li>
        <li><a href="#" data-target="modal-logout" class="modal-trigger">Logout</a></li>
      </ul>
    </div>
  </nav>

<!-- PLAN LIST -->


<div class="row">
    <div class="col s12">
        <!-- BUTTON & SEARCH -->
        <div class="row">
            <div class="col s12">
                <!-- SEARCH -->
                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_from" class="datepicker" placeholder="Date From" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_to" class="datepicker" placeholder="Date To" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="partscode_search" ><label for="keyword">Search Parts Code</label>
                </div>
                <!-- SHIFT -->
                <div class="input-field col l2 m12 s12">
                    <select name="" id="shift_search" class="browser-default z-depth-1" style="border-radius:30px;">
                        <option value="">--SELECT SHIFT--</option>
                        <option value="A">Shift A</option>
                        <option value="B">Shift B</option>
                    </select>
                </div>


                <!-- SEARCH BTN -->
                <div class="input-field col l2 m12 s12">
                    <button class="btn col s12 btn-large #607d8b blue-grey" onclick="load_plan_list()" id="search-plan" style="border-radius:30px;"> Search</button>
                </div>
                <!-- EXPORT -->
                <div class="input-field col l2 m12 s12">
                    <button id="exportBtn" class="btn col s12 btn-large #546e7a blue-grey darken-2" onclick="export_plan('planTable')" style="border-radius:30px;"> Export</button>
                </div>
            </div>
        </div>

        <!-- ORDER/PLAN LIST -->
            <div class="col s12 collection z-depth-1" id="plan_list">
                <table class="centered" id="planTable">
                    <thead style="font-size:12px;">
                        <th>PARTSNAME</th>
                        <th>PARTSCODE</th>
                        <th>LENGTH</th>
                        <th>PLAN QTY</th>
                        <th>IN CHARGE</th>
                        <th>SHIFT</th>
                        <th>MACHINE #</th>
                        <th>SETUP #</th>
                        <th>ORDER CODE</th>
                        <th>ORDER DATE</th>
                    </thead>
                    <tbody id="plan_data"></tbody>
                </table>
            </div>
    </div>
</div>



<!-- /PLAN LIST -->


<script src="../Component/jquery.min.js"></script>
<script src="../materialize/js/materialize.min.js"></script>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $('.modal').modal({
        inDuration: 300,
        outDuration:200
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });
        load_plan_list();
    });

    const load_plan_list =()=>{
        var dateFrom = document.getElementById('date_from').value;
        var dateTo = document.getElementById('date_to').value;
        var partsCode = document.getElementById('partscode_search').value;
        var shiftCode = document.getElementById('shift_search').value;
            $.ajax({
                url:'../process/admin_function.php',
                type: 'POST',
                cache:false,
                data:{
                    method:'displayPlanList',
                    dateFrom:dateFrom,
                    dateTo:dateTo,
                    partsCode:partsCode,
                    shiftCode:shiftCode
                },success:function(response){
                    $('#plan_data').html(response);
                }
            });
    }

    const get_plan_del =(param)=>{
        var data = param.split('~!~');
        document.getElementById('partscode_del').value = data[0];
        document.getElementById('ordercode_del').value = data[1];
        document.getElementById('plan_code_del').value = data[2];
        document.getElementById('partscodeprev').innerHTML = data[0];
        document.getElementById('partsnameprev').innerHTML = data[5];
        document.getElementById('ordercodeprev').innerHTML = data[1];
        document.getElementById('quantityprev').innerHTML = data[4];
        document.getElementById('inchargeprev').innerHTML = data[3];
    }

    const delete_plan_admin =()=>{
        var partsCode = document.getElementById('partscode_del').value;
        var orderCode = document.getElementById('ordercode_del').value;
        var planCode = document.getElementById('plan_code_del').value;
        console.log(planCode);
        $('#delPlanBtn').attr('disabled',true);
        $('#delPlanBtn').html('Deleting...');
        $.ajax({
           url: '../process/admin_function.php' ,
           type: 'POST',
           cache:false,
           data:{
               method:'delete_plan_sequence',
               partsCode:partsCode,
               orderCode:orderCode,
               planCode:planCode
           },success:function(response){
            console.log(response);

            $('#delPlanBtn').attr('disabled',false);
            $('#delPlanBtn').html('Delete');
           }
        });
    }
</script>
</body>
</html>
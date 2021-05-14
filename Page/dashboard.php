<?php
    require '../process/session.php';
    include '../Component/Modals/new_plan.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIC Dashboard | <?=$full_name;?></title>
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <link rel="stylesheet" href="../Component/main.css">
    <link rel="icon" href="../Image/water-hose.png" type="image/png" sizes="16x16">
</head>
<body>
<nav class="#263238 blue-grey darken-4">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo"><?=$full_name;?></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="">Master List</a></li>
        <li><a href="">History</a></li>
        <li><a href=" ">Logout</a></li>
      </ul>
    </div>
  </nav>
<!-- BODY -->

<div class="row">
    <div class="col s12">
        <!-- BUTTON & SEARCH -->
        <div class="row">
            <div class="col s12">
                <div class="input-field col l2 m12 s12">
                    <button class="btn #263238 blue-grey darken-4 col s12 btn-large new-plan modal-trigger" data-target="create-plan" onclick="create_plan()">new plan</button>
                </div>
                <!-- SEARCH -->
                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_from" class="datepicker" placeholder="Date From" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_to" class="datepicker" placeholder="Date To" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="partscode_search" onchange="load_plan_list()"><label for="keyword">Search Parts Code</label>
                </div>
            </div>
        </div>

        <!-- ORDER/PLAN LIST -->
            <div class="col s12 collection z-depth-1" id="plan_list">
                <table class="centered">
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
// VIEW MODAL HACK METHOD
const create_plan =()=>{
    $('#render_modal').load('../Forms/modal-new-plan.php');
}


const load_plan_list =()=>{
    var code = document.querySelector('#partscode_search').value;
    var dateFrom = document.querySelector('#date_from').value;
    var dateTo = document.querySelector('#date_to').value;
    $.ajax({
        url: '../process/controller.php',
        type:'POST',
        cache:false,
        data:{
            method: 'fetch_plan',
            code:code,
            dateFrom:dateFrom,
            dateTo:dateTo
        },success:function(response){
            // console.log(response);
            document.getElementById('plan_data').innerHTML = response;
        }
    }); 

}

const detect_part_info =()=>{
    var parts_code = document.querySelector('#partscode_plan').value;
    // console.log(parts_code);
    $.ajax({
        url: '../process/controller.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'fetch_details_plan',
            parts_code:parts_code
        },success:function(response){
            console.log(response);
            if(response != ''){
                var str = response.split('~!~');
                document.querySelector('#partsname_plan').value = str[0];
                document.querySelector('#length_plan').value = str[1];
                document.querySelector('#qr_code_tubemaking').value = str[2];
                document.querySelector('#partscode_plan').disabled = true;
            }else{
                document.querySelector('#partsname_plan').value = '';
                document.querySelector('#length_plan').value = '';
                document.querySelector('#qr_code_tubemaking').value = '';
                M.toast({
                    html:'INVALID PARTS CODE, PLEASE VERIFY',
                    classes:'red rounded'
                });
            }
        }
    });
}

const save_plan =()=>{
    var partscode = document.querySelector('#partscode_plan').value;
    var partsname = document.querySelector('#partsname_plan').value;
    var length = document.querySelector('#length_plan').value;
    var shift = document.querySelector('#shift_plan').value;
    var machine_number = document.querySelector('#machine_num_plan').value;
    var setup_number = document.querySelector('#setup_num_plan').value;
    var plan = document.querySelector('#planQty').value;
    var qrcode = document.querySelector('#qr_code_tubemaking').value;
    var inCharge = '<?=$full_name;?>';
    if(partscode == ''){
        swal('Empty Parts Code!','','info');
    }else if(partsname == ''){
        swal('Empty Parts Name!','','info');
    }else if(length == ''){
        swal('Empty length!','','info');
    }else if(shift == ''){
        swal('Empty Shift!','','info');
    }else if(machine_number == ''){
        swal('Empty Machine Number!','','info');
    }else if(plan == ''){
        swal('Please Enter Plan!','','info');
    }else if(plan <= 0){
        swal('Invalid Plan!','','info');
    }else{
        // SAVING
        document.querySelector('#planBtnCreate').disabled = true;
        document.querySelector('#status_create').innerHTML = 'SAVING & GENERATING SEQUENCE. PLEASE WAIT AND DO NOT RELOAD THE PAGE!';
        $('#loader').fadeIn(500);
        $.ajax({
            url: '../process/controller.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'create_plan_method',
                partscode:partscode,
                partsname:partsname,
                length:length,
                shift:shift,
                machine_number:machine_number,
                setup_number:setup_number,
                plan:plan,
                qrcode:qrcode,
                inCharge:inCharge
            },success:function(response){
                if(response == 'done'){
                    swal('Successful!','','success');
                    $('.modal').modal('close','#create-plan');
                    load_plan_list();
                }else if(response == 'exists'){
                    swal('Process already exists!','','info');
                    $('#loader').fadeOut(100);
                }else{
                    swal('Error!','','info');
                }
                document.querySelector('#planBtnCreate').disabled = false;
                document.querySelector('#status_create').innerHTML = '';
            }
        });
    }
}
    </script>
</body>
</html>
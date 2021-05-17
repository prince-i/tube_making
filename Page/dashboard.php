<?php
    require '../process/session.php';
    include '../Component/Modals/new_plan.php';
    include '../Component/Modals/plan_modal_menu.php';
    include '../Component/Modals/masterlist_view_only.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="../Image/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIC Dashboard | <?=$full_name;?></title>
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <link rel="stylesheet" href="../Component/main.css">
</head>
<body>
<nav class="#263238 blue-grey darken-4">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo"><?=$full_name;?></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#" data-target="master_view_only" class="modal-trigger">Master List</a></li>
        <li><a href="">History</a></li>
        <li><a href="">Logout</a></li>
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
                    <input type="text" name="" id="partscode_search" ><label for="keyword">Search Parts Code</label>
                </div>
                <!-- SEARCH BTN -->
                <div class="input-field col l2 m12 s12">
                    <button class="btn col s12 btn-large #607d8b blue-grey" onclick="load_plan_list()" id="search-plan"> Search</button>
                </div>
                <!-- EXPORT -->
                <div class="input-field col l2 m12 s12">
                    <button id="exportBtn" class="btn col s12 btn-large #546e7a blue-grey darken-2" onclick="export_plan('planTable')"> Export</button>
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

const get_order_code =(orderCode)=>{
    $('#orderCodeReference').val(orderCode);
}

const printTag =()=>{
    var ref = $('#orderCodeReference').val();
    window.open('../Forms/tube_making_tag.php?ref='+ref,'Tube Making Tag',"width=1000,height=600");
}

const printKanban =()=>{
    var code = $('#orderCodeReference').val();
    window.open('../Forms/generate_tm_kanban.php?order_code='+code,'Kanban','width=1000,height=600');
}

function export_plan(table_id, separator = ',') {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'TubeMaking_Logs'+ '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


function load_masterlist(){
    var x = document.querySelector('#masterSearch').value;
    var ajax = new XMLHTTPRequest();
    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var response = this.responseText;

        }
    }
    ajax.open("POST","",true);
    ajax.send();
}
</script>
</body>
</html>
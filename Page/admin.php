<?php
    require '../process/session.php';
    include '../Component/Modals/logout-modal.php';
    include '../Component/Modals/plan_admin_modal.php';
    include '../Component/Modals/masterlist_admin.php';
    include '../Component/Modals/add_masterlist.php';
    include '../Component/Modals/upload_masterlist.php';
    include '../Component/Modals/user_management.php';
    include '../Component/Modals/add_user.php';
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
        <li><a href="#" data-target="masterlist_admin" class="modal-trigger" onclick="load_masterlist()">Master List</a></li>
        <li><a href="#" class="modal-trigger" data-target="manage_user" onclick="load_users()">Manage Users</a></li>
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
        $('input:text').attr('autocomplete','off');
        load_plan_list();
        $('#checkbox_control button').attr('disabled',true);
        $('#user_control button').attr('disabled',true);
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
            $('#delPlanBtn').attr('disabled',false);
            $('#delPlanBtn').html('Delete');
            $('.modal').modal('close','#plan_menu_admin');
            load_plan_list();
           }
        });
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

function export_masterlist(table_id, separator = ',') {
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
    var filename = 'TubeMaking_Masterlist'+ '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
const load_masterlist =()=>{
    var keyword = document.querySelector('#searchKey').value;
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache:false,
        data:{
            method: 'load_masterlist_admin',
            keyword:keyword
        },success:function(response){
            $('#masterData').html(response);
            get_checked_length();
        }
    });
    
}
const saveItem =()=>{
    var partscode = $('#new_partcode').val();
    var partsname = $('#new_partname').val();
    var packing = $('#new_packingQty').val();
    var qrCode = $('#new_qrcode').val();
    if(partscode == ''){
        swal('Enter Parts Code!','','info');
    }else if(partsname == ''){
        swal('Enter Parts Name!','','info');
    }else if(packing == ''){
        swal('Enter Packing Quantity!','','info');
    }else if(packing < 0){
        swal('Invalid Packing Quantity!','','info');
    }else{
        $.ajax({
        url:'../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'add_part',
            partscode:partscode,
            partsname:partsname,
            packing:packing,
            qrCode:qrCode
        },success:function(response){
            if(response == 'success'){
                clear();
                // $('.modal').modal('close','#create-master-item');
                swal('Success!','','success');
                load_masterlist();
            }else{
                swal('Error!','','error');
            }
        }
        });
    }
}

const clear =()=>{
    $('#new_partcode').val('');
    $('#new_partname').val('');
    $('#new_packingQty').val('');
    $('#new_qrcode').val('');
}

// CHECK ALL CHECKBOX
const select_all_master =()=>{
    var all_button = document.getElementById('selectmaster_all');
    if(all_button.checked == true){
        $('.singleCheckMaster').each(function(){
            this.checked = true;
        });
    }else{
        $('.singleCheckMaster').each(function(){
            this.checked = false;
        });
    }
    get_checked_length();
}

// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_length =()=>{
    var checkedArr = [];
    $('input.singleCheckMaster:checkbox:checked').each(function(){
        checkedArr.push($(this).val());
    });
    var number_of_selected = checkedArr.length;
    // console.log(number_of_selected);
    if(number_of_selected > 0){
        // $('#checkbox_control').fadeIn(500);
        $('#checkbox_control button').attr('disabled',false);
    }else{
        $('#checkbox_control button').attr('disabled',true);
    }
}

const uncheck_all =()=>{
    var select_all = document.getElementById('selectmaster_all');
    select_all.checked = false;
    $('.singleCheckMaster').each(function(){
        this.checked=false;
    });
    get_checked_length();
}

// GET VALUES TO DELETE
const get_masterlist_value =()=>{
    var arrID = [];
    $('input.singleCheckMaster:checkbox:checked').each(function(){
        arrID.push($(this).val());
    });
    var validateSelect = arrID.length;
    if(validateSelect > 0){
        var x = confirm('CONFIRM DELETE. PLEASE CLICK OK!');
        if(x == true){
            // console.log('confirm');
            $.ajax({
                url: '../process/admin_function.php',
                type: 'POST',
                cache: false,
                data:{
                    method: 'delete_kanban_master_item',
                    arrID:arrID
                },success:function(response){
                    if(response == 'done'){
                        swal('SUCCESSFULLY DELETED!','','success');
                        load_masterlist();
                    }else{
                        swal('Error','','error');
                    }
                    get_checked_length();
                }
            });
        }else{
            // DO NOTHING
        }
    }else{
        swal('NO ITEM IS SELECTED','','info');
    }
}

const load_users =()=>{
    var userSearch = document.querySelector('#searchUser').value;
    $.ajax({
        url: '../process/admin_function.php',
        type:'POST',
        cache: false,
        data:{
            method: 'fetch_users',
            userSearch:userSearch
        },success:function(response){
            document.querySelector('#userData').innerHTML = response;
            get_user_select();
        }
    });
}

const select_all_user =()=>{
    var thisbutton = document.querySelector('#check_all_user');
    if(thisbutton.checked == true){
        $('.singleCheckUser').each(function(){
            this.checked = true;
        });
    }else{
        $('.singleCheckUser').each(function(){
            this.checked = false;
        });
    }
    get_user_select();
}

const get_user_select =()=>{
    var checkedArr = [];
    $('input.singleCheckUser:checkbox:checked').each(function(){
        checkedArr.push($(this).val());
    });
    var number_of_selected = checkedArr.length;
    // console.log(number_of_selected);
    if(number_of_selected > 0){
        $('#user_control button').attr('disabled',false);
    }else{
        $('#user_control button').attr('disabled',true);
    }
}

const uncheck_all_user =()=>{
    var select_all = document.getElementById('check_all_user');
    select_all.checked = false;
    $('.singleCheckUser').each(function(){
        this.checked=false;
    });
    get_user_select();
}


const saveUser =()=>{
    var userid = $('#addUserID').val();
    var passwd = $('#addPassword').val();
    var fullname = $('#addFullname').val();
    var usertype = $('#addUsertype').val();
    if(userid == '' || passwd == '' || fullname == '' || usertype == ''){
        swal('Please complete all fields!','','info');
    }else{
        $.ajax({
            url: '../process/admin_function.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'addUser',
                userid:userid,
                passwd:passwd,
                fullname:fullname,
                usertype:usertype
            },success:function(response){
                if(response == 'exists'){
                    swal('User already exists!','','info');
                }else if(response == 'save'){
                    swal('User added successfully!','','info');
                    load_users();
                    clear_add();
                }else{
                    swal('User failed to add!','','info');
                }
            }
        });
    }
}

const get_to_delete_user =()=>{
    var userArray = [];
    $('input.singleCheckUser:checkbox:checked').each(function(){
        userArray.push($(this).val());
    });
    var val_selected_user = userArray.length;
    if(val_selected_user > 0){
        var x = confirm("Click OK to confirm deletion!");
        if(x == true){
            // DELETE AJAX
            $.ajax({
                url: '../process/admin_function.php',
                type: 'POST',
                cache: false,
                data:{
                    method: 'deleteUser',
                    userArray:userArray
                },success:function(response){
                   if(response == 'done'){
                    swal('SUCCESSFULLY DELETED!','','info');
                    load_users();
                   }else{
                       swal('Error to delete!','','info');
                   }
                   get_user_select();
                }
            });
        }else{
            // DO NOTHING
        }
    }else{
        swal('NO USER IS SELECTED','','info');
    }
}


const clear_add =()=>{
    document.querySelector('#addUserID').value = '';
    document.querySelector('#addPassword').value = '';
    document.querySelector('#addFullname').value = '';
    document.querySelector('#addUsertype').selectedIndex = 0;
}

</script>
</body>
</html>
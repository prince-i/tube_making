<?php
    require '../process/session.php';
    include '../Component/Modals/new_plan.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../Image/water-hose.png" type="image/x-icon">
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
                    <button class="btn #263238 blue-grey darken-4 col s12 btn-large new-plan">new plan</button>
                </div>
                <!-- SEARCH -->
                <div class="input-field col l4 m12 s12 right">
                    <input type="text" name="" id="keyword"><label for="keyword">Search</label>
                </div>
            </div>
        </div>

        <!-- ORDER/PLAN LIST -->
            <div class="col s12 collection z-depth-1" id="plan_list">
                <table class="centered">
                    <thead>
                        <th>PARTSNAME</th>
                        <th>PARTSCODE</th>
                        <th>LENGTH</th>
                        <th>PLAN QTY</th>
                        <th>IN CHARGE</th>
                        <th>SHIFT</th>
                        <th>MACHINE #</th>
                        <th>ORDER CODE</th>
                        <th>ORDER DATE</th>
                    </thead>
                </table>
            </div>
    </div>
</div>



    <script src="../Component/jquery.min.js"></script>
    <script src="../materialize/js/materialize.min.js"></script>
</body>
</html>
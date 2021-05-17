<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="Image/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TubeMaking | Login</title>
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link rel="stylesheet" href="Component/main.css">
</head>
<body>

    <div class="row">
        <h4 class="center">TUBE-MAKING KANBAN SYSTEM</h4>
        <div class="row divider" id="line"></div>

        <form action="" method="post" id="login_form">
            <div class="row z-depth-5" id="form_content">
                <div class="col s12 input-field center">
                    <img src="Image/login.png" alt="" id="icon_login" class="responsive-img z-depth-5"/>
                </div>
                <!-- ID -->
                <div class="col s12 input-field">
                    <input type="text" name="userID" autocomplete="OFF">
                        <label for="">UserID</label>
                </div>
                <!-- PASS -->
                <div class="col s12 input-field">
                    <input type="password" name="userPass" autocomplete="OFF">
                        <label for="">Password</label>
                </div>
                <!-- BUTTON -->
                <div class="col s12 input-field">
                    <input type="submit" name="login_btn" value="Login" class="btn-large blue col s12">
                </div>
                <!-- PHP -->
                <div class="col s12 input-field">
                    <?php require 'process/login.php';?>
                </div>
            </div>
        </form>
    </div>
    <script src="Component/jquery.min.js"></script>
    <script src="materialize/js/materialize.min.js"></script>
    <script>

    </script>
</body>
</html>
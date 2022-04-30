<?php
error_reporting(0);
if($_GET["Login"] =="no"){
    $message = "Hatalı Giriş";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- TODO Extract the styles to css and center the contents-->
    <style>
        body{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            background-image: url("bodyback.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /*üst panel*/
        nav{
            text-align:center;
            background-color: #2d4769cb;
            padding: 10px 0px;
            border-top-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        ul.topMenu li{
            list-style: none;
            display: inline;
            font-size: 20px;
        }

        ul.topMenu li a{
            text-decoration: none;
            color:#164077 ;
            background-color: #1172b3e3;
            padding: 25px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        ul.topMenu li a:hover{
            background-color: #2eadf796;
        }
        ul.topMenu a,img{
            width: 10%;
            padding:0px;
        }
        ul.topMenu li a.btnOut{
            color:#dce0e4 ;
            background-color: #f12d0ae3;
        }
        ul.topMenu li a.btnOut:hover{
            background-color: #ff2600;
        }
        .error{
            color:#861212;
        }

        /*REGISTER */
        .register{
            text-align: center;
        }

        .register table{
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #77aabe9f;
            border-top-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .register input{
            padding: 7px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="register">
    <form method="post" action="adminUI.php">

    <table>
        <tr><td>Admin Girişi</td></tr>
        <tr><td><input type="text" name="userName" placeholder="User Name"> </td></tr>

        <tr><td><input type="password" name="password" placeholder="Password"></td></tr>

        <tr><td><input type="submit" name="btnLogin" value="Login" style="width:20%"></td></tr>

        <tr><td style="color:#ff0000;"><?php echo $message?></td></tr>
    </table>

    </form>
</div>

</body>
</html>
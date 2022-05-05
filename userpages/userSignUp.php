<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <style>
        @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url('/images/bodyback.jpeg');
        }


        header {
            background-color: #BECFE4;
            padding: 30px;
            font-size: 35px;
            height: 150px;
            overflow: clip;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;

        }
        .logo{
            display: inline-flex;
        }
        .header_buttons{
            float: right;
            margin-left: 250px;
        }
        nav{
            text-align:center;
            background-color: #BECFE4;
            padding: 10px 0px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        ul.topMenu li{
            list-style: none;
            display: inline;
            font-size: 20px;
        }

        ul.topMenu li a{
            text-decoration: none;
            color:#164077 ;
            background-color: #BECFE4;
            padding: 25px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        ul.topMenu li a:hover{
            background-color: #FFF5F3;
            color: black;
        }
        ul.topMenu li a.btnOut{
            color:#164077 ;
            background-color: #BECFE4;
        }
        ul.topMenu li a.btnOut:hover{
            background-color: #FFF5F3;
            color: red;
        }

        .error{
            color:#861212;
        }
        .register{
            text-align: center;
            margin-bottom: 30px;
        }

        .register table{
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #FFF5F3;
            border-radius: 15px;

        }

        .register input{
            padding: 7px;
            margin-top: 10px;
            border-radius: 5px;
        }
        #signUp{
            margin-bottom: 25px;
            width:25%;
            float: right;

            background-color: #BECFE4;
        }
        #signUp:hover{
            background-color: green;
            color: #FFFFFF;

        }
    </style>
</head>
<body style="background-image: url('/images/bodyback.jpeg')">


<?php
error_reporting(0);
session_start();
$serverName = "localhost";
$userNameForDB = "root";
$passwordForDB = "";
$db = "mobilephonedb";

$name = "";
$surname = "";
$year = "";
$email = "";
$userName = "";
$password = "";
$webSite = "";
$gender = "";
$nameErr=$surnameErr=$emailErr=$userNameErr=$passwordErr=$genderErr=$yearErr = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){
        $nameErr = "Name is required";
    }else{
        $name = cleanProcess($_POST['name']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$name)){
            $nameErr = "Only characters and space";
        }else{
            $nameErr ="";
        }
    }
    if(empty($_POST['surname'])){
        $surnameErr = "Surname is required";
    }else{
        $surname = cleanProcess($_POST['surname']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$surname)){
            $surnameErr = "Only characters and space";
        }else{
            $surnameErr = "";
        }
    }
    if(empty($_POST['year'])){
        $yearErr = "Year is required";
    }else{
        $year = cleanProcess($_POST['year']);
        if(!preg_match("/^[0-9]*$/",$year)){
            $yearErr = "Only numbers";
        }else{
            $yearErr = "";
        }
    }
    if(empty($_POST['email'])){
        $emailErr = "Email is required";
    }else{
        $email = cleanProcess($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        }else{
            $emailErr ="";
        }
    }
    if(empty($_POST['userName'])){
        $userNameErr = "User Name is required";
    }else{
        $userName = cleanProcess($_POST['userName']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$userName)){
            $userNameErr = "Only characters and space";
        }else{
            $userNameErr = "";
        }
    }
    if(empty($_POST['password'])){
        $passwordErr = "Password is required";
    }else{
        $password = cleanProcess($_POST['password']);
        $passwordErr = "";
    }
    if(empty($_POST['gender'])){
        $genderErr = "Gender is required";
    }else{
        $gender = cleanProcess($_POST['gender']);
        $genderErr = "";
    }
    $webSite = cleanProcess($_POST['webSite']);
}
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userNameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($name !="" && $nameErr=="" && $surnameErr=="" && $yearErr=="" && $emailErr=="" && $userNameErr=="" && $passwordErr=="" && $genderErr==""){

        $isUniq = isUserExist($connect, $userName);

        if($isUniq){
            $passwordMD5 = md5($password);
            $sqlRegister = "INSERT INTO users (name,surname,year,email,user_name,password,web_site,gender) VALUES
                    ('$name','$surname',$year,'$email','$userName','$passwordMD5','$webSite','$gender')";
            $connect->exec($sqlRegister);

            echo "<script type='text/javascript'>alert('Kayıt başarılı');</script>";

            $name ="";
            $surname ="";
            $year ="";
            $email ="";
            $userName ="";
            $password ="";
            $webSite ="";
            $gender ="";
            $userNameErr = "";
        }
        else{
            $userNameErr = "Kullanıcı adı kullanılıyor!";
        }
    }
}catch(PDOException $ex){echo $ex;}

function cleanProcess($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function isUserExist($connection, $user){
    $sqlUsername = "SELECT user_name FROM users WHERE user_name='$user'";
    $resultOfUserName = $connection->query($sqlUsername);
    $row = $resultOfUserName->fetch();
    $resultOfThis = $row[0] == "" ? true : false;
    return $resultOfThis;
}
$connect = null;

?>

<header class="header" id="header">
    <div class="logo">
        <a href="../index.php"> <img src="../images/logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; font-family: 'Merriweather', serif;">CLOUD STORE</h2>
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong>USER PROFILE</strong></p>
        <div class="header_buttons" style="float: right; margin-left: 500px;">
            <div style="float: right" onclick="openBasket()"> <img src="/images/basket.jpeg" style="height: 80px; width: 80px;border-radius: 33.3%; border: 1px solid black;margin-left: 250px;" > </div>

        </div>
    </div>

</header>
<nav>
    <ul class="topMenu">
        <li style="color: #ffffff"><?php echo $_SESSION['user']?></li>
        <li><a href="../index.php">Main Page</a></li>
        <li><a href="#">Sign Up</a></li>
        <li><a href="userSignIn.php">Sign In</a></li>
        <li><a href="userProfile.php">Profile</a></li>
        <li><a href="../adminpages/adminLogin.php">Admin Login</a></li>
        <li><a href="logOut.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>

<div class="register">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

        <table>
            <tr><td colspan="3"><span class="error">* : Required</span></td><td></td><td></td></tr>

            <tr><td>Name: </td> <td><input type="text" name="name" value="<?php echo $name ?>"> </td>
                <td><span class="error">*<?php echo $nameErr ?></span> </td></tr>

            <tr><td>Surname: </td> <td><input type="text" name="surname" value="<?php echo $surname ?>"> </td>
                <td><span class="error">*<?php echo $surnameErr ?></span> </td></tr>

            <tr><td>Birth Year: </td> <td><input type="number" name="year" value="<?php echo $year ?>" max=2020> </td>
                <td><span class="error">*<?php echo $yearErr ?></span> </td></tr>

            <tr><td>E-mail: </td> <td><input type="email" name="email" value="<?php echo $email ?>"> </td>
                <td><span class="error">*<?php echo $emailErr ?></span> </td></tr>

            <tr><td>User Name: </td> <td><input type="text" name="userName" value="<?php echo $userName ?>"> </td>
                <td><span class="error">*<?php echo $userNameErr ?></span> </td></tr>

            <tr><td>Password: </td> <td><input type="password" name="password" value="<?php echo $password ?>"> </td>
                <td><span class="error">*<?php echo $passwordErr ?></span> </td></tr>

            <tr><td>Web Site: </td> <td><input type="url" name="webSite" value="<?php echo $webSite ?>"> </td>
                <td> </td></tr>

            <tr><td>Gender: </td> <td><input type="radio" name="gender" value="male">Male
                    <input type="radio" name="gender" value="female">Female </td>
                <td><span class="error">*<?php echo $genderErr ?></span> </td></tr>

            <tr><td colspan="2"><input  class="btn" type="submit" name="btnSubmit" value="Sign Up" id="signUp"></td><td></td><td></td></tr>
        </table>

    </form>
</div>

</body>
</html>

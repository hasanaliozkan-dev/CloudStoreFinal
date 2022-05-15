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


        .register{
            margin-top: 10px;
            text-align: center;
            margin-bottom: 30px;
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
        <li><a href="signOut.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>

<div class="register p-5" style="width: 40%; background-color: #FFF5F3; border-radius: 10px; border: black solid 1px">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="mb-2  text-center">
            <label for="fName" class="form-label">Name: </label>
            <input type="text" class="form-control" id="fName"  name="fName" placeholder="Username">
        </div>
        <div class="mb-2  text-center">
            <label for="lName" class="form-label">Surname: </label>
            <input type="text" class="form-control" id="lName"  name="lName" placeholder="Lastname">
        </div>
        <div class="mb-2  text-center">
            <label for="year" class="form-label">Birth Year: </label>
            <input type="number" class="form-control" id="year" name="year" placeholder="Year">
        </div>
        <div class="mb-2  text-center">
            <label for="email" class="form-label">Email: </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="mb-2  text-center">
            <label for="email" class="form-label">User Name: </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Username">
        </div>
        <div class="mb-2  text-center">
            <label for="password" class="form-label">User Name: </label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="mb-2  text-center">
            <label>
                <input type="radio" name="gender" value="male">
            </label>Male
            <label>
                <input type="radio" name="gender" value="female">
            </label>Female
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="signUp">Sign In</button>
        </div>
    </form>
</div>

</body>
</html>

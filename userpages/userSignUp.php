<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <link rel="stylesheet" href="../styles/userCommon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <style>
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
$db = "clouddb";

$name = "";
$surname = "";
$year = "";
$email = "";
$userName = "";
$password = "";

$gender = "";
$nameErr=$surnameErr=$emailErr=$userNameErr=$passwordErr=$genderErr=$yearErr = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['fName'])){
        $nameErr = "Name is required";
    }else{
        $name = cleanProcess($_POST['fName']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$name)){
            $nameErr = "Only characters and space";
        }else{
            $nameErr ="";
        }
    }
    if(empty($_POST['lName'])){
        $surnameErr = "Surname is required";
    }else{
        $surname = cleanProcess($_POST['lName']);
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
    if(empty($_POST['username'])){
        $userNameErr = "User Name is required";
    }else{
        $userName = cleanProcess($_POST['username']);
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
}

try{
    $connect = new PDO("mysql:host=$serverName;dbname=$db",$userNameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($name !="" && $nameErr=="" && $surnameErr=="" && $yearErr=="" && $emailErr=="" && $userNameErr=="" && $passwordErr=="" && $genderErr==""){

        $isUniq = isUserExist($connect, $userName);

        if($isUniq){
            $passwordMD5 = md5($password);
            $sqlRegister = "INSERT INTO users (name,surname,year,email,username,password,gender) VALUES
                    ('$name','$surname',$year,'$email','$userName','$passwordMD5','$gender')";
            $connect->exec($sqlRegister);


            header("Location:userSignIn.php");

            $name ="";
            $surname ="";
            $year ="";
            $email ="";
            $userName ="";
            $password ="";

            $gender ="";
            $userNameErr = "";
        }
        else{
            $userNameErr = "Username is already taken";
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
    $sqlUsername = "SELECT username FROM users WHERE username='$user'";
    $resultOfUserName = $connection->query($sqlUsername);
    $row = $resultOfUserName->fetch();
    $result = $row[0] == "" ? true : false;
    return $result;
}
$connect = null;

?>

<header class="header" id="header">
    <div class="logo">
        <a href="../index.php"> <img src="../images/logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; font-family: 'Merriweather', serif;">CLOUD STORE</h2>
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong>SIGN UP</strong></p>
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

<div class="register p-5 text-center" style="width: 40%; background-color: #FFF5F3; border-radius: 10px; border: black solid 1px">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="mb-2  text-center">
            <label for="fName" class="form-label">Name: </label>
            <input type="text" class="form-control" id="fName"  name="fName" placeholder="Username">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $nameErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label for="lName" class="form-label">Surname: </label>
            <input type="text" class="form-control" id="lName"  name="lName" placeholder="Lastname">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $surnameErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label for="year" class="form-label">Birth Year: </label>
            <input type="number" class="form-control" id="year" name="year" placeholder="Year">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $yearErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label for="email" class="form-label">Email: </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $emailErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label for="email" class="form-label">User Name: </label>
            <input type="text" class="form-control" id="usernam" name="username" placeholder="Username">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $userNameErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label for="password" class="form-label">Password: </label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $passwordErr?></span>
            </div>
        </div>
        <div class="mb-2  text-center">
            <label>
                <input type="radio" name="gender" value="male">
            </label>Male
            <label>
                <input type="radio" name="gender" value="female">
            </label>Female
            <div style="margin-left: 30px; margin-bottom: 30px;">
                <span style=" color:#ff0000;"><?php echo $genderErr?></span>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="signUp" name="signUp">Sign In</button>
        </div>
    </form>
</div>

</body>
</html>

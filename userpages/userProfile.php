<?php
error_reporting(0);
session_start();

/*if(!isset($_SESSION['user'])){
    header("Location:userLogin.php");
}*/

$server = "localhost";
$userName = "root";
$passwordForDB = "";
$db = "mobilephonedb";
$isLogin = false;

$name ="";
$surname = "";
$year = "";
$password = "";
$email = "";
$webSite = "";
$newPassword = false;

$nameErr=$surnameErr=$emailErr=$passwordErr=$yearErr = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){
        $name = $_SESSION['currentName'];
    }else{
        $name = cleanProcess($_POST['name']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$name)){
            $nameErr = "Only characters and space";
        }else{
            $nameErr ="";
        }
    }
    if(empty($_POST['surname'])){
        $surname = $_SESSION['currentSurname'];
    }else{
        $surname = cleanProcess($_POST['surname']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$surname)){
            $surnameErr = "Only characters and space";
        }else{
            $surnameErr = "";
        }
    }
    if(empty($_POST['year'])){
        $year = $_SESSION['currentYear'];
    }else{
        $year = cleanProcess($_POST['year']);
        if(!preg_match("/^[0-9]*$/",$year)){
            $yearErr = "Only numbers";
        }else{
            $yearErr = "";
        }
    }
    if(empty($_POST['email'])){
        $email = $_SESSION['currentEmail'];
    }else{
        $email = cleanProcess($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        }else{
            $emailErr ="";
        }
    }
    if(empty($_POST['newPassword'])){
        $password = $_SESSION['currentPassword'];
        $newPassword = false;
    }else{
        $password = cleanProcess($_POST['newPassword']);
        $newPassword = true;
        $passwordErr = "";
    }
    if(empty($_POST['password'])){
        $passwordErr = "Şifre Gerekli";
    }
    $webSite = empty($_POST['webSite']) ? $_SESSION['currentWeb'] : cleanProcess($_POST['webSite']);
}

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_POST['btnUpdate'] && $nameErr=="" && $surnameErr=="" && $yearErr=="" && $emailErr=="" && $passwordErr==""){
        $user = $_SESSION["user"];
        $pass = $newPassword ? md5($password) : $password;
        $sqlPassword = "SELECT password FROM users WHERE user_name='$user'";
        $result = $connect->query($sqlPassword);
        $rowPassword = $result->fetch();
        if($rowPassword['password'] != md5($_POST['password'])){
            $passwordErr = "Şifre Yanlış";
        }else{
            $sqlUpdate = "UPDATE users SET name='$name',surname='$surname',year='$year',
                password='$pass',email='$email',web_site='$webSite' WHERE user_name='$user' ";

            $statement = $connect->prepare($sqlUpdate);

            $statement->execute();

            echo "<script type='text/javascript'>alert('Kayıt yenilendi');</script>";
        }
    }
    $currentUser = $_SESSION["user"];
    $sqlSelect = "SELECT name,surname,year,password,email,web_site FROM users WHERE user_name='$currentUser'";
    $result = $connect->query($sqlSelect);
    $row = $result->fetch();

    if($row['name'] != ""){
        $_SESSION['currentName'] = $name =$row['name'];
        $_SESSION['currentSurname'] = $surname = $row['surname'];
        $_SESSION['currentYear'] = $year = $row['year'];
        $_SESSION['currentPassword'] = $password = $row['password'];
        $_SESSION['currentEmail'] = $email = $row['email'];
        $_SESSION['currentWeb'] = $webSite = $row['web_site'];
    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}
function printInfo(){
    $currentUser = $_SESSION["user"];
    $sqlSelect = "SELECT name,surname,year,password,email,web_site FROM users WHERE user_name='$currentUser'";
    $result = $connect->query($sqlSelect);
    $row = $result->fetch();

    if($row['name'] != ""){
        $name =$row['name'];
        $surname = $row['surname'];
        $year = $row['year'];
        $password = $row['password'];
        $email = $row['email'];
        $webSite = $row['web_site'];
    }
}
function cleanProcess($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/styles/indexPage.css">
    <style>


        .register{
            margin-top: 20px;
            text-align: center;
        }

        .register input,td{
            padding: 7px;
            margin-top: 10px;
        }
        #update{
            width:30%;
            float: right;
            background-color: #BECFE4;
        }
        #update:hover{
            background-color: green;
            color: #FFFFFF;

        }
    </style>
</head>
<body style="background-image: url('/images/bodyback.jpeg')">
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
        <li><a href="userSignUp.php">Sign Up</a></li>
        <li><a href="userSignIn.php">Sign In</a></li>
        <li><a href="#">Profile</a></li>
        <li><a href="../adminpages/adminLogin.php">Admin Login</a></li>
        <li><a href="signOut.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>
<div class="register container" style="width: 40%; background-color: #FFF5F3; border-radius: 10px; border: black solid 1px;">
    <form class="mt-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" style="width: 80%;">
        <div class="mb-2  text-center">
            <label for="fName" class="form-label">Name: </label>
            <input type="text" class="form-control" id="fName"  name="fName" placeholder="<?php echo $name ?>">
        </div>
        <div class="mb-2  text-center">
            <label for="lName" class="form-label">Surname: </label>
            <input type="text" class="form-control" id="lName"  name="lName" placeholder="<?php echo $surname ?>">
        </div>
        <div class="mb-2  text-center">
            <label for="year" class="form-label">Birth Year: </label>
            <input type="number" class="form-control" id="year" name="year" placeholder="<?php echo $year ?>" max=2004>
        </div>
        <div class="mb-2  text-center">
            <label for="email" class="form-label">Email: </label>
            <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $email ?>">
        </div>
        <div class="mb-2  text-center">
            <label for="oPassword" class="form-label">Current Password: </label>
            <input type="password" class="form-control" id="oPassword" name="oPassword" placeholder="Current Password">
        </div>
        <div class="mb-2  text-center">
            <label for="nPassword" class="form-label">User Name: </label>
            <input type="password" class="form-control" id="nPassword"  name="nPassword" placeholder="New Password">

        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="update">Update</button>
        </div>
    </form>
</div>


</body>
</html>

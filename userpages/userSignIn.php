<?php
error_reporting(0);
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$db = "mobilephonedb";
$isLogin = false;
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_POST['btnLogin']){
        $user = $_POST['userName'];
        $pass = md5($_POST['password']);
        $sql = "SELECT user_name, name, password FROM users WHERE user_name='$user' and password='$pass'";
        $result = $connect->query($sql);
        $row = $result->fetch();
        if($row['user_name'] != ""){
            $isLogin = true;
            $_SESSION['user'] = $_POST['userName'];
            echo "<script type='text/javascript'>alert('Giriş yapıldı');</script>";
            header("Location:index.php");
        }else{
            $message = "Hatalı Giriş";
        }
    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}
$connect = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        #signIn{
            width: 25%;
            background-color: #BECFE4;
        }
        #signIn:hover{
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
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong>SIGN IN</strong></p>
    </div>

</header>
<nav>
    <ul class="topMenu">
        <li style="color: #ffffff"><?php echo $_SESSION['user']?></li>
        <li><a href="../index.php">Main Page</a></li>
        <li><a href="userSignUp.php">Sign Up</a></li>
        <li><a href="#">Sign In</a></li>
        <li><a href="userProfile.php">Profile</a></li>
        <li><a href="../adminpages/adminLogin.php">Admin Login</a></li>
        <li><a href="signOut.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>
<div  class="container mt-5" style="width: 30%; background-color: #FFF5F3; border-radius: 10px; border: black solid 1px" >
    <h3 class=" text-center pt-3"> User Sign In </h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="mb-5  text-center">
            <label for="fUserName" class="form-label">User Name</label>
            <input type="text" class="form-control" id="fUserName"  name="fUserName" placeholder="User Name">
        </div>
        <div class="mb-5  text-center">
            <label for="fPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="fPassword" name="fPassword" placeholder="Password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="signIn">Sign In</button>
        </div>
    </form>

</div>

</body>
</html>

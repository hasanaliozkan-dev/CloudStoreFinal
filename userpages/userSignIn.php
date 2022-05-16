<?php
error_reporting(0);
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$db = "clouddb";
$isLogin = false;
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $value = $_POST['signIn'];

    if(isset($_POST['signIn'])){

        $user = $_POST['userName'];

        $pass = md5($_POST['password']);
        $sql = "SELECT username, name, password FROM users WHERE username='$user' and password='$pass'";
        $result = $connect->query($sql);
        $row = $result->fetch();
        if($row['username'] != ""){
            $isLogin = true;
            $_SESSION['user'] = $_POST['userName'];
            echo "<script type='text/javascript'>alert('Login Successful');</script>";
            header("Location:../index.php");
        }else{
            $message = "Wrong Credentials!";
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
    <link rel="stylesheet" href="../styles/userCommon.css">
    <title>User Signin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>

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
<div  class="container mt-5" style="width: 25%; background-color: #FFF5F3; border-radius: 10px; border: black solid 1px" >
    <form  class="mt-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="mb-5  text-center">
            <label for="userName" class="form-label">User Name</label>
            <input type="text" class="form-control" id="userName"  name="userName" placeholder="User Name">
        </div>
        <div class="mb-5  text-center">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="signIn" name="signIn">Sign In</button>
        </div>
        <div style="margin-left: 100px; margin-bottom: 30px;">
            <span style=" color:#ff0000;"><?php echo $message?></span>
        </div>
    </form>

</div>

</body>
</html>

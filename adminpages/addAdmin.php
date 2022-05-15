<?php
session_start();
error_reporting(0);
$server = "localhost";
$userNameForDB = "root";
$passwordForDB = "";
$db = "clouddb";
/*if(!isset($_SESSION['admin'])){
header("Location:adminLogin.php?Login=no");
}*/

$userName = "";
$password = "";
$userNameErr=$passwordErr= "";
    if(empty($_POST['fUserName'])){
        $userNameErr = "Please provide a username";
    }else{
        $userName = cleanProcess($_POST['fUserName']);

        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$userName)){
            $userNameErr = "Only character and space acceptable";
        }else{
            $userNameErr ="";
        }
    }
    $passwordErr = empty($_POST['fPassword']) ? "Please provide a password" : "";
try{

    $connect = new PDO("mysql:host=$server;dbname=clouddb",$userNameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['addAdmin']) && $userNameErr == "" && $passwordErr == ""){
            $password = md5($_POST['fPassword']);

            $sqlTest = "SELECT user_name FROM admins WHERE user_name='$userName'";
            $result = $connect->query($sqlTest);

            $row = $result->fetch();
            if($row['user_name'] != ""){
                echo "<script type='text/javascript'>alert('$row');</script>";
                $userNameErr = "This username is already taken!!!";
            }else{
                $sql = "INSERT INTO admins VALUES('$userName','$password')";
                $result = $connect->exec($sql);
                echo "<script type='text/javascript'>alert('Admin is added');</script>";
            }

    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}

function cleanProcess($input){

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

$connect = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../styles/adminCommon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        #createAdmin{
            background-color: #BECFE4;
        }
        #createAdmin:hover{
            background-color: green;
            color: #FFFFFF;

        }



    </style>
</head>
<body>
<header>
    <div class="logo">
        <a  href="../index.php"> <img class="logoImg" src="../images/logo.jpg" ></a>
        <h2 class="title">ADMIN PANEL</h2>
        <p  class = "subTitle"> <strong> ADD ADMIN</strong></p>
    </div>

</header>
<nav>
    <ul class="topMenu">
        <li><a href="adminUI.php">Search Product</a></li>
        <li><a href="addProduct.php">Add Product</a></li>
        <li><a href="addAdmin.php" class="btnAddAdmin">Add Admin</a></li>
        <li><a href="logOutAdmin.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>

<div  class="container mt-5" id="content" >
    <form  class="mt-5" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
        <div class="mb-5  text-center">
            <label for="fUserName" class="form-label">User Name</label>
            <input type="text" class="form-control" id="fUserName"  name="fUserName" placeholder="User Name">
        </div>
        <div class="mb-5  text-center">
            <label for="fPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="fPassword" name="fPassword" placeholder="Password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="createAdmin" name="addAdmin">Add Admin</button>
        </div>
    </form>

</div>



</body>
</html>
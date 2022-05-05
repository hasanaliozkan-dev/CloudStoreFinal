<?php
session_start();
error_reporting(0);
$server = "localhost";
$userNameForDB = "root";
$passwordForDB = "";
$db = "mobilephonedb";
/**if(!isset($_SESSION['admin'])){
header("Location:adminLogin.php?Login=no");
}**/

$userName = "";
$password = "";
$authority = "";
$userNameErr=$passwordErr=$authErr = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['fUserName'])){
        $userNameErr = "Kullanıcı Adı Giriniz";
    }else{
        $userName = cleanProcess($_POST['fUserName']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$userName)){
            $userNameErr = "Sadece boşluk ve karakterler kabul edilir";
        }else{
            $userNameErr ="";
        }
    }
    $passwordErr = empty($_POST['fPassword']) ? "Şifre Giriniz" : "";
    $authErr = empty($_POST['fAuthority']) ? "Yetkinlik Seçiniz" : "";
}
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userNameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['btnInsert']) && $userNameErr == "" && $authErr == "" && $passwordErr == ""){
        if($_SESSION['auth'] != "super_admin"){
            echo "<script type='text/javascript'>alert('Yetkinlik Hatası! Admin Eklenmedi');</script>";
        }else{
            $password = md5($_POST['fPassword']);
            $authority = $_POST['fAuthority'];

            $sqlTest = "SELECT user_name FROM admins WHERE user_name='$userName'";
            $result = $connect->query($sqlTest);
            $row = $result->fetch();
            if($row['user_name'] != ""){
                $userNameErr = "Kullanıcı adı zaten mevcut!";
            }else{
                $sql = "INSERT INTO admins VALUES('$userName','$password','$authority')";
                $result = $connect->exec($sql);
                echo "<script type='text/javascript'>alert('Admin Eklendi');</script>";
            }
        }
    }
    $adminName = $_SESSION['admin'];
    $sqlTest = "SELECT authority FROM admins WHERE user_name='$adminName'";
    $result = $connect->query($sqlTest);
    $row = $result->fetch();
    $_SESSION['auth'] = $row['authority'];
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
        #content{
            width: 25%;
            background-color: #FFF5F3;
            border-radius: 10px;
            border: black solid 1px;
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
<!-- TODO: ALL LOGIN PAGES-->
<div  class="container mt-5" id="content" >
    <h3 class=" text-center pt-3 mb-3"> Create Admin</h3>
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
            <button type="submit" class="btn mb-5" id="createAdmin">Create Admin</button>
        </div>
    </form>

</div>



</body>
</html>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("../bodyback.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        header {
            background-color: #BECFE4;
            padding: 20px;
            font-size: 35px;
            height: 150px;
            overflow: clip;
            color: black;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;

        }
        .logo{
            display: inline-flex;
        }
        input{
            border-radius: 7px;
        }
        h1{
            text-align: center;
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
        ul.topMenu li a.btnAddAdmin{
            color:#164077 ;
            background-color: #BECFE4;
        }
        ul.topMenu li a.btnAddAdmin:hover{
            background-color: #FFF5F3;
            color: green;
        }
        ul.topMenu li a.btnOut{
            color:#164077 ;
            background-color: #BECFE4;
        }
        ul.topMenu li a.btnOut:hover{
            background-color: #FFF5F3;
            color: red;
        }
        ul.topMenu li a:hover{
            background-color: #FFF5F3;
            color: black;
        }
        /*Yeni ürün ekleme*/
        .newProduct{
            height: auto;
            padding: 20px;
            margin-left:10px;
            margin-right: 10px;
            border: 1px solid #2b2e2b;
            border-top-left-radius: 15px;
            border-bottom-right-radius: 15px;
            background-color: #badadf;
            color: #2b2e2b;
        }
        .newProductButton{
            text-align: center;
        }

        /*alert*/
        .alert {
            padding: 20px;
            background-color: #26a030;
            color: white;
            margin-bottom: 15px;
            visibility: hidden;
        }
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
        /*section*/

        section{
            border: 1px solid #2b2e2b;
            border-top-left-radius: 15px;
            border-bottom-right-radius: 15px;
            padding: 5px;
        }
        /* ürün arama */
        .searchTab{
            text-align: center;
            background-color: #6dc7d4;
            border-top-left-radius: 15px;
            padding: 20px;
            color: #1d2122;
        }
        /* ürün listeleme*/
        .productList{
            text-align: center;
            background-color: #63878d;
            border-bottom-right-radius: 15px;
            padding: 20px;
            color: #1d2122;
            height: auto;
            margin: auto;
            width: auto;
        }
        .productList table, th, td, button{
            border: 1px solid #2b2e2b;
            text-align: center;
            border-collapse: collapse;
            padding: 15px;
            margin-left: 30px;
        }

        .error{
            color:#861212;
        }


    </style>
</head>
<body>
<header>
    <div class="logo">
       <a href="adminUI.php"><img src="../logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; margin-right: 20px; font-family: 'Merriweather', serif;">ADMIN PANEL</h2>
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong> ADD ADMIN</strong></p>
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
<div  class="container mt-5" style="width: 25%; background-color: #FFF5F3" >
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
            <button type="submit" class="btn mb-5" style="background-color: #BECFE4">Create Admin</button>
        </div>
    </form>

</div>



</body>
</html>
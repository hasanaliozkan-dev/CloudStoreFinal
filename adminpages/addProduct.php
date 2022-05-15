<?php
session_start();
error_reporting(0);
$server = "localhost";
$userName = "root";
$password = "";
$db = "mobilephonedb";
if(!isset($_SESSION['admin'])){
header("Location:adminLogin.php?Login=no");
}
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['btnInsert'])){
        $brand = $_POST['fBrand'];
        $model = $_POST['fModel'];
        $screen = $_POST['fScreen'];
        $camera = $_POST['fCamera'];
        $cpu = $_POST['fCPU'];
        $ram = $_POST['fRAM'];
        $memory = $_POST['fMemory'];
        $battery = $_POST['fBattery'];
        $OS = $_POST['fOS'];
        $Extra = $_POST['fExtra'];
        $oldPrice = $_POST['fOldPrice'];
        $price = $_POST['fPrice'];
        $picture = $_POST['fPicture'];

        $sql = "INSERT INTO products(brand, model, screen,camera,cpu,ram,memory,battery,os,extra,old_price,
            price,picture_address) VALUES('$brand','$model','$screen','$camera','$cpu','$ram','$memory','$battery','$OS','$Extra',
            '$oldPrice','$price','$picture')";
        $result = $connect->exec($sql);
        echo "Ürün Eklendi";
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
    <link rel="stylesheet" href="../styles/adminCommon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>

        .newProduct{
            border: black solid 1px;
            margin-right: 20px;
            margin-left: 20px;
            margin-top: 50px;
            height: auto;
            padding: 50px;
            border-radius: 15px;
            background-color: #FFF5F3;
            color: #2b2e2b;
        }
        .newProduct label {
            display:flex;
            flex-direction:column;
        }
        #addProduct{
            float: right;
            background-color: #BECFE4;

        }
        #addProduct:hover{
            background-color: green;
            color: #FFFFFF;

        }



    </style>

</head>
<body>

<header>
    <div class="logo">
        <a href="../index.php"> <img class="logoImg" src="../images/logo.jpg" ></a>
        <h2 class="title">ADMIN PANEL</h2>
        <p class="subTitle"> <strong>ADD PRODUCT</strong></p>
    </div>

</header>
<nav>
    <ul class="topMenu">
        <li style="color: #ffffff"><?php echo $_SESSION['admin']?></li>
        <li><a href="adminUI.php">Search Product</a></li>
        <li><a href="addProduct.php">Add Product</a></li>
        <li><a href="addAdmin.php" class="btnAddAdmin">Add Admin</a></li>
        <li><a href="logOutAdmin.php" class="btnOut">Log Out</a></li>
    </ul>
</nav>

<div class="newProduct">

    <form id="ekleForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="container">
            <div class="row">
                <div class="col">
                    <label for="fBrand">Marka: </label>
                    <input type="text" id="fBrand" name="fBrand">
                    <br>
                    <br>
                    <label for="fModel">Model: </label>
                    <input type="text" id="fModel" name="fModel">
                    <br>
                    <br>
                    <label for="fScreen">Ekran: </label>
                    <input type="text" id="fScreen" name="fScreen">
                    <br>
                    <br>
                    <label for="fCamera">Kamera: </label>
                    <input type="text" id="fCamera" name="fCamera">
                    <br>
                    <br>
                    <label for="fPicture">Fotoğraf Adresi: </label>
                    <input type="text" id="fPicture" name="fPicture" style="width: 149%;"><br>
                </div>
                <div class="col">
                    <label for="fCPU">İşlemci: </label>
                    <input type="text" id="fCPU" name="fCPU">
                    <br>
                    <br>
                    <label for="fRAM">RAM: </label>
                    <input type="text" id="fRAM" name="fRAM">
                    <br>
                    <br>
                    <label for="fMemory">Hafıza: </label>
                    <input type="text" id="fMemory" name="fMemory">
                    <br>
                    <br>
                    <label for="fBattery">Batarya: </label>
                    <input type="text" id="fBattery" name="fBattery">

                </div>
                <div class="col">
                    <label for="fOS">İşletim Sistemi: </label>
                    <input type="text" id="fOS" name="fOS">
                    <br>
                    <br>
                    <label for="fExtra">Ekstra Özellik: </label>
                    <input type="text" id="fExtra" name="fExtra">
                    <br>
                    <br>
                    <label for="fOldPrice">Eski Fiyat: </label>
                    <input type="text" id="fOldPrice" name="fOldPrice">
                    <br>
                    <br>
                    <label for="fPrice">Fiyat: </label>
                    <input type="text" id="fPrice" name="fPrice">
                </div>
            </div>
        </div>
        <button type="submit" class="btn mb-5" id="addProduct" >Add Product</button>
    </form>

</div>


</body>
</html>
<?php
session_start();
error_reporting(0);
$server = "localhost";
$userName = "root";
$password = "";
$db = "mobilephonedb";
/** if(!isset($_SESSION['admin'])){
header("Location:adminLogin.php?Login=no");
}**/
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
            height: 100px;
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
        <img src="../logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%" onclick="window.location.href='cloud_store.html'">
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; margin-right: 20px; font-family: 'Merriweather', serif;">ADMIN PANEL</h2>
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong>ADD PRODUCT</strong></p>
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
<div class="newProduct">
    <form id="ekleForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <table id="tblEkle" style="width:50%;">
            <tr>
                <th>Telefon Ekle</th>
                <th></th>
            </tr>
            <tr>
                <td><label for="fBrand">Marka: </label></td>
                <td><input type="text" id="fBrand" name="fBrand"></td>
            </tr>
            <tr>
                <td><label for="fModel">Model: </label></td>
                <td><input type="text" id="fModel" name="fModel"></td>
            </tr>
            <tr>
                <td><label for="fScreen">Ekran: </label></td>
                <td><input type="text" id="fScreen" name="fScreen"></td>
            </tr>
            <tr>
                <td><label for="fCamera">Kamera: </label></td>
                <td><input type="text" id="fCamera" name="fCamera"></td>
            </tr>
            <tr>
                <td><label for="fCPU">İşlemci: </label></td>
                <td><input type="text" id="fCPU" name="fCPU"></td>
            </tr>
            <tr>
                <td><label for="fRAM">RAM: </label></td>
                <td><input type="text" id="fRAM" name="fRAM"></td>
            </tr>
            <tr>
                <td><label for="fMemory">Hafıza: </label></td>
                <td><input type="text" id="fMemory" name="fMemory"></td>
            </tr>
            <tr>
                <td><label for="fBattery">Batarya: </label></td>
                <td><input type="text" id="fBattery" name="fBattery"></td>
            </tr>
            <tr>
                <td><label for="fOS">İşletim Sistemi: </label></td>
                <td><input type="text" id="fOS" name="fOS"></td>
            </tr>
            <tr>
                <td><label for="fExtra">Ekstra Özellik: </label></td>
                <td><input type="text" id="fExtra" name="fExtra"></td>
            </tr>
            <tr>
                <td><label for="fOldPrice">Eski Fiyat: </label></td>
                <td><input type="text" id="fOldPrice" name="fOldPrice"></td>
            </tr>
            <tr>
                <td><label for="fPrice">Fiyat: </label></td>
                <td><input type="text" id="fPrice" name="fPrice"></td>
            </tr>
            <tr>
                <td><label for="fPicture">Fotoğraf Adresi: </label></td>
                <td> <input type="text" id="fPicture" name="fPicture"><br></td>
            </tr>
            <tr>
                <td>

                </td>
                <td>
                    <input type="submit" name="btnInsert" value="Ekle">

                </td>
            </tr>
        </table>
    </form>

</div>


</body>
</html>
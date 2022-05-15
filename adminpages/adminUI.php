<?php
error_reporting(0);
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$db = "clouddb";
$isLogin = true;
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['login'])){
        $user = $_POST['userName'];
        $pass = md5($_POST['password']);
        $sql = "Select * from admins";
        $result = $connect->query($sql);
        while($row = $result->fetch()){
            if($row['user_name'] == $user && $row['password'] == $pass){
                $isLogin = true;
                $_SESSION['admin'] = $_POST['userName'];
                break;
            }
        }
    }
    if(isset($_POST['btnDel'])){
        $delElem = $_POST['btnDel'];
        $sqlDelete = "DELETE FROM products WHERE id = '$delElem'";
        $connect->exec($sqlDelete);
        echo "<script type='text/javascript'>alert('Ürün Silindi');</script>";
    }
    if(!$isLogin && !isset($_SESSION['admin'])){
        header("Location:adminLogin.php?Login=no");
    }

}catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}

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
    .searchTab{
        text-align: center;
        background-color: #FFF5F3;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 20px;
    }
    .productList{
        text-align: center;
        background-color: #BECFE4;
        border-bottom-right-radius: 15px;
        border-bottom-left-radius: 15px;
        padding: 20px;

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
    #search{
        float: right;
        background-color: #BECFE4;

    }
    #search:hover{
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
        <p class="subTitle"> <strong> SEARCH PRODUCT</strong></p>
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

<section style="margin-top: 50px">
    <div class="searchTab" >
        <form action="" method="POST">
            ID:
            <input type="text" name="id">
            Marka:
            <input type="text" name="brand">
            Model:
            <input type="text" name="model">
            <input class="btn mb-5" type="submit" name="btnSearch" value="Search" id="search">
        </form>
    </div>
    <div class="productList">
        <form action="" method="POST">
            <table class="table container" id="tblProducts">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">BRAND</th>
                    <th scope="col">MODEL</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">CHANGE QUANTITY</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Cloud Rainy</td>
                    <td>Otto</td>
                    <td>1234</td>
                    <td>1234</td>
                    <td><button type="button" class="btn btn-success" style="width: 25%">+</button>
                        <button type="button" class="btn btn-warning" style="width: 25%">-</button>
                        <button type="button" class="btn btn-danger" style="width: 25%">DELETE</button></td>
                </tr>
            </table>

        </form>
    </div>

</section>
</body>
</html>
<?php
session_start();
error_reporting(0);
$server = "localhost";
$userName = "root";
$password = "";
$db = "clouddb";
if(!isset($_SESSION['admin'])){
header("Location:adminLogin.php?Login=no");
}
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['addProduct'])){
        $title = $_POST["title"];
        $link = $_POST["link"];
        $price = $_POST["price"];
        $desc = $_POST["desc"];
        $quantity = $_POST["quantity"];
        $category = $_POST["category"];

        $sql = "INSERT INTO `products`(`title`, `description`, `quantity`, `price`, `image_link`, `category`) VALUES ('$title','$desc','$quantity','$price','$link','$category')";
        $result = $connect->exec($sql);
        echo "<script>alert('Product is Added Successfully')</script>";
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
                    <label for="title">Title: </label>
                    <input type="text" id="title" name="title">
                    <br>
                    <br>
                    <label for="link">Image Link: </label>
                    <input type="text" id="link" name="link" style="width: 100%;"><br>
                </div>
                <div class="col">
                    <label for="price">Price: </label>
                    <input type="number" id="price" name="price">
                    <br>
                    <br>
                    <label for="desc">Description: </label>
                    <input type="text" id="desc" name="desc" style="width: 100%;">
                </div>
                <div class="col">
                    <label for="quantity">Quantity: </label>
                    <input type="number" id="quantity" name="quantity">
                    <br>
                    <br>
                    <label for="category">Category: </label>
                    <input type="text" id="category" name="category">
                </div>
            </div>
        </div>
        <button type="submit" class="btn mb-5" id="addProduct" name="addProduct" >Add Product</button>
    </form>

</div>


</body>
</html>
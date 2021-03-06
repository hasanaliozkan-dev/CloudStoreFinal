<?php
error_reporting(0);
if($_GET["Login"] =="no"){
    $message = "Wrong Credentials";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../styles/adminCommon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        #login{
            background-color: #BECFE4;
            width: 40%;
        }
        #login:hover{
            background-color: green ;
            color: #FFF5F3;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <a href="../index.php"> <img class="logoImg" src="../images/logo.jpg"></a>
        <h2 class="title">ADMIN PANEL</h2>
        <p class="subTitle"> <strong> LOGIN AS ADMIN</strong></p>
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
    <form class="mt-5" method="post" action="../adminpages/adminUI.php">
        <div class="mb-5  text-center">
            <label for="userName" class="form-label">User Name</label>
            <input type="text" class="form-control" id="userName"  name="userName" placeholder="User Name">
        </div>
        <div class="mb-5  text-center">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="login" name="login" >Login</button>
        </div>
        <div style="margin-left: 100px; margin-bottom: 30px;">
            <span style=" color:#ff0000;"><?php echo $message?></span>
        </div>
    </form>

</div>

</body>
</html>
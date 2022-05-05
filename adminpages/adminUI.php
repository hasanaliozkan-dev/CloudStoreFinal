
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
            <table id="tblProducts">
                <tr><th>ID</th><th>Brand</th><th>Model</th></tr>
            </table>
        </form>
    </div>
</section>
</body>
</html>
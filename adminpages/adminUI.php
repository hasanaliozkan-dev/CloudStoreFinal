
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- TODO extract styles to css-->
<style>
    @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');

    body {
        font-family: Arial, Helvetica, sans-serif;
        background-image: url("../images/bodyback.jpeg");
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
        <a href="../index.php"> <img src="../images/logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; margin-right: 20px; font-family: 'Merriweather', serif;">ADMIN PANEL</h2>
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
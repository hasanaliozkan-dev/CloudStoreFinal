<?php
error_reporting(0);
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$db = "clouddb";
$isLogin = false;
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

    if(isset($_POST['delButton'])){
        $delElem = $_POST['delButton'];
        $sqlDelete = "DELETE FROM products WHERE id = '$delElem'";
        $connect->exec($sqlDelete);
        echo "<script type='text/javascript'>alert('Product is deleted successfully');</script>";
    }
    if(isset($_POST['minusButton'])){
        $decElem = $_POST['minusButton'];
        $oldQuan = 0;
        $sqlOld = "SELECT quantity FROM products WHERE id = '$decElem'";

        $result = $connect->query($sqlOld);
        $result = $result->fetch();
        $oldQuan = $result['quantity'];
        $newQuan = $oldQuan-1;
        if($newQuan == 0){
            $sqlDec = "DELETE FROM products WHERE id = '$decElem'";
            $connect->exec($sqlDec);
        }else{
            $sqlDec = "UPDATE `products` SET `quantity`= '$newQuan' WHERE id = '$decElem'";
            $statement = $connect->prepare($sqlDec);
            $statement->execute();
        }


    }
    if(isset($_POST['plusButton'])){
        $incElem = $_POST['plusButton'];
        $oldQuan = 0;
        $sqlOld = "SELECT quantity FROM products WHERE id = '$incElem'";

        $result = $connect->query($sqlOld);
        $result = $result->fetch();
        $oldQuan = $result['quantity'];
        $newQuan = $oldQuan+1;
        $sqlDec = "UPDATE `products` SET `quantity`= '$newQuan' WHERE id = '$incElem'";

        $statement = $connect->prepare($sqlDec);
        $statement->execute();
    }
    if(isset($_POST['updateButton'])){

        $updElem = $_POST['updateButton'];
        $newPrice = $_POST['newPrice'];
        $sqlDec = "UPDATE `products` SET `price`= $newPrice WHERE id = '$updElem'";
        $statement = $connect->prepare($sqlDec);
        $statement->execute();
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
    <title>Search Product</title>
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
            Title:
            <input type="text" name="title">
            Category:
            <input type="text" name="category">
            <input class="btn mb-5" type="submit" name="search" value="Search" id="search">
        </form>
    </div>
    <div class="productList">
        <form action="" method="POST">
            <table class="table container" id="tblProducts">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">CATEGORY</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">PRICE</th>
                    <th scope="col">QUANTITY</th>
                    <th scope="col">CHANGE QUANTITY</th>
                    <th scope="col">UPDATE PRICE</th>
                </tr>
                </thead>
                <tbody>
            </table>

        </form>
    </div>

</section>

<script>
    var searchProducts=[];
    var allProducts = [];
    <?php
    if(isset($_POST['search'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $searchQuery = "SELECT id,title,category,price,quantity FROM products WHERE id = '$id' or title = '$title' or category = '$category'";
        $result = $connect->query($searchQuery);
        $allsearchProducts = array();
        while($row=$result->fetch()){
            array_push($allsearchProducts,$row);
        }
        echo "var searchProducts = " . json_encode($allsearchProducts) . ";";
        $_SESSION['lastProducts'] = $allsearchProducts;
    }
    else{
        $allProductsQuery = "SELECT id,title,category,price,quantity FROM products";
        $resultall = $connect->query($allProductsQuery);
        $allProductsResult = array();
        while($row=$resultall->fetch()){
            array_push($allProductsResult,$row);
        }
        echo "var allProducts = " . json_encode($allProductsResult) . ";";
    }
    $connect = null;
    ?>
    function PlacedProducts(productList){

        var lengthOfSearch = productList.length;
        console.log(lengthOfSearch);
        for (var i = 0; i < lengthOfSearch; i++){
            var tr = document.createElement('tr');
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');
            var td6 = document.createElement('td');
            var td7 = document.createElement('td');

            var id = document.createTextNode(productList[i][0])
            td1.appendChild(id);
            tr.appendChild(td1)

            var category = document.createTextNode(productList[i][2])
            td2.appendChild(category);
            tr.appendChild(td2)

            var title = document.createTextNode(productList[i][1])
            td3.appendChild(title);
            tr.appendChild(td3)

            var price = document.createTextNode(productList[i][3])
            td4.appendChild(price);
            tr.appendChild(td4)
            var quantity = document.createTextNode(productList[i][4])
            td5.appendChild(quantity);
            tr.appendChild(td5)

            var minusButton = document.createElement('button');
            var plusButton = document.createElement('button');
            var delButton = document.createElement('button');

            var nodeDel = document.createTextNode('DELETE')
            var nodeMin = document.createTextNode('-')
            var nodePlu = document.createTextNode('+')
            var formButtons = document.createElement('form')
            formButtons.setAttribute("method","post")

            delButton.appendChild(nodeDel);
            plusButton.appendChild(nodePlu);
            minusButton.appendChild(nodeMin);

            delButton.classList.add("btn","btn-danger")
            plusButton.classList.add("btn","btn-success")
            minusButton.classList.add("btn","btn-warning")

            delButton.style.borderRadius = "10px";
            plusButton.style.borderRadius = "10px";
            minusButton.style.borderRadius = "10px";

            delButton.style.width = "24%";
            plusButton.style.width = "20%";
            minusButton.style.width = "20%";
            minusButton.style.color = "white";

            delButton.setAttribute('type','submit');
            plusButton.setAttribute('type','submit');
            minusButton.setAttribute('type','submit');

            delButton.setAttribute('name','delButton');
            plusButton.setAttribute('name','plusButton');
            minusButton.setAttribute('name','minusButton');

            delButton.setAttribute('value',productList[i].id);
            plusButton.setAttribute('value',productList[i].id);
            minusButton.setAttribute('value',productList[i].id);

            formButtons.appendChild(minusButton)
            formButtons.appendChild(plusButton)
            formButtons.appendChild(delButton)
            td6.append(formButtons)
            tr.appendChild(td6);

            var form = document.createElement("form")
            form.setAttribute("method","POST");


            var newPrice= document.createElement("input")
            var updateButton = document.createElement("button")
            var nodeUp = document.createTextNode('UPDATE')
            updateButton.appendChild(nodeUp);
            updateButton.style.borderRadius = "10px";
            updateButton.classList.add("btn","btn-primary")

            updateButton.setAttribute('type','submit');
            updateButton.setAttribute('name','updateButton');
            updateButton.setAttribute('value',productList[i].id);
            updateButton.style.float = "right";
            newPrice.style.width = "40%";

            newPrice.setAttribute('type' ,'number');
            newPrice.setAttribute('name' ,'newPrice');
            newPrice.classList.add("form-control");
            newPrice.style.border = "1px black solid";
            form.style.display = "flex";
            form.append(newPrice);
            form.append(updateButton)
            td7.append(form)


            tr.appendChild(td7);



            document.getElementById('tblProducts').appendChild(tr);
        }
    }

    PlacedProducts(searchProducts)
    PlacedProducts(allProducts)





</script>
</body>
</html>
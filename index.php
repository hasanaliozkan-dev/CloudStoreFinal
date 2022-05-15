<?php
session_start();
error_reporting(0);
$serverName = "localhost";
$userName = "root";
$password = "";
$dataBaseName = "clouddb";

try {
    $connection = new PDO("mysql:host=$serverName", $userName, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $queryIsExist = "SHOW DATABASES LIKE '$dataBaseName'";
    $exist = $connection->query($queryIsExist);
    $row = $exist->fetch();


    if ($row > 0) {
        $connection = null;
        $connection = $connection = new PDO("mysql:host=$serverName;dbname=$dataBaseName", $userName, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } else {
        echo '<script>alert("There is an error while connection to the DataBase !!! Please refresh the page. ")</script>';
    }
} catch (PDOException $exception) {
    echo "Connection Somehow Failed !!! " . $exception->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cloud Store</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/indexPage.css">
    <script src="cloud_store.js"></script>
</head>
<body style="background-image: url('images/bodyback.jpeg')">


<header class="header" id="header">
    <div class="logo">
        <a href="#"> <img src="../images/logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
        <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; font-family: 'Merriweather', serif;">
            CLOUD STORE</h2>
        <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"><strong>WE HAVE YOUR
                DREAMS IN STORE...</strong></p>
        <div class="header_buttons">
            <div style="float: right" onclick="openBasket()"><img src="images/basket.jpeg"
                                                                  style="height: 80px; width: 80px;border-radius: 33.3%; border: 1px solid black;">
            </div>

        </div>
    </div>

</header>
<nav>
    <ul class="topMenu">
        <li style="color: #ffffff"><?php echo $_SESSION['user'] ?></li>
        <li><a href="#">Main Page</a></li>
        <li><a href="userpages/userSignUp.php">Sign Up</a></li>
        <li><a href="userpages/userSignIn.php">Sign In</a></li>
        <li><a href="userpages/userProfile.php">Profile</a></li>
        <li><a href="adminpages/adminLogin.php">Admin Login</a></li>
        <li><a href="#" class="btnOut">Log Out</a></li>
    </ul>
</nav>
<nav style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
    <div>
        <form method="POST">
            <input type="submit" value="RAINY" class="filterButton" name="rainy">
            <input type="submit" value="DIVINE" class="filterButton" name="divine">
            <input type="submit" value="COLORFUL" class="filterButton" name="colorful">
            <input type="submit" value="BROTHER" class="filterButton" name="brother">
            <input type="submit" value="TECHNO" class="filterButton" name="techno">
        </form>
    </div>

</nav>
<br>

<div id="row" class="row">
</div>

<div class="basket" id="basket">


    <div class="total" id="total">
        <h4> TOTAL PRICE: </h4>
        <strong><p style="text-align: center; margin-top: 22px; bottom: 0">50₺</p></strong>
    </div>
    <button id="buyButton" disabled type="button"
            style="background-color: #FFC4FF; float: right;margin-top: 25px;margin-right:25px; height: 30px; width: 70px;border-radius: 25%; border: 0px"
            onclick="openPayment()"><strong>BUY </strong></button>


</div>
<div class="payment_method" id="payment_method" style="visibility: hidden; border-radius: 10px">
    <form>
        <div style="margin: 25px">
            <label for="address"> ADDRESS</label><input type="text" id="address"
                                                        placeholder="Please enter your address...">
        </div>
    </form>
    <div style="padding: 25px;display: grid">

        <div>
            <table>
                <tbody>
                <tr>
                    <td><label for="cash">CASH</label><input type="radio" name="payment" id="cash"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><label for="creditcard">CREDIT CARD</label><input type="radio" name="payment" id="creditcard">
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
        <tr>


        </tr>
    </div>
    <button type="button" style="float:right; margin-right: 20px; background-color: rgba(0,128,0,0.53);" class="button"
            onclick="confirm()">CONFIRM
    </button>
    <button type="button" style="float:right; margin-right: 20px;background-color: rgba(222,9,9,0.68)" class="button"
            onclick="closePayment()">CANCEL
    </button>
</div>

<script>
    var products = [];
    <?php

    $filters = array(
        "rainy" => " where category = 'Rainy'",
        "divine" => " where category = 'Divine'",
        "brother" => " where category = 'Brother'",
        "colorful" => " where category = 'Colorful'",
        "techno" => " where category = 'Techno'",
    );

    if (!empty($_POST)) {

        $arrayMatch = array_intersect_key($_POST, $filters);
        foreach (array_keys($arrayMatch) as $filterName) {
            $newFilter = $filters[$filterName];
        }
    } else {
        $newFilter = "";
    }
    $sql = "SELECT * FROM products $newFilter";
    $result = $connection->query($sql);
    $products = array();
    while ($row = $result->fetch()) {
        array_push($products, $row);
    }
    echo "var products = " . json_encode($products) . ";";


    $productLength = count($products);



    ?>

    var counter = 0;
    var productLength = <?php echo $productLength ?>;

    class Cloud {
        constructor(title, desc, quantity, price, image_url, category) {
            this.title = title;
            this.desc = desc;
            this.quantity = quantity;
            this.category = category;

            this.price = price;
            this.image_url = image_url;
        }

    }

    var productList = [];
    var basketpro = [];
    for (let i = 0; i < productLength; i++) {

        productList.push(new Cloud(products[i][1], products[i][2],
            parseInt(products[i][3]), parseInt(products[i][4]), products[i][5], products[i][6]));
    }

    lengthOfList = productList.length;

    function displayProducts() {

        for (let i = 0; i < lengthOfList; i++) {

            let row = document.getElementById("row");
            let columnn = document.createElement("div");
            columnn.classList.add("column");
            let containerr = document.createElement("div");
            containerr.classList.add("container");

            let squarre = document.createElement("div");
            squarre.classList.add("square");
            squarre.style.backgroundColor = "#FFF5F3"

            let photo = document.createElement("img");
            photo.src = productList[i].image_url;
            photo.style.maxWidth = "260px";
            photo.style.height = "180px";
            photo.style.borderRadius = "15px";
            let divh1 = document.createElement("div");
            let divh1text = document.createTextNode(productList[i].title);
            divh1.classList.add("h1");
            let divh2 = document.createElement("div");
            let divh2text = document.createTextNode("Category: " + productList[i].category);
            divh2.classList.add("h2");

            divh1.appendChild(divh1text)
            divh2.appendChild(divh2text)
            let description = document.createElement("p");
            let desctext = document.createTextNode(productList[i].desc);
            description.appendChild(desctext);
            let price = document.createElement("p");
            let pricetext = document.createTextNode("Price: " + productList[i].price + " ₺")
            price.appendChild(pricetext)
            let buttondiv = document.createElement("div");
            let addbutton = document.createElement("img");
            addbutton.src = "images/addbasket.jpeg";
            addbutton.classList.add("addbasketclass")
            addbutton.onclick = addToBasket
            addbutton.style.border = "3px solid #958EBD"

            let quantity = document.createElement("p");
            let quanNode = document.createTextNode("Quantity: " + productList[i].quantity);
            quantity.append(quanNode);
            quantity.style.marginTop = "10px";

            buttondiv.appendChild(addbutton);
            squarre.appendChild(photo);
            squarre.appendChild(divh1);
            squarre.appendChild(divh2);
            squarre.appendChild(description);
            squarre.appendChild(price);
            squarre.appendChild(quantity);
            squarre.appendChild(buttondiv);
            containerr.appendChild(squarre);
            columnn.appendChild(containerr);
            row.appendChild(columnn);

        }
        if (basketpro.length !== 0) {
            document.getElementById("buyButton").disabled = false;
        }

    }

    displayProducts()


</script>
</body>

</html>





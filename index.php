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
<nav style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px; background-color: #FFF5F3; display: block">

        <form method="POST">
            <input type="submit" value="RAINY" class="filterButton" name="rainy">
            <input type="submit" value="DIVINE" class="filterButton" name="divine">
            <input type="submit" value="COLORFUL" class="filterButton" name="colorful">
            <input type="submit" value="BROTHER" class="filterButton" name="brother">
            <input type="submit" value="TECHNO" class="filterButton" name="techno">
        </form>

</nav>
<br>

<div id="row" class="row">
</div>

<div class="basket" id="basket">

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
    var basketpro = [];
    sessionStorage.setItem("basket",JSON.stringify(basketpro))
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



    function addToBasket(){
        var parent = event.target.parentElement.parentElement.children;
        console.log(parent[2])
        //constructor(title,desc,quantity,price,image_url,category){
        let image_url = parent[0].src;
        let title = parent[1].innerHTML;
        let category = parent[2].innerHTML;
        let desc = parent[3].innerHTML;
        let price = parent[4].innerHTML;
        let quantity = parent[5].innerHTML;


        let temp = new Cloud(title,desc,quantity,price,image_url,category);

        basketpro.push(temp)
        sessionStorage.setItem("basket",JSON.stringify(basketpro))
        displayBasket()

    }

    basketpro = JSON.parse(sessionStorage.getItem("basket"));
    function displayBasket(){

        let basketcont = document.getElementById("basket");
        basketcont.innerHTML = "<div class=\"total\" id=\"total\">\n" +
            "        <h4> TOTAL PRICE:  </h4>\n" +
            "        <strong><p style=\"text-align: center; margin-top: 22px; bottom: 0\">"+totalPrice()+" ₺</p></strong>\n" +
            "    </div>\n" +
            "    <button id=\"buyButton\"  disabled type=\"button\" style=\"background-color: #FFC4FF; float: right;margin-top: 25px;margin-right:25px; height: 30px; width: 70px;border-radius: 25%; border: 0px\" onclick=\"openPayment()\" > <strong>BUY </strong></button>\n" +
            "\n" +
            "\n";


        if(basketpro.length>0){
            document.getElementById("buyButton").disabled = false;
        }
        for (let i = 0; i < basketpro.length; i++) {
            basketcont = document.getElementById("basket");
            let totall = document.getElementById("total");
            let basket_element = document.createElement("div");
            basket_element.classList.add("basket-element");
            let basket_photo = document.createElement("img");

            basket_photo.src = basketpro[i].image_url;
            basket_photo.classList.add("basketrow");
            basket_photo.classList.add("display-horizantally");
            let productname = document.createElement("h4");
            productname.classList.add("display-horizantally");
            let realproductname = document.createTextNode(basketpro[i].title);
            productname.appendChild(realproductname);
            let priceproduct = document.createElement("p");
            priceproduct.classList.add("display-horizantally")
            let realprice = document.createTextNode(basketpro[i].price);
            priceproduct.appendChild(realprice)
            let removebutton = document.createElement("button")
            removebutton.classList.add("display-horizantally");
            removebutton.classList.add("cart_button");
            let minus = document.createTextNode("-");
            removebutton.onclick = removeFromBasket;
            removebutton.appendChild(minus);
            basket_element.appendChild(basket_photo);
            basket_element.appendChild(productname);
            basket_element.appendChild(priceproduct);
            basket_element.appendChild(removebutton);
            totall.before(basket_element)
        }



    }

    function removeFromBasket(){
        let output=  event.target.parentElement.children;
        let product_name =output[1].innerHTML;
        for (let i = 0; i < basketpro.length; i++) {
            if(basketpro[i].title === product_name){
                basketpro.splice(i,1);
                break;
            }
        }
        sessionStorage.setItem("basket",JSON.stringify(basketpro))
        displayBasket();

    }
    function totalPrice(){
        basketpro = JSON.parse(sessionStorage.getItem("basket"));
        let total = 0;
        for (let i = 0; i < basketpro.length ; i++) {
            total += parseInt(basketpro[i].price.split(" ")[1]);
        }
        return total;




    }

    function openBasket(){

        if(document.getElementById("basket").style.visibility=== "hidden"){
            document.getElementById("basket").style.visibility= "visible";
            displayBasket()
        }
        else {

            document.getElementById("basket").style.visibility= "hidden"
        }
        totalPrice()

    }
    function openPayment(){
        document.getElementById("payment_method").style.visibility = "visible";
        document.getElementById("basket").style.visibility = "hidden";
    }
    function closePayment(){
        document.getElementById("address").value = "";
        document.getElementById("cash").checked = false;
        document.getElementById("creditcard").checked = false;
        document.getElementById("payment_method").style.visibility = "hidden";
    }
    function confirm(){
        if(document.getElementById("address").value === ""
            || (document.getElementById("cash").checked === false
                && document.getElementById("creditcard").checked === false)){
            alert("Please fill all empty places!!!")


        }
        else{
            basketpro = []
            sessionStorage.setItem("basket",JSON.stringify(basketpro));
            document.getElementById("address").value = "";
            document.getElementById("cash").checked = false;
            document.getElementById("creditcard").checked = false;
            document.getElementById("payment_method").style.visibility = "hidden";

        }
    }

    displayProducts()


</script>
</body>

</html>





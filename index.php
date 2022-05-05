<?php
 session_start();
 error_reporting(0);
 $serverName = "localhost";
 $userName = "root";
 $password = "";
 $dataBaseName = "clouddb";

 try{
  $connection = new PDO("mysql:host=$serverName",$userName,$password);
  $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $queryIsExist = "SHOW DATABASES LIKE '$dataBaseName'";
  $exist = $connection->query($queryIsExist);
  $row = $exist->fetch();


  if($row>0){
   $connection = null;
   $connection =  $connection = new PDO("mysql:host=$serverName;dbname=$dataBaseName",$userName,$password);
   $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  }else{
   echo '<script>alert("There is an error while connection to the DataBase !!! Please refresh the page. ")</script>';
  }
 }catch (PDOException $exception){
  echo "Connection Somehow Failed !!! ". $exception->getMessage();
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
<body onload="displayProducts()" style="background-image: url('images/bodyback.jpeg')">



<header class="header" id="header">
 <div class="logo">
     <a href="#"> <img src="../images/logo.jpg" style="height: 100px ;width: 100px; border-radius: 50%"></a>
  <h2 style="padding-left: 20px; margin-bottom: 25px ; margin-top: 20px; font-family: 'Merriweather', serif;">CLOUD STORE</h2>
  <p style=" margin-top: 50px; font-size:25px; font-family: 'Merriweather', sans-serif;"> <strong>WE HAVE YOUR DREAMS IN STORE...</strong></p>
     <div class="header_buttons">
         <div style="float: right" onclick="openBasket()"> <img src="images/basket.jpeg" style="height: 80px; width: 80px;border-radius: 33.3%; border: 1px solid black;" > </div>

     </div>
 </div>

</header>
<nav>
    <ul class="topMenu">
        <li style="color: #ffffff"><?php echo $_SESSION['user']?></li>
        <li><a href="#">Main Page</a></li>
        <li><a href="userpages/userSignUp.php">Sign Up</a></li>
        <li><a href="userpages/userSignIn.php">Sign In</a></li>
        <li><a href="userpages/userProfile.php">Profile</a></li>
        <li><a href="adminpages/adminLogin.php">Admin Login</a></li>
        <li><a href="https://www.google.com.tr" class="btnOut">Log Out</a></li>
    </ul>
</nav>
<br>

<div id= "row" class="row">
</div>

<div class="basket" id="basket">




 <div class="total" id="total">
  <h4> TOTAL PRICE: </h4>
  <strong><p style="text-align: center; margin-top: 22px; bottom: 0">50₺</p></strong>
 </div>
 <button id="buyButton"  disabled type="button" style="background-color: #FFC4FF; float: right;margin-top: 25px;margin-right:25px; height: 30px; width: 70px;border-radius: 25%; border: 0px" onclick="openPayment()" > <strong>BUY </strong></button>




</div>
<div class="payment_method"  id="payment_method" style="visibility: hidden; border-radius: 10px">
 <form>
  <div style="margin: 25px">
   <label for="address"> ADDRESS</label><input type="text" id="address" placeholder="Please enter your address..." >
  </div>
 </form>
 <div style="padding: 25px;display: grid">

  <div >
   <table>
    <tbody>
    <tr>
     <td><label for="cash">CASH</label><input type="radio" name="payment" id="cash"></td>
     <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
     <td > <label for="creditcard">CREDIT CARD</label><input type="radio" name="payment" id="creditcard" ></td>

    </tr>
    </tbody>
   </table>
  </div>
  <tr>


  </tr>
 </div>

 <button type="button" style="float:right; margin-right: 20px; background-color: rgba(0,128,0,0.53);" class="button" onclick="confirm()">CONFIRM</button>
 <button type="button" style="float:right; margin-right: 20px;background-color: rgba(222,9,9,0.68)" class="button" onclick="closePayment()">CANCEL</button>
</div>

<div class="payment_method" id="addcloud" style="height: 500px; visibility: hidden; border-radius: 10px">
 <div style="margin: 50px">
  <label for="name"> Cloud Name</label><input type="text" id="name" placeholder="The name of your cloud..."><br><br>
  <label for="desc"> Cloud Description</label><input type="text" id="desc" placeholder="One sentence description of cloud..."><br><br>
  <label for="imageurl"> Cloud Image</label><input type="text" id="imageurl" placeholder="The url of your cloud..."><br><br>
  <label for="price"> Cloud Price </label><input type="number" id="price" placeholder="How much do you want???"><br><br>
  <button type="button" class="button" style="background-color: rgba(0,128,0,0.53)" onclick="addCloud()"> ADD </button>
  <button type="button" class="button" style="background-color: rgba(222,9,9,0.68)" onclick="closeAddCloud()"> CANCEL </button>

 </div>
</div>

</body>
</html>





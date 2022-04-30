<?php
error_reporting(0);
session_start();
$server = "localhost";
$userName = "root";
$password = "";
$db = "mobilephonedb";
$isLogin = false;
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_POST['btnLogin']){
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
    <link rel="stylesheet" href="styles/adminStyle.css">
</head>
<body>
<h1>Admin Panele Hoşgeldin <?php echo $_SESSION['admin']?></h1>
<nav>
    <ul class="topMenu">
        <a href="#" ><img src="image/logo.png" alt=""></a>
        <li><a href="#">Ürün Listele</a></li>
        <li><a href="adminPanelAppend.php">Ürün Ekle</a></li>
        <li><a href="adminPanelAppendAdmin.php" class="btnOut">Admin Ekle</a></li>
        <li><a href="logOut.php" class="btnOut">Güvenli Çıkış</a></li>
    </ul>
</nav>

<section>
    <div class="searchTab">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            ID:
            <input type="text" name="id">
            Marka:
            <input type="text" name="brand">
            Model:
            <input type="text" name="model">
            <input type="submit" name="btnSearch" value="Ara">
        </form>
    </div>
    <div class="productList">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <table id="tblProducts">
                <tr><th>ID</th><th>Brand</th><th>Model</th></tr>
            </table>
        </form>
    </div>
</section>
<script>
    var searchData=[];
    <?php
    if(isset($_POST['btnSearch'])){
        $id = $_POST['id'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $searchQuery = "SELECT id,brand,model FROM products WHERE id = '$id' or brand = '$brand' or model = '$model'";
        $result = $connect->query($searchQuery);
        $allSearchData = array();
        while($row=$result->fetch()){
            array_push($allSearchData,$row);
        }
        echo "var searchData = " . json_encode($allSearchData) . ";";
        $_SESSION['lastProducts'] = $allSearchData;
    }
    function listProductsAfterDel(){

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
            var id = document.createTextNode(productList[i].id)
            td1.appendChild(id);
            tr.appendChild(td1)
            var brand = document.createTextNode(productList[i].brand)
            td2.appendChild(brand);
            tr.appendChild(td2)
            var model = document.createTextNode(productList[i].model)
            td3.appendChild(model);
            tr.appendChild(td3)
            var btnDel = document.createElement('button');
            var nodeDel = document.createTextNode('Sil')
            btnDel.appendChild(nodeDel);
            btnDel.setAttribute('type','submit');
            btnDel.setAttribute('name','btnDel');
            btnDel.setAttribute('value',productList[i].id);
            tr.appendChild(btnDel);
            document.getElementById('tblProducts').appendChild(tr);
        }
    }
    PlacedProducts(searchData)
</script>
</body>
</html>
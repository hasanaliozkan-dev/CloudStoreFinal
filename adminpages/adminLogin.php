<?php
error_reporting(0);
if($_GET["Login"] =="yes"){
    $message = "Hatalı Giriş";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- TODO Extract the styles to css and center the contents-->
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
<body style=" background-image: url('/images/bodyback.jpeg');">
<div  class="container mt-5" style="width: 25%; background-color: #FFF5F3" >
    <h3 class=" text-center pt-3 mb-3"> Login as Admin</h3>
    <form method="post" action="../adminpages/adminUI.php">
        <div class="mb-5  text-center">
            <label for="fUserName" class="form-label">User Name</label>
            <input type="text" class="form-control" id="fUserName"  name="fUserName" placeholder="User Name">
        </div>
        <div class="mb-5  text-center">
            <label for="fPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="fPassword" name="fPassword" placeholder="Password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn mb-5" id="login">Login</button>
        </div>
    </form>

</div>

</body>
</html>
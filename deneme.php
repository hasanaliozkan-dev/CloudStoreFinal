

<?php

$a = 3;
$b = 3;
if($a == $b){
    echo '
    <script>alert("There is an error while connection to the DataBase !!! Please refresh the page. ")</script>
';
}else{
    echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
   <p> Everything is OK </p>

</body>
</html>';
}


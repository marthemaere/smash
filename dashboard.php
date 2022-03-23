<?php
include_once("bootstrap.php");

$conn = Db::getInstance();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="logo">Smasssh</a>
    <a href="logout.php" class="navbar__logout"> logout </a>
</nav>

<h1> Welcome to the smash platform,  <?php echo $_SESSION['username'];?> </h1>


    
</body>
</html>

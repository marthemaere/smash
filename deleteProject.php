<?php
    include_once(__DIR__ . "/bootstrap.php");
    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    }
    //ga terug naar de settings
    if (!empty($_POST['disprove'])) {
        header('Location: index.php');
    }
    $id = $_SESSION['id'];
    //verwijder het account
    if (!empty($_POST['confirm'])) {
        try {
            $post = Post::deleteProject($postId);
           // header('Location: index.php');
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Document</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <form action="" method="post">
            <h1 class="header">Are you sure you want to delete your project?</h1>
            <div class="d-flex justify-content-center">
                <input class="btn btn-outline-primary m-2" type="submit" value="No" name="disprove">
                <input class="btn btn-dark m-2"  type="submit" value="Yes" name="confirm">
            </div>
        
        </form>
    </div>
    
</body>
</html>
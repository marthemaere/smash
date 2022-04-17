<?php
    include_once("bootstrap.php");
	
      /*  $id = session_create_id();	
        session_id($id);
        print("\n"."Id: ".$id);
        session_start();    
        session_commit();  
*/


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
    <title>Feed</title>



</head>
<body>
    <?php require_once("header.php"); ?>
    <?php 
    if(empty($_POST)) 
        echo '<div class = "empty-state">
        <img class="empty-state-picture" src="assets\images\empty-box.svg" alt="emptystate">
        <p> No projects were found. </p> </div>'
    ?>
    <div class="d-flex justify-content-center"><a class="btn btn-primary" href="/php/smash/uploadProject.php">Upload Project</a></div>
    
    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
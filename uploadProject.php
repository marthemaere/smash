<?php
include_once("bootstrap.php");


?>

<!DOCTYPE html>
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
    <title>Upload your project</title>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="upload-intro"> 
        <h1> What are you working on? Show us all of it! #excited 🤩 </h1> 
        <p> Upload your project. </p>
    </div>
    <form class="uploadzone" action="project.php" method ="POST" enctype="multipart/form-data">
        <label for="title">Give your project a name</label>
        <input type="text" id="title" name="title" placeholder="Enter projectname"> <br>

        <label for="freeTags">Add tags to your project</label>
        <input type="text" id="freeTags" name="freeTags" placeholder="Enter tags to your project"> <br>

        <label for="image">Select a file:</label>
        <input type="file" id="file" name="file"> <br>

        <input type="submit" value="Upload project" name="submit">
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>
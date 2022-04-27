<?php
include_once("bootstrap.php");

session_start();

if (!empty($_POST)) {
    try {

        //post aanmaken
    
        $post = new Post();
        $post->setTitle($_POST['title']);
        $post->setDescription($_POST['description']);
        $id = $post->canUploadProject();

        //tags toevoegen
        $tags = new Tag();
        $tags->setTag($_POST['tags']);
        $tags->addTagsToDatabase($id);

        $userId= $_SESSION['id'];
        $post->setUserId($userId);
        //$post->canUploadProject();
        
        header("Location: index.php");


    } catch (\Throwable $e) {
        $error = $e->getMessage();
    }
}

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
    <?php if (isset($error)):?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif;?>
  

    <div class="login--form col">
    <div class="form form--login">
    <form class="uploadzone" action="#" method ="POST" enctype="multipart/form-data">

        <fieldset>  
        <label for="floatingInput">Give your project a name</label>
        <input type="text" class="form-control" id="floatingInput" name="title" > <br>
        </fieldset>

        <fieldset>
        <label for="title">Tell us more about your project</label>
        <textarea name="description" class="form-control" id="description" cols="50" rows="3" ></textarea>
        </fieldset>


        <fieldset>
        <label for="tags">Add tags to your project</label>
        <input type="text" class="form-control" id="tags" name="tags" > <br>
        </fieldset>

        <fieldset>
        <label class="form-label" for="image"></label>
        <input type="file" class="form-control" id="customFile" name="file"> <br>
        <div class="form-text">JPG or PNG. Max size of 2MB</div>
        </fieldset>

        <input class="btn btn-dark" type="submit" value="Upload project" name="submit">
        </div>
        </div>

    <?php require_once("footer.php"); ?>
</body>
</html>
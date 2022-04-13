<?php
    include_once("bootstrap.php");

    if (isset($_POST['submit'])) {
        try {
        
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setImage($_POST['image']);
            $post->setProjectInDatabase();
            $post->canUploadProject($file);
            
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
    <title>Your new project</title>
</head>
<body>
    
</body>
</html>
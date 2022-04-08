<?php
    include_once("bootstrap.php");

    if (isset($_POST['submit'])) {
        try {
            //upload projects
            $file = $_FILES['file'];
            print_r($file);
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];
        
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt)); //check in lowercase
        
            $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'svg');
        
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 500000) {
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = 'uploaded_projects/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
        
                        
                    } else {
                        echo("Your file is too large!");
                    }
                } else {
                    echo("There was an error uploading your file");
                }
            } else {
                echo("You cannot upload files of this type");
            }
        
            $post = new Post();
            $post->setTitle($_POST['title']);
            $post->setProjectInDatabase();
            
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
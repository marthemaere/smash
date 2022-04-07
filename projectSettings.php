<?php

/*if (isset($_POST['submit']) && isset($_FILES['myProject'])) {
 
    $project = $_FILES['myProject'];
    print_r($project);
    $projectName = $_FILES['myProject']['name'];
    $projectTmpName = $_FILES['myProject']['tmp_name'];
    $projectSize = $_FILES['myProject']['size'];
    $projectError = $_FILES['myProject']['error'];
    $projectType = $_FILES['myProject']['type'];

    $projectExt = explode('.', $projectName);
    $projectActualExt = strtolower(end($projectExt)); //check in lowercase

    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'svg');

    if (in_array($projectActualExt, $allowed)) {
        if ($projectError === 0) {
            if ($projectSize < 500000) {
                $projectNameNew = uniqid('', true) . "." . $projectActualExt;
                $projectDestination = 'uploaded_projects/' . $projectNameNew;
                move_uploaded_file($projectTmpName, $projectDestination);

                //insert into database


            } else {
                echo  "Your file is too large!";
            }
        } else {
            echo  "There was an error uploading your file";
        }
    } else {
        echo  "You cannot upload files of this type";
    }
}*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project settings</title>
</head>

<body>
    <h1>hallo</h1>

</body>

</html>
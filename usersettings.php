<?php
    include_once("bootstrap.php");
    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        try {
            $user = new User();
            $sessionId = $_SESSION['id'];
            $userDataFromId = User::getUserDataFromId($sessionId);
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }
    }

    if (!empty($_POST['submitProfilePicture'])) {
        $user->canUploadPicture($sessionId);
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.scss">
    <title>Settings</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="">
                <!-- <label for="profilePicture">Profile picture</label> -->
                <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="" alt="profile picture" style="width: 100px;">
                <input type="file" name="profilePicture" id="profilePicture">
                <input type="submit" name="submitProfilePicture" value="Upload">
            </div>
        </form>
    </div>
</body>
</html>
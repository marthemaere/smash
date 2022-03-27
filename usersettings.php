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
        $file = $_FILES['profilePicture'];
        $fileName = $_FILES['profilePicture']['name'];
        $fileTmpName = $_FILES['profilePicture']['tmp_name'];
        $fileSize = $_FILES['profilePicture']['size'];
        $fileError = $_FILES['profilePicture']['error'];
        $fileError = $_FILES['profilePicture']['type'];
        
        $fileTarget = 'profile_pictures/' . basename($fileName);
        $fileExtention = strtolower(pathinfo($fileTarget, PATHINFO_EXTENSION));
        
        $fileIsImage = getimagesize($fileTmpName);

        // Check if file is an image
        if ($fileIsImage !== false) {
            $canUpload = true;
        } else {
            $error = 'Uw geupload bestand is geen afbeelding.';
            $canUpload = false;
        }

        // Check if file already exists
        if (file_exists($fileTarget)) {
            $canUpload = true;
        }

        // Check if file-size is under 2MB
        if ($fileSize > 2097152) { // 2097152 bytes
            $error = 'Je afbeelding mag niet groter zijn dan 2MB, probeer opnieuw.';
            $canUpload = false;
        }

        // Check if format is JPG, JPEG or PNG
        if ($fileExtention != 'jpg' && $fileExtention != 'jpeg' && $fileExtention != 'png' && !empty($fileName)) {
            $error = 'Dit bestandstype wordt niet ondersteund. Upload een jpg of png bestand.';
            $canUpload = false;
        }

        // Upload file when no errors
        if ($canUpload) {
            if (move_uploaded_file($fileTmpName, $fileTarget)) {
                $profilePicture = basename($fileName);
                $user->setProfilePicture($profilePicture);
                $user->uploadPicture($profilePicture, $sessionId);
            }
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Settings</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="">
        <?php if (isset($error)): ?>
            <div class="formError"><?php echo $error; ?></div>
        <?php endif; ?>
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
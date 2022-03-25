<?php
    include_once("bootstrap.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
</head>
<body>
    <div class="">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="">
                <!-- <label for="profilePicture">Profile picture</label> -->
                <img src="profile_picture/default.png" class="" alt="profile picture">
                <input type="file" name="profilePicture" id="profilePicture">
                <input type="submit" name="submitProfilePicture" value="Upload">
            </div>
        </form>
    </div>
</body>
</html>
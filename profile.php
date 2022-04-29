<?php
    include_once("bootstrap.php");
    session_start();
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
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
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Profile</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1">Fien Gérardi • <span>16 followers</span></p>
                <p class="biography">Ready to ace all of my designs and code.</p>
                <p class="education">Interactive Multimedia Design</p>
                <div class="my-4">
                    <a href="#" class="btn btn-primary">Follow</a>
                    <a href="#" class="btn btn-outline-primary">Report user</a>
                    <a href="#" class="btn btn-outline-primary">...</a> <!--link to socials-->
                </div>
            </div>
            <div class="project--item--latest col m-3" style="background-color: lightgrey;"></div>
        </div>
        <div class="">
            <h4 class="header py-1">All projects</h4>
            <div class="row">
                <div class="project--item col-12 mb-5" style="background-color: lightgrey; height: 300px" ></div>
                <div class="project--item col-12 mb-5" style="background-color: lightgrey; height: 300px" ></div>
                <div class="project--item col-12 mb-5" style="background-color: lightgrey; height: 300px" ></div>
            </div>
            <div class="d-grid col-4 mx-auto">
                <a href="#" class="btn btn-primary text-center">More projects</a>
            </div>
        </div>
    </div>

    <?php echo include_once('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
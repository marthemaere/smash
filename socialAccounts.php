<?php
    include_once("bootstrap.php");
    session_start();
    
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Settings</title>
    
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="header">
            <h1 class="">Settings</h1>
            <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="img-thumbnail rounded-circle" alt="profile picture">
        </div>

        <div class="row">
            <div class="col-3">
            <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action " href="usersettings.php">Account</a>
                    <a class="list-group-item list-group-item-action " href="editProfile.php">Edit profile</a>
                    <a class="list-group-item list-group-item-action " href="changePassword.php">Change password</a>
                    <a class="list-group-item list-group-item-action active" href="socialAccounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" href="deleteAccount.php">Remove account</a>
                </div>
            </div>

             <!-- ChangePassword -->
             <div class="col-9">
             <!-- AddSocialAccounts -->
             <div class="tab-pane fade active show" id="socials" role="tabpanel" aria-labelledby="socials-list">
                        <h2 class="mb-4">Share social links</h2>
                        <form action="" method="post">
                            <div class="social-link-item my-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="text" class="form-control" name="linkedin" id="linkedin">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="instagram" id="instagram">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="github" class="form-label">GitHub</label>
                                <input type="text" class="form-control" name="github" id="github">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="codepen" class="form-label">CodePen</label>
                                <input type="text" class="form-control" name="codepen" id="codepen">
                            </div>
                            
                            <div class="social-link-item my-3">
                                <label for="behance" class="form-label">Behance</label>
                                <input type="text" class="form-control" name="behance" id="behance">
                            </div>

                            <input type="submit" class="btn btn-dark mt-4" name="updateSocialProfiles" value="Update social profiles">
                        </form>
                    </div>
            </div>
        </div>
    </div>

    

</body>
</html>
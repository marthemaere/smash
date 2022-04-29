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

    if (!empty($_POST['updateSocialProfiles'])) {
        try {
            $linkedIn = $user->setSocialLinkedIn($_POST['linkedin']);
            $instagram = $user->setSocialInstagram($_POST['instagram']);
            $gitHub = $user->setSocialGitHub($_POST['github']);
            $userId = $user->setUserId($sessionId);
            $user->updateSocials();

            $userDataFromId = User::getUserDataFromId($sessionId);
            $success = "Social profiles successfully saved.";
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }
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

            <div class="col-9">
                <div class="" id="socials" role="tabpanel" aria-labelledby="socials-list">
                    <h2 class="mb-4">Share social links</h2>
                    <p>
                        Add links of your other social media accounts to your profile to share your work.
                    </p>
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <p class="alert alert-success"><?php echo $success; ?></p>
                    <?php endif; ?>
                    <form action="" method="post">
                            <div class="social-link-item my-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" name="linkedin" id="linkedin" value="<?php echo $userDataFromId['social_linkedin']; ?>">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" name="instagram" id="instagram" value="<?php echo $userDataFromId['social_instagram']; ?>">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="github" class="form-label">GitHub</label>
                                <input type="url" class="form-control" name="github" id="github" value="<?php echo $userDataFromId['social_github']; ?>">
                            </div>

                        <input type="submit" class="btn btn-dark mt-4" name="updateSocialProfiles" value="Update social profiles">
                    </form>
                </div>
            </div>
        </div>
    </div>

    

</body>
</html>
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
    <?php include_once('style.php'); ?>
    <title>Settings</title>
    
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <p class="ps-3 pt-5 text-muted"><?php echo htmlspecialchars($userDataFromId['username']); ?> / Settings / Socials</p>
        <h1 class="ps-3">Share your socials</h1>

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
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <p class="alert alert-success"><?php echo $success; ?></p>
                    <?php endif; ?>
                    <form action="" method="post">
                            <div class="social-link-item">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" name="linkedin" id="linkedin" value="<?php echo htmlspecialchars($userDataFromId['social_linkedin']); ?>">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" name="instagram" id="instagram" value="<?php echo htmlspecialchars($userDataFromId['social_instagram']); ?>">
                            </div>

                            <div class="social-link-item my-3">
                                <label for="github" class="form-label">GitHub</label>
                                <input type="url" class="form-control" name="github" id="github" value="<?php echo htmlspecialchars($userDataFromId['social_github']); ?>">
                            </div>

                        <input type="submit" class="btn btn-dark mt-4" name="updateSocialProfiles" value="Update social profiles">
                    </form>
                </div>
            </div>
        </div>
    </div>

    

</body>
</html>
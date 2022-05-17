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
    if (!empty($_POST['delete'])) {
        try {
            User::deleteUser($sessionId);
            Post::deletePosts($sessionId);
            Comment::deleteComments($sessionId);
            Like::deleteLikesFromUser($sessionId);
            Follower::deleteFollowers($sessionId);
            header('Location: index.php');
            session_destroy();
        } catch (Throwable $e) {
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

        <!-- are you sure alert -->
        <div class="modal fade" id="deleteAccount" aria-hidden="true" aria-labelledby="deleteAccountLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountLabel">Are you sure you want to delete your account?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                <div class="modal-footer">
                <button class="btn btn-outline-primary" data-bs-toggle="modal">No</button>
                    <input type="submit" value="Yes" name="delete" class="btn btn-primary" data-bs-toggle="modal">
                </div>
                </form>
                            
                </div>
            </div>
        </div>
        <!-- are you sure alert -->

        <div class="row">
            <div class="col-sm-12 col-md-auto col-lg-3">
            <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action" href="account-info.php">Account info</a>
                    <a class="list-group-item list-group-item-action" href="edit-profile.php">Edit profile</a>
                    <a class="list-group-item list-group-item-action" href="change-password.php">Change password</a>
                    <a class="list-group-item list-group-item-action active" href="social-accounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="modal" role="button" href="#deleteAccount">Remove account</a>
                </div>
            </div>

            <div class="col-sm-12 col-md-auto col-lg-3">
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

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
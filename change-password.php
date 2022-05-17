<?php
    include_once("bootstrap.php");
    session_start();
    $sessionId = $_SESSION['id'];
    $userDataFromId = User::getUserDataFromId($sessionId);
    
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        if (!empty($_POST['updatePassword'])) {
            $email = $_SESSION['email'];
            $oldpassword = $_POST['currentPassword'];
            $newpassword = $_POST['newPassword'];
            $confirmation = $_POST['confirmPassword'];
            try {
                $checkPassword = User::checkPassword($email, $oldpassword);
                if ($newpassword == $confirmation) {
                    User::changePassword($email, $newpassword);
                    $success = "Password successfully changed.";
                } else {
                    $error = "Passwords don't match.";
                }
            } catch (\Throwable $e) {
                $error =  $e->getMessage();
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
        <p class="ps-3 pt-5 text-muted"><?php echo htmlspecialchars($userDataFromId['username']); ?> / Settings / Password</p>
        <h1 class="ps-3">Change password</h1>

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
                    <a class="list-group-item list-group-item-action active " href="change-password.php">Change password</a>
                    <a class="list-group-item list-group-item-action" href="social-accounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="modal" role="button" href="#deleteAccount">Remove account</a>
                </div>
            </div>

             <!-- ChangePassword -->
             <div class="col-sm-12 col-md-auto col-lg-9">
             <div class="tab-pane fade active show" id="password" role="tabpanel" aria-labelledby="password-list">
                        <?php if (isset($error)): ?>
                            <p class="alert alert-danger"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <p class="alert alert-success"><?php echo $success; ?></p>
                        <?php endif; ?>

                        <form action="" method="post">
                            <fieldset>
                                <label for="password" class="form-label">Current password</label>
                                <input type="password" class="form-control" id="password" name="currentPassword" minlength="6" required>
                            </fieldset>
                            
                            <fieldset>
                                <label for="password" class="form-label">New password</label>
                                <input type="password" class="form-control" id="password" name="newPassword" minlength="6" required>
                                <div class="form-text">Minimum 6 characters</div>
                            </fieldset>
                            <fieldset>
                                <label for="password" class="form-label">Confirm new password</label>
                                <input type="password" class="form-control" id="password" name="confirmPassword" minlength="6" required>
                            </fieldset>
                            <input type="submit" id="change-password" class="btn btn-dark mt-4" name="updatePassword" value="Change password">
                        </form>
                    </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
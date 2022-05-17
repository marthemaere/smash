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
        try {
            $fileName = $_FILES['profilePicture']['name'];
            $fileTmpName = $_FILES['profilePicture']['tmp_name'];
            $fileSize = $_FILES['profilePicture']['size'];

            $user->canUploadPicture($sessionId, $fileName, $fileTmpName, $fileSize);
            $success = "Profile picture saved.";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    if (!empty($_POST['updateProfile'])) {
        try {
            $biography = $user->setBiography($_POST['biography']);
            $secondEmail = $user->setSecondEmail($_POST['secondEmail']);
            $education = $user->setEducation($_POST['education']);
            $userId = $user->setUserId($sessionId);
            $user->updateProfile();

            $userDataFromId = User::getUserDataFromId($sessionId);
            $success = "Profile changes successfully saved.";
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
        <p class="ps-3 pt-5 text-muted"><?php echo htmlspecialchars($userDataFromId['username']); ?> / Settings / Profile</p>
        <h1 class="ps-3">Edit profile</h1>

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
            <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action" href="account-info.php">Account info</a>
                    <a class="list-group-item list-group-item-action active" href="edit-profile.php">Edit profile</a>
                    <a class="list-group-item list-group-item-action" href="change-password.php">Change password</a>
                    <a class="list-group-item list-group-item-action" href="social-accounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="modal" role="button" href="#deleteAccount">Remove account</a>
                 </div>
            </div>

            <!-- EditProfile -->
            <div class="col-sm-12 col-md-8 col-lg-9">
            <div class="tab-pane fade active show" >
                        <?php if (isset($error)): ?>
                            <p class="alert alert-danger"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <p class="alert alert-success"><?php echo $success; ?></p>
                        <?php endif; ?>
                        <!-- EditProfile > ProfilePicture -->
                        <div class="profile-picture pb-3">
                            <img src="profile_pictures/<?php echo htmlspecialchars($userDataFromId['profile_pic']); ?>" class="img-thumbnail rounded-circle" alt="profile picture">
                            <a href="#" class="btn btn-primary" id="upload-new-picture">Upload new picture</a>
                            <div id="upload-file">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <fieldset class="">
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="profilePicture" id="profilePicture">
                                            <input type="submit" class="input-group-text" name="submitProfilePicture" value="Upload">
                                        </div>
                                        <div class="form-text">JPG or PNG. Max size of 2MB</div>
                                    </fieldset>
                                </form>
                            </div>
                            <a href="#" class="btn btn-outline-primary">Delete</a>
                        </div>

                        <!-- EditProfile > ProfileInfo -->
                        <div class="profile-info">
                            <form action="" method="post">
                                <fieldset>
                                    <label for="biography" class="form-label">Biography</label>
                                    <textarea name="biography" class="form-control" id="biography" cols="50" rows="3"><?php echo htmlspecialchars($userDataFromId['bio']); ?></textarea>
                                    <div class="form-text">Brief description for your profile.</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Second email</label>
                                    <input type="text" class="form-control" name="secondEmail" id="secondEmail" value="<?php echo htmlspecialchars($userDataFromId['second_email']);?>">
                                    <div class="form-text">When you lose access from your school account.</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" id="education" value="<?php echo htmlspecialchars($userDataFromId['education']);?>">
                                    <div class="form-text">Add your education to complete your profile.</div>
                                </fieldset>

                                <input type="submit" class="btn btn-dark mt-4" name="updateProfile" value="Save profile">
                            </form>
                        </div>
            </div>
            </div>
        </div>
    </div>

    <script src="javascript/usersettings.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
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
                    <a class="list-group-item list-group-item-action active" href="editProfile.php">Edit profile</a>
                    <a class="list-group-item list-group-item-action" href="changePassword.php">Change password</a>
                    <a class="list-group-item list-group-item-action" href="socialAccounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" href="deleteAccount.php">Remove account</a>
                </div>
            </div>

            <!-- EditProfile -->
            <div class="col-9">
            <div class="tab-pane fade active show" >
                        <h2 class="mb-4">Edit profile</h2>
                        <?php if (isset($error)): ?>
                            <p class="alert alert-danger"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <p class="alert alert-success"><?php echo $success; ?></p>
                        <?php endif; ?>
                        <!-- EditProfile > ProfilePicture -->
                        <div class="profile-picture">
                            <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="img-thumbnail rounded-circle" alt="profile picture">
                            <a href="#" class="btn btn-primary" id="upload-new-picture">Upload new picture</a>
                            <div id="upload-file">
                                <?php if (isset($error)): ?>
                                <div class="formError"><?php echo $error; ?></div>
                                <?php endif; ?>

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
                                    <textarea name="biography" class="form-control" id="biography" cols="50" rows="3"><?php echo $userDataFromId['bio']; ?></textarea>
                                    <div class="form-text">Brief description for your profile.</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Second email</label>
                                    <input type="text" class="form-control" name="secondEmail" id="secondEmail" value="<?php echo $userDataFromId['second_email'];?>">
                                    <div class="form-text">When you lose access from your school account.</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" id="education" value="<?php echo $userDataFromId['education'];?>">
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

</body>
</html>
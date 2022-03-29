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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.scss">
    <title>Settings</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="header">
            <h1>Settings</h1>
            <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="img-thumbnail rounded-circle" alt="profile picture">
        </div>

        <div class="row" role="tabpanel">
            <div class="col-3">
                <div class="list-group" id="myList" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">Account</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#profile" role="tab">Edit profile</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">Change password</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#socials" role="tab">Social profiles</a>
                    <a class="list-group-item list-group-item-action" href="#">Remove account</a>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="account" role="tabpanel">
                        <form action="">
                            <fieldset>
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="name" id="name" readonly>
                            </fieldset>

                            <fieldset>
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" readonly>
                            </fieldset>

                            <fieldset>
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" readonly>
                            </fieldset>
                        </form>
                    </div>

                    </div>
                    <div class="tab-pane" id="profile" role="tabpanel">
                        <div class="profile-picture">
                            <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="img-thumbnail rounded-circle" alt="profile picture">
                            <a href="#" class="btn btn-primary">Upload new picture</a>
                            <div class="">
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
                            <a href="#" class="btn btn-primary">Delete</a>
                        </div>

                        <div class="profile-info">
                            <form action="" method="post">
                                <fieldset>
                                    <label for="biography" class="form-label">Biography</label>
                                    <textarea name="biography" class="form-control" id="biography" cols="50" rows="3" placeholder=""></textarea>
                                    <div class="form-text">Brief description for your profile.</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Second email</label>
                                    <input type="text" class="form-control" name="secondEmail" id="secondEmail">
                                    <div class="form-text">When you lose access from your school account</div>
                                </fieldset>

                                <fieldset>
                                    <label for="education" class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" id="education">
                                    <div class="form-text">Add your education to complete your profile.</div>
                                </fieldset>

                                <input type="submit" class="btn btn-primary" name="updateProfile" value="Save profile">
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane" id="password" role="tabpanel">
                        <div class="display-error">
                            <p class="">Serve error</p>
                        </div>

                        <form action="" method="post">
                            <fieldset>
                                <label for="password" class="form-label">Current password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            </fieldset>
                            
                            <fieldset>
                                <label for="password" class="form-label">New password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                <div class="form-text">Minimum 6 characters</div>
                            </fieldset>
                            <input type="submit" class="btn btn-primary" name="updatePassword" value="Change password">
                        </form>
                    </div>

                    <div class="tab-pane" id="socials" role="tabpanel">
                        <form action="" method="post">
                            <div class="social-link-item">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="text" class="form-control" name="linkedin" id="linkedin">
                            </div>

                            <div class="social-link-item">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="instagram" id="instagram">
                            </div>

                            <div class="social-link-item">
                                <label for="github" class="form-label">GitHub</label>
                                <input type="text" class="form-control" name="github" id="github">
                            </div>

                            <div class="social-link-item">
                                <label for="codepen" class="form-label">CodePen</label>
                                <input type="text" class="form-control" name="codepen" id="codepen">
                            </div>
                            
                            <div class="social-link-item">
                                <label for="behance" class="form-label">Behance</label>
                                <input type="text" class="form-control" name="behance" id="behance">
                            </div>

                            <input type="submit" class="btn btn-primary" name="updateSocialProfiles" value="Update social profiles">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
</body>
</html>
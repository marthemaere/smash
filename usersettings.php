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
        <div class="row">
            <div class="col-3">
                <ul>
                    <li>Account info</li>
                    <li>Edit profile</li>
                    <li>Change password</li>
                    <li>Social profiles</li>
                    <li>Remove account</li>
                </ul>
            </div>

            <div class="col-9">
                <div class="general">
                    <form action="">
                        <fieldset>
                            <label for="username">Username</label>
                            <input type="text" name="name" id="name">
                        </fieldset>

                        <fieldset>
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name">
                        </fieldset>

                        <fieldset>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email">
                        </fieldset>
                    </form>
                </div>

                <div class="edit-profile">
                    <div class="profile-picture">
                        <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" alt="profile picture" style="width: 100px;">
                        <a href="#">Upload new picture</a>
                        <div class="">
                            <?php if (isset($error)): ?>
                            <div class="formError"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form action="" method="post" enctype="multipart/form-data">
                                <fieldset class="">
                                    <input type="file" name="profilePicture" id="profilePicture">
                                    <input type="submit" name="submitProfilePicture" value="Upload">
                                    <div>JPG or PNG. Max size of 2MB</div>
                                </fieldset>
                            </form>
                        </div>
                        <a href="#">Delete</a>
                    </div>

                    <div class="profile-info">
                        <form action="" method="post">
                            <fieldset>
                                <label for="biography">Biography</label>
                                <textarea name="biography" id="biography" cols="50" rows="3" placeholder=""></textarea>
                                <div>Brief description for your profile.</div>
                            </fieldset>

                            <fieldset>
                                <label for="education">Second email</label>
                                <input type="text" name="secondEmail" id="secondEmail">
                                <div>When you lose access from your school account</div>
                            </fieldset>

                            <fieldset>
                                <label for="education">Education</label>
                                <input type="text" name="education" id="education">
                                <div>Add your education to complete your profile.</div>
                            </fieldset>

                            <input type="submit" name="updateProfile" value="Save profile">
                        </form>
                    </div>
                </div>

                <div class="change-password">
                    <div class="display-error">
                        <p>Serve error</p>
                    </div>

                    <form action="" method="post">
                        <fieldset>
                            <label for="pass">Current password</label>
                            <input type="password" id="pass" name="password" minlength="8" required>
                        </fieldset>
                        
                        <fieldset>
                            <label for="pass">New password</label>
                            <input type="password" id="pass" name="password" minlength="8" required>
                            <div>Minimum 6 characters</div>
                        </fieldset>
                        <input type="submit" name="updatePassword" value="Change password">
                    </form>
                </div>

                <div class="social-links">
                    <form action="" method="post">
                        <div class="social-link-item">
                            <label for="linkedin">LinkedIn</label>
                            <input type="text" name="linkedin" id="linkedin">
                        </div>

                        <div class="social-link-item">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instagram" id="instagram">
                        </div>

                        <div class="social-link-item">
                            <label for="github">GitHub</label>
                            <input type="text" name="github" id="github">
                        </div>

                        <div class="social-link-item">
                            <label for="codepen">CodePen</label>
                            <input type="text" name="codepen" id="codepen">
                        </div>
                        
                        <div class="social-link-item">
                            <label for="behance">Behance</label>
                            <input type="text" name="behance" id="behance">
                        </div>

                        <input type="submit" name="updateSocialProfiles" value="Update social profiles">
                    </form>
                </div>
                
                <a href="#">Remove account</a>
            </div>
        </div>
    </div>
</body>
</html>
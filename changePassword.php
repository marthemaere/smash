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
                    <a class="list-group-item list-group-item-action active" href="changePassword.php">Change password</a>
                    <a class="list-group-item list-group-item-action" href="socialAccounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" href="deleteAccount.php">Remove account</a>
                </div>
            </div>

             <!-- ChangePassword -->
             <div class="col-9">
             <div class="tab-pane fade active show" id="password" role="tabpanel" aria-labelledby="password-list">
                        <h2 class="mb-4">Change password</h2>
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

    

</body>
</html>
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
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active" href="usersettings.php" >Account</a>
                    <a class="list-group-item list-group-item-action" href="editProfile.php">Edit profile</a>
                    <a class="list-group-item list-group-item-action" href="changePassword.php">Change password</a>
                    <a class="list-group-item list-group-item-action" href="socialAccounts.php">Social profiles</a>
                    <a class="list-group-item list-group-item-action text-danger" href="deleteAccount.php">Remove account</a>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="nav-tabContent">
                    <!-- AccountInfo -->
                    <div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-list">
                        <h2 class="mb-4">Account info</h2>
                        <form action="">
                            <fieldset>
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $userDataFromId['username'];?>" id="name" readonly>
                                <div class="form-text">Used on feed when posting projects.</div>
                            </fieldset>

                            <fieldset>
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="<?php echo $userDataFromId['email'];?>" id="email" readonly>
                                <div class="form-text">Registration email from school.</div>
                            </fieldset>

                            <fieldset>
                                <label for="email" class="form-label">Second email</label>
                                <input type="text" class="form-control" name="email" value="<?php echo $userDataFromId['second_email'];?>" id="email" readonly>
                                <div class="form-text">Additional email to login with when losing your school account.</div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<?php
    include_once(__DIR__ . "/bootstrap.php");
    $code = $_GET['code'];
    $link = Mailer::getCode($code); //check if code exists in database
    $expired = Mailer::linkExpired(); //check if link is expired
    if ($link === false || $expired === true) {
        exit("Can't find page");
    } else {
        try {
            // er is een nieuw wachtwoord ingevuld
            if (!empty($_POST['save_password'])) {
                $user = Mailer::getEmailFromCode($code);
                //er bestaat een email met die code
                if (!empty($user)) {
                    $updatePassword = Mailer::saveNewPassword($user, $_POST['password']);
                    $deleteCode = Mailer::deleteCode($code);
                    $success = true;
                } else {
                    exit("Can't find page");
                }
            }
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
    <title>Smash - Reset password</title>
</head>
<body>
<div class="resetPassword row">
        <div class="reset--image col">
            <a href="index.php" class="navbar-brand">Smasssh</a>
        </div>
        <div class="reset--form col">
            <div class="form form--reset">
                <a href="login.php" class="link-dark">Go back</a>

                <form action="" method="post">
                    <h1>Reset your password</h1>
                    <?php if (!isset($success)): ?>
                    <p class="alert alert-info">Set your new password.</p>
                    <?php endif; ?>

                    <?php if (isset($error)):?>
                    <div class="alert alert-danger">
                        <p><?php echo $error; ?></p>
                    </div>
                    <?php endif;?>

                    <?php if (isset($success)):?>
                    <div class="alert alert-success">
                        <p>Your password is changed.</p>
                    </div>
                    <a href="login.php">Go to login page</a>
                    <?php endif; ?>

                    <div class="form-floating my-3">
                        <input type="password" class="form-control" id="password" placeholder="new password"  name="password">
                        <label for="password">New password</label>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-dark" id="btnSubmit" value="Save password" name="save_password">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
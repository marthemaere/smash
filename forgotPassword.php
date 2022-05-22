<?php
    include_once(__DIR__ . "/bootstrap.php");
    $info = true;
    if (!empty($_POST)) {
        $email = $_POST['email'];
        try {
            if (Mailer::hasAccount($email)) {
                if (empty($_POST['email'])) {
                    $error = "Email cannot be empty.";
                } elseif (!empty($_POST['forgot_password'])) {
                    // $mailer->sendPasswordResetEmail();
                    Mailer::sendMail($email);
                    $success = true;
                    // header("Location: passwordMessage.php");
                }
            }
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
    <title>Smash - Forgot password</title>
</head>
<body>
    <div class="resetPassword row" style="margin-right: 0; margin-left: 0;">
        <div class="reset--image col">
            <a href="index.php" class="navbar-brand">Smasssh</a>
        </div>
        <div class="reset--form col">
            <div class="form form--reset">
                <a href="login.php" class="link-dark">Go back</a>

                <form action="" method="post">
                    <h1 class="py-2">Forgot your racket uh... password?</h1>
                    <?php if (isset($error)):?>
                    <div class="alert alert-danger">
                        <p><?php echo $error; ?></p>
                    </div>
                    <?php endif;?>

                    <?php if (isset($success)):?>
                    <div class="alert alert-success">
                        <p>An email has been sent to reset your password.</p>
                    </div>
                    <?php endif; ?>

                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="email" placeholder="Email"  name="email">
                        <label for="email">Email</label>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-dark py-3" id="btnSubmit" value="Send email" name="forgot_password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    include_once(__DIR__ . "/bootstrap.php");
    
    if (!empty($_POST)) {
        $email = $_POST['email'];
        try {
            $user = User::hasAccount($email);
            if (!empty($_POST['forgot_password'])) {
                $user = User::sendPasswordResetEmail($email);
                header("Location: passwordMessage.php");
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Forgot password</title>
</head>
<body>
    <div class="resetPassword row">
        <div class="reset--image col">
            <a class="navbar-brand">Smasssh</a>
        </div>
        <div class="reset--form col">
            <div class="form form--reset">
                <a href="login.php" class="link-dark">Go back</a>

                <form action="" method="post">
                    <h1>Reset your password</h1>
                    <p class="alert alert-info">An email will be send to reset your password</p>

                    <?php if (isset($error)):?>
                    <div class="alert alert-danger">
                        <p><?php echo $error; ?></p>
                    </div>
                    <?php endif;?>

                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="email" placeholder="Email"  name="email">
                        <label for="email">Email</label>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-dark" id="btnSubmit" value="Send email" name="forgot_password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
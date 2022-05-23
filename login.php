<?php
    include_once("bootstrap.php");

    if (!empty($_POST)) {
        try {
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            if ($user->canLogin()) {
                $id = User::getIdByEmail($user->getEmail());
                $user->setUserId($id);
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['email']= $user->getEmail();

                $_SESSION['auth']= true; 
                $_SESSION['start']= time();
                $_SESSION['expire']= $_SESSION['start']+ (10); //1 week session 
                header("Location: index.php");
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }
    }

?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <?php include_once('style.php'); ?>
  <title>Smash - Login</title>
</head>
<body class="">
    <div class="login row" style="margin-right: 0; margin-left: 0;">
        <div class="login--image col">
            <a class="navbar-brand" href="/">Smasssh</a>
        </div>
        
        <div class="login--form col">
            <div class="form form--login">
                <form action="" method="post">
                    <h1 class="pb-2">Welcome back,<br> Smasher!</h1>

                    <?php if (isset($error)):?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif;?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@student.thomasmore.be" value="" name="email">
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="text-end mt-2 mb-3">
                        <a href="forgotPassword.php" class="link-dark">Forgot password?</a>
                    </div>
                    <div class="d-grid">
                        <input type="submit" value="Log in" class="btn btn-dark py-3" value="Log in">
                    </div>
                </form>
                <p class="text-center my-2">Not a member? <a href="register.php" class="link-primary">Sign up today</a></p>

            </div>
        </div>
    </div>
</body>

</html>
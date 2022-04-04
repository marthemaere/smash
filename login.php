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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/custom.css">
  <title>Smasssh</title>
</head>
<body class="">
    <div class="login row">
        <div class="login--image col">
            <a class="navbar-brand">Smasssh</a>
        </div>
        
        <div class="login--form col">
            <div class="form form--login">
                <form action="" method="post">
                    <h1 class="mb-6">Welcome back,<br> Smasher!</h1>

                    <?php if (isset($error)):?>
                    <div class="alert alert-danger"><?php echo $error?></div>
                    <?php endif;?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@student.thomasmore.be" value="r012345@student.thomasmore.be" name="email">
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
                        <input type="submit" value="Log in" class="btn btn-dark" value="Log in">
                    </div>
                </form>
                <p class="text-center my-2">Not a member? <a href="register.php" class="link-primary">Sign up today</a></p>

            </div>
        </div>
    </div>
</body>
</html>
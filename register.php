<?php
include_once("bootstrap.php");

if (!empty($_POST)) {
    try {
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);

        $user->register();
        $success = "user saved";
        $id = User::getIdByEmail($user->getEmail());
        $user->setUserId($id);
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $user->getEmail();
        header("Location:index.php");
    } catch (\Throwable $e) {
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
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

<body>
    <div class="register row">
        <div class="register--image col">
            <a class="navbar-brand">Smasssh</a>
        </div>

        <div class="register--form col">
            <div class="form form--register">
                <form action="" method="post">
                    <h1>Hi there! Join the<br>community now!</h1>
                    <!-- <p>*use your Thomas More email address<br>*don't leave any field empty<br>*your password needs to have at least 6 characters</p> -->

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <p>
                               <?php echo $error; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="email" placeholder="name@example.com" value="xxx@student.thomasmore.be" onblur="checkEmail()" name="email">
                        <span id="email_response"></span>
                        <label for="floatingInput">Email</label>
                    </div>

                    <div class="form-floating my-3">
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" onblur="checkUsername()" />
                        <span id="username_response"></span>
                        <label for="floatingInput">Username</label> 
                    </div>

            <div class="form-floating my-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="d-grid">
                <input type="submit" value="Sign up" class="btn btn-dark" id="signup">
            </div>
            </form>
            </div>
            <p class="text-center my-2">Already have an account? <a href="login.php" class="link-primary">Log in</a></p>
        </div>
    </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/accountAvailability.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
                     
</body>

</html>
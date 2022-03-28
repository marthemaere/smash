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
  <title>Smasssh</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="smashRegister">
		<div class="form form--login">
			<form action="" method="post">
                <h1>Welcome back smasher!</h1>
				<h2 form__title>Log in</h2>

                <?php if (isset($error)):?>
                <div class="alert alert-danger"><?php echo $error?></div>
                <?php endif;?>

				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>

				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" name="password" placeholder="Password">
				</div>
				<div class="form__field">
					<input type="submit" value="Log in" class="btn btn--primary" value="Log in">	
				</div>
			</form>
			
		</div>
	</div>
</body>
</html>
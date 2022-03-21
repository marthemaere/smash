<?php

include_once("bootstrap.php");

session_start();
 
$user = new User();
 
if(isset($_POST['login'])){
	$email = $user($_POST['email']);
	$password = $user($_POST['password']);
 
	$auth = $user->login($email, $password);
 
	if(!$auth){
		$_SESSION['message'] = 'Invalid username or password';
	}
	else{
		$_SESSION['user'] = $auth;

	}
}
else{
	$_SESSION['message'] = 'You need to login first';
}

?>


<!DOCTYPE html>
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
				<h2 form__title>Sign in</h2>

                <?php 
					if(isset($error)):
				?>

				<div class="form__error">
					<p>
						Oops, something went wrong! Please check if all fields are filled in and you used a Thomas More email address. 
					</p>
				</div>

                <?php endif; ?>

				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>

				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>
				<div class="form__field">
					<input type="submit" value="Sign up" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>
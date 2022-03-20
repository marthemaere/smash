<?php 

if(!empty($_POST)){
    $email= $_POST['email'];
    $username=$_POST['username'];
    $options=[
        'cost' => 12,
    ];
    $password= password_hash($_POST['password'], PASSWORD_DEFAULT, $options);

    try{
        $conn= new PDO('mysql:host=localhost;dbname=smash', "root", "root");
        $statement= $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $statement->bindValue("email", $email);
        $statement->bindValue("username", $username);
        $statement->bindValue("password", $password);
        
        $result= $statement->execute();
    }
    catch(Throwable $e){
        echo $e->getMessage();
    }
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
                <h1>Hi! Join our Smash-community!</h1>
				<h2 form__title>Sign Up</h2>

                <p>*use your Thomas More email address<br>*don't leave any field empty<br>*your password needs to have at least 6 characters</p>

				<div class="form__error">
					<p>
						Sorry. You have to use your Thomas More email address to register. Please try again.
					</p>
				</div>

                <div class="form__error">
					<p>
						Sorry. This field cannot be empty. Please try again.
					</p>
                </div>

				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>

                <div class="form__error">
					<p>
						Sorry. Your username cannot be empty. Please try again.
					</p>
				</div>

                <div class="form__field">
					<label for="Username">Username</label>
					<input type="text" name="username">
				</div>

                <div class="form__error">
					<p>
						Sorry. Your password needs to have a minimum of 6 characters. Please try again.
					</p>
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
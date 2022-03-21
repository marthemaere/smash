<?php 

    include_once("bootstrap.php");

    if(!empty($_POST)){
       /* $email= $_POST['email'];
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
        }*/

        try{
            $user= new User();
            $user->setEmail($_POST['email']);
            $user->setUsername($_POST['username']);
            $options=[
                'cost' => 12,
            ];
            $password= password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
            $user->setPassword($password);

            $user->save();
            $success= "user saved";

        } catch (\Throwable $e){
            $error= $e->getMessage();
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
					<label for="Username">Username</label>
					<input type="text" name="username">
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
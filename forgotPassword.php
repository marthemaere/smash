<?php
    include_once(__DIR__ . "bootstrap.php");
    
   
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
      <h1>Reset your password</h1>
      <p>An email will be send to reset your password</p>

    
    <div class="form form--login">
      <label for="username">Email</label>
      <input type="text" id="username" name="username">
      <input type="submit" class="btn" id="btnSubmit" value="Send email" name="forgot_password">
    </div>
</body>
</html>
<?php
    include_once(__DIR__ . "/bootstrap.php");
    $code = $_GET['code'];
    $link = User::getCode($code);
    if ($link === false) {
        exit("Can't find page");
    } else {
        try {
            // er is een nieuw wachtwoord ingevuld
            if (!empty($_POST['save_password'])) {
                $user = User::getEmailFromCode($code);
                //er bestaat een email met die code
                if (!empty($user)) {
                    $updatePassword = User::saveNewPassword($user, $_POST['password']);
                    $deleteCode = User::deleteCode($code);
                    header("Location: login.php");
                } else {
                    exit("Can't find page");
                }
            }
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }
    }

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
      <h1>New Password</h1>

    
    <div class="form form--login">
      <label for="password">New password</label>
      <input type="text" id="password" name="password">
      <input type="submit" class="btn" id="btnSubmit" value="Save password" name="save_password">
    </div>
</body>
</html>
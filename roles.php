<?php
    include_once('bootstrap.php');
    session_start();

    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $data = User::getUserDataFromId($sessionId);
    }

    if ($data['is_admin'] == false) {
        header('Location: index.php');
    }

    $users = User::getAll();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <title>Roles</title>
</head>
<body>
    <?php include_once('header.php'); ?>

    <div class="container my-4">
        <h1>Roles</h1>
        <p>By making a user moderator, you give them the authorization to <span class="fw-bold">delete posts</span> permanently and <span class="fw-bold">block users</span> temporarily</p>
        <table class="table table-bordered table-hover my-4">
            <tr>
                <th scope="col">id</th>
                <th scope="col">username</th>
                <th scope="col">email</th>
                <th scope="col">moderator</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <?php
                    $makeModerator = 'makeModerator' . $user['id'];
                    if (!empty($_POST[$makeModerator])) {
                        User::updateModeratorRole($user['id'], 1);
                    }

                    $deleteModerator = 'deleteModerator' . $user['id'];
                    if (!empty($_POST[$deleteModerator])) {
                        User::updateModeratorRole($user['id'], 0);
                    }
                ?>
                <tr>
                    <th scope="row"><?php echo $user['id']; ?></th>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <?php if ($user['is_moderator'] == false): ?>
                            <form action="" method="POST">
                                <input type="submit" value="Add" name="makeModerator<?php echo $user['id']?>" class="btn btn-success">
                            </form>
                        <?php else: ?>
                            <form action="" method="POST">
                                <input type="submit" value="Delete" name="deleteModerator<?php echo $user['id']?>" class="btn btn-danger">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
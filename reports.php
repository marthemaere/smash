<?php
    include_once('bootstrap.php');
    session_start();

    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $data = User::getUserDataFromId($sessionId);
    }

    if ($data["is_moderator"] == false) {
        if ($data["is_admin"] == false) {
            header('Location: index.php');
        }
    }

    $userReports = Report::getReportedUsers();
    $postReports = Report::getReportedPosts();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <title>Reports</title>
</head>
<body>
    <?php include_once('header.php'); ?>

    <div class="container my-4">
        <h1>Reports</h1>
        <h2 class="mt-4">Users</h2>
        <p>A user gets a warning on his or her screen that their account is being watched as soon as they have <span class="fw-bold">5 reports</span> of their account.</p>
        <table class="table table-bordered table-hover my-4">
            <tr>
                <th scope="col">id</th>
                <th scope="col">username</th>
                <th scope="col">num of reports</th>
                <th scope="col">block user</th>
            </tr>
            <?php foreach ($userReports as $userReport): ?>
                <?php
                    $blockUser = 'blockUser' . $userReport['reported_user_id'];
                    $unblockUser = 'unblockUser' . $userReport['reported_user_id'];
                    if (!empty($_POST[$blockUser])) {
                        Report::blockUser($userReport['reported_user_id']);
                    }
                    if (!empty($_POST[$unblockUser])) {
                        Report::unblockUser($userReport['reported_user_id']);
                    }
                    $user = Report::getBlockedUser($userReport['reported_user_id']);
                ?>
                <tr>
                    <th scope="row"><?php echo $userReport['reported_user_id']; ?></th>
                    <td><?php echo $userReport['username']; ?></td>
                    <td><?php echo $userReport['count']; ?></td>
                    <td>
                        <?php if (($user['is_blocked'] == false)): ?>
                            <form action="" method="POST">
                                <input type="submit" value="Block" name="blockUser<?php echo $userReport['reported_user_id']?>" class="btn btn-success">
                            </form>
                        <?php else: ?>
                            <form action="" method="POST">
                                <input type="submit" value="Unblock" name="unblockUser<?php echo $userReport['reported_user_id']?>" class="btn btn-danger">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2 class="mt-4">Posts</h2>
        <table class="table table-bordered table-hover my-4">
            <tr>
                <th scope="col">id</th>
                <th scope="col">title of post</th>
                <th scope="col">link</th>
                <th scope="col">num of reports</th>
                <th scope="col">delete post</th>
            </tr>
            <?php foreach ($postReports as $postReport): ?>
                <?php
                    $deletePost = 'deletePost' . $postReport['post_id'];
                    if (!empty($_POST[$deletePost])) {
                        Post::deleteProjectWithReport($postReport['post_id']);
                    }
                ?>
                <tr>
                    <th scope="row"><?php echo $postReport['post_id']; ?></th>
                    <td><?php echo $postReport['title']; ?></td>
                    <td>
                        <a href="<?php echo $postReport['link']; ?>"><?php echo $postReport['link']; ?></a>
                    </td>
                    <td><?php echo $postReport['count']; ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="submit" value="Delete" name="deletePost<?php echo $postReport['post_id']; ?>" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
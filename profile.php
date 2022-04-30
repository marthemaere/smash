<?php
    include_once("bootstrap.php");
    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        $user = new User();
        $key = $_GET['p'];
        $userData = User::getUserDataFromId($key);
        $userPosts = $user->getUserPostsFromId($key);

        if (empty($userPosts)) {
            $emptyState;
        }

        if (!empty($_POST['report'])) {
            try {
                $report = new Report();
                $report->setUserId($key);
                $report->reportUser();
                $success = "User reported. Thank you for your feedback.";
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Profile</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="profile_pictures/<?php echo $userData['profile_pic']; ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1"><?php echo $userData['username']; ?> • <span>16 followers</span></p>
                <p class="biography"><?php echo $userData['bio']; ?></p>
                <p class="education"><?php echo $userData['education']; ?></p>
                <form action="" method="post">
                <div class="my-4">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <!-- are you sure alert -->
                    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel">Are you sure you want to report this user?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                            <div class="modal-footer">
                            <button class="btn btn-outline-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">No</button>
                                <input type="submit" value="yes" name="report" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">
                            </div>
                            </form>
                            
                            </div>
                        </div>
                    </div>
                    <!-- are you sure alert -->
                    <a href="#" class="btn btn-primary">Follow</a>
                    <a class="btn btn-outline-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Report user</a>
                    <a href="#" class="btn btn-outline-primary">...</a> <!--link to socials-->
                </div>
                </form>
            </div>
            <div class="project--item--latest col m-3">
                <img class="img-fluid" src="uploaded_projects/<?php echo $userPosts[0]['image'];?>" alt="latest posts">
            </div>
        </div>
        <div class="">
            <h4 class="header py-1">All projects</h4>
            <?php if (isset($emptyState)): ?>
                <div class= "empty-state">
                    <img class="empty-state-picture" src="assets/images/empty-box.svg" alt="emptystate">
                    <p>Username hasn't uploaded any projects.</p> 
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($userPosts as $post): ?>
                        <div class="col-4 p-5">
                            <img src="uploaded_projects/<?php echo $post['image'];?>" width="100%" height="220px"
                                class="img-project-post" style="object-fit:cover">
                            <div>
                                <div class="d-flex justify-content-between py-2">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img src="profile_pictures/<?php echo $post['profile_pic']; ?>"
                                            class="img-profile-post">
                                        <a href="profile.php?p=<?php echo $post['user_id'];?>">
                                            <h4 class="pt-2 ps-2"><?php echo $post['username'];?></h4>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/empty-heart.svg" class="like">
                                        <p class="num-of-likes">1</p>
                                    </div>
                                </div>
                                <h2><?php echo $post['title']; ?></h2>
                                <p class="pe-4"><?php echo $post['description']; ?> <span
                                        class="link-primary"><?php echo $post['tag']; ?></span></p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="" class="link-dark">View comments</a>
                                <a href="" class="btn btn-smash">Smash</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php echo include_once('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
<?php
    include_once("bootstrap.php");
    session_start();
    $userId = $_GET['p'];
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        $user = new User();
        $key = $_GET['p'];
        $userData = User::getUserDataFromId($key);
        $userPosts = $user->getUserPostsFromId($key);

        $report = new Report();
        $report->setReported_userId($key);
        $report->setReport_userId($_SESSION['id']);
        $isReported = $report->isUserReportedByUser();

        if (empty($userPosts)) {
            $emptyState;
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <title>Profile</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="row p-3">
            <div id="report-success" class="invisible" role="alert">
                      
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row d-flex align-items-center">
            <div class="col">
                <img src="profile_pictures/<?php echo $userData['profile_pic']; ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1"><?php echo htmlspecialchars($userData['username']); ?> • <span>16 followers</span></p>
                <p class="biography"><?php echo htmlspecialchars($userData['bio']); ?></p>
                <p class="education"><?php echo htmlspecialchars($userData['education']); ?></p>
                <form action="" method="post">
                <div class="my-4">
                    <!-- are you sure alert -->
                    <div class="modal fade" id="reportUser" aria-hidden="true"
                        aria-labelledby="report-userLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="report-userLabel">Are you sure you want to report
                                        this user?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" method="post">
                                    <div class="modal-footer">
                                        <button class="btn btn-outline-primary"
                                            data-bs-toggle="modal">No</button>
                                        <input id="report-user" data-userid="<?php echo $userId ?>" data-report_userid="<?php echo $_SESSION['id'] ?>"  type="submit" value="Yes" name="report" class="btn btn-primary"
                                            data-bs-toggle="modal">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- are you sure alert -->
                    <div class="profile-btn">
                        <a href="#" name="follow" class="btn btn-primary mb-2 follow" data-followerid="<?php echo $_SESSION['id'];?>" data-followingid="<?php echo $key;?>">Follow</a>
                        <?php if ($isReported === false): ?>
                        <a class="btn btn-outline-primary mb-2" data-bs-toggle="modal" href="#reportUser" id="report-btn" role="button">Report user</a>
                        <?php else: ?>
                        <a class="btn btn-danger disabled mb-2" data-bs-toggle="modal" href="#reportUser" id="report-btn" role="button">Reported</a>
                        <?php endif; ?>
                        <?php if (!empty($userPosts[0]['social_linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_linkedin']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_linkedin.png" alt="linkedin"></a>
                        <?php endif; ?>
                        <?php if (!empty($userPosts[0]['social_github'])): ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_github']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_github.png" alt="github"></a>
                        <?php endif; ?>
                        <?php if (!empty($userPosts[0]['social_instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_instagram']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_instagram.png" alt="instagram"></a>
                        <?php endif; ?>
                    </div>
                </div>
                </form>
            </div>
            <div class="col project--item--latest">
                <img class="" src="uploaded_projects/<?php echo $userPosts[0]['image'];?>" alt="latest posts">
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
                        <div class="col-4 p-4">
                            <img src="uploaded_projects/<?php echo htmlspecialchars($post['image']);?>" width="100%" height="250px"
                                class="img-project-post" style="object-fit:cover">
                            <div>
                                <div class="d-flex justify-content-between py-2">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img src="profile_pictures/<?php echo htmlspecialchars($post['profile_pic']); ?>"
                                            class="img-profile-post">
                                        <a href="profile.php?p=<?php echo htmlspecialchars($post['user_id']);?>">
                                            <h4 class="pt-2 ps-2"><?php echo htmlspecialchars($post['username']);?></h4>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/empty-heart.svg" class="like">
                                        <p class="num-of-likes">1</p>
                                    </div>
                                </div>
                                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                                <p class="pe-4"><?php echo htmlspecialchars($post['description']); ?> <span
                                        class="link-primary"><?php echo htmlspecialchars($post['tag']); ?></span></p>
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
    <script src="javascript/follow.js"></script>
    <script src="javascript/report-user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
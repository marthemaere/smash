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

    $follower = new Follower();
    $follower->setFollowerId($_SESSION['id']);
    $follower->setFollowingId($key);
    $isFollowed = $follower->isFollowedByUser();
    $countFollowers = $follower->countFollowers();

    if (empty($userPosts)) {
        $emptyState = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <link rel="stylesheet" href="styles/custom.css">
    <title>Profile</title>
</head>

<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <?php if (isset($error)) : ?>
            <div class="row p-3">
                <div id="report-success" class="invisible" role="alert">
                </div>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row d-flex align-items-center pt-4">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <img src="<?php echo $userData['profile_pic']; ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1"><?php echo htmlspecialchars($userData['username']); ?> • 

                <?php if (($_SESSION['id'])): ?>
                <?php if ( $countFollowers["COUNT(id)"] === "0"): ?>
                       <span> no followers yet </span></p>
                <?php elseif ($countFollowers['COUNT(id)'] === "1"): ?>
                    <span> <?php echo $countFollowers["COUNT(id)"] ?> follower</span></p>
                <?php else: ?>
                    <span> <?php echo $countFollowers["COUNT(id)"] ?> followers</span></p>
                <?php endif; ?>
                <?php endif; ?>

            


                
                <p class="biography"><?php echo htmlspecialchars($userData['bio']); ?></p>
                <p class="education"><?php echo htmlspecialchars($userData['education']); ?></p>
                <form action="" method="post">
                    <div class="my-4">
                        <!-- are you sure alert -->
                        <div class="modal fade" id="reportUser" aria-hidden="true" aria-labelledby="report-userLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="report-userLabel">Are you sure you want to report
                                            this user?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-footer">
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal">No</button>
                                            <input id="report-user" data-userid="<?php echo $userId ?>" data-report_userid="<?php echo $_SESSION['id'] ?>" type="submit" value="Yes" name="report" class="btn btn-primary" data-bs-toggle="modal">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- are you sure alert -->
                        <div class="profile-btn">
                            <?php if (!($_SESSION['id'] === $key)): ?>
                                <?php if (!$isFollowed) : ?>
                                    <a href="#" name="follow" class="btn btn-primary mb-2 follow" data-followingid="<?php echo $key; ?>">Follow</a>
                                <?php else : ?>
                                    <a href="#" name="follow" class="btn btn-primary mb-2 follow active" data-followingid="<?php echo $key; ?>">Following</a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($isReported === false) : ?>
                                <a class="btn btn-outline-primary mb-2" data-bs-toggle="modal" href="#reportUser" id="report-btn" role="button">Report user</a>
                            <?php else : ?>
                                <a class="btn btn-danger disabled mb-2" data-bs-toggle="modal" href="#reportUser" id="report-btn" role="button">Reported</a>
                            <?php endif; ?>

                            <?php if (!empty($userPosts[0]['social_linkedin'])) : ?>
                                <a href="<?php echo htmlspecialchars($userPosts[0]['social_linkedin']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_linkedin.png" alt="linkedin"></a>
                            <?php endif; ?>
                            <?php if (!empty($userPosts[0]['social_github'])) : ?>
                                <a href="<?php echo htmlspecialchars($userPosts[0]['social_github']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_github.png" alt="github"></a>
                            <?php endif; ?>
                            <?php if (!empty($userPosts[0]['social_instagram'])) : ?>
                                <a href="<?php echo htmlspecialchars($userPosts[0]['social_instagram']); ?>" class="btn btn-outline-primary mb-2"><img src="assets/icons/icon_instagram.png" alt="instagram"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 project--item--latest">
                <?php if (empty($emptyState)) : ?>
                    <a href="post.php?p=<?php echo $userPosts[0]['id']?>">
                        <img class="" src="<?php echo $userPosts[0]['image']; ?>" alt="latest posts">
                    </a>
                <?php else: ?>
                    <img class="profile-empty-state d-flex justify-content-center" src="assets/images/empty-state-weareimd.png" alt="latest posts">
                <?php endif; ?>
            </div>
        </div>
        <?php if (empty($emptyState)) : ?>
            <div>
                <div class="d-flex header mr-auto p-2 ">
                    <div class="">
                        <h3>All projects</h3>
                    </div>
                    <div class="p-2"><a href="smashedProjects.php?p=<?php echo $userData['id'] ?>" name="smashedprojects" class="btn btn-outline-primary">My featured projects</a></div>
                </div>
            
                <div class="row">
                    <?php foreach ($userPosts as $post) : ?>
                        <?php
                        $smash = new Post();
                        $smash->setPostId($post['id']);
                        $isSmashed = $smash->isSmashed();

                        $like = new Like();
                        $like->setPostId($post['id']);
                        $like->setUserId($_SESSION['id']);
                        $isLiked = $like->isPostLikedByUser();
                        $count = $like->getLikes();

                        $tags = Post::getTagsFromPost($post['id']);
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 p-4">
                            <a href="post.php?p=<?php echo $post['id']?>">
                                <img src="<?php echo htmlspecialchars($post['image']); ?>" width="100%" height="250px" class="img-project-post" style="object-fit:cover">
                            </a>
                            <div>
                                <div class="d-flex justify-content-between py-2">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img src="<?php echo htmlspecialchars($post['profile_pic']); ?>" class="img-profile-post">
                                        <a href="profile.php?p=<?php echo htmlspecialchars($post[0]['user_id']); ?>">
                                            <h4 class="pt-2 ps-2"><?php echo htmlspecialchars($post['username']); ?></h4>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <?php if (!$isLiked) : ?>
                                            <img src="assets/images/empty-heart.svg" name="like" class="like notLiked" id="likePost" data-userid="<?php echo $_SESSION['id'] ?>" data-postid="<?php echo $post['id'] ?>">
                                            <?php if ($count['COUNT(id)'] === "0") : ?>
                                                <p class="num-of-likes" data-postid="<?php echo $post['id'] ?>"><?php ?></p>
                                            <?php else : ?>
                                                <p class="num-of-likes" data-postid="<?php echo $post['id'] ?>"><?php echo $count['COUNT(id)'] ?></p>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <img src="assets/images/liked-heart.svg" name="like" class="like notLiked" id="likePost" data-userid="<?php echo $_SESSION['id'] ?>" data-postid="<?php echo $post['id'] ?>">
                                            <p class="num-of-likes" data-postid="<?php echo $post['id'] ?>"><?php echo $count['COUNT(id)'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="post.php?p=<?php echo $post['id']; ?>">
                                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                                </a>
                                <p class="pe-4 mb-0 max-num-of-lines"><?php echo htmlspecialchars($post['description']); ?></p>
                                <?php foreach ($tags as $tag) : ?>
                                    <span class="link-primary"><?php echo htmlspecialchars($tag['tag']); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2">
                                <a href="" class="link-dark">View comments</a>
                                <?php if ($_SESSION['id'] === $userId) : ?>
                                    <?php if (!$isSmashed) : ?>
                                        <a href="#" id="smashed" name="smashed" class="btn btn-smash" data-postid="<?php echo $post['id']; ?>" data-userid="<?php echo $_SESSION['id'] ?>"> Smash </a>
                                    <?php else : ?>
                                        <a href="#" id="smashed" name="smashed" class="btn btn-smash active" data-postid="<?php echo $post['id']; ?>" data-userid="<?php echo $_SESSION['id'] ?>"> Smashed 💥</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php echo include_once('footer.php'); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="javascript/follow.js"></script>
    <script src="javascript/report-user.js"></script>
    <script src="javascript/smashed.js"></script>
    <script src="javascript/like.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
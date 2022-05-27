<?php
include_once("bootstrap.php");
session_start();

$conn = Db::getInstance();

if (isset($_SESSION['id'])) {
    $sessionId = $_SESSION['id'];
    $userDataFromId = User::getUserDataFromId($sessionId);
}

$user = new User();
$key = $_GET['p'];
$userData = User::getUserDataFromId($key);
$userPosts = $user->getUserPostsFromId($key);
$posts = Post::showSmashedProjects($key);

if (empty($key)) {
    header('Location: index.php');
}

if (empty($posts)) {
    $emptyState = true;
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <link rel="stylesheet" href="styles/custom.css">
    <title>Smash - Showcase <?php echo htmlspecialchars($userData['username']); ?></title>
</head>
<body>
    <?php include_once('header.php'); ?>

    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 text-center">
                <img src="<?php echo htmlspecialchars($userData['profile_pic']); ?>" class="img-thumbnail rounded-circle mt-5" alt="profile picture">
                <p class="username mt-3 mb-1"><?php echo htmlspecialchars($userData['username']); ?></p>
                <p class="biography mb-1"><?php echo htmlspecialchars($userData['bio']); ?></p>
                <p class="education"><?php echo htmlspecialchars($userData['education']); ?></p>

                <form action="" method="post">
                    <div class="my-4">
                        <div class="profile-btn">
                            <?php if (!empty($userPosts[0]['social_linkedin'])) : ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_linkedin']); ?>"
                                class="btn btn-outline-primary btn-icon mb-2"><img src="assets/icons/icon_linkedin.png"
                                    alt="linkedin"></a>
                            <?php endif; ?>
                            <?php if (!empty($userPosts[0]['social_github'])) : ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_github']); ?>"
                                class="btn btn-outline-primary btn-icon mb-2"><img src="assets/icons/icon_github.png"
                                    alt="github"></a>
                            <?php endif; ?>
                            <?php if (!empty($userPosts[0]['social_instagram'])) : ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_instagram']); ?>"
                                class="btn btn-outline-primary btn-icon mb-2"><img src="assets/icons/icon_instagram.png"
                                    alt="instagram"></a>
                            <?php endif; ?>
                            <?php if (!empty($userPosts[0]['social_portfolio'])) : ?>
                            <a href="<?php echo htmlspecialchars($userPosts[0]['social_portfolio']); ?>" target="_blank"
                                class="btn btn-outline-primary btn-icon mb-2"><img src="assets/icons/icon_portfolio.png"
                                    alt="portfolio"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <?php if (!empty($emptyState)) : ?>
                <div class="empty-state">
                    <img class="d-block mx-auto" src="assets/images/empty-state-weareimd.png" alt="empty state">
                </div>
            <?php else : ?>
                <div class="row justify-content-start">
                    <?php foreach ($posts as $key => $p) : ?>
                        <?php $tags = Post::getTagsFromPost($p[0]); ?>

                        <div class="d-flex align-items-center py-0">
                            <img src="<?php echo htmlspecialchars($p['profile_pic']); ?>" class="img-profile-post">
                            <h4 class="pt-2 ps-2"><?php echo htmlspecialchars($p['username']);?></h4>
                        </div>
                        
                        <div class="pt-2">
                            <h2 class="mb-1"><?php echo htmlspecialchars($p['title']); ?></h2>
                            <div class="col-sm-12 col-md-12 col-lg-9">
                                <p class=""><?php echo htmlspecialchars($p['description']); ?> 
                                    <?php foreach ($tags as $tag): ?>
                                        <span class="link-primary"><?php echo htmlspecialchars($tag['tag']); ?></span>
                                    <?php endforeach; ?>
                                </p>

                            </div>
                            <img src="<?php echo htmlspecialchars($p['image']); ?>" width="100%" height="" class="img-project-post"
                                style="object-fit:cover">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="javascript/follow.js"></script>
    <script src="javascript/report-user.js"></script>
    <script src="javascript/smashed.js"></script>
</body>
</html>
<?php
include_once("bootstrap.php");
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
} else {
    $key = $_GET['p'];
    $projectData = Post::getPostDataFromId($key);
    $comments = Comment::getCommentsFromPostId($key);
    if (empty($comments)) {
        $emptystate = true;
    }
    
    if (!empty($_POST['delete'])) {
        try {
            Post::deletePosts($id);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

    if (!empty($_POST['deleteProject'])) {
        try {
            Post::deleteProject($postId);
            header('Location: index.php');
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

    if (!empty($_POST['report'])) {
        try {
            $report = new Report();
            $report->setPostId($key);
            $report->reportPost();
            $success = "Post reported. Thank you for your feedback.";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
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
    <title>Post</title>
</head>

<body>
    <?php include_once('header.php'); ?>
    <div class="container">
        <div class="row">
            <?php if (isset($success)) : ?>
                <div class="alert alert-success m-2" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <!-- are you sure alert -->
            <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Are you sure you want to report this post?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-footer">
                                <button class="btn btn-outline-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">No</button>
                                <input id="report-post" data-postId=`$key` type="submit" value="yes" name="report" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- are you sure alert -->
            <!-- are you sure alert -->
            <div class="modal fade" id="deleteProject" aria-hidden="true" aria-labelledby="deleteProjectLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProjectLabel">Are you sure you want to delete this post?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-footer">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal">No</button>
                                <input type="submit" value="Yes" name="deleteProject" class="btn btn-primary" data-bs-toggle="modal">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- are you sure alert -->
            <div class="d-flex align-items-center p-3">
                <img src="profile_pictures/<?php echo $projectData['profile_pic']; ?>" class="img-profile-post">
                <a href="profile.php?p=<?php echo $projectData['user_id']; ?>">
                    <h4 class="pt-2 ps-2"><?php echo $projectData['username']; ?></h4>
                </a>
            </div>

            <div class="col-9">
                <h2><?php echo $projectData['title']; ?></h2>
                <div class="d-flex align-items-center justify-content-between">
                    <p class="pe-4"><?php echo $projectData['description']; ?> <span class="link-primary"><?php echo $projectData['tags']; ?></span></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center" action="" method="post">
                            <div class="btn btn-primary d-flex">
                                <img src="assets/images/empty-heart.svg" class="btn-icon-like">
                                <input type="submit" value="Like" class="btn p-0" name="like">
                                <p class="num-of-likes p-2"> 1</p>
                            </div>
                        </form>

                        <a class="btn btn-outline-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Report</a>
                        <a class="btn btn-outline-primary text-danger" data-bs-toggle="modal" href="#deleteProject" role="button">Delete post</a>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-9">
                <img src="uploaded_projects/<?php echo $projectData['image']; ?>" width="100%" height="75%" class="img-project-post" style="object-fit:cover">
            </div>

            <div class="col-3 col-lg-3">
                <h3>Comments</h3>
                <?php if (isset($emptystate)) : ?>
                    <p class="empty-state">No comments yet</p>
                <?php else : ?>
                    <ul class="">
                        <?php foreach ($comments as $c) : ?>
                            <li class=""><?php echo $c['text']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="row d-flex justify-content-between">
                    <form class="form" action="" method="post">
                        <input class="form-control col" type="text" placeholder="make a comment">
                        <input type="submit" value="Send" class="btn btn-primary col col-lg-3" name="comment">
                    </form>
                </div>
            </div>
        </div>


    </div>

    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
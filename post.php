<?php
    include_once("bootstrap.php");
    $postId =  $_GET['p'];
    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {
        $key = $_GET['p'];
        $projectData = Post::getPostDataFromId($key);
        $userId=$_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($userId);

        //var_dump($projectData);
         
        //check if post is reported by user who is logged in
        $report = new Report();
        $report->setPostId($postId);
        $report->setReport_userId($_SESSION['id']);
        $isReported = $report->isPostReportedByUser();
        //var_dump($isReported);
    
        if (!empty($_POST['addComment'])) {
            try {
                $comment = new Comment();
                $comment->setText($_POST['comment']);
                $comment->setPostId($postId);
                $comment->setUserId($userId);
                $comment->save();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        
        //altijd alle laatste activiteiten ophalen
        $comments = Comment::getCommentsFromPostId($key);

        if (empty($comments)) {
            $emptystate = true;
        }

        if (!empty($_POST['deleteProject'])) {
            try {
                Post::deleteProject($postId);
                header('Location: index.php');
            } catch (Throwable $e) {
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
    <script type="text/javascript"></script>
</head>

<body>
    <?php include_once('header.php'); ?>
    <div class="container my-4">
        <div class="row">
            <div id="report-success" class="invisible" role="alert">
                      
            </div>
          
            <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <!-- are you sure alert -->
            <div class="modal fade" id="reportPost" aria-hidden="true" aria-labelledby="reportPostLabel"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportPostLabel">Are you sure you want to report this
                                post?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-footer">
                                <button class="btn btn-outline-primary" 
                                    data-bs-toggle="modal">No</button>
                                <input id="report-post" data-postId="<?php echo $postId ?>" data-userid="<?php echo $_SESSION['id'] ?>" type="submit" value="yes" name="report"
                                    class="btn btn-primary" 
                                    data-bs-toggle="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- are you sure alert -->

             <!-- are you sure alert for deleting a post -->
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
            <!-- are you sure alert for deleting a post -->
          
            <div class="d-flex align-items-center py-2">
                <img src="profile_pictures/<?php echo htmlspecialchars($projectData['profile_pic']); ?>" class="img-profile-post">
                <a href="profile.php?p=<?php echo htmlspecialchars($projectData['user_id']);?>">
                    <h4 class="pt-2 ps-2"><?php echo htmlspecialchars($projectData['username']);?></h4>
                </a>
            </div>

            <div class="col-8 py-0">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h2><?php echo htmlspecialchars($projectData['title']); ?></h2>
                        <p class="pe-4"><?php echo htmlspecialchars($projectData['description']); ?> <span
                                class="link-primary"><?php echo htmlspecialchars($projectData['tags']); ?></span></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center" action="" method="post">
                            <div class="btn btn-primary d-flex align-items-center mx-2 px-2">
                                <img src="assets/images/empty-heart.svg" class="btn-icon-like">
                                <input type="submit" value="Like" class="btn p-0 ps-1" name="like">
                                <p class="num-of-likes"> 1</p>
                            </div>
                            <?php if ($isReported === false): ?>
                            <a class="btn btn-outline-primary" data-bs-toggle="modal" href="#reportPost" id="report-btn" role="button">Report</a>
                            <?php elseif ($isReported === true): ?>
                            <a class="btn btn-danger disabled" data-bs-toggle="modal" href="#reportPost" id="report-btn" role="button">Reported</a>
                            <?php endif; ?>
                            <a class="btn btn-outline-danger ms-2" data-bs-toggle="modal" href="#deleteProject" role="button">Delete</a>
                        </form>

                        <form method="post" action="editProject.php?p=<?php echo $key?>" id="edit_form">
                                <input type="submit" value="&#9998;" class="btn btn-outline-primary ms-2" name="editProject">
                        </form> 

                    </div>
                </div>
            </div>
        </div>

          
        <div class="row">
            <div class="col-8">
                <img src="uploaded_projects/<?php echo htmlspecialchars($projectData['image']);?>" width="100%" height="100%"
                    class="img-project-post" style="object-fit:cover">
            </div>

            <div class="col-4 col-lg-4 d-flex align-content-between flex-wrap">
                <div>
                    <h3>Comments</h3>
                    <?php if (isset($emptystate)): ?>
                    <p class="">There are no comments for this project.</p>
                    <?php else: ?>
                    <?php foreach ($comments as $c): ?>

                    <ul class="list-group list-group-flush" id="listupdates">
                                <li class="list-group-item d-flex align-items-center border-bottom">
                                    <a href="profile.php?p=<?php echo htmlspecialchars($userDataFromId['user_id']);?>"><img src="profile_pictures/<?php echo htmlspecialchars($projectData['profile_pic']); ?>" class="img-profile-post"></a>
                                    <a href="profile.php?p=<?php echo htmlspecialchars($userDataFromId['user_id']);?>">
                                        <h4 class="p-2 mb-0"><?php echo htmlspecialchars($userDataFromId['username']);?></h4>
                                    </a>
                                    <?php echo $c['text']; ?>
                                </li>
                    </ul>
                    <?php endforeach; ?>

                    <?php endif; ?>
                    <div class="row d-flex justify-content-between">
                        <form class="" action="" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Place a comment" aria-label="Place a comment" aria-describedby="button-addon2" id="comment" name="comment">
                                <input type="submit" name="addComment" id="btnSubmit" data-userId="<?php echo $userId ?>" data-postId="<?php echo $postId ?>" value=">" class="btn btn-outline-primary btn-icon-search" >
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>
    <script src="javascript/report-post.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="javascript/comment.js"></script>
</body>
</html>
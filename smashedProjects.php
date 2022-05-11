<?php
    include_once("bootstrap.php");
    session_start();
    $userId = $_GET['p'];
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    } else {

        if(!empty($_POST['smashed'])) {
            $posts = Post::showSmashedProjects();
            
        } else {
            empty($posts);
            $emptyState;

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
    <title>Smashed projects</title>
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
       
                     
            <?php if (isset($emptyState)): ?>
                <div class= "empty-state">
                    <img class="empty-state-picture" src="assets/images/empty-box.svg" alt="emptystate">
                    <p>Username hasn't smashed any projects.</p> 
                </div>

                <?php foreach ($posts as $key => $p): ?>
                <?php if (!isset($_SESSION['id'])) :?>

                    <div class="col-4 p-4">
                        <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px"
                            class="img-project-post" style="object-fit:cover">
                        <div>
                            <div class="d-flex justify-content-between py-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="profile_pictures/<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                    <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/empty-heart.svg" class="like">
                                    <p class="num-of-likes">1</p>
                                </div>
                            </div>
                            <h2><?php echo $p['title']; ?></h2>
                            <p class="pe-4"><?php echo $p['description']; ?> <span class="link-primary"><?php echo $p['tag']; ?></span></p>
                        </div>
                        <!-- <div class="d-flex justify-content-between align-items-center">
                            <a href="" class="link-dark">View comments</a>
                            <a href="" class="btn btn-smash">Smash</a>
                        </div> -->
                    </div>

                <?php else: ?>

                <div class="col-4 p-4">
                    <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px"
                        class="img-project-post" style="object-fit:cover">
                    <div>
                        <div class="d-flex justify-content-between py-2">
                            <div class="d-flex align-items-center justify-content-start">
                                <img src="profile_pictures/<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                <a href="profile.php?p=<?php echo $p['user_id'];?>">
                                    <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="assets/images/empty-heart.svg" class="like">
                                <p class="num-of-likes">1</p>
                            </div>
                        </div>
                        <a href="post.php?p=<?php echo $p[0]?>">
                            <h2><?php echo $p['title']; ?></h2>
                        </a>

                        <p class="pe-4"><?php echo $p['description']; ?> <span class="link-primary"><?php echo $p['tag']; ?></span></p>  </div>
                    <!-- <div class="d-flex justify-content-between align-items-center">
                        <a href="" class="link-dark">View comments</a>
                        <a href="" class="btn btn-smash">Smash</a>
                    </div> -->

                    <div class="d-flex justify-content-between align-items-center">
                    <a href="" class="link-dark">View comments</a>
                    <a href="" class="btn btn-outline-primary">Smash</a>
                </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>

    <?php echo include_once('footer.php'); ?>
    <script src="javascript/follow.js"></script>
    <script src="javascript/report-user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
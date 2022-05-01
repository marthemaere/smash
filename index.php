<?php
    include_once("bootstrap.php");
    session_start();
    

    $conn = Db::getInstance();

   
        $posts = Post::getAll();
        if (empty($posts)) {
            $emptystate = true;
        }

        $limit= 15;
        $conn = Db::getInstance();
        $result = $conn->query("select count(id) AS id from posts");
        $postCount= $result->fetchAll();
        $total= $postCount[0]['id'];
        $pages= ceil($total / $limit);

        if (isset($_SESSION['id'])) {
            $sessionId = $_SESSION['id'];
            $userDataFromId = User::getUserDataFromId($sessionId);
        }
        
    if (!empty($_POST['submit-search'])) {
        $search = $_POST['search'];
        $posts = Post::search($search);
        if (empty($posts)) {
            $emptystate = true;
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
    <title>Feed</title>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="justify-content-center container">
        <form class="form row gx-3 gy-2 align-items-center col-4" action="" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search for projects" aria-label="Search for projects" aria-describedby="button-addon2">
                <input class="btn btn-outline-primary btn-icon-search" type="submit" name="submit-search" id="button-addon2" value="Search">
            </div>
        </form>
    </div>

    <?php
    if (isset($emptystate)): ?>
        <div class= "empty-state">
            <img class="empty-state-picture" src="assets/images/empty-box.svg" alt="emptystate">
            <p> No projects were found. </p> 
        </div>
    <?php endif; ?>


    <div class="container mt-5 mb-5">
       <div class="row justify-content-center">
        
    <?php
        foreach ($posts as $key => $p):
    ?>

    <?php if (!isset($_SESSION['id'])) :?>

            <div class="col-4 p-5">
                <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="200px" class="rounded" style="object-fit:cover" >
                <h2><?php echo $p['title']; ?></h2>
                <div class="d-flex justify-content-between align-items-center"v>
                    <a href="/login.php" class="link-dark">View comments</a>
                    <a href="/login.php" class="btn btn-outline-primary">Smash</a>
                </div>
            </div>
      
    <?php else: ?>

            <div class="col-4 p-5">
                <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="220px" class="img-project-post" style="object-fit:cover" >
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
                   
                    <p class="pe-4"><?php echo $p['description']; ?> <span class="link-primary"><?php echo $p['tag']; ?></span></p>
                </div>
                <!-- <div class="d-flex justify-content-between align-items-center">
                    <a href="" class="link-dark">View comments</a>
                    <a href="" class="btn btn-smash">Smash</a>
                </div> -->
            </div>

    <?php endif; ?>
    <?php endforeach; ?>

    <div class="row justify-content-center">
        <div class="col-md-10 d-flex justify-content-center">
            <nav class="page-navigation" aria-label="page navigation">
                <ul class="pagination">
                    <?php for ($i=1; $i<= $pages; $i++): ?>
                    <li>
                        Page <a href="index.php?page=<?= $i; ?>" class="link-dark p-2"><?= $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
   
    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/javascript/like.js"></script>
</body>
</html>
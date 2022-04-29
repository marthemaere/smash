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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Feed</title>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="justify-content-center container">
        <form class="form" action="" method="post">
            <div class="form-group d-flex justify-content-center">
                <input class="form-control col-2 col-lg-0 mb-3 mb-lg-0 me-lg-3" type="text" name="search" placeholder="Search for projects">
                <input class="btn btn-dark mt-4" type="submit" name="submit-search" value="Search">
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
        foreach ($posts as $p):
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
                <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="220px" class="rounded" style="object-fit:cover" >
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex justify-content-start">
                            <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="p-2 rounded-circle" width="45px">
                            <h4 class="pt-2"><?php echo $p['username'];?></h4>
                        </div>
                        <div>
                            <img src="assets/images/empty-heart.svg" width="18px" class="like">
                        </div>
                    </div>
                    <h2><?php echo $p['title']; ?></h2>
                    <p><?php echo $p['description']; ?></p>
                    <p class="link-primary"><?php echo $p['tag']; ?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="" class="link-dark">View comments</a>
                    <a href="" class="btn btn-outline-primary">Smash</a>
                </div>
            </div>

    <?php endif; ?>
    <?php endforeach; ?>

    <div class="row justify-content-center">
        <div class="col-md-10 d-flex justify-content-center">
            <nav class="page-navigation" aria-label="page navigation">
                <ul class="pagination">
                    <?php for ($i=1; $i<= $pages; $i++): ?>
                    <li>
                        <a href="index.php?page=<?= $i; ?>" class="link-dark p-3"><?= $i; ?></a>
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
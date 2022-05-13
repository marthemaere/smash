<?php
    include_once("bootstrap.php");
    session_start();
    
    $conn = Db::getInstance();
    
    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
    }

    $key = $_GET['p'];
    $posts = Post::showSmashedProjects($key);
    

    
    if (empty($posts)) {
        $emptyState = true;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css">
    <title>Smashed Projects</title>

</head>

<body>
    <?php require_once("header.php"); ?>
    <div class="container mt-5 mb-5">
        <h1> My smashed showcase page 💥</h1>

        <?php if (!empty($emptyState)):?>
        <div class="empty-state flex-column">
            <img class="d-block mx-auto" src="assets/images/empty-state.png" alt="emptystate">
            <h3 class="text-center py-4">Nothing to see here...</h3>
        </div>
        <?php else: ?>

        <div class="row justify-content-start">

            <?php foreach ($posts as $key => $p): ?>
                <?php if (!isset($_SESSION['id'])) :?>

                    <div class="col-4 p-4">
                        <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px"
                            class="img-project-post" style="object-fit:cover">
                        <div>
                            <h2><?php echo $p['title']; ?></h2>
                            <p class="pe-4"><?php echo $p['description']; ?> <span class="link-primary"><?php echo $p['tag']; ?></span></p>
                        </div>
                    </div>

                <?php else: ?>

                <div class="col-4 p-4">
                    <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px"
                        class="img-project-post" style="object-fit:cover">
                    <div>
                        <a href="post.php?p=<?php echo $p[0]?>">
                            <h2><?php echo $p['title']; ?></h2>
                        </a>

                        <p class="pe-4"><?php echo $p['description']; ?> <span class="link-primary"><?php echo $p['tag']; ?></span></p>  </div>
                    
                </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
        <?php endif; ?>
    </div>
    
    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="javascript/like.js"></script>
    <script src="javascript/smashed.js"></script>
</body>
</html>
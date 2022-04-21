<?php
    include_once("bootstrap.php");
    session_start();
	
      /*  $id = session_create_id();	
        session_id($id);
        print("\n"."Id: ".$id);
        session_start();    
        session_commit();  
*/

    $conn = Db::getInstance();

    if (!isset($_SESSION['id'])) {
        if(!empty($_POST)){
            try {
                $post->getTitle($_POST['title']);
                $post->getImage($_POST['image']);
                $post->save();
                echo $post;
            }
            catch ( Throwable $e ) {
                $error = $e->getMessage();
            }
        }
        $posts = Post::getAll();

    } else {
        if(!empty($_POST)){

            try {
                $post->getTitle($_POST['title']);
                $post->getImage($_POST['image']);
                $post->getDescription($_POST['description']);
                $post->getTags($_POST['tags']);
                $post->getUserId($_SESSION['id']);
                $post->save();
                echo $post;
            }
            catch ( Throwable $e ) {
                $error = $e->getMessage();
            }
        }

    $posts = Post::getAll();

    $limit= 3;
    $conn = Db::getInstance();
    $result = $conn->query("select count(id) AS id from posts");
    $postCount= $result->fetchAll();
    $total= $postCount[0]['id'];
    $pages= ceil($total / $limit); 

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
    <?php 
    if(empty($_POST)) 
        echo '<div class = "empty-state">
        <img class="empty-state-picture" src="assets\images\empty-box.svg" alt="emptystate">
        <p> No projects were found. </p> </div>'
    ?>
    <?php   
        foreach($posts as $p): 
    ?>
    <?php if (!isset($_SESSION['id'])) :?>

    <div class="container">
        <div class="row-fluid">
            <div class="col">
                <div class="m-5" style = "width: 22rem;" > 
                    <img src="<?php echo $p['image'];?>" width="100%" class="img-rounded">
                    <div>
                        <h2><?php echo $p['title']; ?></h2>
                    </div>
                    <div>
                        <a href="" class="link-dark">View comments</a>
                        <a href="" class="btn btn-outline-primary me-2">Smash</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>

    <div class="container">
        <div class="row-fluid">
            <div class="col">
                <div class="m-5" style = "width: 22rem; " > 

                    <p><?php echo $p['date']; ?></p>

                    <img src="<?php echo $p['image'];?>" width="100%" height= "200px" class="img-rounded">
                    <div>
                        <h2><?php echo $p['title']; ?></h2>
                        <h4><?php echo $p['user_id'];?></h4>
                        <p><?php echo $p['description']; ?></p>
                        <p class="link-primary"><?php echo $p['tags']; ?></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="" class="link-dark">View comments</a>
                        <a href="" class="btn btn-outline-primary me-2">Smash</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>
    <?php endforeach; ?>

    <div class="row">
        <div class="col-md-10">
            <nav class="page-navigation" aria-label="page navigation">
                <ul class="pagination">
                    <li>
                        <a href="" aria-label="previous"><span aria-hidden="true">&laquo; Previous</span></a>
                    </li>
                    <?php for($i=1; $i<= $pages; $i++): ?>
                    <li>
                        <a href="index.php?page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li>
                        <a href="" aria-label="next"><span aria-hidden="true">Next &raquo;</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
   
    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
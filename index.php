<?php
    include_once("bootstrap.php");
    session_start();
    
    $conn = Db::getInstance();
    
    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
    }

    $limit = 15;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page -1) * $limit;

    $sorting = 'DESC';
    $posts = Post::getPosts($sorting, $start, $limit);
    
    $conn = Db::getInstance();
    $result = $conn->query("select count(id) AS id from posts");
    $postCount= $result->fetchAll();
    $total= $postCount[0]['id'];
    $pages= ceil($total / $limit);
    
    if (!empty($_POST['submit-search'])) {
        $search = $_POST['search'];
        $posts = Post::search($search);
    }
    
    if (!empty($_POST['ASC'])) {
        $sorting = 'ASC';
        $posts = Post::getPosts($sorting, $start, $limit);
    } elseif (!empty($_POST['DESC'])) {
        $sorting = 'DESC';
        $posts = Post::getPosts($sorting, $start, $limit);
    } elseif (!empty($_POST['following'])) {
        $posts = Post::filterPostsByFollowing($start, $limit);
    }
    
    if (empty($posts)) {
        $emptystate = true;
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
    <title>Feed</title>

</head>

<body>
    <?php require_once("header.php"); ?>

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center m-3">
            <div class="btn-group">
                <button type="button" class="btn btn-primary sort-title">
                    <?php if (!empty($_POST['ASC'])): ?>
                        <?php echo "Oldest"; ?>
                    <?php elseif (!empty($_POST['DESC'])): ?>
                        <?php echo "Latest"; ?>
                    <?php elseif (!empty($_POST['following'])): ?>
                        <?php echo "Following"; ?>
                    <?php else: ?>
                        <?php echo "Latest"; ?>
                    <?php endif; ?>
                </button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                
                <ul class="dropdown-menu">
                    <form action="" method="POST">
                        <li><h6 class="dropdown-header">Sort by date</h6></li>
                        <li><a class="dropdown-item sort-latest" href="#"><input type="submit" name="DESC" value="Latest"></a></li>
                        <li><a class="dropdown-item sort-oldest" href="#"><input type="submit" name="ASC" value="Oldest"></a></li>
                        <li><h6 class="dropdown-header">Filter</h6></li>
                        <li><a class="dropdown-item filter-following" href="#"><input type="submit" name="following" value="Following"></a></li>
                    </form>
                </ul>
            </div>

            <div>
                <a href="#" class="px-2 btn btn-light">All</a>
                <a href="#" class="px-2 text-muted">Branding</a>
                <a href="#" class="px-2 text-muted">Development</a>
                <a href="#" class="px-2 text-muted">Mobile</a>
                <a href="#" class="px-2 text-muted">Typography</a>
            </div>

            <div>
                <a href="#" class="px-2 btn btn-outline-primary">Filters</a>
            </div>
        </div>

        <?php if (isset($emptystate)): ?>
        <div class="empty-state flex-column">
            <img class="d-block mx-auto" src="assets/images/empty-state.png" alt="emptystate">
            <h3 class="text-center py-4">Nothing to see here...</h3>
        </div>
        <?php endif; ?>

        <div class="row justify-content-start">

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
                            <form class="" action="" method="post">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/empty-heart.svg" name= "like" class="like" id="likePost" data-userId="<?php echo $userId ?>" data-postId="<?php echo $postId ?>>
                                    <p class="num-of-likes">1</p>
                                </div>
                            </form>
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

            <div class="row justify-content-center">
                <div class="d-flex justify-content-center">
                    <nav class="page-navigation" aria-label="page navigation">
                        <ul class="pagination">
                            <?php for ($i=1; $i<= $pages; $i++): ?>
                            <li>
                                Page <a href="index.php?page=<?= $i; ?>" class="link-dark"><?= $i; ?> </a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="javascript/like.js"></script>
</body>
</html>
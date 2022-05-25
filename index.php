<?php
    include_once("bootstrap.php");
    session_start();
    
    $conn = Db::getInstance();
    
    if (isset($_SESSION['id'])) {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
    }
    
    if (isset($_SESSION['auth'])) {
        $currentTime= time();
        if ($currentTime > $_SESSION['expire']) {
            session_unset();
            session_destroy();
        }
    }

    $sort = "Newest First";
    $limit = 15;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page -1) * $limit;

    $sorting = 'DESC';
    $posts = Post::getPosts($sorting, $start, $limit);

    $sortPopularTags = Tag::sortPopularTagsDesc();
    
    
    $conn = Db::getInstance();
    $result = $conn->query("select count(id) AS id from posts");
    $postCount= $result->fetchAll();
    $total= $postCount[0]['id'];
    $pages= ceil($total / $limit);
    
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $posts = Post::search($search);
        $searched = true;
    }
    
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        if ($sort == "Newest First ") {
            $posts = Post::getPosts("DESC", $start, $limit);
        } elseif ($sort == "Oldest First") {
            $posts = Post::getPosts("ASC", $start, $limit);
        } elseif ($sort == "Following") {
            $posts = Post::filterPostsByFollowing($start, $limit, $userDataFromId['id']);
        }
    }
    
    if (isset($_GET['tag']) && !empty($_GET['tag'])) {
        $filteredTag = "#" . $_GET['tag'];
        $posts = Tag::filterPostsByTag($filteredTag);
        $filtered = true;
    }
    
    /*
    if (isset($_GET['tag']) && !empty($_GET['tag'])) {
        $popularTag = $_GET['tag'];
        $posts = Tag::filterPostsByPopularTag($popularTag);
        $filteredPopularTag = true;
    }
    */

    if (empty($posts)) {
        $emptystate = true;
    }

//}
//}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include_once('style.php'); ?>
    <title>Smash — #WeAreIMD Showcase</title>
</head>

<body>
    <?php require_once("header.php"); ?>

    <div class="container mt-5 mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center m-3">
            <div class="btn-group">
                <button type="button" class="btn btn-primary sort-title">
                    <?php echo $sort; ?>
                </button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu">
                    <form action="" method="GET">
                        <li>
                            <h6 class="dropdown-header">Sort by date</h6>
                        </li>
                        <li>
                            <a class="dropdown-item sort-latest" href="#"><input type="submit" name="sort" value="Newest First"></a>
                        </li>
                        <li>
                            <a class="dropdown-item sort-oldest" href="#"><input type="submit" name="sort" value="Oldest First"></a>
                        </li>
                        <?php if (isset($_SESSION['id'])) : ?>
                        <li>
                            <h6 class="dropdown-header">Filter</h6>
                        </li>
                        <li>
                            <a class="dropdown-item filter-following" href="#"><input type="submit" name="sort" value="Following"></a>
                        </li>
                        <?php endif; ?>
                    </form>
                </ul>
            </div>

            <?php if (!empty($sortPopularTags)): ?>
                <div class="filter-tags">
                    <a href="index.php" class="px-2 btn btn-light">All</a>
                    <?php foreach ($sortPopularTags as $pTag): ?>
                        <a href="index.php?tag=<?php echo str_replace("#", "", $pTag['tag']); ?>" class="px-2 btn btn-light"><?php echo $pTag['tag']; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="filter-btn">
                <p class="d-none"></p>
            </div>
        </div>

        <?php if (!empty($searched)): ?>
            <div class="d-flex mt-5 ms-3 me-3 alert alert-dark bg-light">
                <p class="m-0">Search results for: <span class="fw-bold"><?php echo $search; ?></span></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($filtered)): ?>
            <div class="d-flex mt-5 ms-3 me-3 alert alert-dark bg-light">
                <p class="m-0">Filter by tag: <span class="fw-bold"><?php echo $filteredTag; ?></span></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($filteredPopularTag)): ?>
            <div class="d-flex mt-5 ms-3 me-3 alert alert-dark bg-light">
                <p class="m-0">Filter by tag: <span class="fw-bold"><?php echo $popularTag; ?></span></p>
            </div>
        <?php endif; ?>

        <?php if (isset($emptystate)): ?>
            <div class="empty-state">
                <img class="d-block mx-auto" src="assets/images/empty-state-weareimd.png" alt="empty state">
            </div>
        <?php endif; ?>

        <div class="row justify-content-start">
            <?php foreach ($posts as $key => $p): ?>
            
                <?php if (!isset($_SESSION['id'])) :?>
                    <?php
                        $like = new Like();
                        $like->setPostId($p[0]);
                        $count = $like->getLikes();
                        $tags = Post::getTagsFromPost($p[0]);
                    ?>
                    
                    <div class="col-12 col-md-6 col-lg-4 p-4">

                        <a href="register.php">
                            <img src="<?php echo $p['image_thumb'];?>" width="100%" height="250px" class="img-project-post" style="object-fit:cover">
                        </a>

                        <div class="">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                    <a href="register.php">
                                        <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
                                    </a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <img src="assets/images/empty-heart.svg" class="like">
                                    <?php if ($count['COUNT(id)'] === "0"): ?>
                                        <p class="num-of-likes" data-postid="<?php echo $p[0] ?>"><?php ?></p>
                                    <?php else : ?>
                                        <p class="num-of-likes" data-postid="<?php echo $p[0] ?>"><?php echo $count['COUNT(id)'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="register.php">
                                <h2><?php echo $p['title']; ?></h2>
                            </a>
                            <p class="pe-4 mb-1 max-num-of-lines"><?php echo $p['description']; ?></p>
                            <?php foreach ($tags as $tag): ?>
                                <a href="register.php">
                                    <span class="link-primary"><?php echo $tag['tag']; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <?php if ($userDataFromId['is_blocked']): ?>
                        <div class="modal modal_blocked fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Attention!</h5>
                                    </div>
                                    <div class="modal-body">Your account has been blocked due to many reports of your current profile.</div>
                                </div>
                            </div>
                        </div>
                     <?php endif; ?>
                     
                    <?php
                        $like = new Like();
                        $like->setPostId($p[0]);
                        $like->setUserId($_SESSION['id']);
                        $isLiked = $like->isPostLikedByUser();
                        $count = $like->getLikes();
                        $tags = Post::getTagsFromPost($p[0]);
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 p-4">

                        <a href="post.php?p=<?php echo $p[0]?>">
                            <img src="<?php echo $p['image_thumb'];?>" width="100%" height="250px" class="img-project-post" style="object-fit:cover">
                        </a>

                        <div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                    <a href="profile.php?p=<?php echo $p['user_id'];?>">
                                        <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
                                    </a>
                                </div>
                                <form class="" action="" method="post">
                                    <div class="d-flex align-items-center">
                                        <?php if (!$isLiked): ?>
                                            <img src="assets/images/empty-heart.svg" name="like" class="like notLiked" id="likePost" data-userid="<?php echo $_SESSION['id'] ?>" data-postid="<?php echo $p[0] ?>">
                                        <?php if ($count['COUNT(id)'] === 0): ?>
                                            <p class="num-of-likes" data-postid="<?php echo $p[0] ?>"><?php ?></p>
                                        <?php else : ?>
                                        <p class="num-of-likes" data-postid="<?php echo $p[0] ?>">
                                            <?php echo $count['COUNT(id)'] ?></p>
                                        <?php endif; ?>
                                        <?php else: ?>
                                            <img src="assets/images/liked-heart.svg" name="like" class="like notLiked" id="likePost" data-userid="<?php echo $_SESSION['id'] ?>" data-postid="<?php echo $p[0] ?>">
                                            <p class="num-of-likes" data-postid="<?php echo $p[0] ?>">
                                            <?php echo $count['COUNT(id)'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                            <a href="post.php?p=<?php echo $p[0]?>">
                                <h2><?php echo $p['title']; ?></h2>
                            </a>
                            <p class="pe-4 mb-1 max-num-of-lines"><?php echo $p['description']; ?></p>
                            <?php foreach ($tags as $tag): ?>
                                <a href="index.php?tag=<?php echo str_replace("#", "", $tag['tag']); ?>" class="link-primary bg-transparent border-0 p-0"><?php echo $tag['tag']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <nav aria-label="Results pages">
                <ul class="pagination justify-content-center">
                    <?php for ($i=1; $i<= $pages; $i++): ?>
                    <li class="page-item" aria-current="page">
                        <a href="index.php?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="javascript/like.js"></script>
    <script src="javascript/smashed.js"></script>
</body>
</html>
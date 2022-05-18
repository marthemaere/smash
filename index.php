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
        $searched = true;
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

    if (!empty($_POST['tag'])) {
        $tag = $_POST['tag'];
        $posts = Tag::filterPostsByTag($tag);
        $filtered = true;
    }
    
    if (empty($posts)) {
        $emptystate = true;
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('style.php'); ?>
    <title>Home</title>
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
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu">
                    <form action="" method="POST">
                        <li>
                            <h6 class="dropdown-header">Sort by date</h6>
                        </li>
                        <li>
                            <a class="dropdown-item sort-latest" href="#"><input type="submit" name="DESC" value="Latest"></a>
                        </li>
                        <li>
                            <a class="dropdown-item sort-oldest" href="#"><input type="submit" name="ASC" value="Oldest"></a>
                        </li>
                        <li>
                            <h6 class="dropdown-header">Filter</h6>
                        </li>
                        <li>
                            <a class="dropdown-item filter-following" href="#"><input type="submit" name="following" value="Following"></a>
                        </li>
                    </form>
                </ul>
            </div>

            <div class="filter-tags">
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

        <?php if (!empty($searched)): ?>
            <div class="d-flex mt-5 ms-3 me-3 alert alert-dark">
                <p class="m-0">Search results for: <span class="fw-bold"><?php echo $search; ?></span></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($filtered)): ?>
            <div class="d-flex mt-5 ms-3 me-3 alert alert-dark">
                <p class="m-0">Filter by tag: <span class="fw-bold"><?php echo $tag; ?></span></p>
            </div>
        <?php endif; ?>

        <?php if (isset($emptystate)): ?>
            <div class="empty-state flex-column">
                <img class="d-block mx-auto" src="assets/images/empty-state.png" alt="emptystate">
                <h3 class="text-center py-4">Nothing to see here...</h3>
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
                    
                    <div class="col-12 col-md-4 p-4">
                        <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px" class="img-project-post" style="object-fit:cover">
                        <div class="">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="profile_pictures/<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                    <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
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
                            <h2><?php echo $p['title']; ?></h2>
                            <p class="pe-4"><?php echo $p['description']; ?>
                                <?php foreach ($tags as $tag): ?>
                                    <span class="link-primary"><?php echo $tag['tag']; ?></span>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>

                <?php else: ?>
                    <?php
                        $like = new Like();
                        $like->setPostId($p[0]);
                        $like->setUserId($_SESSION['id']);
                        $isLiked = $like->isPostLikedByUser();
                        $count = $like->getLikes();
                        $tags = Post::getTagsFromPost($p[0]);
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 p-4">
                        <img src="uploaded_projects/<?php echo $p['image'];?>" width="100%" height="250px"
                            class="img-project-post" style="object-fit:cover">
                        <div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="profile_pictures/<?php echo $p['profile_pic']; ?>" class="img-profile-post">
                                    <a href="profile.php?p=<?php echo $p['user_id'];?>">
                                        <h4 class="pt-2 ps-2"><?php echo $p['username'];?></h4>
                                    </a>
                                </div>
                                <form class="" action="" method="post">
                                    <div class="d-flex align-items-center">
                                        <?php if (!$isLiked): ?>
                                            <img src="assets/images/empty-heart.svg" name="like" class="like notLiked" id="likePost" data-userid="<?php echo $_SESSION['id'] ?>" data-postid="<?php echo $p[0] ?>">
                                        <?php if ($count['COUNT(id)'] === "0"): ?>
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
                            <p class="pe-4 mb-1"><?php echo $p['description']; ?></p>
                            <?php foreach ($tags as $tag): ?>
                                <form action="" method="post" class="d-inline">
                                    <input value="<?php echo $tag['tag']; ?>" class="link-primary bg-transparent border-0 p-0" type="submit" name="tag"></input>
                                </form>
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
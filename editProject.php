<?php
include_once("bootstrap.php");

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
}

$postId =  $_GET['p'];
$projectData = Post::getPostDataFromId($postId);
$tags = Post::getTagsFromPost($postId);

if ($_SESSION['id'] !== $projectData['user_id']) {
    header('Location: index.php');
}

if (!empty($_POST['submit'])) {
    try {
        $post = new Post();
        $post->setTitle($_POST['title']);
        $post->editTitle($postId);
                            
        $tags = new Tag();
        $tags->setTag($_POST['tags']);
        $tags->editTags($postId);

        header('Location: index.php');
    } catch (Throwable $e) {
        $error = $e->getMessage();
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
    <title>Smash Post - Edit <?php echo $projectData['title']; ?> </title>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="container py-4">
        <a href="index.php" class="btn btn-outline-primary">Cancel</a>


        <div class="upload-intro text-center pt-4">
            <h1>Edit your project:</h1>
        </div>
        
        <div class="col-7 py-5 m-auto">
            <img src="<?php echo htmlspecialchars($projectData['image']); ?>" width="100%" height="auto" class="img-project-post mb-4" style="object-fit:cover">

            <?php if (isset($error)):?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif;?>

            <form class="uploadzone" action="#" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <!-- <label for="floatingInput">Edit the title of your project</label> -->
                    <input type="text" class="form-control" id="floatingInput" name="title" value="<?php echo $projectData['title'] ?>">
                </fieldset>

                <fieldset>
                    <!-- <label for="tags">Edit your tags</label> -->
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Give it some tags like #branding" value="<?php foreach ($tags as $tag): ?><?php echo $tag['tag']; ?> <?php endforeach; ?>">
                    <div class="form-text">Don't forget the famous '#' before your tag</div>
                </fieldset>
                <input class="btn btn-primary col-12" type="submit" value="Save changes" name="submit">
            </form>
        </div>
    </div>

    <?php require_once("footer.php"); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
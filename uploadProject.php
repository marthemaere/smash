<?php
include_once("bootstrap.php");

session_start();

if (!empty($_POST)) {
    try {

        //post aanmaken
        $post = new Post();
        $post->setTitle($_POST['title']);
        $post->setDescription($_POST['description']);
        //$post->setPostId($_POST['id']);
        //$post->setPostById($postId);
        //var_dump($post);
      
        $userId= $_SESSION['id'];
        $post->setUserId($userId);
        $id = $post->canUploadProject();
       
        $userId = $_SESSION['id'];
        $post->setUserId($userId);


        //tags toevoegen
        $tags = new Tag();
        $tags->setTag($_POST['tags']);
        $tags->addTagsToDatabase($id);
        
        header("Location: index.php");
    } catch (\Throwable $e) {
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
    <title>Upload your project</title>
</head>
<body>
    <?php require_once("header.php"); ?>

    <div class="container py-4">
        <a href="index.php" class="btn btn-outline-primary">Cancel</a>

        <div class="upload-intro text-center pt-4">
            <h1>What are you working on?</h1>
            <p>Show us what you got! Upload your mindblowing project.</p>
        </div>

        <div class="col-sm-12 col-md-10 col-lg-7 py-5 m-auto">
            <?php if (isset($error)):?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif;?>

            <form class="uploadzone" action="#" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <!-- <label for="floatingInput">Give your project a name</label> -->
                    <input type="text" class="form-control" id="floatingInput" name="title" placeholder="Give your project a name">
                </fieldset>

                <fieldset>
                    <!-- <label for="title">Tell us more about your project</label> -->
                    <textarea name="description" class="form-control" id="description" cols="50" rows="3" placeholder="Tell us more about your project (but not a chapter)"></textarea>
                </fieldset>

                <fieldset>
                    <!-- <label for="tags">Add tags to your project</label> -->
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Give it some tags like #branding">
                    <div class="form-text">Don't forget the famous '#' before your tag</div>
                </fieldset>

                <fieldset>
                    <label class="form-label" for="image"></label>
                    <input type="file" class="form-control" id="customFile" name="file">
                    <div class="form-text">JPG or PNG. Max size of 2MB</div>
                </fieldset>

                <input class="btn btn-primary col-12" type="submit" value="Upload masterpiece" name="submit">
            </form>
        </div>
    </div>

    <?php require_once("footer.php"); ?>
</body>
</html>
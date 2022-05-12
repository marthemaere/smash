<?php
    require_once('../bootstrap.php');


    if( !empty($_POST) ) {
        $text = $_POST['comment'];
        $postId = intval($_POST['postid']);
        $userId = intval($_POST['userid']);


        try {
            $c = new Comment();
            $c->setText($text);
            $c->setPostId($postId);
            $c->setUserId($userId);
            $c->save();

            // success
            $response = [
                "status" => "success",
                "message" => "Comment was saved.", 
            ];

        } catch( Exception $e ) {
            // error
            $response = [
                "status" => "error",
                "message" => "Something went wrong."
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }
<?php
    require_once('../bootstrap.php');
    session_start();


    if( !empty($_POST) ) {
      

        try {
            $text = $_POST['text'];
            $userId = $_SESSION['id'];
            $postId = intval($_POST['postid']);

            $c = new Comment();
            $c->setText(htmlspecialchars($text));
            $c->setUserId($userId);
            $c->setPostId($postId);
            $result= $c->save();
            $notEmpty= $c->getCommentsFromPostId($postId);

            // success
            $response = [
                "status" => "success",
                "message" => "Comment was saved.", 
                "data" => [
                    "user"=> $result, 
                    "comments"=> $notEmpty
                ]
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
<?php
    require_once('../bootstrap.php');


    if( !empty($_POST) ) {
        $text = $_POST['text'];
        $postId = intval($_POST['postid']);
        $userId = intval($_POST['userid']);


        try {
            $c = new Comment();
            $c->setText($text);
            $c->setPostId($postId);
            $c->setUserId($userId);
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
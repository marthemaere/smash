<?php
    require_once('../bootstrap.php');

    if(!empty($_POST)){
        $postId = intval($_POST['postId']);
        $userId = intval($_POST['userId']);

        try{
            $like= new Like();
            $like->setPostId($postId);
            $like->setUserId($userId);
            $like->saveLike();
            $like->countLike($userId);
        
            $response= [
                "status"=> "success",
                "message" => "Like was successful.",
            ];

        } 
        catch (Exception $e){
            $response= [  
                "status"=> "error",
                "message" => "Liking failed."
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
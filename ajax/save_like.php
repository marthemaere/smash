<?php
    require_once('../bootstrap.php');

    if(!empty($_POST)){
        $postId= $_POST['postId'];

        try{
            $like= new Like();
            $like->setPostId($postId);
            $like->setUserId(1);
            $like->saveLike();
        
            $response= [
                "status"=> "success",
                "message" => "Like was successful"
            ];

        } 
        catch (Throwable $e){
            $response= [  
                "status"=> "error",
                "message" => "Like failed"
            ];
        }

        echo json_encode($response);
    }
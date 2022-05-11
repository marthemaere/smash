<?php
   include_once(__DIR__.'/../bootstrap.php');
   
    if (!empty($_POST['smashed'])) {

        $postId = intval($_POST['postId']);
        $userId = intval($_POST['userId']);
        
        try{
            $posts= new Post();
            $posts->setPostId($postId);
            $posts->smashed($postId);
            print_r($posts);
        
            $response= [
                "status"=> "success",
                "message" => "Smashed.",
            ];

        } 
        catch (Exception $e){
            $response= [  
                "status"=> "error",
                "message" => "Cannot smash."
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
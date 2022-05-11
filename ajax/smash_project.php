<?php
   include_once(__DIR__.'/../bootstrap.php');
   
    if (!empty($_POST)) {

        
        try{
            $posts= new Post();
            $postId = intval($_POST['postId']);
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
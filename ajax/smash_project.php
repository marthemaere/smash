<?php
   include_once(__DIR__.'/../bootstrap.php');

   
    if (!empty($_POST)) {

        try{

            //new smashed project
            // $posts= new Smashed();
            // $postId = intval(($_POST['postId']));
            // $userId = intval(($_POST['userId']));

            // $posts->setPostId($postId);
            // $posts->setUserId($userId);
            // $posts->saveSmash($postId);


            //new smashed project
             $posts= new Post();
            //  $postId = intval(($_POST['postId']));
            //  $userId = intval(($_POST['userId']));  
            //  $posts->setPostId($postId);
            //  $posts->setUserId($userId);
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
<?php
   include_once(__DIR__.'/../bootstrap.php');

   
    if (!empty($_POST)) {

        try{

            //new smashed project
            $posts= new Smashed();
            $posts->setPostId($_POST['postId']);
            $posts->setUserId($_SESSION['id']);
            $posts->saveSmash($postId);
        
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
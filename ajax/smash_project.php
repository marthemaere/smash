<?php
   include_once(__DIR__.'/../bootstrap.php');

   
    if (!empty($_POST)) {
        try {

            //new smashed project
            
            $postId = intval(($_POST['postid']));
            $userId = intval(($_POST['userid']));

            $posts= new Post();
            $posts->setPostId($postId);
            $posts->setUserId($userId);
            $count = $posts->smashExists();
            
            if ($posts->smashExists()) {
                $posts->unsmashed($postId);

                $response= [
                "status" => "success",
                "userid" => $userId,
                "postid" => $postId,
                "message" => "Unsmashed.",
                'smashed' => false,
                'count' => $count
            ];
            } else {
                $posts->smashed($postId);
                $response = [
                'status' => 'success',
                "userid" => $userId,
                "postid" => $postId,
                'message' => "smashed.",
                'smashed' => true,
                'count' => $count
            ];
            }
        } catch (Exception $e) {
            $response= [
                "status"=> "error",
                "message" => "Cannot smash."
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

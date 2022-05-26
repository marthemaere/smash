<?php
    require_once('../bootstrap.php');
    session_start();

    if(!empty($_POST)){
        $postId = intval($_POST['postId']);
        $userId = $_SESSION['id'];

        try{
            $like= new Like();
            $like->setPostId($postId);
            $like->setUserId($userId);

        if($like->countLike()){
            $like->deleteLikes();

            $response = [
                'status' => 'success',
                'userid' => $userId,
                'postid' => $postId,
                'message' => 'Post unliked.',
                'isLiked' => false
            ];
        } else {
            $like->saveLike();
            
            $response = [
                'status' => 'success',
                'userid' => $userId,
                'postid' => $postId,
                'message' => 'Post liked.',
                'isLiked' => true
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Liking post failed, please try again.'
        ];
    }
        /*}    
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
        }*/

        header('Content-Type: application/json');
        echo json_encode($response);
    }
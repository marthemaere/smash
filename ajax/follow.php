<?php
    include_once('../bootstrap.php');
    
    if (!empty($_POST)) {
        try {
            $follow = new Follower();

            $followerId = intval($_POST['followerid']);
            $followingId = intval($_POST['followingid']);

            $follow->setFollowerId($followerId);
            $follow->setFollowingId($followingId);

            if ($follow->followExists()) {
                $follow->unfollowUser();

                $response = [
                    'status' => 'success',
                    'followerid' => $followerId,
                    'followingid' => $followingId,
                    'message' => 'User unfollowed.'
                ];
            } else {
                $follow->followUser();
                
                $response = [
                    'status' => 'success',
                    'followerid' => $followerId,
                    'followingid' => $followingId,
                    'message' => 'User followed.'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Following user failed, please try again.'
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

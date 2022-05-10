<?php
   include_once(__DIR__.'/../bootstrap.php');
   
    if (!empty($_POST)) {
        try {
            $report = new Report();
            $postId = intval($_POST['postid']);
            $userid = intval($_POST['userid']);
            $report->setPostId($postId);
            $report->setReport_userId($userid);
            
            //report
            $report->reportPost();

            //success weergeven
            $response = [
                'status' => 'success',
                'message' => "Post is reported. Thank you for your feedback.",
            ];
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => "Something went wrong. Please try again later."
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

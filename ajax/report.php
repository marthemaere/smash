<?php
    include_once('../bootstrap.php');

    if (!empty($_POST['report'])) {
        try {
            $report = new Report();
            $report->setPostId($key);

            //report
            $report->reportPost();
            
            //success weergeven
            $response = [
                'status' => 'success',
                'message' => 'Post reported. Thank you for your feedback.'
            ];
            
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

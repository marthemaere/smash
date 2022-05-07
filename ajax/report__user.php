<?php
   include_once(__DIR__.'/../bootstrap.php');
   
    if (!empty($_POST)) {
        try {
            $report = new Report();
            $userId = intval($_POST['userid']);
            $report->setUserId($userId);
            
            //report
            $report->reportUser();

            //success weergeven
            $response = [
                'status' => 'success',
                'message' => "User is reported. Thank you for your feedback.",
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

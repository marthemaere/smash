<?php
   include_once(__DIR__.'/../bootstrap.php');
   
    if (!empty($_POST)) {
        try {
            $report = new Report();
            $reported_userId = intval($_POST['userid']);
            $report_userId = intval($_POST['report_userid']);
            $report->setReported_userId($reported_userId);
            $report->setReport_userId($report_userId);
            
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

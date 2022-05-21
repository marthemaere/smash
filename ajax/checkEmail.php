<?php
include_once(__DIR__ . '/../bootstrap.php');

if (!empty($_POST)) {
    try {

        $email = (($_POST['email']));
        $users = new User();
        $users->setEmail($email);

        if ($users->checkEmailAvailability()) {
            $response = [
                "status" => "success",
                "email" => $email,
                "availability" => 1,
                "message" => "Email available."
            ];
        } else {
            $response = [
                "status" => "success",
                "email" => $email,
                "availability" => 0,
                "message" => "Email unavailable."
            ];
        }
    } catch (Exception $e) {
        $response = [
            "status" => "error",
            "message" => "Cannot check email."
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}


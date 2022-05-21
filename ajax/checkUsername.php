<?php
include_once(__DIR__ . '/../bootstrap.php');


if (!empty($_POST)) {
    try {
        $username = strval($_POST['username']);
        $users = new User();
        $users->setUsername($username);

        if ($users->checkUsernameAvailability()) {
            $response = [
                "status" => "success",
                "username" => $username,
                "availability" => 1,
                "message" => "Username available."
            ];
        } else {
            $response = [
                "status" => "success",
                "username" => $username,
                "availability" => 0,
                "message" => "Username unavailable."
            ];
        }
    } catch (Exception $e) {
        $response = [
            "status" => "error",
            "message" => "Cannot check username."
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

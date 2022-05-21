<?php
include_once(__DIR__ . '/../bootstrap.php');


if (!empty($_POST)) {
    try {

        $email = (strval($_POST['email']));
        $users = new User();
        $users->setEmail($email);
        var_dump($users);

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



// if (isset($_POST['type']) == 1) {
//     $email = $_POST['email'];
//     $conn = Db::getInstance();
//     $statement = $conn->prepare("select * from users where email = :email");
//     $statement->bindValue("email", $email);
//     $statement->execute();
//     $rowcount = $statement->rowCount();
//     if ($rowcount > 0) {
//         echo "<span style='color: red;' class='status-not-available'> Email Not Available.</span>";
//     } else {
//         echo "<span style='color: green' class='status-available'> Email Available.</span>";
//     }
// }

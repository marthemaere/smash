<?php
include_once(__DIR__.'/../bootstrap.php');


if (isset($_POST['type']) == 1) {
    $email = $_POST['email'];
    $conn = DB::getInstance();
    $statement = $conn->prepare("select * from users where email = :email");
    $statement->bindValue("email", $email);
    $statement->execute();
    $rowcount = $statement->rowCount();
    if ($rowcount > 0) {
        echo "<span style='color: red;' class='status-not-available'> Email Not Available.</span>";
    } else {
        echo "<span style='color: green' class='status-available'> Email Available.</span>";
    }
}

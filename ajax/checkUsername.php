<?php
include_once(__DIR__.'/../bootstrap.php');

if (isset($_POST['type']) == 1) {
    $username = $_POST['username'];
    $conn = Db::getInstance();
    $statement = $conn->prepare("select * from users where username = :username");
    $statement->bindValue("username", $username);
    $result = $statement->execute();
    $rowcount = $statement->rowCount();
    if ($rowcount > 0) {
        echo "<span style='color: red;' class='status-not-available'> Username Not Available.</span>";
    } else {
        echo "<span style='color: green'; class='status-available'> Username Available.</span>";
    }
}

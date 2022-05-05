<?php
include_once('../bootstrap.php');

if(isset($_POST['username'])){
	$db = Db::getInstance();
	$stmt = $db->prepare("select * from users where username = :username");
	$stmt->bindValue(":username", $this->username);
	$result = $stmt->execute();
	$response = "<span style='color: green;'>Available.</span>";
	return $response;

    if(mysqli_num_rows($result)){
        $row = mysqli_fetch_array($result);
        $count = $row['users'];
        
        if($count > 0){
            $response = "<span style='color: red;'>Not Available.</span>";
        }
    }
    
    echo $response;
    die;
}

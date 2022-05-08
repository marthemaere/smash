<?php
include_once('../bootstrap.php');

	/*$con =mysqli_connect('localhost','root','','dp_testing');
	if(!$con){
       die("Failed to connect:" . mysqli_connect_error());
    } */


	if(isset($_POST['username'])){
        $username = $_POST['username'];

        //check username
        $stmt = $conn->prepare("select * from users where username = :username");
        $stmt->bindValue(":username", $username);
        $result = $stmt->execute();
        $count = $stmt->fetchColumn();
        $response = "<span style='color: green;'>Available.</span>";
        if($count >0){
			$response = "<span style= 'color:red;'> Not available. </span>";
		}
        echo $response;
        exit;



        
	}


	/*if(isset($_POST['type']) == 1){

        $con = Db::getInstance();
		$username =$_POST['username'];
		$query ="SELECT * FROM users where username = :username ";
        $quary->bindValue(":username", $this->username);
		$result =mysqli_query($con, $query);
		$rowcount=mysqli_num_rows($result);
		if($rowcount >0){
			echo "<span class='status-not-available'> Username Not Available.</span>";
            print_r("<span class='status-not-available'> Username Not Available.</span>");
		}else{
			 echo "<span class='status-available'> Username Available.</span>";
             print_r("<span class='status-not-available'> Username Not Available.</span>");
		}




        $con = Db::getInstance();
		$username =$_POST['username'];
        $stmt = $db->prepare("select * from users where username = :username");
        $stmt->bindValue(":username", $this->username);
        $result = $stmt->execute();
		$rowcount=mysqli_num_rows($result);
		if($rowcount >0){
			echo "<span class='status-not-available'> Username Not Available.</span>";
		}else{
			 echo "<span class='status-available'> Username Available.</span>";
		}
	}*/



    /*if(isset($_POST['username'])){
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
}*/
?>



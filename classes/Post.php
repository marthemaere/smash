<?php

include_once(__DIR__ . "/Db.php");

class Post
{
    private $title;
    private $image;
    private $description;
    private $username;


    public function setUserId($userId)
    { 
        $this->userId = $userId;
        return $this;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        if (empty($title)) {
            throw new Exception("Title cannot be empty");
        }
        $this->title = $title;
        return $this;
    }


   /* public function getImage()
    {
        return $this->image;
    }


    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }*/

    public function getDescription()
    {
        return $this->description;
    }

 
    public function setDescription($description)
    {
        if (empty($description)) {
            throw new Exception("description cannot be empty");
        }
        $this->description = $description;
        return $this;
    }

    

    public static function getAll()
    {
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }


    public function setProjectInDatabase()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into posts (title, image, description, date) values (:title, :image, :description, now())");
        
        $title = $this->getTitle();
        $description = $this->getDescription();
        $statement->bindValue(":title", $title);
        $statement->bindValue(":description", $description);
        $result = $statement->execute();
        return $result;
    }

    /*public static function getUserId(int $userId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select users.`id` from users inner join users on posts.`user_id` = users.`id`");
        $statement->bindValue('userId', $userId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }*/

    public function canUploadProject()
    {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
    
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt)); //check in lowercase
    
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'svg');
    
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 500000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'uploaded_projects/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $image = basename($fileName);
                    $this->setProjectInDatabase($image);
                    
                } else {
                    throw new Exception("Your file is too large!");
                }
            } else {
                throw new Exception("There was an error uploading your file");
            }
        } else {
            throw new Exception("You cannot upload files of this type");
        }

    }
    }


   

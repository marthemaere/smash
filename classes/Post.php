<?php

include_once(__DIR__ . "/Db.php");

class Post
{
    private $title;
    private $image;
    private $description;
    private $username;
    //private $tags;



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


    public function getImage()
    {
        return $this->image;
    }


    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }


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

    public function getUsername()
    {
        return $this->username;
    }

 
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    

    public static function getAll()
    {
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }

    public function getUsernameById($username){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select username from posts inner join users on user_id = posts.user_id");
        $username = $statement->execute();
        return $username;
    }
    
    public function setProjectInDatabase()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into posts (title, image, description, date) values (:title, :image, :description, now())");
        $title = $this->getTitle();
        $image = $this->getImage();
        $description = $this->getDescription();
        //$tags = $this->getTags();
        $statement->bindValue(":title", $title);
        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
       // $statement->bindValue(":tags", $tags);
        $result = $statement->execute();
        return $result;
    }

    /*public static function getUsername(int $userId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select username from posts inner join users on users.id = :posts.user_id");
        $statement->bindValue('posts.user_id', $username);
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
                    $fileDestination = 'uploaded_projects/' . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $image = basename($fileName);
                    $this->setImage($image);
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


   

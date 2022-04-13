<?php

include_once(__DIR__ . "/Db.php");

class Post
{
    private $title;
    private $image;
    private $freetags;
    private $userId;
    private $description;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUser_id($userId)
    {
        $this->user_id = $userId;
        return $this;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        if (empty($title)) {
            throw new Exception("title cannot be empty");
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


    public function getFreetags()
    {
        return $this->freetags;
    }

    public function setFreetags($freetags)
    {
        $this->freetags = $freetags;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

 
    public function setDescription($description)
    {
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
        $image = $this->getImage();
        $description = $this->getDescription();
        $statement->bindValue(":title", $title);
        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $result = $statement->execute();
        return $result;

    }

    public function canUploadProject()
    {
        $file = $_FILES['file'];
        print_r($file);
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
                    $this->setImage($image);
                    $this->setProjectInDatabase($image);
                    
                } else {
                    echo  "Your file is too large!";
                }
            } else {
                echo  "There was an error uploading your file";
            }
        } else {
            echo  "You cannot upload files of this type";
        }

    }
    }


   

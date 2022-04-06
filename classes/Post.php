<?php
class Post
{
    private $title;
    private $image;
    private $freetags;
    private $upload;


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


    public function getProjectToUpload()
    {
        return $this->upload;
    }


    public function setProjectToUpload($upload)
    {
        $this->upload = $upload;
        return $this;
    }


    public static function getAll()
    {
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    }

    public function updateProjectInDatabase($projectToUpload, $id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET image = :projectToUpload WHERE id = :id");
        $statement->bindValue(":projectToUpload", $projectToUpload);
        $statement->bindValue(":id", $id);
        $statement->execute();
        header('Location: projectSettings.php#');
    }


    public function canUploadProject($sessionId)
    {
        $fileName = $_FILES['projectToUpload']['name'];
        $fileTmpName = $_FILES['projectToUpload']['tmp_name'];
        $fileSize = $_FILES['projectToUpload']['size'];

        $fileTarget = 'uploaded_projects/' . basename($fileName);
        $fileIsImage = getimagesize($fileTmpName);

        // Check file size
        if ($fileSize > 500000) {
            $canUpload = false;
            throw new Exception('Image size can not be larger than 5MB, try again.');
        }

         // Check if file is an image
         if ($fileIsImage !== false) {
            $canUpload = true;
        } else {
            $canUpload = false;
            throw new Exception("Your uploaded file is not an image.");
        }

        // Upload file when no errors
        if ($canUpload) {
            if (move_uploaded_file($fileTmpName, $fileTarget)) {
                $projectToUpload = basename($fileName);
                $this->setProjectToUpload($projectToUpload);
                $this->updateProjectInDatabase($projectToUpload, $sessionId);
        }
  
    }
}
}
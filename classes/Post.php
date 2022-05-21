<?php
include_once(__DIR__ . "/Db.php");

class Post
{
    private $title;
    private $image;
    private $imageThumb;
    private $description;
    private $userId;
    private $postId;

    public function getUserId()
    {
        return $this->userId;
    }

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
            throw new Exception("Title cannot be empty.");
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

    public function setPostId($postId)
    {
        $this->postId = $postId;
        return $this;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public static function deleteProject($postId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("delete from posts where id = :postId");
        $statement->bindValue(":postId", $postId);
        $postId =  $_GET['p'];
        print_r($postId);
        return $statement->execute();
    }

    public function setPostById($postId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT id FROM posts WHERE id = :postId");
        $statement->bindValue(":postId", $postId);
        $postId = $statement->execute();
        return $postId;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        if (empty($description)) {
            throw new Exception("Description cannot be empty.");
        }
        $this->description = $description;
        return $this;
    }

    public function setProjectInDatabase()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into posts (title, image, image_thumb, description, date, user_id) values (:title, :image, :image_thumb, :description, now(), :userId)");
        $title = $this->getTitle();
        $image = $this->getImage();
        $userId = $this->getUserId();
        $description = $this->getDescription();
        $statement->bindValue(":title", $title);
        $statement->bindValue(":image_thumb", $this->getImageThumb());
        $statement->bindValue(":image", $image);
        $statement->bindValue(":description", $description);
        $statement->bindValue(":userId", $userId);
        $result = $statement->execute();
        return $conn->lastInsertId();
        return $result;
    }


    public function canUploadProject()
    {
        // $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        // $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt)); //check in lowercase

        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'svg');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2097152) {
                    //$fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'uploaded_projects/' . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $image = basename($fileName);
                    $this->setImage($image);
                    $result = $this->setProjectInDatabase();
                    return $result;
                } else {
                    throw new Exception("Your file is too large!");
                }
            } else {
                throw new Exception("There was an error uploading your file.");
            }
        } else {
            throw new Exception("You cannot upload files of this type.");
        }
    }



    public static function search($search)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from posts INNER JOIN users ON posts.user_id = users.id INNER JOIN tags on tags.post_id = posts.id where posts.title like :search OR tag like :search");
        $statement->bindValue(":search", "%$search%");
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getPostDataFromId($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM posts INNER JOIN users on posts.user_id = users.id WHERE posts.id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getPosts($sorting, $start, $limit)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * from posts INNER JOIN users ON posts.user_id = users.id ORDER BY `date` $sorting LIMIT $start, $limit");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function getTagsFromPost($postId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM tags WHERE post_id = :postId");
        $statement->bindValue(':postId', $postId);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function filterPostsByFollowing($start, $limit)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare(
            "SELECT * 
            FROM posts p
            INNER JOIN followers f ON f.following_id = p.user_id
            INNER JOIN users u ON p.user_id = u.id 
            ORDER BY `date` DESC 
            LIMIT $start, $limit"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function smashed($postId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE posts SET isShowcase=1 where posts.id = :postId");
        $statement->bindValue(':postId', $postId);
        return $statement->execute();
    }

    public static function unsmashed($postId)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE posts SET isShowcase=0 where posts.id = :postId");
        $statement->bindValue(':postId', $postId);
        return $statement->execute();
    }

    public static function showSmashedProjects($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare(
            "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.isShowcase=1 AND posts.user_id = :id"
        );
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public function isSmashed()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM posts WHERE posts.id = :id AND posts.isShowcase = 1 ");
        $statement->bindValue(':id', $this->postId);
        $statement->execute();
        $result = $statement->fetch();
        if ($result != null) {
            return true;
        } else {
            return false;
        }
        return $result;
    }

    public static function deletePosts($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM posts WHERE user_id = :id");
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    public function editTitle($postId)
    {
        $title = $this->getTitle();
        // $postId =  $_GET['p'];

        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE posts SET title= :title where id = :postId");
        $statement->bindValue(":title", $title);
        $statement->bindValue(":postId", $postId);
        return $statement->execute();
    }

    /**
     * Get the value of imageThumb
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * Set the value of imageThumb
     *
     * @return  self
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;

        return $this;
    }
}

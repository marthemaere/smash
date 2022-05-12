<?php

class Smashed {
    private $postId;
    private $userId;

   
    public function getPostId()
    {
        return $this->postId;
    }

   
    public function setPostId($postId)
    {
        $this->postId = $postId;
        return $this;
    }


    public function getUserId()
    {
        return $this->userId;
    }


    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    // public static function smashed($postId){
    //     $conn = Db::getInstance();
    //     $statement = $conn->prepare("UPDATE posts SET isShowcase= 1 where id = :postId");
    //     $statement->bindValue(':postId', $postId);
    //     return $statement->execute();
    // }

    public function saveSmash($postId)
        {
            $postId= $this->getPostId();
            $userId= $this->getUserId();

            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT into smashed (user_id, post_id) values (:user_id, :post_id)");
            $statement->bindValue(":user_id", $userId);
            $statement->bindValue(":post_id", $postId);

            $result= $statement->execute();
            return $result;        
        }

    public static function showSmashedProjects()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare(
        "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id INNER JOIN tags ON tags.post_id = posts.id WHERE posts.isShowcase=1" );
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
}
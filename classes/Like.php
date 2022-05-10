<?php
    class Like
    {
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

        public function saveLike()
        {
            $postId= $this->getPostId();
            $userId= $this->getUserId();

            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT into likes (user_id, post_id) values (:user_id, :post_id)");
            $statement->bindValue(":user_id", $userId);
            $statement->bindValue(":post_id", $postId);

            $result= $statement->execute();
            return $result;        
        }

        public static function countLike($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT COUNT(user_id) FROM likes WHERE post_id= :id");
            $statement->bindValue(":id", $id);
            $statement->execute();
            $likes = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $likes;
        }

        public static function deleteLikes($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM likes WHERE user_id = :id");
            $statement->bindValue(':id', $id);
            return $statement->execute();
        }
    }

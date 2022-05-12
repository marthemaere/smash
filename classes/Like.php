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

        public function countLike()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT COUNT(user_id) FROM likes WHERE post_id= :postid");
            $statement->bindValue(":postid", $this->getPostId());
            $statement->execute();
            $count = intval($statement->fetchColumn());

            if ($count > 0){
                return true;
            }

            return $count;
        }

        public function deleteLikes()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM likes WHERE user_id = :userid OR post_id= :postid");
            $statement->bindValue(':userid', $this->getUserId());
            $statement->bindValue(':postid', $this->getPostId());
            return $statement->execute();
        }
    }

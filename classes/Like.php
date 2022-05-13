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
            $statement = $conn->prepare("SELECT COUNT(id) FROM likes WHERE post_id= :postid OR user_id=:userid");
            $statement->bindValue(":postid", $this->getPostId());
            $statement->bindValue(":userid", $this->getUserId());
            $statement->execute();
            $count = intval($statement->fetchColumn());

            if ($count > 0) {
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

        public function isLikedByUser()
        {
            $conn = Db::getInstance();
            $userId = $this->getUserId();
            $postId = $this->getPostId();
            $statement = $conn->prepare("SELECT * FROM likes WHERE user_id = :userid AND post_id = :postid");
            $statement->bindValue(":userid", $userId);
            $statement->bindValue(":postid", $postId);
            $statement->execute();
            $result = $statement->fetchAll();
            if ($result != null) {
                return true;
            } else {
                return false;
            }
        }

        public static function deleteLikesFromUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM likes WHERE user_id = :id");
            $statement->bindValue(':id', $id);
            return $statement->execute();
        }
    }

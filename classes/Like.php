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
            $statement = $conn->prepare("SELECT COUNT(id) FROM likes WHERE post_id= :postid AND user_id=:userid");
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
            $statement = $conn->prepare("DELETE FROM likes WHERE user_id = :userid AND post_id= :postid");
            $statement->bindValue(':userid', $this->getUserId());
            $statement->bindValue(':postid', $this->getPostId());
            return $statement->execute();
        }

        public static function deleteLikesFromUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM likes WHERE user_id = :id");
            $statement->bindValue(':id', $id);
            return $statement->execute();
        }

        public function isPostLikedByUser()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id");
            $statement->bindValue(":user_id", $this->getUserId());
            $statement->bindValue(":post_id", $this->getPostId());
            $statement->execute();
            $result = $statement->fetch();
            if ($result != null) {
                return true;
            } else {
                return false;
            }
        }

        public function getLikes()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT COUNT(id) FROM likes WHERE post_id= :postid");
            $statement->bindValue(":postid", $this->getPostId());
            $statement->execute();
            $count = $statement->fetch();
            return $count;
        }
    }

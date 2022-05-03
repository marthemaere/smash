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
            $conn = Db::getInstance();
            $statement = $conn->prepare("insert into likes (post_id, user_id) values (:postid, :userid)");
            $statement->bindValue(":postid", $this->getPostId());
            $statement->bindValue(":userid", $this->getUserId());
            return $statement->execute();
        }

        public function countLike()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT COUNT(user_id) FROM likes");
            return $statement->execute();
        }

        public static function deleteLikes($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('DELETE FROM likes WHERE user_id = :id');
            $statement->bindValue(':id', $id);
            return $statement->execute();
        }
    }

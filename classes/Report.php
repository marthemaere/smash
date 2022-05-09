<?php
include_once(__DIR__ . "/Db.php");

    class Report
    {
        private $userId;
        private $postId;
        

        /**
         * Get the value of userId
         */
        public function getUserId()
        {
            return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */
        public function setUserId($userId)
        {
            $this->userId = $userId;

            return $this;
        }

        /**
         * Get the value of postId
         */
        public function getPostId()
        {
            return $this->postId;
        }

        /**
         * Set the value of postId
         *
         * @return  self
         */
        public function setPostId($postId)
        {
            $this->postId = $postId;

            return $this;
        }

        public function reportUser()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO reports (user_id) VALUES (:user_id)");
            $statement->bindValue(":user_id", $this->userId);
            $result = $statement->execute();
            return $result;
        }

        public function reportPost()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO reports (post_id) VALUES (:post_id)");
            $statement->bindValue(":post_id", $this->postId);
            $result = $statement->execute();
            return $result;
        }
    }

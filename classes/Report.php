<?php
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
            $db = Db::getInstance();
            $stmt = $db->prepare("INSERT INTO reports (user_id) VALUES (:user_id)");
            $stmt->bindValue(":user_id", $this->userId);
            $result = $stmt->execute();
            return $result;
            if (!$result) {
                throw new Exception("Something went wrong while reporting user.");
            }
        }
    }

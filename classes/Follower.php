<?php
    class Follower
    {
        private $followerId;
        private $followingId;

        public function setFollowerId($followerId)
        {
            $this->followerId = $followerId;
            return $this;
        }
        
        public function getFollowerId()
        {
            return $this->followerId;
        }

        public function setFollowingId($followingId)
        {
            $this->followingId = $followingId;
            return $this;
        }
        
        public function getFollowingId()
        {
            return $this->followingId;
        }

        public function followExists()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT COUNT(*) FROM followers WHERE follower_id = :followerId AND following_id = :followingId");

            $statement->bindValue(":followerId", $this->getFollowerId());
            $statement->bindValue(":followingId", $this->getFollowingId());
            $statement->execute();
            $count = intval($statement->fetchColumn());

            if ($count > 0) {
                return true;
            }
            return $count;
        }

        public function followUser()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO followers (follower_id, following_id) VALUES (:followerId, :followingId)");

            $follower = $this->getFollowerId();
            $following = $this->getFollowingId();

            $statement->bindValue(":followerId", $follower);
            $statement->bindValue(":followingId", $following);
            $result = $statement->execute();
            return $result;
        }
        
        public static function deleteFollowers($userId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('DELETE FROM followers WHERE follower_id = :userId OR following_id = :userId');
            $statement->bindValue(':userId', $userId);
            return $statement->execute();
        }
    }

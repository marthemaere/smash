<?php

    class Follower
    {
        public static function deleteFollowers($userId)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('DELETE FROM followers WHERE follower_id = :userId OR following_id = :userId');
            $statement->bindValue(':userId', $userId);
            return $statement->execute();
        }
    }

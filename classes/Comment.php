<?php
    class Comment
    {
        public static function getCommentsFromPostId($id)
        {
            $db = Db::getInstance();
            $stmt = $db->prepare("SELECT * FROM comments WHERE post_id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }

        public static function deleteComments($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM comments WHERE user_id = :id");
            $statement->bindValue(":id", $id);
            return $statement->execute();
        }
    }

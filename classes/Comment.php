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
    }

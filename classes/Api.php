<?php
    class Api
    {
        public function get40LatestPosts()
        {
            $conn = Db::getInstance();
            $statement = $conn->query('SELECT id, title postTitle, description postDescription ,CONCAT(\'http://localhost/api/feed.php?p=\', id) as postLink, date postDateAdded, image postImageThumbnail FROM posts ORDER BY id DESC LIMIT 40');
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

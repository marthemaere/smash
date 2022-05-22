<?php
    class Api
    {
        public function get40LatestPosts()
        {
            $conn = Db::getInstance();
            $statement = $conn->query('SELECT id, title postTitle, description postDescription ,CONCAT(\'https://smash.weareimd.be/post.php?p=\', id) as postLink, date postDateAdded, image postImage, image_thumb postImageThumbnail FROM posts ORDER BY id DESC LIMIT 40');
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

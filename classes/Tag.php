<?php

use LDAP\Result;

include_once(__DIR__ . "/Db.php");

class Tag
{
    private $tags;
    private $post;

    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTag($tags)
    {
        $this->tags = $tags;
        return $this;
    }
    
    public function getPost()
    {
        return $this->post;
    }

    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }


    public function addTagsToDatabase($post_id)
    {
        $tags = $this->getTags();
        $tags = explode(" ", $tags);
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into tags (tag, post_id) values (:tag, :post_id)");
      

        for ($i=0; $i<count($tags); $i++) {
            $statement->bindValue(":tag", $tags[$i]);
            $statement->bindValue(":post_id", $post_id);
            $result = $statement->execute();
        }

        unset($tags);
        return $result;
    }

    public function editTags($postId)
    {
        $tags = $this->getTags();

        $conn = Db::getInstance();

        $statement = $conn->prepare("UPDATE tags SET tag= :tag where post_id = :postId");
        
        $statement->bindValue(":tag", $tags);
        $statement->bindValue(":postId", $postId);
        $result = $statement->execute();
        return $result;
    }

    public static function filterPostsByTag($tag)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM posts INNER JOIN users on posts.user_id = users.id INNER JOIN tags ON posts.id = tags.post_id WHERE tags.tag = :tag");
        $statement->bindValue(':tag', $tag);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function sortPopularTagsDesc()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT tag, COUNT(tag) FROM tags GROUP BY tag HAVING COUNT(tag) > 1 ORDER BY COUNT(tag) DESC LIMIT 5");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    public static function filterPostsByPopularTag($popularTag)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM posts INNER JOIN users on posts.user_id = users.id INNER JOIN tags ON posts.id = tags.post_id WHERE tags.tag = :tag");
        $statement->bindValue(':tag', $popularTag);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
}

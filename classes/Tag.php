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
        if(empty($tags)) {
            throw new Exception("Tags cannot be empty.");
        }
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
        if (!empty($tags)) {
            //$myString = $tags;
            $tags = explode(" ", $tags);
            for ($i = 0; $i < count($tags); $i++) {
                if (strpos($tags[$i], '#') === false) {
                    $tags[$i] =  "#" . $tags[$i];
                }
            }
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT into tags (tag, post_id) VALUES (:tag, :post_id)");
            for ($i = 0; $i < count($tags); $i++) {
                $statement->bindValue(":tag", $tags[$i]);
                $statement->bindValue(":post_id", $post_id);
                $result = $statement->execute();
            }
            unset($tags);
            return $result;
        }
    }
    public function resetTagsInDatabase($post_id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM tags WHERE post_id = :postid");
        $statement->bindValue(':postid', $post_id);
        return $statement->execute();
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

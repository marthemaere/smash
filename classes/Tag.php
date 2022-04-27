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

    public function addPostId()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT posts.id from posts INSERT inner join tags on posts.id = tags.post_id");
        $statement->execute();
        $postId = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $postId;
    }


    public function addTagsToDatabase(){

        $tags = $_POST["tags"];
        $tags = explode(", ", $tags);
        $conn = Db::getInstance();
        $statement = $conn->prepare("insert into tags (tag) values (:tag)");
      

        for($i=0; $i<count($tags); $i++){
            $statement->bindValue(":tag", $tags[$i]);
            $result = $statement->execute();
        }

        unset($tags);
        return $result;
        
    }





    

   
   

}
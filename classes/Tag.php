<?php

include_once(__DIR__ . "/Db.php");

class Tag
{
    private $tags;
    private $postId;


    public function getTags()
    {
        return $this->tags;
    }


    public function setTag($tags)
    {
        $this->tags = $tags;
        return $this;
    }


    public function getPostId()
    {
        return $this->postId;
    }


    public function setPostId($postId)
    {
        $this->postId = $postId;
        return $this;
    }

    public function addTagsToDatabase(){

        $tags = $_POST["tags"];
        $tags = explode(",", $tags);
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
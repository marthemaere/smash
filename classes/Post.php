<?php
class Post
{
    public static function getAll(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();
    } 

    
}

<?php
    include_once("../bootstrap.php");
    
    $api = new Api();
    $posts = $api->get40LatestPosts();
    $postLink = "http://localhost/api/feed.php?p=";
    //array_push($posts, $postLink);
    //var_dump($posts);
    $response = ["status" => "success", "data" => ["posts" => $posts]];

    header("Content-Type: application/json");
    echo json_encode($response);

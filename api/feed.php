<?php
    include_once("../bootstrap.php");
    
    $api = new Api();
    $posts = $api->get40LatestPosts();
    
    $response = [
        "status" => "success",
        "data" => [
            "posts" => $posts
        ]
    ];

    header("Content-Type: application/json");
    echo json_encode($response);

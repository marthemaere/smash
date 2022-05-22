<?php
    header('Access-Control-Allow-Origin: *'); 
    header( 'Access-Control-Allow-Methods: GET' );
    header( 'Access-Control-Allow-Credentials: true' );
    header('Access-Control-Allow-Headers: Content-Type');


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

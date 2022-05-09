<?php
    require_once('../bootstrap.php');

    if( !empty($_POST) ) {
        $text = $_POST['comment'];

        try {
            $c = new Comment();
            $c->setText($text);
            $c->save();

            // success
            $result = [
                "status" => "success",
                "message" => "Comment was saved.", 
                "data" => [
                    "comment" => htmlspecialchars($text)
                ]
            ];

        } catch( Throwable $t ) {
            // error
            $result = [
                "status" => "error",
                "message" => "Something went wrong."
            ];
        }

        echo json_encode($result);

    }
<?php
    class Comment
    {
        private $text;
        private $postId;
        private $userId;

        /**
         * Get the value of text
         */ 
        public function getText()
        {
                return $this->text;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */ 
        public function setText($text)
        {
                $this->text = $text;

                return $this;
        }

        /**
         * Get the value of postId
         */ 
        public function getPostId()
        {
                return $this->postId;
        }

        /**
         * Set the value of postId
         *
         * @return  self
         */ 
        public function setPostId($postId)
        {
                $this->postId = $postId;

                return $this;
        }

        /**
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        public function save(){
            $conn= new PDO("mysql:host=db;dbname='facebook', 'root', 'root'");
            $statement= $conn->prepare("INSERT into comments (text, post_id, user_id) values (:text, :post_id, :user_id)");
            
            $text= $this->getText();
            //$postId= $this->getPostId();
            //$userId= $this->getUserId();
           
            $statement->bindValue(":text", $text);
            $statement->bindValue(":post_id", '1');
            $statement->bindValue(":user_id", '1');

            $result= $statement->execute();
            return $result;
        }

        public static function getCommentsFromPostId($id)
        {
            $db = Db::getInstance();
            $stmt = $db->prepare("SELECT * FROM comments WHERE post_id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        }

        public static function deleteComments($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("DELETE FROM comments WHERE user_id = :id");
            $statement->bindValue(":id", $id);
            return $statement->execute();
        }
    }

<?php
    class Post
    {
        private $title;
        private $image;
        private $freetags;
        private $upload;

        public static function getAll(){
        $conn = Db::getInstance();
        $result = $conn->query("select * from posts");
        return $result->fetchAll();

        /**
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of image
         */ 
        public function getImage()
        {
                return $this->image;
        }

        /**
         * Set the value of image
         *
         * @return  self
         */ 
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }

        /**
         * Get the value of freetags
         */ 
        public function getFreetags()
        {
                return $this->freetags;
        }

        /**
         * Set the value of freetags
         *
         * @return  self
         */ 
        public function setFreetags($freetags)
        {
                $this->freetags = $freetags;

                return $this;
        }

        /**
         * Get the value of upload
         */ 
        public function getUpload()
        {
                return $this->upload;
        }

        /**
         * Set the value of upload
         *
         * @return  self
         */ 
        public function setUpload($upload)
        {
                $this->upload = $upload;

                return $this;
        }
    }

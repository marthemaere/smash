<?php

use LDAP\Result;

include_once(__DIR__ . "/Db.php");

    class User
    {
        private $email;
        private $username;
        private $password;

        public function setEmail($email){
            if(empty($email)){
                throw new Exception("email cannot be empty");
            }
            $this->email= $email;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setUsername($username){
            if(empty($username)){
                throw new Exception("username cannot be empty");
            }
            $this->username= $username;
        }

        public function getUsername(){
            return $this->username;
        }

        public function setPassword($password){
            if(empty($password)){
                throw new Exception("password cannot be empty and needs to contain at least 6 characters");
            }
            $this->password= $password;
        }

        public function getPassword(){
            return $this->password;
        }

        public function save(){
            //database connection
            
           $conn= Db::getInstance();

            //query to save in database

            $statement= $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");

            $email= $this->getEmail();
            $username= $this->getUsername();
            $password= $this->getPassword();

            $statement->bindValue(":email", $email);
            $statement->bindValue(":username", $username);
            $statement->bindValue(":password", $password);
                
            $result= $statement->execute();

            return $result;
        }
    }
<?php

use LDAP\Result;

include_once(__DIR__ . "/Db.php");

    class User
    {
        private $email;
        private $username;
        private $password;

        public function setEmail($email){
            $email_input= $_POST['email'];
          $domains = array('student.thomasmore.be', 'thomasmore.be');
            $pattern= "/^[a-z0-9._%+-]+@[a-z0-9.-]*(" . implode('|', $domains) . ")$/i";

            if(empty($email) || !preg_match($pattern, $email_input)){
                throw new Exception("email cannot be empty and needs to be a Thomas More email address");
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
            $password_input= $_POST['password'];
            if(empty($password) || strlen($password_input)<6){
                throw new Exception("password cannot be empty and needs to contain at least 6 characters");
            }
            $this->password= $password;
            return $this;
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

        public static function getAll(){
            $conn= Db::getInstance();
            $statement = $conn->prepare("select * from users");
            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }


        public function login(){

            $conn= Db::getInstance();
            $statement = $conn->prepare("select email, password from users where email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user){
                $hash = $user['password'];
                if(password_verify($this->password, $hash)){
                    return true;
    
                }else{
                    return false;
                }
            } else{
                throw new Exception("user does not exist, try again");
            }
           
        }


    }
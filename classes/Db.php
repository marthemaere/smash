<?php
    abstract class Db
    {
        private static $conn;

        public static function getInstance()
        {
            if (self::$conn != null) {
                // Return existing connection
                return self::$conn;
            } else {
                // New connection
                // first, let's see if we have an online connection variable on our server
                if(getenv("DATABASE_URL")){
                    $url = getenv('DATABASE_URL');
                    $components = parse_url($url);

                    // this link was useful: https://www.broculos.net/2015/12/dokku-creating-and-linking-mariadb.html
                    if ($components) {
                        $host = $components['host'];
                        $username = $components['user'];
                        $password = $components['pass'];
                        $dbname = substr($components['path'], 1);
                        $port = $components['port'];
                        self::$conn = new PDO('mysql:host='. $host .';dbname=' . $dbname, $username, $password);  
                    }
                }
                else {
                    // looks like we don't have a connection environment variable so this must be a local project
                    // let's just read from our config file
                    $config = parse_ini_file(__DIR__ . "/../config/config.ini");
                    self::$conn = new PDO('mysql:host='. $config['db_host'] .';dbname=' . $config['db_name'], $config['db_user'], $config['db_password']);  
                }
                
                return self::$conn;
            }
        }
    }

<?php


//include_once(__DIR__ . "../interfaces/iUser.php");
include_once(__DIR__ . "/Db.php");

//php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class User
{
    private $email;
    private $username;
    private $password;
    private $userId;
    private $profilePicture;

    public function setEmail($email)
    {
        $email_input = $_POST['email'];
        $domains = array('student.thomasmore.be', 'thomasmore.be');
        $pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]*(" . implode('|', $domains) . ")$/i";

        if (empty($email) || !preg_match($pattern, $email_input)) {
            throw new Exception("email cannot be empty and needs to be a Thomas More email address");
        }
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUsername($username)
    {
        if (empty($username)) {
            throw new Exception("username cannot be empty");
        }
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $password_input = $_POST['password'];
        if (empty($password) || strlen($password_input) < 6) {
            throw new Exception("password cannot be empty and needs to contain at least 6 characters");
        }
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->userId;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }
    
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function register()
    {
        //database connection

        $conn = Db::getInstance();

        //query to save in database

        $statement = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");

        $email = $this->getEmail();
        $username = $this->getUsername();
        $password = $this->getPassword();

        $statement->bindValue(":email", $email);
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $password);

        $result = $statement->execute();

        return $result;
    }

    public static function getAll()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users");
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }


    public function canLogin()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select email, password from users where email = :email");
        $statement->bindValue(":email", $this->email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hash = $user['password'];
            if (password_verify($this->password, $hash)) {
                return true;
            } else {
                throw new Exception("Password is wrong, try again");
                return false;
            }
        } else {
            throw new Exception("Userdata does not match, try again");
        }
    }

    public static function hasAccount($email)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from users where email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            throw new Exception("user doesn't exist");
        }
    }

    public static function sendPasswordResetEmail($emailTo)
    {
        //get random code
        $code = uniqid(true);
        //get connection
        $conn = Db::getInstance();
        //send email from email to user
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = 2;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'smash.weareimd@gmail.com';                     //SMTP username
            $mail->Password   = '4p7h*LN2j4WYj^';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                
            //Recipients
            $mail->setFrom('smash.weareimd@gmail.com', 'Smash');
            $mail->addAddress($emailTo);     //Add a recipient
            $mail->addReplyTo('no-reply@gmail.com', 'No reply');
                

            //Content
            //get url where user is on + add token
            $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetPassword.php?code=$code";
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Password reset link ";
            $mail->Body    = "<h1> You requested to reset your password </h1>
                                    click <a href='$url' > this link </a> to do so";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        };
    }

    public static function getIdByEmail($email)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select id from users where email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch();
        return $result['id'];
    }

    public static function getUserDataFromId($id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePictureInDatabase($profilePicture, $id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET profile_pic = :profilePicture WHERE id = :id");
        $statement->bindValue(":profilePicture", $profilePicture);
        $statement->bindValue(":id", $id);
        $statement->execute();
        header('Location: usersettings.php');
    }

    public function canUploadPicture($sessionId)
    {
        $fileName = $_FILES['profilePicture']['name'];
        $fileTmpName = $_FILES['profilePicture']['tmp_name'];
        $fileSize = $_FILES['profilePicture']['size'];
        
        $fileTarget = 'profile_pictures/' . basename($fileName);
        $fileExtention = strtolower(pathinfo($fileTarget, PATHINFO_EXTENSION));
        
        $fileIsImage = getimagesize($fileTmpName);

        // Check if file is an image
        if ($fileIsImage !== false) {
            $canUpload = true;
        } else {
            $error = 'Uw geupload bestand is geen afbeelding.';
            $canUpload = false;
        }

        // Check if file already exists
        if (file_exists($fileTarget)) {
            $canUpload = true;
        }

        // Check if file-size is under 2MB
        if ($fileSize > 2097152) { // 2097152 bytes
            $error = 'Je afbeelding mag niet groter zijn dan 2MB, probeer opnieuw.';
            $canUpload = false;
        }

        // Check if format is JPG, JPEG or PNG
        if ($fileExtention != 'jpg' && $fileExtention != 'jpeg' && $fileExtention != 'png' && !empty($fileName)) {
            $error = 'Dit bestandstype wordt niet ondersteund. Upload een jpg of png bestand.';
            $canUpload = false;
        }

        // Upload file when no errors
        if ($canUpload) {
            if (move_uploaded_file($fileTmpName, $fileTarget)) {
                $profilePicture = basename($fileName);
                $this->setProfilePicture($profilePicture);
                $this->updatePictureInDatabase($profilePicture, $sessionId);
            }
        }
    }
}

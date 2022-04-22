<?php
    //include_once(__DIR__ . "../interfaces/iUser.php");
    include_once(__DIR__ . "/Db.php");

    // Php Mailer
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
        private $biography;
        private $secondEmail;
        private $education;

        public function setEmail($email)
        {
            if (empty($email)) {
                throw new Exception("email cannot be empty");
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

        public function setBiography($biography)
        {
            $this->biography = $biography;
            return $this;
        }
        
        public function getBiography()
        {
            return $this->biography;
        }

        public function setSecondEmail($secondEmail)
        {
            $this->secondEmail = $secondEmail;
            return $this;
        }
        
        public function getSecondEmail()
        {
            return $this->secondEmail;
        }

        public function setEducation($education)
        {
            $this->education = $education;
            return $this;
        }
        
        public function getEducation()
        {
            return $this->education;
        }

        //registreren

        public function register()
        {
            $options=[
                'cost' => 12,
            ];
            $password= password_hash($_POST['password'], PASSWORD_DEFAULT, $options);

            $email_input = $_POST['email'];
            $domains = array('student.thomasmore.be', 'thomasmore.be');
            $pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]*(" . implode('|', $domains) . ")$/i";

            $conn = Db::getInstance();
            $query= $conn->prepare("SELECT * from users WHERE email=?");
            $query->execute([$email_input]);
            $result= $query->rowCount();

            if (((!empty($email) || preg_match($pattern, $email_input)) && $result <= 0)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");

                $statement->bindValue(":email", $this->email);
                $statement->bindValue(":username", $this->username);
                $statement->bindValue(":password", $password);

                $result = $statement->execute();
                return $result;
            } else {
                throw new Exception("email cannot be empty and needs to be a Thomas More email address");
            }
        }

        public static function getAll()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from users");
            $statement->execute();
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $users;
            print_r($users);
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

        /*   public static function emailExists($email){
               $conn = Db::getInstance();
               $statement = $conn->prepare("SELECT * FROM users WHERE email = '". $_POST['email']."'");
               $statement->bindValue($_POST['email'], $email);
               $statement->execute();
               $user = $statement->fetch(PDO::FETCH_ASSOC);

               if ($user) {
                   return true;
               }else {
                   throw new Exception("user doesn't exist");
               }
           }*/

        public static function sendPasswordResetEmail($emailTo)
        {
            // Get random code
            $code = uniqid(true);

            // Get connection
            $conn = Db::getInstance();

            // Send email from email to user
            $mail = new PHPMailer(true);

            try {
                // Server settings
                // $mail->SMTPDebug = 2;
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'smash.weareimd@gmail.com';             // SMTP username
                $mail->Password   = '4p7h*LN2j4WYj^';                       // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable implicit TLS encryption
                $mail->Port       = 587;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    
                // Recipients
                $mail->setFrom('smash.weareimd@gmail.com', 'Smash');
                $mail->addAddress($emailTo);     //Add a recipient
                $mail->addReplyTo('no-reply@gmail.com', 'No reply');
                    

                // Content
                // Get url where user is on + add token
                $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetPassword.php?code=$code";
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "Password reset link ";
                $mail->Body    = "<h1> You requested to reset your password </h1>
                                        click <a href='$url' > this link </a> to do so";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                // Save random code
                $now = time();
                $date = date('Y/m/d H:i:s', $now);
                $expiry_date = (new DateTime($date))->modify('+26 hours')->format('Y-m-d H:i:s');
                $statement = $conn->prepare("insert into reset_password (email, code, datetime) values (:email, :code, :date);");
                $statement->bindValue(':email', $emailTo);
                $statement->bindValue(':code', $code);
                $statement->bindValue(':date', $expiry_date);
                return $statement->execute();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            };
        }

        public static function getCode($code)
        {
            // Check if code exists
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from reset_password where code = :code");
            $statement->bindValue(":code", $code);
            $statement->execute();
            $link = $statement->fetch(PDO::FETCH_ASSOC);
            if ($link) {
                return true;
            } else {
                return false;
            }
        }

        public static function linkExpired()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from reset_password where datetime < now()");
            $statement->execute();
            $link = $statement->fetch(PDO::FETCH_ASSOC);
            if ($link) {
                return true;
            } else {
                return false;
            }
        }

        public static function getEmailFromCode($code)
        {
            // Get email from unique code that updates password
            $conn = Db::getInstance();
            $statement = $conn->prepare("select email from reset_password where code = :code");
            $statement->bindValue(":code", $code);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC); //result[email]
            return $result['email'];
        }

        public static function saveNewPassword($email, $password)
        {
            $options = [
                "cost" => 12
            ];
            $passwordhash = password_hash($password, PASSWORD_DEFAULT, $options);
            
            // Update database
            $conn = Db::getInstance();
            $statement = $conn->prepare("update users set password = :password where email = :email");
            $statement->bindValue(":password", $passwordhash);
            $statement->bindValue(":email", $email);
            $update = $statement->execute();
            if ($update) {
                return true;
            } else {
                throw new Exception("Something went wrong");
            }
        }

        public static function deleteCode($code)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("delete from reset_password where code = :code");
            $statement->bindValue(":code", $code);
            return $statement->execute();
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
            header('Location: usersettings.php#');
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
                $canUpload = false;
                throw new Exception("Your uploaded file is not an image.");
            }

            // Check if file already exists
            if (file_exists($fileTarget)) {
                $canUpload = true;
            }

            // Check if file-size is under 2MB
            if ($fileSize > 2097152) { // 2097152 bytes
                $canUpload = false;
                throw new Exception('Image size can not be larger than 2MB, try again.');
            }

            // Check if format is JPG, JPEG or PNG
            if ($fileExtention != 'jpg' && $fileExtention != 'jpeg' && $fileExtention != 'png' && !empty($fileName)) {
                $canUpload = false;
                throw new Exception("This filetype is not supported. Upload a jpg or png.");
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

        public function updateProfile()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE users SET bio = :biography, second_email = :secondEmail, education = :education WHERE id = :userId");

            $biography = $this->getBiography();
            $secondEmail = $this->getSecondEmail();
            $education = $this->getEducation();
            $userId = $this->getUserId();

            $statement->bindValue(":biography", $biography);
            $statement->bindValue(":secondEmail", $secondEmail);
            $statement->bindValue(":education", $education);
            $statement->bindValue(":userId", $userId);

            $statement->execute();
        }

        public static function checkPassword($email, $password)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from users where email = :email");
            $statement->bindValue(":email", $email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $hash = $user['password'];
                if (password_verify($password, $hash)) {
                    return true;
                } else {
                    throw new Exception('current password is wrong');
                }
            } else {
                throw new Exception("user does not exist");
            }
        }

        public static function changePassword($email, $password)
        {
            $options = [
                'cost' => 12
            ];
            $password = password_hash($password, PASSWORD_DEFAULT, $options);
            $conn = Db::getInstance();
            $statement = $conn->prepare("update users set password = :password where email = :email");
            $statement->bindValue(":email", $email);
            $statement->bindValue(":password", $password);
            return $statement->execute();
        }
        
        public static function deleteAccount($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("delete users, posts, comments, likes, followers from users 
                                            inner join posts on users.`id` = posts.`user_id`
                                            inner join comments on users.`id` = comments.`user_id`
                                            inner join likes on users.`id` = likes.`user_id`
                                            inner join followers on users.`id` = followers.`follower_id` OR followers.`following_id`
                                            where users.`id` = :id");
                                            
                                            
                                           
            $statement->bindValue(":id", $id);
            return $statement->execute();
        }
    }

<?php
    //include_once(__DIR__ . "../interfaces/iUser.php");
    include_once(__DIR__ . "/Db.php");

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
        
        private $socialLinkedIn;
        private $socialInstagram;
        private $socialGitHub;


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
                throw new Exception("Password cannot be empty and needs to contain at least 6 characters.");
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

        public function setSocialType($socialType)
        {
            $this->socialType = $socialType;
            return $this;
        }
        
        public function setSocialLinkedIn($socialLinkedIn)
        {
            $this->socialLinkedIn = $socialLinkedIn;
            return $this;
        }
        
        public function getSocialLinkedIn()
        {
            return $this->socialLinkedIn;
        }

        public function setSocialInstagram($socialInstagram)
        {
            $this->socialInstagram = $socialInstagram;
            return $this;
        }
        
        public function getSocialInstagram()
        {
            return $this->socialInstagram;
        }

        public function setSocialGitHub($socialGitHub)
        {
            $this->socialGitHub = $socialGitHub;
            return $this;
        }
        
        public function getSocialGitHub()
        {
            return $this->socialGitHub;
        }

        //registreren

        public function register()
        {
            $options=[
                'cost' => 12,
            ];
            $password= password_hash($this->getPassword(), PASSWORD_DEFAULT, $options);

            $email_input = $this->getEmail();
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
                throw new Exception("Email cannot be empty and needs to be a Thomas More email address. Try again.");
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
            $statement = $conn->prepare("select email, password from users where email = :email or second_email = :secondEmail");
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":secondEmail", $this->email);
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

        public static function getIdByEmail($email)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select id from users where email = :email or second_email = :secondEmail");
            $statement->bindValue(":email", $email);
            $statement->bindValue(":secondEmail", $email);
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
        }

        public function canUploadPicture($sessionId, $fileName, $fileTmpName, $fileSize)
        {
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
            $statement = $conn->prepare(
                "UPDATE users 
                SET bio = :biography, second_email = :secondEmail, education = :education
                WHERE id = :userId"
            );

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

        public function updateSocials()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare(
                "UPDATE users
                SET social_linkedin = :linkedin, social_instagram = :instagram, social_github = :github
                WHERE id = :userId"
            );

            $linkedIn = $this->getSocialLinkedIn();
            $instagram = $this->getSocialInstagram();
            $gitHub = $this->getSocialGitHub();
            $userId = $this->getUserId();

            $statement->bindValue(":linkedin", $linkedIn);
            $statement->bindValue(":instagram", $instagram);
            $statement->bindValue(":github", $gitHub);
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
                    throw new Exception('Current password is wrong. Please try again.');
                }
            } else {
                throw new Exception("User does not exist.");
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
        
        public static function deleteUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("delete from users where id = :id");
            $statement->bindValue(":id", $id);
            return $statement->execute();
        }

        public function getUserPostsFromId($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare(
                "SELECT u.username, u.profile_pic, u.social_github, u.social_linkedin, u.social_instagram, p.id, p.title, p.image, p.description
                FROM users u 
                INNER JOIN posts p ON u.id = p.user_id
                WHERE u.id = :id;"
            );
            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

<?php

    // Php Mailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    class Mailer
    {
        private $email;

        /**
         * Get the value of email
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        public function hasAccount()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from users where email OR second_email = :email");
            $statement->bindValue(":email", $this->email);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return true;
            } else {
                throw new Exception("This user doesn't exist.");
            }
        }

        public function sendPasswordResetEmail()
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
                $mail->addAddress($this->email);     //Add a recipient
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
                $statement->bindValue(':email', $this->email);
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
    }

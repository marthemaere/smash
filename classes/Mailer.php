<?php


// Import postmark library
use Postmark\PostmarkClient;

include_once(__DIR__ . '/../vendor/autoload.php');

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

    public static function hasAccount($email)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select id from users where email = :email OR second_email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return true;
        } else {
            throw new Exception("Sorry, we can't help you with that email address.");
        }
    }

    public static function sendMail($email)
    {
        try {

            $code = uniqid(true);

            if (getenv('POSTMARK_TOKEN')) {
                $client = new PostmarkClient(getenv('POSTMARK_TOKEN'));
            } else {
                $config = parse_ini_file(__DIR__ . "/../config/postmark.ini");
                $client = new PostmarkClient($config['key']);
            }

            $fromEmail = "smash@weareimd.be";
            $toEmail = $email;
            $subject = "Password recovery";
            $textBody = "Password recovery";
            $tag = "example-email-tag";
            $trackOpens = true;
            $trackLinks = "None";
            $messageStream = "outbound";

            // Setting the email content

            $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetPassword.php?code=$code";
            $htmlBody = "<h1>You requested a password reset</h1>
                        <p>Click <a href= '$url'>this link</a> to reset your password</p>";

            $sendResult = $client->sendEmail(
                $fromEmail,
                $toEmail,
                $subject,
                $htmlBody,
                $textBody,
                $tag,
                $trackOpens,
                NULL, // Reply To
                NULL, // CC
                NULL, // BCC
                NULL, // Header array
                NULL, // Attachment array
                $trackLinks,
                NULL, // Metadata array
                $messageStream
            );

            self::saveCode($code, $email);
        } catch (Exception $e) {
            throw new Exception("Message could not be sent.");

        }


    }

    public static function saveCode($code, $email)
    {
        // Save random code
        $conn = Db::getInstance();
        $now = time();
        $date = date('Y/m/d H:i:s', $now);
        $expiry_date = (new DateTime($date))->modify('+26 hours')->format('Y-m-d H:i:s');
        $statement = $conn->prepare("insert into reset_password (email, code, datetime) values (:email, :code, :date);");
        $statement->bindValue(':email', $email);
        $statement->bindValue(':code', $code);
        $statement->bindValue(':date', $expiry_date);
        return $statement->execute();
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
        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }
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

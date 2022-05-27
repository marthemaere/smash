<?php
include_once(__DIR__ . "/Db.php");

    class Report
    {
        private $reported_userId;
        private $report_userId;
        private $postId;
        

        /**
        * Get the value of reported_userId
        */
        public function getReported_userId()
        {
            return $this->reported_userId;
        }

        /**
         * Set the value of reported_userId
         *
         * @return  self
         */
        public function setReported_userId($reported_userId)
        {
            $this->reported_userId = $reported_userId;

            return $this;
        }


        /**
         * Get the value of report_userId
         */
        public function getReport_userId()
        {
            return $this->report_userId;
        }

        /**
         * Set the value of report_userId
         *
         * @return  self
         */
        public function setReport_userId($report_userId)
        {
            $this->report_userId = $report_userId;

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

        public function reportUser()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO reports (reported_user_id, report_user_id) VALUES (:user_id, :report_user_id)");
            $statement->bindValue(":user_id", $this->reported_userId);
            $statement->bindValue(":report_user_id", $this->report_userId);
            $result = $statement->execute();
            return $result;
        }

        public function reportPost()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("INSERT INTO reports (report_user_id, post_id) VALUES (:user_id, :post_id)");
            $statement->bindValue(":post_id", $this->postId);
            $statement->bindValue(":user_id", $this->report_userId);
            $result = $statement->execute();
            return $result;
        }

        public function isPostReportedByUser()
        {
            $conn = Db::getInstance();
            $userId = $this->getReport_userId();
            $postId = $this->getPostId();
            $statement = $conn->prepare("SELECT * FROM reports WHERE report_user_id = :user_id AND post_id = :post_id");
            $statement->bindValue(":user_id", $userId);
            $statement->bindValue(":post_id", $postId);
            $statement->execute();
            $result = $statement->fetchAll();
            if ($result != null) {
                return true;
            } else {
                return false;
            }
        }

        public function isUserReportedByUser()
        {
            $conn = Db::getInstance();

            $userId = $this->getReport_userId();
            $reportedUserId = $this->getReported_userId();

            $statement = $conn->prepare("SELECT * FROM reports WHERE report_user_id = :user_id AND reported_user_id = :reported_user_id");
            $statement->bindValue(":user_id", $userId);
            $statement->bindValue(":reported_user_id", $reportedUserId);
            $statement->execute();
            $result = $statement->fetchAll();

            if ($result != null) {
                return true;
            } else {
                return false;
            }
        }

        public static function getReportedUsers()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT reported_user_id ,count(reported_user_id) as count, users.username from reports INNER JOIN users on users.id = reports.reported_user_id GROUP BY reported_user_id HAVING COUNT(reported_user_id) > 0  ORDER BY COUNT(post_id) DESC");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function getCountReportedUser($user_id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT count(reported_user_id) as count from reports WHERE reported_user_id = :user_id");
            $statement->bindValue(":user_id", $user_id);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }

        public static function getCountReportedPost($post_id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT count(post_id) as count from reports WHERE post_id = :post_id");
            $statement->bindValue(":post_id", $post_id);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }

        public static function getReportedPosts()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT post_id, COUNT(post_id) as `count`, posts.title, CONCAT('http://localhost:8888/smash/post.php?p=', post_id) as `link` from reports INNER JOIN posts on posts.id = reports.post_id GROUP BY post_id HAVING COUNT(post_id) > 0  ORDER BY COUNT(post_id) DESC");
            $statement->execute();
            $result = $statement->fetchAll();
            return $result;
        }

        public static function blockUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE users SET is_blocked = :bool WHERE id = :id");
            $statement->bindValue(":id", $id);
            $statement->bindValue(":bool", 1);
            return $statement->execute();
        }

        public static function unblockUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("UPDATE users SET is_blocked = :bool WHERE id = :id");
            $statement->bindValue(":id", $id);
            $statement->bindValue(":bool", 0);
            return $statement->execute();
        }

        public static function getBlockedUser($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare("SELECT is_blocked FROM users WHERE id = :id ");
            $statement->bindValue(":id", $id);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        }
    }

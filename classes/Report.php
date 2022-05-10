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
    }

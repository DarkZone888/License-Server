<?php 
    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'license_server');
        
    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }
        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM license");
            return $result;
        }

        public function fetchonerecord($userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM license WHERE id = '$userid'");
            return $result;
        }

        public function updateip($ip,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                ip = '$ip'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function updatescript($script,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                script = '$script'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function updatename($name,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                name = '$name'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function updatekey($license,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                license = '$license'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function updatediscord($discord,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                discord = '$discord'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function updateexpired($expired,$userid) {
            $result = mysqli_query($this->dbcon, "UPDATE license SET 
                expired = '$expired'
                WHERE id = '$userid'
            ");
            return $result;
        }

        public function delete($userid) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM license WHERE id = '$userid'");
            return $deleterecord;
        }

        //lscp

        public function fetchdatals() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM list_script");
            return $result;
        }

        public function fetchonerecordls($lsid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM list_script WHERE id = '$lsid'");
            return $result;
        }

        public function updascript($script,$lsid) {
            $result = mysqli_query($this->dbcon, "UPDATE list_script SET 
                script = '$script'
                WHERE id = '$lsid'
            ");
            return $result;
        }

        public function updatels($version,$lsid) {
            $result = mysqli_query($this->dbcon, "UPDATE list_script SET 
                version = '$version'
                WHERE id = '$lsid'
            ");
            return $result;
        }

        public function deletels($lsid) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM list_script WHERE id = '$lsid'");
            return $deleterecord;
        }

        public function updatimage($image,$lsid) {
            $result = mysqli_query($this->dbcon, "UPDATE list_script SET 
                image = '$image'
                WHERE id = '$lsid'
            ");
            return $result;
        }

    }



?>
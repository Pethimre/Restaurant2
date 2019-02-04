<?php
    class db{
        private static $host = "localhost:3306";
        private static $username = "root";
        private static $password = "";
        private static $database = "Restaurant";
        private static $coding = "utf8";
        private static $instance = null;
        private $connection = "";

        public function __construct(){
            $this->connection = mysqli_connect(self::$host,self::$username,self::$password);
            if(mysqli_connect_errno($this->connection)){
                die("Could not connect mysql database");
            }else{
                mysqli_select_db($this->connection,self::$database);
                mysqli_set_charset($this->connection,self::$coding);
            }
        }
        public static function get(){
            if(is_null(self::$instance)){
                self::$instance = new db;
            }
            return self::$instance;
        }
        public function query($queryString){
            $result = mysqli_query($this->connection, $queryString);
            if (!$result) {
                $this->error(mysqli_error($this->connection),$queryString);
            }
            return $result;
        }
        public function insert_id(){
            return mysqli_insert_id($this->connection);
        }
        public function numrows($queryString){
            $result = $this->query($queryString);
            return mysqli_num_rows($result);
        }
        public function getRow($queryString){
            $result = $this->query($queryString);
            return mysqli_fetch_assoc($result);
        }
        public function getArray($queryString){
            $rows = array();
            $result = $this->query($queryString);
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function error($error,$query){
            die("SQL error".$error."<br> with the following query: ".$query);
        }
        public function escape($string){
            return mysqli_real_escape_string($this->connection, $string);
        }
    }
?>
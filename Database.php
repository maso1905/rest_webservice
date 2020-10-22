<?php

class Database{
  
    // specify your own database credentials
    private $host = "studentmysql.miun.se";
    private $db_name = "maso1905";
    private $username = "maso1905";
    private $password = "pm5j5kbc";
    public $conn;
  
    // get the database connection
    public function connect(){
  
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $this->conn;
    }

    // Close database connection
    public function close() {
        $this->conn = null;
    }
}

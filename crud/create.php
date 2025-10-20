<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "manajemen_gerbang_itk";
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        $this->connection = mysqli_connect(
            $this->host, 
            $this->username,
            $this->password, 
            $this->database
        );
        
        if (!$this->connection) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($this->connection, "utf8");
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
?>
<?php
class Database {
    private $host = 'mysql-taleen.alwaysdata.net';
    private $db_name = 'taleen_test_1';
    private $username = 'taleen';
    private $password = '2dKW@2akHnQ@W4m';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

<?php

class Database {

    private $host = "localhost";
    private $db_name = "newman_db";
    private $username = "root";
    private $password = "root";
    public $conn;


    public function getConnexion() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $e) {
            echo "Connexion error :".$e->getMessage();
        }

        return $this->conn ;
    }

}

?>
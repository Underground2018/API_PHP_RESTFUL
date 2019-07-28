<?php

class Database {

    private $host = "host_name";
    private $db_name = "db_name";
    private $username = "user_name";
    private $password = "password";
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
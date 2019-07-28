<?php

class Candidat {
   
private $conn;
private $table_name = "candidat";
//private $table_name1 = "entreprise";


public $id_cnt;
public $nom;
public $prenom;
public $email;
public $password;
public $photo;
public $cv_cnt;
public $lettre_cnt;
public $adresse;
public $tel;
public $link;
public $fcb;
public $twt;
public $state;


public function __construct($db) {
    $this->conn = $db;
}


function create() {
 
    $query = "INSERT INTO ". $this->table_name . "
              SET
                 nom  = :nom,
                 prenom = :prenom,
                 telephone = :tel,
                 email_cnt = :email,
                 adresse = :adresse,
                 password = :password,
                 state_cnt  = :state
                  ";
   
        $stmt = $this->conn->prepare($query);
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->prenom=htmlspecialchars(strip_tags($this->prenom));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->adresse=htmlspecialchars(strip_tags($this->adresse));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->password=htmlspecialchars(strip_tags($this->password));



        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':tel', $this->tel);
        $stmt->bindParam(':state', $this->state);

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        if($stmt->execute()){
            return true;
        }
        return false;
}


function editProfil() {

   
    $query = "UPDATE " . $this->table_name . "
            SET
                photo = :photo,
                nom = :nom,
                prenom = :prenom,
                email_cnt = :email,
                adresse = :adresse,
                telephone = :tel,
                link = :link,
                fcb = :fcb,
                twt = :twt
            WHERE id_cnt = :id_cnt";
 
    
    $stmt = $this->conn->prepare($query);
 
    $this->photo=htmlspecialchars(strip_tags($this->photo));
    $this->adresse=htmlspecialchars(strip_tags($this->adresse));
    $this->nom=htmlspecialchars(strip_tags($this->nom));
    $this->prenom=htmlspecialchars(strip_tags($this->prenom));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->tel=htmlspecialchars(strip_tags($this->tel));
    $this->fcb=htmlspecialchars(strip_tags($this->fcb));
    $this->twt=htmlspecialchars(strip_tags($this->twt));
    $this->link=htmlspecialchars(strip_tags($this->link));

    $stmt->bindParam(':photo', $this->photo);
    $stmt->bindParam(':adresse', $this->adresse);
    $stmt->bindParam(':nom', $this->nom);
    $stmt->bindParam(':prenom', $this->prenom);
    $stmt->bindParam(':fcb', $this->fcb);
    $stmt->bindParam(':twt', $this->twt);
    $stmt->bindParam(':link', $this->link);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':tel', $this->tel);
    $stmt->bindParam(':id_cnt', $this->id_cnt);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


function emailCheck() {

    $query = "SELECT id_cnt,nom,prenom,telephone,email_cnt,adresse,password,state_cnt FROM ".$this->table_name."
              WHERE email_cnt = ?
              LIMIT 0,1 ";

    $stmt = $this->conn->prepare($query);
    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(1,$this->email);
    $stmt->execute();
    $num = $stmt->rowCount();
    
    if($num > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id_cnt = $row['id_cnt'];
        $this->nom = $row['nom'];
        $this->prenom = $row['prenom'];
        $this->tel = $row['telephone'];
        $this->email = $row['email_cnt'];
        $this->adresse = $row['adresse'];
        $this->password = $row['password'];
        $this->state = $row['state_cnt'];

        return true;
    }
    return false;
}


function GetProfile() {

    $query = "SELECT * FROM ".$this->table_name."
    WHERE id_cnt = ?
    LIMIT 0,1 ";

$stmt = $this->conn->prepare($query);
$this->id_cnt = htmlspecialchars(strip_tags($this->id_cnt));
$stmt->bindParam(1,$this->id_cnt);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0) {

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$this->id_cnt = $row['id_cnt'];
$this->nom = $row['nom'];
$this->prenom = $row['prenom'];
$this->adresse = $row['adresse'];
$this->tel = $row['telephone'];
$this->email = $row['email_cnt'];
$this->fcb = $row['fcb'];
$this->twt = $row['twt'];
$this->link = $row['link'];
$this->photo = $row['photo'];
$this->state = $row['state_cnt'];

   return true;
 }
   return false;

}





















}
?>
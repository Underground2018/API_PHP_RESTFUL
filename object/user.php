<?php


class User {
 
    
private $conn;
private $table_name = "users";
private $table_name1 = "entreprise";


public $id;
public $username;
public $role;
public $email;
public $password;
public $id_ent;
public $sec_act;
public $state;
public $nom;
public $prenom;
public $fonction;
public $tel;




public function __construct($db) {
    $this->conn = $db;
}


function create() {
 
    $query = "INSERT INTO ". $this->table_name . "
              SET
                 nom  = :nom,
                 prenom = :prenom,
                 fonction = :fonction,
                 phone = :tel,
                 username = :username,
                 role_user = :role,
                 email_user = :email,
                 mdp = :password,
                 etat  = :state,
                 id_ent  = :id_ent ";
   
        $stmt = $this->conn->prepare($query);
        $this->id_ent=htmlspecialchars(strip_tags($this->id_ent));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->fonction=htmlspecialchars(strip_tags($this->fonction));
        $this->prenom=htmlspecialchars(strip_tags($this->prenom));
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':fonction', $this->fonction);
        $stmt->bindParam(':tel', $this->tel);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':id_ent', $this->id_ent);

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        if($stmt->execute()){
            return true;
        }
        return false;
}

function emailproCheck() {

    $query = "SELECT id,username,role,mdp,state,nom,prenom,fonction,tel,name_comp FROM ".$this->table_name.",".$this->table_name1." WHERE ".$this->table_name.".id_ent LIKE ".$this->table_name1.".id AND ".$this->table_name.".email = ?  LIMIT 0,1 ";

    $stmt = $this->conn->prepare($query);
    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(1,$this->email);
    $stmt->execute();
    $num = $stmt->rowCount();
    
    if($num > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->nom = $row['nom'];
        $this->prenom = $row['prenom'];
        $this->fonction = $row['fonction'];
        $this->tel = $row['tel'];
        $this->role = $row['role'];
        $this->password = $row['mdp'];
        $this->name_comp = $row['name_comp'];
        $this->state = $row['state'];
        $this->id_ent = $row['id_ent'];

        return true;
    }
    return false;
}

function Cheched() {

    $query = "SELECT id_user,username,name_comp,mdp,nom,fonction,etat,prenom,phone,role_user,email_user,id_ent FROM ".$this->table_name.",".$this->table_name1." WHERE ".$this->table_name.".id_ent LIKE ".$this->table_name1.".id AND ".$this->table_name.".email_user = ? LIMIT 0,1 ";

    $stmt = $this->conn->prepare($query);
    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(1,$this->email);
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->username = $row['username'];
        $this->name_comp = $row['name_comp'];
        $this->password = $row['mdp'];
        $this->nom    = $row['nom'];
        $this->fonction    = $row['fonction'];
        $this->state    = $row['etat'];
        $this->prenom    = $row['prenom'];
        $this->email    = $row['email_user'];
        $this->tel   = $row['phone'];
        $this->role   = $row['role_user'];
        $this->id   = $row['id_user'];
        $this->id_ent = $row['id_ent'];

        return true;
    }

    return false;
}


public function update(){
 
   
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
   
    $query = "UPDATE " . $this->table_name . "
            SET
                username = :username,
                email = :email
                {$password_set}
            WHERE id = :id";
 
    
    $stmt = $this->conn->prepare($query);
 
   
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->email=htmlspecialchars(strip_tags($this->email));

    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':email', $this->email);

    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
    $stmt->bindParam(':id', $this->id);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}










}

?>
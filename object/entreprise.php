<?php


class Entreprise
{

private $conn;
private $table_name = "entreprise";
private $table_name1 = "jobs";


public $id;
public $logo;
public $pays;
public $tel;
public $taille;
public $website;
public $about;
public $video;
public $linkd;
public $role;
public $fcb;
public $twt;
public $inst;
public $email;
public $password;
public $name_comp;
public $sec_act;
public $state;

//Poster un emploie 

public $id_job;
public $titre;
public $sec;
public $lieu;
public $type_contrat;
public $exp;
public $salaire;
public $mobilite;
public $niv_etude;
public $date_exp;
public $des_emp;
public $resp;
public $diplome;
public $certif;
public $domaine;
public $nationalite;
public $posted;
public $ID_ent;



public function __construct($db) {
    $this->conn = $db;
}


function createEnt() {

    $query = "INSERT INTO ". $this->table_name . "
              SET
                 name_comp = :name_comp,
                 sec_act = :sec_act,
                 pays = :pays,
                 tel = :tel,
                 role = :role,
                 email = :email,
                 password = :password,
                 state = :state ";
   
        $stmt = $this->conn->prepare($query);

        $this->name_comp=htmlspecialchars(strip_tags($this->name_comp));
        $this->sec_act=htmlspecialchars(strip_tags($this->sec_act));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->pays=htmlspecialchars(strip_tags($this->pays));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->state=htmlspecialchars(strip_tags($this->state));


        $stmt->bindParam(':name_comp', $this->name_comp);
        $stmt->bindParam(':sec_act', $this->sec_act);
        $stmt->bindParam(':pays', $this->pays);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':tel', $this->tel);
        $stmt->bindParam(':email', $this->email);

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':state', $this->state);

        if($stmt->execute()){
            return true;
        }
        return false;
}


function editProfil() {

    $password_set=!empty($this->password) ? ", password = :password" : "";

   
    $query = "UPDATE " . $this->table_name . "
            SET
                logo = :logo,
                adresse = :adresse,
                taille = :taille,
                website = :website,
                about = :about,
                linkd = :linkd,
                fcb = :fcb,
                twt = :twt,
                inst = :inst
                {$password_set}
            WHERE id = :id";
 
    
    $stmt = $this->conn->prepare($query);
 
    $this->logo=htmlspecialchars(strip_tags($this->logo));
    $this->adresse=htmlspecialchars(strip_tags($this->adresse));
    $this->taille=htmlspecialchars(strip_tags($this->taille));
    $this->website=htmlspecialchars(strip_tags($this->website));
    $this->about=htmlspecialchars(strip_tags($this->about));
    $this->linkd=htmlspecialchars(strip_tags($this->linkd));
    $this->fcb=htmlspecialchars(strip_tags($this->fcb));
    $this->twt=htmlspecialchars(strip_tags($this->twt));
    $this->inst=htmlspecialchars(strip_tags($this->inst));

    $stmt->bindParam(':logo', $this->logo);
    $stmt->bindParam(':adresse', $this->adresse);
    $stmt->bindParam(':taille', $this->taille);
    $stmt->bindParam(':website', $this->website);
    $stmt->bindParam(':about', $this->about);
    $stmt->bindParam(':linkd', $this->linkd);
    $stmt->bindParam(':fcb', $this->fcb);
    $stmt->bindParam(':twt', $this->twt);
    $stmt->bindParam(':inst', $this->inst);

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

function emailCheck() {

    $query = "SELECT id, name_comp,sec_act,email,pays,tel,state,role,password,state FROM ".$this->table_name."
              WHERE email = ?
              LIMIT 0,1 ";

    $stmt = $this->conn->prepare($query);
    $this->email = htmlspecialchars(strip_tags($this->email));
    $stmt->bindParam(1,$this->email);
    $stmt->execute();
    $num = $stmt->rowCount();
    
    if($num > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->pays = $row['pays'];
        $this->name_comp = $row['name_comp'];
        $this->tel = $row['tel'];
        $this->role = $row['role'];
        $this->sec_act = $row['sec_act'];
        $this->password = $row['password'];
        $this->state = $row['state'];

        return true;
    }
    return false;
}


function GetProfile() {

    $query = "SELECT * FROM ".$this->table_name."
    WHERE id = ?
    LIMIT 0,1 ";

$stmt = $this->conn->prepare($query);
$this->id = htmlspecialchars(strip_tags($this->id));
$stmt->bindParam(1,$this->id);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0) {

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$this->id = $row['id'];
$this->pays = $row['pays'];
$this->name_comp = $row['name_comp'];
$this->taille = $row['taille'];
$this->tel = $row['tel'];
$this->email = $row['email'];
$this->adresse = $row['adresse'];
$this->logo = $row['logo'];
$this->website = $row['website'];
$this->logo = $row['logo'];
$this->about = $row['about'];
$this->fcb = $row['fcb'];
$this->twt = $row['twt'];
$this->inst = $row['inst'];
$this->linkd = $row['linkd'];
$this->role = $row['role'];
$this->sec_act = $row['sec_act'];
$this->state = $row['state'];

    return true;
 }
 return false;

}


function verify() {

    $query = "SELECT id FROM ".$this->table_name."
              WHERE name_comp = ?
              LIMIT 0,1 ";

    $stmt = $this->conn->prepare($query);
    $this->name_comp = htmlspecialchars(strip_tags($this->name_comp));
    $stmt->bindParam(1,$this->name_comp);
    $stmt->execute();
    $num = $stmt->rowCount();
    
    if($num > 0) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
       
        return $this->id;
    }
    return false;
}



function PostJob() {

    $query = "INSERT INTO ". $this->table_name1 . "
    SET
       titre = :titre,
       sec = :sec,
       lieu = :lieu,
       type_contrat = :type_contrat,
       experience = :exp,
       salaire = :salaire,
       mobilite = :mobilite,
       niv_etude = :niv_etude,
       date_exp = :date_exp,
       des_emp   = :des_emp,
       resp   = :resp,
       diplome  = :diplome,
       certif = :certif,
       posted   = :posted,
       domaine = :domaine,
       nationalite   = :nationalite,
       wait  = :wait, 
       ID_ent = :ID_ent ";


       $stmt = $this->conn->prepare($query);

       $this->titre=htmlspecialchars(strip_tags($this->titre));
       $this->sec=htmlspecialchars(strip_tags($this->sec));
       $this->lieu=htmlspecialchars(strip_tags($this->lieu));
       $this->type_contrat=htmlspecialchars(strip_tags($this->type_contrat));
       $this->exp=htmlspecialchars(strip_tags($this->exp));
       $this->salaire=htmlspecialchars(strip_tags($this->salaire));
       $this->mobilite=htmlspecialchars(strip_tags($this->mobilite));
       $this->niv_etude=htmlspecialchars(strip_tags($this->niv_etude));
       $this->date_exp=htmlspecialchars(strip_tags($this->date_exp));
       $this->des_emp=htmlspecialchars(strip_tags($this->des_emp));
       $this->resp=htmlspecialchars(strip_tags($this->resp));
       $this->diplome=htmlspecialchars(strip_tags($this->diplome));
       $this->certif=htmlspecialchars(strip_tags($this->certif));
       $this->posted=htmlspecialchars(strip_tags($this->posted));
       $this->domaine=htmlspecialchars(strip_tags($this->domaine));
       $this->nationalite=htmlspecialchars(strip_tags($this->nationalite));
       $this->wait=htmlspecialchars(strip_tags($this->wait));
       $this->ID_ent=htmlspecialchars(strip_tags($this->ID_ent));


       $stmt->bindParam(':titre', $this->titre);
       $stmt->bindParam(':sec', $this->sec);
       $stmt->bindParam(':lieu', $this->lieu);
       $stmt->bindParam(':type_contrat', $this->type_contrat);
       $stmt->bindParam(':exp', $this->exp);
       $stmt->bindParam(':salaire', $this->salaire);
       $stmt->bindParam(':mobilite', $this->mobilite);
       $stmt->bindParam(':niv_etude', $this->niv_etude);
       $stmt->bindParam(':des_emp', $this->des_emp);
       $stmt->bindParam(':date_exp', $this->date_exp);
       $stmt->bindParam(':diplome', $this->diplome);
       $stmt->bindParam(':resp', $this->resp);
       $stmt->bindParam(':certif', $this->certif);
       $stmt->bindParam(':posted', $this->posted);
       $stmt->bindParam(':domaine', $this->domaine);
       $stmt->bindParam(':nationalite', $this->nationalite);
       $stmt->bindParam(':wait', $this->wait);
       $stmt->bindParam(':ID_ent', $this->ID_ent);

       if($stmt->execute()){
        return true;
    }
    return false;
}


function GetEnt() {


    $query = "SELECT * FROM  ".$this->table_name."  ";


    $stmt = $this->conn->prepare($query);
    $stmt->execute();

        return $stmt;

}



function AccountActivated() {
   
    $query = "UPDATE " . $this->table_name . "
            SET state = :state  WHERE id = :id";

            
    $stmt = $this->conn->prepare($query);

    $this->state=htmlspecialchars(strip_tags($this->state));
    $this->id=htmlspecialchars(strip_tags($this->id)); 

    $stmt->bindParam(':state', $this->state);
    $stmt->bindParam(':id', $this->id);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


function Delete() {


    $query = " DELETE FROM ".$this->table_name." WHERE id = ? ";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1,$this->id);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


    
}






?>
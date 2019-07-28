<?php


class Jobs  {


    private $conn;
    private $table_name = "jobs";
    private $table_name1 = "entreprise";


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
    public $domaine;
    public $nationalite;
    public $certif;
    public $posted;
    public $wait;
    public $ID_ent;


    //Entreprise

public $email;
public $pays;
public $name_comp;
public $sec_act;
public $tel;



     
 
   public function __construct($db) {
      $this->conn = $db;
    }


    function GetAll() {

        $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1." WHERE ".$this->table_name.".ID_ent = ".$this->table_name1.".id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

    }


    function GetJobs() {

        $query = "SELECT * FROM ".$this->table_name." WHERE ID_ent = ?";

        $stmt = $this->conn->prepare($query);
        $this->ID_ent = htmlspecialchars(strip_tags($this->ID_ent));
        $stmt->bindParam(1,$this->ID_ent);
        $stmt->execute();

        return $stmt;
    }

    function GetID() {

        $query = "SELECT * FROM ".$this->table_name." WHERE titre = ?";

        $stmt = $this->conn->prepare($query);
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $stmt->bindParam(1,$this->titre);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_job = $row['id_job'];
        }
        return $this->id_job;       
    }



    function GetJobsByID() {


       $query = "SELECT * FROM ".$this->table_name." WHERE id_job = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
            $this->id_job= htmlspecialchars(strip_tags($this->id_job));
            $stmt->bindParam(1,$this->id_job);
            $stmt->execute();
            $num = $stmt->rowCount();

            if($num > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_job = $row['id_job'];
            $this->titre = $row['titre'];
            $this->sec = $row['sec'];
            $this->lieu = $row['lieu'];
            $this->type_contrat = $row['type_contrat'];
            $this->exp = $row['experience'];
            $this->salaire = $row['salaire'];
            $this->mobilite = $row['mobilite'];
            $this->niv_etude = $row['niv_etude'];
            $this->date_exp = $row['date_exp'];
            $this->des_emp = $row['des_emp'];
            $this->resp = $row['resp'];
            $this->diplome = $row['diplome'];
            $this->certif = $row['certif'];
            $this->domaine = $row['domaine'];
            $this->nationalite = $row['nationalite'];
            $this->posted = $row['posted'];
            $this->wait = $row['wait'];
            $this->ID_ent = $row['ID_ent'];

                return true;
            }
            return false;
    }


    function Posted()  {


   $query = "UPDATE " . $this->table_name . "
        SET posted = :posted  WHERE id_job = :id_job";

        
        $stmt = $this->conn->prepare($query);

        $this->posted=htmlspecialchars(strip_tags($this->posted));
        $this->id_job=htmlspecialchars(strip_tags($this->id_job)); 

        $stmt->bindParam(':posted', $this->posted);
        $stmt->bindParam(':id_job', $this->id_job);
        if($stmt->execute()){
            return true;
        }

        return false;
    }



    function Delete() {


        $query = " DELETE FROM ".$this->table_name." WHERE id_job = ? ";
    
        $stmt = $this->conn->prepare($query);
    
        $this->id_job = htmlspecialchars(strip_tags($this->id_job));
        $stmt->bindParam(1,$this->id_job);
        if($stmt->execute()){
            return true;
        }
        return false;
    }



function MakeDraft() {

    $query = "UPDATE " . $this->table_name . "
    SET wait = :wait  WHERE id_job = :id_job";

    $stmt = $this->conn->prepare($query);
    $this->wait=htmlspecialchars(strip_tags($this->wait));
    $this->id_job=htmlspecialchars(strip_tags($this->id_job)); 

    $stmt->bindParam(':wait', $this->wait);
    $stmt->bindParam(':id_job', $this->id_job);
    if($stmt->execute()){
        return true;
    }
    return false;
}



function UpdateJob() {

 
    $query = "UPDATE " . $this->table_name . "
            SET
                titre        = :titre,
                sec          = :sec,
                lieu         = :lieu,
                type_contrat = :type_contrat,
                salaire      = :salaire,
                mobilite     = :mobilite,
                date_exp     = :date_exp,
                niv_etude    = :niv_etude,
                diplome      = :diplome,
                certif       = :certif,
                experience   = :exp,
                des_emp      = :des_emp,
                domaine      = :domaine,
                nationalite  = :nationalite,
                resp         = :resp
    
            WHERE id_job = :id_job";
 
    
    $stmt = $this->conn->prepare($query);
 
   
    $this->titre=htmlspecialchars(strip_tags($this->titre));
    $this->sec=htmlspecialchars(strip_tags($this->sec));
    $this->lieu=htmlspecialchars(strip_tags($this->lieu));
    $this->type_contrat=htmlspecialchars(strip_tags($this->type_contrat));
    $this->salaire=htmlspecialchars(strip_tags($this->salaire));
    $this->mobilite=htmlspecialchars(strip_tags($this->mobilite));
    $this->date_exp=htmlspecialchars(strip_tags($this->date_exp));
    $this->niv_etude=htmlspecialchars(strip_tags($this->niv_etude));
    $this->certif=htmlspecialchars(strip_tags($this->certif));
    $this->diplome=htmlspecialchars(strip_tags($this->diplome));
    $this->exp=htmlspecialchars(strip_tags($this->exp));
    $this->des_emp=htmlspecialchars(strip_tags($this->des_emp));
    $this->domaine=htmlspecialchars(strip_tags($this->domaine));
    $this->nationalite=htmlspecialchars(strip_tags($this->nationalite));
    $this->resp=htmlspecialchars(strip_tags($this->resp));



    $stmt->bindParam(':titre', $this->titre);
    $stmt->bindParam(':sec', $this->sec);
    $stmt->bindParam(':lieu', $this->lieu);
    $stmt->bindParam(':type_contrat', $this->type_contrat);
    $stmt->bindParam(':salaire', $this->salaire);
    $stmt->bindParam(':mobilite', $this->mobilite);
    $stmt->bindParam(':date_exp', $this->date_exp);
    $stmt->bindParam(':niv_etude', $this->niv_etude);
    $stmt->bindParam(':certif', $this->certif);
    $stmt->bindParam(':exp', $this->exp);
    $stmt->bindParam(':diplome', $this->diplome);
    $stmt->bindParam(':resp', $this->resp);
    $stmt->bindParam(':domaine', $this->diplome);
    $stmt->bindParam(':nationalite', $this->nationalite);
    $stmt->bindParam(':des_emp', $this->des_emp);



    $stmt->bindParam(':id_job', $this->id_job);
    if($stmt->execute()){
        return true;
    }
      return false;
   }
}



?>
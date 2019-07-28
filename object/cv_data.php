<?php

class CVDATA {

    private $conn;
    private $table_name = "cv_data";
    private $table_name1 = "candidat";

    public $id_cv;
    public $titre_cv;
    public $niv_etude;
    public $last_p;
    public $last_c;
    public $exp_g;
    public $domaine;
    public $genre;
    public $date_naiss;
    public $nationalite;
    public $pays_res;
    public $fact_mot;
    public $disponibilite;
    public $mobilite;
    public $salaire_cv;
    public $ID_cnt;
    public $cv_file;
    public $cover_file;
    public $posted;
    public $activated;


    //Candidat

  public $email;
  public $nom;
  public $prenom;
  public $tel;



    public function __construct($db) {
        $this->conn = $db;
      }


      function PostCV() {

        $query = "INSERT INTO ". $this->table_name . "
        SET
           titre_cv = :titre_cv,
           niv_etude = :niv_etude,
           last_p = :last_p,
           last_c = :last_c,
           exp_g = :exp_g,
           domaine = :domaine,
           genre = :genre,
           date_naiss = :date_naiss,
           nationalite = :nationalite,
           pays_res = :pays_res,
           fact_mot   = :fact_mot,
           disponibilite   = :disponibilite,
           mobilite  = :mobilite,
           salaire_cv = :salaire_cv,
           cv_file    = :cv_file,
           cover_file = :cover_file,
           activated  = :activated,
           posted  = :posted,
           ID_cnt = :ID_cnt ";
    
    
           $stmt = $this->conn->prepare($query);
    
           $this->titre_cv=htmlspecialchars(strip_tags($this->titre_cv));
           $this->niv_etude=htmlspecialchars(strip_tags($this->niv_etude));
           $this->last_p=htmlspecialchars(strip_tags($this->last_p));
           $this->last_c=htmlspecialchars(strip_tags($this->last_c));
           $this->exp_g=htmlspecialchars(strip_tags($this->exp_g));
           $this->domaine=htmlspecialchars(strip_tags($this->domaine));
           $this->genre=htmlspecialchars(strip_tags($this->genre));
           $this->date_naiss=htmlspecialchars(strip_tags($this->date_naiss));
           $this->nationalite=htmlspecialchars(strip_tags($this->nationalite));
           $this->pays_res=htmlspecialchars(strip_tags($this->pays_res));
           $this->fact_mot=htmlspecialchars(strip_tags($this->fact_mot));
           $this->disponibilite=htmlspecialchars(strip_tags($this->disponibilite));
           $this->mobilite=htmlspecialchars(strip_tags($this->mobilite));
           $this->salaire_cv=htmlspecialchars(strip_tags($this->salaire_cv));
           $this->cv_file=htmlspecialchars(strip_tags($this->cv_file));
           $this->cover_file=htmlspecialchars(strip_tags($this->cover_file));
           $this->posted=htmlspecialchars(strip_tags($this->posted));
           $this->activated=htmlspecialchars(strip_tags($this->activated));
           $this->ID_cnt=htmlspecialchars(strip_tags($this->ID_cnt));
       
    
    
           $stmt->bindParam(':titre_cv', $this->titre_cv);
           $stmt->bindParam(':niv_etude', $this->niv_etude);
           $stmt->bindParam(':last_p', $this->last_p);
           $stmt->bindParam(':last_c', $this->last_c);
           $stmt->bindParam(':exp_g', $this->exp_g);
           $stmt->bindParam(':domaine', $this->domaine);
           $stmt->bindParam(':genre', $this->genre);
           $stmt->bindParam(':date_naiss', $this->date_naiss);
           $stmt->bindParam(':nationalite', $this->nationalite);
           $stmt->bindParam(':pays_res', $this->pays_res);
           $stmt->bindParam(':fact_mot', $this->fact_mot);
           $stmt->bindParam(':disponibilite', $this->disponibilite);
           $stmt->bindParam(':mobilite', $this->mobilite);
           $stmt->bindParam(':salaire_cv', $this->salaire_cv);
           $stmt->bindParam(':cv_file', $this->cv_file);
           $stmt->bindParam(':cover_file', $this->cover_file);
           $stmt->bindParam(':activated', $this->activated);
           $stmt->bindParam(':posted', $this->posted);
           $stmt->bindParam(':ID_cnt', $this->ID_cnt);
   
    
           if($stmt->execute()){
            return true;
        }
        return false;
    } 
    
    function GetAll() {

        $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1." WHERE ".$this->table_name.".ID_cnt = ".$this->table_name1.".id_cnt";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function GetCV() {

        $query = "SELECT * FROM ".$this->table_name." WHERE ID_cnt = ?";

        $stmt = $this->conn->prepare($query);
        $this->ID_cnt = htmlspecialchars(strip_tags($this->ID_cnt));
        $stmt->bindParam(1,$this->ID_cnt);
        $stmt->execute();

        return $stmt;
    }

    function GetCVByID() {


        $query = "SELECT * FROM ".$this->table_name." WHERE id_cv = ? LIMIT 0,1";
 
             $stmt = $this->conn->prepare($query);
             $this->id_cv= htmlspecialchars(strip_tags($this->id_cv));
             $stmt->bindParam(1,$this->id_cv);
             $stmt->execute();
             $num = $stmt->rowCount();
 
             if($num > 0) {
 
             $row = $stmt->fetch(PDO::FETCH_ASSOC);
             $this->id_cv = $row['id_cv'];
             $this->titre_cv = $row['titre_cv'];
             $this->niv_etude = $row['niv_etude'];
             $this->last_p = $row['last_p'];
             $this->last_c = $row['last_c'];
             $this->exp_g = $row['exp_g'];
             $this->domaine = $row['domaine'];
             $this->genre = $row['genre'];
             $this->date_naiss = $row['date_naiss'];
             $this->nationalite = $row['nationalite'];
             $this->pays_res = $row['pays_res'];
             $this->fact_mot = $row['fact_mot'];
             $this->disponibilite = $row['disponibilite'];
             $this->mobilite = $row['mobilite'];
             $this->salaire_cv = $row['salaire_cv'];
             $this->cv_file    = $row['cv_file'];
             $this->cover_file = $row['cover_file'];  
             $this->ID_cnt = $row['ID_cnt'];
             $this->posted = $row['posted'];
             $this->activated = $row['activated'];
 
                 return true;
             }
             return false;
     }


     function DeleteCV() {


        $query = " DELETE FROM ".$this->table_name." WHERE id_cv = ? ";
    
        $stmt = $this->conn->prepare($query);
    
        $this->id_cv = htmlspecialchars(strip_tags($this->id_cv));
        $stmt->bindParam(1,$this->id_cv);
        if($stmt->execute()){
            return true;
        }
        return false;
    }


    function UpdateCV() {

 
    $query = "UPDATE " . $this->table_name . "
            SET
                titre_cv = :titre_cv,
                niv_etude = :niv_etude,
                last_p = :last_p,
                last_c = :last_c,
                exp_g = :exp_g,
                domaine = :domaine,
                genre = :genre,
                date_naiss = :date_naiss,
                nationalite = :nationalite,
                pays_res = :pays_res,
                fact_mot  = :fact_mot,
                disponibilite  = :disponibilite,
                mobilite  = :mobilite,
                salaire_cv = :salaire_cv,
                cv_file    = :cv_file,
                cover_file  = :cover_file
    
                   WHERE id_cv = :id_cv";
 
    
    $stmt = $this->conn->prepare($query);
 
   
    $this->titre_cv=htmlspecialchars(strip_tags($this->titre_cv));
    $this->niv_etude=htmlspecialchars(strip_tags($this->niv_etude));
    $this->last_p=htmlspecialchars(strip_tags($this->last_p));
    $this->last_c=htmlspecialchars(strip_tags($this->last_c));
    $this->exp_g=htmlspecialchars(strip_tags($this->exp_g));
    $this->domaine=htmlspecialchars(strip_tags($this->domaine));
    $this->genre=htmlspecialchars(strip_tags($this->genre));
    $this->date_naiss=htmlspecialchars(strip_tags($this->date_naiss));
    $this->nationalite=htmlspecialchars(strip_tags($this->nationalite));
    $this->pays_res=htmlspecialchars(strip_tags($this->pays_res));
    $this->fact_mot=htmlspecialchars(strip_tags($this->fact_mot));
    $this->disponibilite=htmlspecialchars(strip_tags($this->disponibilite));
    $this->mobilite=htmlspecialchars(strip_tags($this->mobilite));
    $this->cv_file=htmlspecialchars(strip_tags($this->cv_file));
    $this->cover_file=htmlspecialchars(strip_tags($this->cover_file));    
    $this->salaire_cv=htmlspecialchars(strip_tags($this->salaire_cv));
    $this->id_cv=htmlspecialchars(strip_tags($this->id_cv));

   
    $stmt->bindParam(':titre_cv', $this->titre_cv);
    $stmt->bindParam(':niv_etude', $this->niv_etude);
    $stmt->bindParam(':last_p', $this->last_p);
    $stmt->bindParam(':last_c', $this->last_c);
    $stmt->bindParam(':exp_g', $this->exp_g);
    $stmt->bindParam(':domaine', $this->domaine);
    $stmt->bindParam(':genre', $this->genre);
    $stmt->bindParam(':date_naiss', $this->date_naiss);
    $stmt->bindParam(':nationalite', $this->nationalite);
    $stmt->bindParam(':pays_res', $this->pays_res);
    $stmt->bindParam(':fact_mot', $this->fact_mot);
    $stmt->bindParam(':disponibilite', $this->disponibilite);
    $stmt->bindParam(':mobilite', $this->mobilite);
    $stmt->bindParam(':cv_file', $this->cv_file);
    $stmt->bindParam(':cover_file', $this->cover_file);
    $stmt->bindParam(':salaire_cv', $this->salaire_cv);


    $stmt->bindParam(':id_cv', $this->id_cv);
    if($stmt->execute()){
        return true;
    }
      return false;
  }
  
 function  ChangeStatut() {
    
       $query = "UPDATE ".$this->table_name."
       
       SET posted = :posted 
       WHERE id_cv = :id_cv";
   
    $stmt = $this->conn->prepare($query);
   
    $this->posted=htmlspecialchars(strip_tags($this->posted));
    $this->id_cv=htmlspecialchars(strip_tags($this->id_cv));
   
    $stmt->bindParam(':posted', $this->posted);
    $stmt->bindParam(':id_cv', $this->id_cv);
   
       if($stmt->execute()){
        return true;
    }
      return false;
  }



}

?>
<?php

class Candidated {

    private $conn;
    private $table_name  = "candidature";
    private $table_name1 = "jobs";
    private $table_name2 = "cv_data";
    private $table_name3 = "candidat";
    private $table_name4 = "entreprise";

    public $id_ct;
    public $ct_job;
    public $ct_cnt;
    public $ct_lib;
    public $ct_note;
    public $ct_cat;
    public $status;
    public $ID_cnt;
    public $ID_job;



    public function __construct($db) {
        $this->conn = $db;
      }



 function MakeCT() {


    $query = "INSERT INTO ". $this->table_name. "
    SET
       ct_job    = :ct_job,
       ct_cnt    = :ct_cnt,
       ct_lib    = :ct_lib,
       ct_note   = :ct_note,
       ct_cat    = :ct_cat,
       status    = :status ";

       $stmt = $this->conn->prepare($query);

       $this->ct_job=htmlspecialchars(strip_tags($this->ct_job));
       $this->ct_cnt=htmlspecialchars(strip_tags($this->ct_cnt));
       $this->ct_lib=htmlspecialchars(strip_tags($this->ct_lib));
       $this->ct_note=htmlspecialchars(strip_tags($this->ct_note));
       $this->ct_cat=htmlspecialchars(strip_tags($this->ct_cat));
       $this->status=htmlspecialchars(strip_tags($this->status));

       $stmt->bindParam(':ct_job', $this->ct_job);
       $stmt->bindParam(':ct_cnt', $this->ct_cnt);
       $stmt->bindParam(':ct_lib', $this->ct_lib);
       $stmt->bindParam(':ct_note',$this->ct_note);
       $stmt->bindParam(':ct_cat', $this->ct_cat);
       $stmt->bindParam(':status', $this->status);

       if($stmt->execute()){
        return true;
    }
    return false;

 }

 function GetAll() {

    $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1.",".$this->table_name2.",".$this->table_name3.",".$this->table_name4." WHERE ".$this->table_name.".ct_job = ".$this->table_name1.".id_job AND ".$this->table_name.".ct_cnt = ".$this->table_name2.".id_cv AND ".$this->table_name1.".ID_ent = ".$this->table_name4.".id AND ".$this->table_name2.".ID_cnt = ".$this->table_name3.".id_cnt";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;

}

 function GetCTByID() {

    $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1.",".$this->table_name2.",".$this->table_name3.",".$this->table_name4." WHERE ".$this->table_name.".ct_job = ".$this->table_name1.".id_job AND ".$this->table_name.".ct_cnt = ".$this->table_name2.".id_cv AND ".$this->table_name1.".ID_ent = ".$this->table_name4.".id AND ".$this->table_name2.".ID_cnt = ".$this->table_name3.".id_cnt AND ".$this->table_name.".ct_cnt = :ct_cnt";
    
    $stmt = $this->conn->prepare($query);
    $this->ct_cnt = htmlspecialchars(strip_tags($this->ct_cnt));
    $stmt->bindParam(':ct_cnt',$this->ct_cnt);
    $stmt->execute();

    return $stmt;
}

function GetCTByJob() {

    $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1.",".$this->table_name2.",".$this->table_name3.",".$this->table_name4." WHERE ".$this->table_name.".ct_job = ".$this->table_name1.".id_job AND ".$this->table_name.".ct_cnt = ".$this->table_name2.".id_cv AND ".$this->table_name1.".ID_ent = ".$this->table_name4.".id AND ".$this->table_name2.".ID_cnt = ".$this->table_name3.".id_cnt AND ".$this->table_name.".ct_job = :ct_job";
    
    $stmt = $this->conn->prepare($query);
    $this->ct_job = htmlspecialchars(strip_tags($this->ct_job));
    $stmt->bindParam(':ct_job',$this->ct_job);
    $stmt->execute();

    return $stmt;
}


function GetCTByJob() {

    $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1.",".$this->table_name2.",".$this->table_name3.",".$this->table_name4." WHERE ".$this->table_name.".ct_job = ".$this->table_name1.".id_job AND ".$this->table_name.".ct_cnt = ".$this->table_name2.".id_cv AND ".$this->table_name1.".ID_ent = ".$this->table_name4.".id AND ".$this->table_name2.".ID_cnt = ".$this->table_name3.".id_cnt AND ".$this->table_name.".ct_job = :ct_job";
    
    $stmt = $this->conn->prepare($query);
    $this->ct_job = htmlspecialchars(strip_tags($this->ct_job));
    $stmt->bindParam(':ct_job',$this->ct_job);
    $stmt->execute();

    return $stmt;
}

function GetCTByCAND() {

    $query = "SELECT * FROM ".$this->table_name.",".$this->table_name1.",".$this->table_name2.",".$this->table_name3.",".$this->table_name4." WHERE ".$this->table_name.".ct_job = ".$this->table_name1.".id_job AND ".$this->table_name.".ct_cnt = ".$this->table_name2.".id_cv AND ".$this->table_name1.".ID_ent = ".$this->table_name4.".id AND ".$this->table_name2.".ID_cnt = ".$this->table_name3.".id_cnt AND ".$this->table_name3.".id_cnt = :ID_cnt";
    
    $stmt = $this->conn->prepare($query);
    $this->ID_cnt = htmlspecialchars(strip_tags($this->ID_cnt));
    $stmt->bindParam(':ID_cnt',$this->ID_cnt);
    $stmt->execute();

    return $stmt;
}


function ChangeStatus() {


   $query = "UPDATE " . $this->table_name . "
   SET status = :status  WHERE ct_job = :ct_job AND ct_cnt = :ct_cnt ";

   
   $stmt = $this->conn->prepare($query);

   $this->status=htmlspecialchars(strip_tags($this->status));
   $this->ct_job=htmlspecialchars(strip_tags($this->ct_job)); 
   $this->ct_cnt=htmlspecialchars(strip_tags($this->ct_cnt)); 

   $stmt->bindParam(':status', $this->status);
   $stmt->bindParam(':ct_job', $this->ct_job);
   $stmt->bindParam(':ct_cnt', $this->ct_cnt);
   if($stmt->execute()){
       return true;
   }

   return false;
}




}
?>
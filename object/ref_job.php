<?php


class RefJob {

    private $conn;
    private $table_name = "reference_job";
    private $table_name1 = "jobs";

    public $ref;
    public $cat;
    public $lib;
    public $note;
    public $ID_job;



    public function __construct($db) {
        $this->conn = $db;
      }


  function CreateRef() {

    $query = "INSERT INTO ". $this->table_name. "
    SET
       cat    = :cat,
       lib    = :lib,
       note   = :note,
       ID_job = :ID_job ";

       $stmt = $this->conn->prepare($query);

       $this->cat=htmlspecialchars(strip_tags($this->cat));
       $this->lib=htmlspecialchars(strip_tags($this->lib));
       $this->note=htmlspecialchars(strip_tags($this->note));
       $this->ID_job=htmlspecialchars(strip_tags($this->ID_job));

       $stmt->bindParam(':cat', $this->cat);
       $stmt->bindParam(':lib', $this->lib);
       $stmt->bindParam(':note', $this->note);
       $stmt->bindParam(':ID_job', $this->ID_job);

       if($stmt->execute()){
        return true;
    }
    return false;
  }
  
  function UpdateRef() {


   $query = "UPDATE " .$this->table_name."
   SET
                cat = :cat,
                lib = :lib,
                note = :note

            WHERE ref = :ref";

   $stmt = $this->conn->prepare($query);
   $this->ref=htmlspecialchars(strip_tags($this->ref));

   $stmt->bindParam(':cat', $this->cat);
   $stmt->bindParam(':lib', $this->lib);
   $stmt->bindParam(':note', $this->note);
   $stmt->bindParam(':ref', $this->ref);

   if($stmt->execute()){
       return true;
   }
   return false;
  }

  function  GetRef() {

    $query = "SELECT * FROM ".$this->table_name." WHERE ID_job = ? ";

    $stmt = $this->conn->prepare($query);
    $this->ID_job= htmlspecialchars(strip_tags($this->ID_job));
    $stmt->bindParam(1,$this->ID_job);
    $stmt->execute();

    return $stmt;
  }






}
?>
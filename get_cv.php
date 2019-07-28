<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once 'config/database.php';
include_once 'object/cv_data.php';

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$cnt  = new CVDATA($db);



if(!$data->id_cnt && !$data->id) {

    $stmt = $cnt->GetAll();
    $num = $stmt->rowCount();
    
    if($num>0){
     
    
        $output=array();
        $getAll=array();
     
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
            extract($row);
     
            $output = array(
            
                "id"             => $row['id_cv'],
                "titre"          => $row['titre_cv'],
                "niveau"         => $row['niv_etude'],
                "last_p"         => $row['last_p'],
                "last_c"         => $row['last_c'],
                "exp_g"          => $row['exp_g'],
                "domaine"        => $row['domaine'],
                "genre"          => $row['genre'],
                "date_naiss"     => $row['date_naiss'],
                "nationalite"    => $row['nationalite'],
                "pays_res"       => $row['pays_res'],
                "fact_mot"       => $row['fact_mot'],
                "disponibilite"  => $row['disponibilite'],
                "mobilite"       => $row['mobilite'],
                "posted"         => $row['posted'],
                "activated"      => $row['activated'],
                "salaire_cv"     => $row['salaire_cv'],
                "data"      =>  array(  
                    "nom" => $row['nom'],
                    "prenom"   => $row['prenom'],
                    "email"     => $row['email_cnt'],
                    "tel"      =>  $row['telephone'] 
                )
             );
       
     
            array_push($getAll, $output);
        }
     
      
        http_response_code(200);
     
    
        echo json_encode($getAll);
    }
    
}

if($data->id_cnt) {

      $cnt->ID_cnt = $data->id_cnt;
  
    $stmt = $cnt->GetCV();
    $num = $stmt->rowCount();
  
  if($num>0){
     
      $output = array();
      $getAll = array();
   
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
          extract($row);
   
          $output = array(
  
              "id"             => $row['id_cv'],
              "titre"          => $row['titre_cv'],
              "niv"            => $row['niv_etude'],
              "last_p"         => $row['last_p'],
              "last_c"         => $row['last_c'],
              "exp_g"          => $row['exp_g'],
              "domaine"        => $row['domaine'],
              "genre"          => $row['genre'],
              "date_naiss"     => $row['date_naiss'],
              "nationalite"    => $row['nationalite'],
              "pays_res"       => $row['pays_res'],
              "fact_mot"       => $row['fact_mot'],
              "disponibilite"  => $row['disponibilite'],
              "mobilite"       => $row['mobilite'],
              "activated"      => $row['activated'],
              "posted"         => $row['posted'],
              "salaire"        => $row['salaire_cv']  
          );
          array_push($getAll, $output);
      }
      http_response_code(200);
      echo json_encode($getAll);
    }
  }

  if($data->id) {

    $cnt->id_cv = $data->id;
  
   if($cnt->GetCVByID()) {
  
        $output = array(
          
           "id"              => $cnt->id_cv,
           "titre"           => $cnt->titre_cv,
           "niv_etude"       => $cnt->niv_etude,
           "last_p"          => $cnt->last_p,
           "last_c"          => $cnt->last_c,
           "exp_g"           => $cnt->exp_g,
           "domaine"         => $cnt->domaine,
           "genre"           => $cnt->genre,
           "date_naiss"      => $cnt->date_naiss,
           "nationalite"     => $cnt->nationalite,
           "pays_res"        => $cnt->pays_res,
           "fact_mot"        => $cnt->fact_mot,
           "disponibilite"   => $cnt->disponibilite,
           "mobilite"        => $cnt->mobilite,
           "posted"          => $cnt->posted,
           "activated"       => $cnt->activated, 
           "salaire"         => $cnt->salaire_cv, 
           "ID_cnt"          => $cnt->ID_cnt    
        );
  
    http_response_code(200);
  
    echo json_encode($output);
    }
  
   } 




?>
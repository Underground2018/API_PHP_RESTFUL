<?php 

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");




include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/cv_data.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$cnt  = new CVDATA($db);



    if($data->methode == 'suppression') {
      
        $cnt->id_cv = $data->id;
      
      if($cnt->DeleteCV()) {
        
        http_response_code(200);
        echo json_encode(array(
        "message" => "CV delete"
        ));
        
      } else {
        http_response_code(400);
        echo json_encode(array(
            "message" => "Unable to delete CV"
        ));
      }
      
    }
    
    if($data->methode == 'update') {
      
        $cnt->id_cv = $data->id;
      
            $cnt->titre_cv      = $data->titre;
            $cnt->niv_etude     = $data->niv_etude;
            $cnt->last_p        = $data->last_p;
            $cnt->last_c        = $data->last_c;
            $cnt->exp_g         = $data->exp_g;
            $cnt->domaine       = $data->domaine;
            $cnt->genre         = $data->genre;
            $cnt->date_naiss    = $data->date_naiss;
            $cnt->nationalite   = $data->nationalite;
            $cnt->pays_res      = $data->pays_res;
            $cnt->fact_mot      = $data->fact_mot;
            $cnt->disponibilite = $data->disponibilite;
            $cnt->mobilite      = $data->mobilite;
            $cnt->cv_file       = $data->cv_file;
            $cnt->cover_file    = $data->cover_file;
            $cnt->salaire_cv    = $data->salaire_cv;
           
             if($cnt->UpdateCV()) {
               
              http_response_code(200);
              echo json_encode(array(
                "message" => "CV was updated"
              ));
               
             } else {
               http_response_code(400);
               echo json_encode(array(
              "message" => "Unable to update CV"
             ));
             }
    }
    
    if($data->methode == 'change') {
      
       $cnt->id_cv = $data->id;
       $cnt->posted = $data->posted;
      
       if($cnt->ChangeStatut()) {
           
               http_response_code(200);
              echo json_encode(array(
                "message" => "state was changed"
              ));
         
       } else {
                   http_response_code(400);
               echo json_encode(array(
                "message" => "Unable to change state"
              ));
       }
      
      
    }
    


?>
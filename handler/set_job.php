<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");




include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/jobs.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$cnt  = new Jobs($db);



    if($data->methode == 'suppression') {
      
        $cnt->id_job = $data->id;
      
      if($cnt->Delete()) {
        
        http_response_code(200);
        echo json_encode(array(
        "message" => "Job deleted"
        ));
        
      } else {
        http_response_code(400);
        echo json_encode(array(
            "message" => "Unable to delete Job"
        ));
      }
      
    }
    
    if($data->methode == 'update') {
      
        $cnt->id_job = $data->id;
      
        $cnt->titre  = $data->titre;
        $cnt->sec    = $data->sec;
        $cnt->lieu   = $data->lieu;
        $cnt->type_contrat = $data->type_contrat;
        $cnt->exp       = $data->exp;
        $cnt->salaire   = $data->salaire;
        $cnt->mobilite  = $data->mobilite;
        $cnt->niv_etude = $data->niv_etude;
        $cnt->date_exp  = $data->date_exp;
        $cnt->des_emp   = $data->des_emp;
        $cnt->resp      = $data->resp;
        $cnt->diplome   = $data->diplome;
        $cnt->certif    = $data->certif;
        $cnt->posted    = $data->posted;
        $cnt->wait      = $data->wait;
        $cnt->domaine   = $data->domaine;
        $cnt->nationalite = $data->nationalite;
        
           
             if($cnt->UpdateJob()) {
               
              http_response_code(200);
              echo json_encode(array(
                "message" => "Job updated"
              ));
               
             } else {
               http_response_code(400);
               echo json_encode(array(
              "message" => "Unable to update Job"
             ));
             }
    }
    
    if($data->methode == 'change') {
      
       $cnt->id_job = $data->id;
       $cnt->posted = $data->posted;
      
       if($cnt->Posted()) {
           
               http_response_code(200);
              echo json_encode(array(
                "message" => "state changed"
              ));
         
       } else {
                   http_response_code(400);
               echo json_encode(array(
                "message" => "Unable to change state"
              ));
       }
    }


    if($cnt->methode == 'draft') {

        $cnt->id_job = $data->id;
        $cnt->wait = $data->wait;

        if($cnt->MakeDraft()) {
           
            http_response_code(200);
           echo json_encode(array(
             "message" => " draft changed"
           ));
      
    } else {
                http_response_code(400);
            echo json_encode(array(
             "message" => "Unable to change draft"
           ));
    }
}
    


?>
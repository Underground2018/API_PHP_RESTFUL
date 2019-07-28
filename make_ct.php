<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/make_cand.php';
include_once 'object/candidat.php';
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnexion();
$make = new Candidated($db);
$cnt  = new Candidat($db);


$data = json_decode(file_get_contents("php://input"));


// Entreprise

  if($data->accept == "cand") {

    $make->ct_job  = $data->id_job;
    $make->ct_cnt  = $data->id_cv;
    $make->status  = $data->status;

    $jwt = isset($data->jwt) ? $data->jwt : "";

    if($jwt) {
    
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $cnt->nom = $decoded->data->nom;
            $cnt->prenom = $decoded->data->prenom;
            $cnt->email = $decoded->data->email;
            $cnt->tel = $decoded->data->tel;
            $cnt->adresse = $decoded->data->adresse;
            $cnt->state = $decoded->data->state;
            $cnt->id_cnt = $decoded->data->id;
     
      
        $make->ct_cat  = $data->cat;
        $make->ct_lib  = $data->lib;
        $make->ct_note = $data->note;
      
        $make->MakeCT();

 
           
    
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $cnt->id_cnt,
            "nom" =>  $cnt->nom,
            "prenom" =>  $cnt->prenom,
            "adresse" =>  $cnt->adresse,
            "tel" =>  $cnt->tel,
            "state" =>  $cnt->state,
            "email" => $cnt->email
        )
     );
     $jwt = JWT::encode($token, $key);
    
     http_response_code(200);
     echo json_encode(
             array(
                 "message" => "Candidat was updated.",
                 "jwt" => $jwt
             )
         );    
        }catch (Exception $e){
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
        }
    }
    else{
        echo json_encode(array("message" => "Access denied."));
    }
}

?>
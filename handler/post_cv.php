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
        $cnt->posted        = $data->posted;
        $cnt->salaire_cv    = $data->salaire_cv;
        $cnt->activated     = $data->activated;
  
$jwt = isset($data->jwt) ? $data->jwt : "";
  
if($jwt) {
  
 try {

   $decoded = JWT::decode($jwt, $key, array('HS256'));
   $cnt->ID_cnt = $decoded->data->id;
   $cnt->email = $decoded->data->email;
   $cnt->nom = $decoded->data->nom;
   $cnt->prenom = $decoded->data->prenom;
   $cnt->adresse = $decoded->data->adresse;
   $cnt->tel = $decoded->data->tel;
   $cnt->state = $decoded->data->state;


if($cnt->PostCV()) {

   $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
        "id" => $cnt->ID_cnt,
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
                "message" => "CV was updated.",
                "jwt" => $jwt
            )
        );
}
   else{
       http_response_code(400);
       echo json_encode(array("message" => "Unable to post a cv."));
   }

   }catch(Exception $e) {
       http_response_code(401);
       echo json_encode(array(
           "message" => "Access denied.",
           "error" => $e->getMessage()
       ));
   }

}else{
   http_response_code(401);
   echo json_encode(array("message" => "Access denied."));
  }



?>
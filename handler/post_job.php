<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once 'object/entreprise.php';
include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/user.php';
include_once 'object/jobs.php';
include_once 'object/ref_job.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);
$user = new User($db);
$job = new Jobs($db);
$refs = new RefJob($db);


 $ent->titre  = $data->titre;
 $ent->sec    = $data->sec;
 $ent->lieu   = $data->lieu;
 $ent->type_contrat = $data->type_contrat;
 $ent->exp       = $data->exp;
 $ent->salaire   = $data->salaire;
 $ent->mobilite  = $data->mobilite;
 $ent->niv_etude = $data->niv_etude;
 $ent->date_exp  = $data->date_exp;
 $ent->des_emp   = $data->des_emp;
 $ent->resp      = $data->resp;
 $ent->diplome   = $data->diplome;
 $ent->certif    = $data->certif;
 $ent->posted    = $data->posted;
 $ent->wait      = $data->wait;
 $ent->domaine   = $data->domaine;
 $ent->nationalite = $data->nationalite;
 
 




 $jwt = isset($data->jwt) ? $data->jwt : "";

 if($jwt) {

  try {

    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $user->username = $decoded->data->username;
    $user->role = $decoded->data->role;
    $user->email = $decoded->data->email;
    $user->nom = $decoded->data->nom;
    $user->prenom = $decoded->data->prenom;
    $user->fonction = $decoded->data->fonction;
    $user->tel = $decoded->data->tel;
    $user->email = $decoded->data->email;
    $user->id = $decoded->data->id;


    $ent->name_comp = $decoded->data->name_comp;
    $id_ent = $ent->verify();

    if($id_ent) {
        $ent->ID_ent = $id_ent;
       
 if($ent->PostJob()) {

    $job->titre = $data->titre;
    $refs->ID_job = $job->GetID();


    $refsize = sizeof($data->refdata);

    for($i = 0; $i < $refsize ; $i++) {
      
        $refs->cat = $data->refdata[$i]->cat;
        $refs->lib = $data->refdata[$i]->lib;
        $refs->note = $data->refdata[$i]->note;
      
        $refs->CreateRef();

    }
    
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
                "role" => $user->role,
                "email" => $user->email,
                "nom"   => $user->nom,
                "prenom" => $user->prenom,
                "fonction" => $user->fonction,
                "tel"     =>  $user->tel,
                "email"  =>   $user->email,
                "name_comp" => $decoded->data->name_comp
             )
         );
         $jwt = JWT::encode($token, $key);
        
         http_response_code(200);
         echo json_encode(
                 array(
                     "message" => "Job was updated.",
                     "jwt" => $jwt
                 )
             );
 }
    
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "Unable to post a job."));
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
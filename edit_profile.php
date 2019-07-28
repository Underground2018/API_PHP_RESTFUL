<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/user.php';
include_once 'object/entreprise.php';
include_once 'object/candidat.php';
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnexion();
$user = new User($db);
$ent  = new Entreprise($db);
$cnt  = new Candidat($db);

$data = json_decode(file_get_contents("php://input"));

$user->username = $data->username;
$user->role  = $data->role;
$user->email     = $data->email;
$user->password  = $data->password;
// Entreprise
$ent->password  = $data->password;
$ent->logo  = $data->file;
$ent->taille  = $data->taille;
$ent->website  = $data->website;
$ent->adresse = $data->adresse;
$ent->about  = $data->about;
$ent->linkd  = $data->linkd;
$ent->fcb  = $data->fcb;
$ent->twt  = $data->twt;
$ent->inst  = $data->inst;



if($data->accept == "entr") {

    $jwt = isset($data->jwt) ? $data->jwt : "";

    if($jwt) {
    
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $ent->name_comp = $data->name_comp;
            $ent->sec_act = $data->sec_act;
            $ent->pays = $data->pays;
            $ent->tel = $data->tel;
            $ent->email = $data->email;
            $ent->role = $data->role;
            $ent->state = $data->state;
            $ent->id = $decoded->data->id;
    
            if($ent->editProfil()){
    
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $ent->id,
            "name_comp" =>  $ent->name_comp,
            "sec_act" =>  $ent->sec_act,
            "pays" =>  $ent->pays,
            "role" => $ent->role,
            "tel" =>  $ent->tel,
            "state" =>  $ent->state,
            "email" => $ent->email
        )
     );
     $jwt = JWT::encode($token, $key);
    
     http_response_code(200);
     echo json_encode(
             array(
                 "message" => "Entreprise was updated.",
                 "jwt" => $jwt
             )
         );
            }
            else{
                echo json_encode(array("message" => "Unable to update entreprise."));
            }
    
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


if($data->accept == "cand") {


    $jwt = isset($data->jwt) ? $data->jwt : "";

    if($jwt) {



        $cnt->nom  = $data->nom;
        $cnt->prenom  = $data->prenom;
        $cnt->adresse  = $data->adresse;
        $cnt->tel  = $data->tel;
        $cnt->email  = $data->email; 
        $cnt->photo  = $data->photo;
        $cnt->link  = $data->link;
        $cnt->fcb  = $data->fcb;
        $cnt->twt  = $data->twt;
    
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
         //   $cnt->nom = $decoded->data->nom;
           // $cnt->prenom = $decoded->data->prenom;
        //    $cnt->email = $decoded->data->email;
        //    $cnt->tel = $decoded->data->tel;
        //    $cnt->adresse = $decoded->data->adresse;
       //     $cnt->state = $decoded->data->state;
            $cnt->id_cnt = $decoded->data->id;
    
            if($cnt->editProfil()){
    
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
            }
            else{
                echo json_encode(array("message" => "Unable to update entreprise."));
            }
    
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
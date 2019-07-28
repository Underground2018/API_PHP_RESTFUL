<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/user.php';
include_once 'object/entreprise.php';
include_once 'object/candidat.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;



$database = new Database();
$db = $database->getConnexion();
$user = new User($db);
$ent = new Entreprise($db);
$cnt = new Candidat($db);

$data = json_decode(file_get_contents("php://input"));


if(!$data->accept) {

    $ent->email = $data->email;
    $email_exist = $ent->emailCheck();

    if($email_exist && password_verify($data->password, $ent->password)) {

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
                "tel" =>  $ent->tel,
                "role" => $ent->role,
                "state" =>  $ent->state,
                "email" => $ent->email
            )
         );   
            http_response_code(200);
            $jwt = JWT::encode($token, $key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt
                )
            );
    }else{
        echo json_encode(array("message" => "Login failed."));
    }
}




if($data->accept == "user") {

    $user->email = $data->email;
    $email_exist = $user->Cheched();

    if($email_exist && password_verify($data->password, $user->password)) {

        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
                "name_comp" => $user->name_comp,
                "nom"      =>  $user->nom,
                "fonction"    =>   $user->fonction,
                "state"    =>   $user->state,
                "prenom"    =>   $user->prenom,
                "role"    =>   $user->role,
                "email"    =>   $user->email,
                "tel"    =>    $user->tel,
                "id_ent" => $user->id_ent
              )
            );
    
            http_response_code(200);
            $jwt = JWT::encode($token, $key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt
                )
            );
    } else{
        echo json_encode(array("message" => "Login failed."));
    }
}


if($data->accept == "cand") {

    $cnt->email = $data->email;
    $email_exist = $cnt->emailCheck();

    if($email_exist && password_verify($data->password, $cnt->password)) {

        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "id" => $cnt->id_cnt,
                "nom" => $cnt->nom,
                "prenom" => $cnt->prenom,
                "tel"      =>  $cnt->tel,
                "adresse"    =>   $cnt->adresse,
                "email"    =>   $cnt->email,
                "state"    =>   $cnt->state
              )
            );
    
            http_response_code(200);
            $jwt = JWT::encode($token, $key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt
                )
            );
    } else{
        http_response_code(401);
        echo json_encode(array("message" => "Login failed."));
    }
}


/*


*/



?>
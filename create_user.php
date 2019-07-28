<?php
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/user.php';
include_once 'object/entreprise.php';
include_once 'object/candidat.php';

$database = new Database();
$db = $database->getConnexion();
$user = new User($db);
$ent = new Entreprise($db);
$cnt = new Candidat($db);

$data = json_decode(file_get_contents("php://input"));


// Entreprise
$ent->name_comp = $data->name_comp;
$ent->sec_act   = $data->sec_act;
$ent->state  = $data->state;
$ent->pays = $data->pays;
$ent->tel  = $data->tel;
$ent->role = $data->role;
$ent->password  = $data->password;
$ent->email  = $data->email;


if($data->accept == "entr") {

    if($ent->createEnt()) {
        http_response_code(200);
        echo json_encode(array("message" => "Entreprise was created.")); 
    }else {
        echo json_encode(array("status" => http_response_code(400),"message" => "Unable to create entreprise."));
    }
}

if($data->accept == "cand") {

    $cnt->nom            = $data->nom;
    $cnt->prenom         = $data->prenom;
    $cnt->email          = $data->email;
    $cnt->adresse        = $data->adresse;
    $cnt->tel            = $data->tel;
    $cnt->password       = $data->password;
    $cnt->state          = $data->state;

    if($cnt->create()) {
        http_response_code(200);
        echo json_encode(array("message" => "Candidat was created."));
       
    }else {
        echo json_encode(array("status" => http_response_code(400),"message" => "Unable to create candidat."));
    }

} 

else {
    if($data->accept == "user") {

        $user->username     = $data->username;
        $user->role         = $data->role;
        $user->email        = $data->email;
        $user->password     = $data->password;
        $user->nom          = $data->nom;
        $user->prenom       = $data->prenom;
        $user->fonction     = $data->fonction;
        $user->tel          = $data->tel;
        $user->state        = $data->state;
        $user->id_ent       = $data->id_ent;

        if($user->create()) {
            http_response_code(200);
            echo json_encode(array("message" => "User was created."));
           
        }else {
            echo json_encode(array("status" => http_response_code(400),"message" => "Unable to create user."));
        }
    }
    else {
        echo json_encode(array("status" => http_response_code(400),"message" => "Request not good"));
    }
}
?>

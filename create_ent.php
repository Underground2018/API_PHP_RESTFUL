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

$database = new Database();
$db = $database->getConnexion();
//$user = new User($db);
$ent = new Entreprise($db);
//$cnt = new Candidat($db);

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




?>

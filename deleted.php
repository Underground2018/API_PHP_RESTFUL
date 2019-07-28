<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/entreprise.php';
include_once 'object/jobs.php';

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);
$job = new Jobs($db);

$data = json_decode(file_get_contents("php://input"));


if($data->id) {

    $ent->id = $data->id;

    if($ent->Delete()) {
        http_response_code(200);
   
        echo json_encode(
          array(
              "message" => "Account was deleted"
          )
        );
    }else {
       echo json_encode(
           array(
               "message" => "Account not been deleted"
           )
         );
    }
}



 if($data->id_job) {

    $job->id_job = $data->id_job;

    if($job->Delete()) {
        http_response_code(200);
   
        echo json_encode(
          array(
              "message" => "Job was deleted"
          )
        );
    }else {
       echo json_encode(
           array(
               "message" => "Job not been deleted"
           )
         );
    }
 }


?>
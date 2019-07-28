<?php
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/entreprise.php';
include_once 'object/jobs.php';

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);
$job = new Jobs($db);

$data = json_decode(file_get_contents("php://input"));


($data->state) {

    $ent->state = $data->state;
    $ent->id = $data->id;

 if($ent->AccountActivated()) {
     http_response_code(200);

     echo json_encode(
       array(
           "message" => "Account set up"
       )
     );
 }else {
    echo json_encode(
        array(
            "message" => "Account not set up"
        )
      );
 }

}

 if($data->posted) {

    $job->posted = $data->posted;
    $job->id_ent = $data->id_ent;

    if($job->Posted()) {
        http_response_code(200);
   
        echo json_encode(
          array(
              "message" => "Job was posted"
          )
        );
    }else {
       echo json_encode(
           array(
               "message" => "Job not been posted"
           )
         );
   
    }

 }


?>
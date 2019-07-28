<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/ref_job.php';


$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$ref  = new RefJob($db);


 if($data->id) {

    $ref->ID_job = $data->id;

    $refdata = array();
    $datas = array();

    $stmt = $ref->GetRef();
    $num = $stmt->rowCount();

     if($num > 0) {

   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       
             extract($row);

             $datas = array(
                 "cat" => $row['cat'],
                 "lib" => $row['lib']
             );

        array_push($refdata, $datas); 
   }
}

http_response_code(200);
echo json_encode(array($refdata));

}




?>
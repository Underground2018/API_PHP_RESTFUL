<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once 'config/database.php';
include_once 'object/entreprise.php';


//$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);

$stmt = $ent->GetEnt();
$num = $stmt->rowCount();

if($num>0){
 

    $output=array();
    $getAll=array();
 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $output=array(
            "id" => $row['id'],
            "name_comp" => $row['name_comp'],
            "sec_act"   => $row['sec_act'],
            "pays"      => $row['pays'],
            "adresse"   => $row['adresse'],
            "taille"    => $row['taille'],
            "tel"       => $row['tel'],
            "email"     =>  $row['email'],
            "logo"      =>  $row['logo'],
            "website"   =>  $row['website'],
            "about"     =>  $row['about'],
            "fcb"       =>   $row['fcb'],
            "twt"       =>   $row['twt'],
            "inst"      =>   $row['inst'],
            "linkd"     =>    $row['linkd'],
            "role"      =>    $row['role'],
            "state"     =>    $row['state'] 
        );
 
        array_push($getAll, $output);
    }
 
  
    http_response_code(200);
 

    echo json_encode($getAll);
}


?>
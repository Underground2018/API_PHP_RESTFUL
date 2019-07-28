<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once 'object/entreprise.php';
include_once 'config/database.php';
include_once 'config/core.php';
include_once 'object/candidat.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);
$cnt = new Candidat($db);

$data = json_decode(file_get_contents("php://input"));


if(!$data->accept) {

    if($data->id) {
        $getAll = array();
        $ent->id = $data->id; 
        if($ent->GetProfile()) {
           $output = array(
               "id" => $ent->id,
               "name_comp" => $ent->name_comp,
               "sec_act"   => $ent->sec_act,
               "pays"      => $ent->pays,
               "adresse"   => $ent->adresse,
               "taille"    => $ent->taille,
               "tel"       => $ent->tel,
               "email"     =>  $ent->email,
               "logo"      =>  $ent->logo,
               "website"   =>  $ent->website,
               "about"     =>  $ent->about,
               "fcb"       =>   $ent->fcb,
               "twt"       =>   $ent->twt,
               "inst"      =>   $ent->inst,
               "linkd"     =>    $ent->linkd,
               "role"      =>    $ent->role,
               "state"     =>    $ent->state        
           );
           array_push($getAll, $output);
           echo json_encode($getAll);  
       } 
    }
}




if($data->accept == "cand") {

    $getAll = array();
    $cnt->id_cnt = $data->id; 

    if($cnt->GetProfile()) {

       $output = array(
           "id"        => $cnt->id_cnt,
           "photo"     => $cnt->photo,
           "nom"       => $cnt->nom,
           "prenom"    => $cnt->prenom,
           "adresse"   => $cnt->adresse,
           "tel"       => $cnt->tel,
           "email"     => $cnt->email,
           "fcb"       => $cnt->fcb,
           "twt"       => $cnt->twt,
           "link"      => $cnt->link,
           "state"     => $cnt->state        
       );
       array_push($getAll, $output);
       echo json_encode($getAll);
       
   } 
}





?>
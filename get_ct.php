<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'object/make_cand.php';
include_once 'object/candidat.php';
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$make = new Candidated($db);
//$cnt  = new Candidat($db);


if(!$data->id_cnt && !$data->id_job ) {

    $stmt = $make->GetAll();
   $num = $stmt->rowCount();


 
    
  if($num>0){
     
    
        $output=array();
        $getAll=array();
     
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
            extract($row);
     
            $output = array(
            
                "id"  => $row['id_ct'],
                "ct_job" => $row['ct_job'],
                "ct_lib"  =>  $row['ct_lib'],
                "ct_note" =>  $row['ct_note'],
                "data_job"      =>  array(
                        
                    "id_job"           => $row['id_job'],
                    "titre"            => $row['titre'],
                    "sec"              =>$row['sec'],
                    "lieu"             => $row['lieu'],
                    "type_contrat"     => $row['type_contrat']
                ),
                "data_cv"      => array(

                    "id_cv"       => $row['id_cv'],
                    "titre_cv"    => $row['titre_cv'],
                    "niv_etude"   => $row['niv_etude'],
                    "last_p"      => $row['last_p'],
                    "last_c"      => $row['last_c'],
                    "exp_g"       => $row['exp_g'],
                    "domaine"     => $row['domaine'],
                    "genre"       => $row['genre']

                ),
                "data_cnt"   => array(
                     "nom"    => $row['nom'],
                     "prenom" => $row['prenom'],
                     "email"  => $row['email_cnt'],
                     "photo"  => $row['photo']
                ),
                "data_ent"  => array(
                     "name_comp" => $row['name_comp'],
                     "logo"      => $row['logo'],
                     "sec_act"   => $row['sec_act'],
                     "pays"      => $row['pays'],
                     "email"     => $row['email'],
                     "tel"       => $row['tel'],
                     "adresse"   => $row['adresse'],
                     "taille"    => $rw['taille']
                )
              );
       
     
            array_push($getAll, $output);
        }
     
      
        http_response_code(200);
     
    
        echo json_encode($getAll);
    } 
    
} 

if($data->id_cnt && !$data->status) {

 $make->ct_cnt = $data->id_cnt;

 $stmt = $make->GetCTByID();
 $num = $stmt->rowCount();

  
if($num>0){
   
  
      $output=array();
      $getAll=array();
   
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
          extract($row);
   
          $output = array(
          
              "id"  => $row['id_ct'],
              "ct_job" => $row['ct_job'],
              "ct_lib"  =>  $row['ct_lib'],
              "ct_note" =>  $row['ct_note'],
              "data_job"      =>  array(
                      
                  "id_job"           => $row['id_job'],
                  "titre"            => $row['titre'],
                  "sec"              =>$row['sec'],
                  "lieu"             => $row['lieu'],
                  "type_contrat"     => $row['type_contrat']
              ),
              "data_cv"      => array(

                  "id_cv"       => $row['id_cv'],
                  "titre_cv"    => $row['titre_cv'],
                  "niv_etude"   => $row['niv_etude'],
                  "last_p"      => $row['last_p'],
                  "last_c"      => $row['last_c'],
                  "exp_g"       => $row['exp_g'],
                  "domaine"     => $row['domaine'],
                  "genre"       => $row['genre']

              ),
              "data_cnt"   => array(
                   "nom"    => $row['nom'],
                   "prenom" => $row['prenom'],
                   "email"  => $row['email_cnt'],
                   "photo"  => $row['photo']
              ),
              "data_ent"  => array(
                   "name_comp" => $row['name_comp'],
                   "logo"      => $row['logo'],
                   "sec_act"   => $row['sec_act'],
                   "pays"      => $row['pays'],
                   "email"     => $row['email'],
                   "tel"       => $row['tel'],
                   "adresse"   => $row['adresse'],
                   "taille"    => $rw['taille']
              )
            );
     
   
          array_push($getAll, $output);
      }
   
    
      http_response_code(200);
   
  
      echo json_encode($getAll);
  } 

}


if($data->id_job  && !$data->status) {

    $make->ct_job = $data->id_job;
   
    $stmt = $make->GetCTByJob();
    $num = $stmt->rowCount();
   
     
   if($num>0){
      
     
         $output=array();
         $getAll=array();
      
     
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     
             extract($row);
      
             $output = array(
             
                 "id"  => $row['id_ct'],
                 "ct_job" => $row['ct_job'],
                 "ct_lib"  =>  $row['ct_lib'],
                 "ct_note" =>  $row['ct_note'],
                 "data_job"      =>  array(
                         
                     "id_job"           => $row['id_job'],
                     "titre"            => $row['titre'],
                     "sec"              =>$row['sec'],
                     "lieu"             => $row['lieu'],
                     "type_contrat"     => $row['type_contrat']
                 ),
                 "data_cv"      => array(
   
                     "id_cv"       => $row['id_cv'],
                     "titre_cv"    => $row['titre_cv'],
                     "niv_etude"   => $row['niv_etude'],
                     "last_p"      => $row['last_p'],
                     "last_c"      => $row['last_c'],
                     "exp_g"       => $row['exp_g'],
                     "domaine"     => $row['domaine'],
                     "genre"       => $row['genre']
   
                 ),
                 "data_cnt"   => array(
                      "nom"    => $row['nom'],
                      "prenom" => $row['prenom'],
                      "email"  => $row['email_cnt'],
                      "photo"  => $row['photo']
                 ),
                 "data_ent"  => array(
                      "name_comp" => $row['name_comp'],
                      "logo"      => $row['logo'],
                      "sec_act"   => $row['sec_act'],
                      "pays"      => $row['pays'],
                      "email"     => $row['email'],
                      "tel"       => $row['tel'],
                      "adresse"   => $row['adresse'],
                      "taille"    => $rw['taille']
                 )
               );
        
      
             array_push($getAll, $output);
         }
      
       
         http_response_code(200);
      
     
         echo json_encode($getAll);
     } 
   
   }
   

   if($data->status) {


      $make->status = $data->status;
      $make->ct_job = $data->id_job;
      $make->ct_cnt = $data->id_cnt;


      if($make->ChangeStatus()) {

         http_response_code(200);
         echo json_encode(array(
             "message" => "CT updated"
         ));
      } else {
         
        http_response_code(400);
        echo json_encode(array(
            "message" => "Unable to update CT"
        ));

      }

}




?>
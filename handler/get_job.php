<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once 'config/database.php';
include_once 'object/entreprise.php';
include_once 'object/jobs.php';
include_once 'object/ref_job.php';
$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnexion();
$ent = new Entreprise($db);
$job = new Jobs($db); 
$refs = new RefJob($db); 


if($data->name_comp) {

  $ent->name_comp = $data->name_comp;
  $id_ent = $ent->verify();

  if($id_ent)  {

    $job->ID_ent = $id_ent;

  $stmt = $job->GetJobs();
  $num = $stmt->rowCount();

if($num>0){
 

    $output = array();
    $getAll = array();
    $refdata = array();
 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

 
        $output = array(

            "id_job"         => $row['id_job'],
            "titre"          => $row['titre'],
            "sec"            => $row['sec'],
            "lieu"           => $row['lieu'],
            "type_contrat"   => $row['type_contrat'],
            "exp"            => $row['experience'],
            "salaire"        => $row['salaire'],
            "mobilite"       => $row['mobilite'],
            "niv_etude"      => $row['niv_etude'],
            "date_exp"       => $row['date_exp'],
            "des_emp"        => $row['des_emp'],
            "resp"           => $row['resp'],
            "diplome"        => $row['diplome'],
            "certif"         => $row['certif'],
            "posted"         => $row['posted'],
            "wait"           => $row['wait'],
        );
 
        array_push($getAll, $output);
    }

    http_response_code(200);
    echo json_encode($getAll);
  }
}

}

 if($data->id) {

    $refdata = array();
    $datas = array();

  $job->id_job = $data->id;
 if($job->GetJobsByID()) {

    $ent->id = $job->ID_ent;

    $ent->GetProfile();


    $refs->ID_job = $job->id_job;

      $result = $refs->GetRef();
      $nbr = $result->rowCount();
   
      if($nbr > 0) {

       while($res = $result->fetch(PDO::FETCH_ASSOC)) {

        extract($res);

          $datas = array(
               "cat"  => $res['cat'],
               "lib"  => $res['lib'],
               "note" => $res['note']
          );

          array_push($refdata, $datas);
       }

      }

      $output = array(
        
         "id"  => $job->id_job,
         "titre" => $job->titre,
         "sec"  =>  $job->sec,
         "lieu" =>  $job->lieu,
         "type_contrat" => $job->type_contrat,
         "exp"   => $job->exp,
         "salaire"  => $job->salaire,
         "mobilite" => $job->mobilite,
         "niv_etude" => $job->niv_etude,
         "date_exp"  => $job->date_exp,
         "des_emp"   => $job->des_emp,
         "resp"      => $job->resp,
         "diplome"   =>  $job->diplome,
         "certif" =>  $job->certif,
         "posted"    =>  $job->posted,
         "wait"      =>  $job->wait,
         "data"      =>  array(
             
             "name_comp" => $ent->name_comp,
             "website"   => $ent->website,
             "email"     => $ent->email,
             "about"     => $ent->about 
         ),
        "refdata"  =>  $refdata
      );

  http_response_code(200);
  echo json_encode($output);
  }

 }  if(!$data->name_comp && !$data->id) {

$stmt = $job->GetAll();
$num = $stmt->rowCount();

if($num>0){
 

    $output=array();
    $getAll=array();
 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $output = array(
        
            "id"  => $row['id_job'],
            "titre" => $row['titre'],
            "sec"  =>  $row['sec'],
            "lieu" =>  $row['lieu'],
            "type_contrat" => $row['type_contrat'],
            "exp"   => $row['experience'],
            "salaire"  => $row['salaire'],
            "mobilite" => $row['mobilite'],
            "niv_etude" => $row['niv_etude'],
            "date_exp"  => $row['date_exp'],
            "des_emp"   => $row['des_emp'],
            "resp"      => $row['resp'],
            "diplome"   =>  $row['diplome'],
            "certif" =>  $row['certif'],
            "posted"    =>  $row['posted'],
            "wait"      =>  $row['wait'],
            "data"      =>  array(
                    
                "name_comp" => $row['name_comp'],
                "sec_act"   => $row['sec_act'],
                "email"     =>$row['email'],
                "pays"      => $row['pays'],
                "logo"     => $row['logo']
            )
         );
   
 
        array_push($getAll, $output);
    }
 
  
    http_response_code(200);
 

    echo json_encode($getAll);
}

} 




?>
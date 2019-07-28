<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$response = array();
$upload_dir = '/Users/Shared/';
//$server_url = 'http://localhost';


if($_FILES['file']) {

    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $error = $_FILES['file']['error'];

    if($error > 0) {
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading the file!"
        );
    } else {

        $random_name = rand(1000,100000)."-".$file_name;
        $upload_name = $upload_dir.strtolower($random_name);
        $upload_name = preg_replace('/\s+/','-',$upload_name);

        in_array()

  
       if(move_uploaded_file($file_tmp_name, $upload_name)) {
       
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "url" => $upload_name,
                "tmp" => $file_tmp_name
            ); 

        } else {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file"
            );
        }
    }

} else {
    $response = array(
        "status" => "failed",
        "message" => " No File was sended!!"
    );
}

echo json_encode($response);

?>
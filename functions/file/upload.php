<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("user_id"));

$now = DateTime::createFromFormat('U.u', microtime(true));
$id = $doc_id . "_" . $now->format('H-i-s');
// $upload_folder = "/igov/wp-admin/pdt_uploads/" . date('Y') . "/" . date('m') . "/" . date('d');
$upload_folder = "/uploads/" . date('Y') . "/" . date('m') . "/" . date('d');
    if (!file_exists($upload_folder)) { mkdir($upload_folder, 0777, true); }

if(isset($_FILES)){
    $file = $_FILES["file"]["tmp_name"];
    $file_name = basename($_FILES["file"]["name"]);
    $file_path = "$upload_folder/$file_name";
    $status = move_uploaded_file($file, $file_path);
    $callBack = isset($_POST["api_call_back"])? $_POST["api_call_back"] : "";
    $api->out( $file_path );
}else {
    $api->out( "No file.." );
}

 ?>
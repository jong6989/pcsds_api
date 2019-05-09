<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("user_id"));

$now = DateTime::createFromFormat('U.u', microtime(true));

$upload_folder = "uploads/staff_uploads/{$api->params->user_id}/" . date('Y') . "_" . date('m') . "_" . date('d');

if (!file_exists($upload_folder)) { mkdir($upload_folder, 0777, true); }

if(isset($_FILES["file"])){
    //upload
    $file = $_FILES["file"]["tmp_name"];
    $fname = basename($_FILES["file"]["name"]);
    $e = explode(".",$fname);
    if(count($e) < 2) $e[] = "txt";
    $file_name = $now->format('H-i-s_') . $api->params->user_id . "." . $e[count($e) - 1];
    $file_path = "$upload_folder/$file_name";
    $status = move_uploaded_file($file, $file_path);
    $api->out( $file_path );
}else {
    $api->out( "",0, "No file.." );
}

 ?>
<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("user_id"));

$now = DateTime::createFromFormat('U.u', microtime(true));
// echo __DIR__;
$upload_folder = "uploads/photos/" . $api->params->user_id . "/" . date('Y') . "-" . date('m') . "-" . date('d');
// echo '<br>';
// echo $upload_folder;
    if (!file_exists($upload_folder)) { mkdir($upload_folder, 0777, true); }

if(isset($_FILES["file"])){
    $bn = basename($_FILES["file"]["name"]);
    if(!is_string($bn)) $api->out( "",0,"No file.." );
    //upload
    $file = $_FILES["file"]["tmp_name"];
    $file_name = $now->format('H-i-s_') .  $bn;
    $file_path = "$upload_folder/$file_name";
    $status = move_uploaded_file($file, $file_path);
    $api->out( $file_path );
}else {
    $api->out( "",0,"No file.." );
}

 ?>
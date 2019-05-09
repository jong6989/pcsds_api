<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("user_id"));

$now = DateTime::createFromFormat('U.u', microtime(true));
// echo __DIR__;
$upload_folder = "uploads/" . date('Y') . "/" . date('m') . "/" . date('d');
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
    //update user
    $user = $api->permitting_accounts->get(array("id"=>$api->params->user_id))[0];
    $user->data->profile_picture = $file_path;
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->user_id));
    $api->out( $user );
}else {
    $api->out( "",0,"No file.." );
}

 ?>
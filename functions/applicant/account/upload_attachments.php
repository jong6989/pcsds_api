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
    //upload
    $file = $_FILES["file"]["tmp_name"];
    $fname = basename($_FILES["file"]["name"]);
    $file_name = $now->format('H-i-s_') . $fname;
    $file_path = "$upload_folder/$file_name";
    $status = move_uploaded_file($file, $file_path);
    //update user
    $user = $api->permitting_accounts->get(array("id"=>$api->params->user_id))[0];
    $user->data->uploads[] = array("name"=>$fname,"url"=>$file_path) ;
    $api->permitting_accounts->update(array("data"=>$user->data),array("id"=>$api->params->user_id));
    $user->user_pass = "";
    $api->out( array("user"=>$user,"url"=>$file_path, "file_name"=>$fname) );
}else {
    $api->out( "No file.." );
}

 ?>
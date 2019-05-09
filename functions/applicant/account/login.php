<?php 

global $api;
if(empty($api)) die();


//check fields
$api->required_fields(array("name","password"));

//check exist
if(!$api->permitting_accounts->exist(array("user_name"=>$api->params->name))) $api->out( $api->params->name,0,"Please Register! Click the REGISTER Button!" );

$user = $api->permitting_accounts->get(array("user_name"=>$api->params->name))[0];
$c_pass = $user->user_pass;

//check password
// $v =  password_verify($api->params->password, $c_pass);// php 7
$v =  validate_password($api->params->password, $c_pass); //php 5
if(!$v) $api->out( $api->params->password,0,"Please check your password!" );

//check if account activated
if($user->status == 0) $api->out( $api->params->name,0,"Account is de-activated! Please contact PCSDS." );

if(!isset($user->num_rows)){
    $res = "";
	$mainView = "app/templates/main.html";
	if($user->user_level == 0){
		$menus = array(
				array("name"=>"Dashboard","url"=>"pages/dashboard","icon"=>"fa-tachometer"),
				array("name"=>"My Profile","url"=>"pages/profile","icon"=>"fa-user"),
			);
		$res = array("main_view"=>$mainView,"page_content"=>"pages/dashboard","user"=>$user,"menus"=>$menus);
	}
	$api->out( $res );
}else {
	$api->out( $api->params->name,0,"Unknown Error..." );
}
	

 ?>
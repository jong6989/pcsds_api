<?php 

global $api;
if(empty($api)) die();


//check fields
$api->required_fields(array("id_number","key"));

//check exist
if(!$api->users->exist(array("id_number"=>$api->params->id_number))) $api->out( $api->params->id_number,0,"User not found!" );

$user = $api->users->get(array("id_number"=>$api->params->id_number))[0];

$c_pass = $user->user_key;
$v =  validate_password($api->params->key, $c_pass); //php 5
if(!$v) $api->out( $api->params->key,0,"Incorrect KEY!" );
$user->user_key = "";
if(!$user->status) $api->out( $api->params->id_number,0,"Account is de-activated! Please Visit your Admin." );

if(!isset($user->num_rows)){
	$res = "";
	$mainView = "app/templates/main.html";


	switch ($user->user_level) {
		case 99:
			$menus = array(
				array("name"=>"Dashboard","url"=>"admin/dashboard","icon"=>"fa-tachometer"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"User Management","url"=>"admin/user_management","icon"=>"fa-users"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"admin/dashboard","user"=>$user,"menus"=>$menus);
			break;

		case 8:
			$menus = array(
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"pages/transactions","user"=>$user,"menus"=>$menus);
			break;

		case 7:
			$menus = array(
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"pages/transactions","user"=>$user,"menus"=>$menus);
			break;

		case 6:
			$menus = array(
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"pages/transactions","user"=>$user,"menus"=>$menus);
			break;

		case 5:
			$menus = array(
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"pages/transactions","user"=>$user,"menus"=>$menus);
			break;

		case 4:
			$menus = array(
				array("name"=>"Transactions","url"=>"pages/transactions","icon"=>"fa-exchange"),
				array("name"=>"Incoming","url"=>"pages/document_management/information","icon"=>"fa-paper-plane"),
			);
			$res = array("main_view"=>$mainView,"page_content"=>"pages/transactions","user"=>$user,"menus"=>$menus);
			break;
		
		default:
			$api->out( $api->params->id_number,0,"Account Type is invalid..." );
			break;
	}

	$api->out( $res );
}else {
	if(count($user) == 0) $api->out( $api->params->key,0,"Incorrect KEY!" );
}
	

 ?>
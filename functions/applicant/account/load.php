<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("offset","last_id","user_id"));

$where = array("id"=>$api->params->user_id);
if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
$user = $api->users->get($where)[0];
if($user->user_level == 0) $api->out( "",0,"Invalid Access" );


$d = $api->permitting_accounts->get(null,null,"ASC","id", 100, $api->params->offset);

if(count($d) > 0){
    if($d[ count($d) - 1 ]->id != $api->params->last_id){
        foreach ($d as $key => $value) {
            $value->user_pass = "";
            $d[$key] = $value;
        }
        $api->out( $d );
    }
}
$api->out("No new Data...",0,"");

 ?>
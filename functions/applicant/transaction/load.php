<?php 

global $api;
if(empty($api)) die();

$api->required_fields(array("offset","last_id","user_id"));

$where = array("id"=>$api->params->user_id);
if(!$api->users->exist($where)) $api->out( "",0,"Invalid User" );
$user = $api->users->get($where)[0];
if($user->user_level == 0) $api->out( "",0,"Invalid Access" );


$d = $api->transactions->get(null,null,"ASC","id", 100, $api->params->offset);

if(count($d) > 0){
    if($d[ count($d) - 1 ]->id != $api->params->last_id){
        foreach ($d as $key => $value) {
            $d[$key]->{"user"} = $api->permitting_accounts->get(array("id"=>$value->user_id ))[0];
        }
        $api->out( $d );
    }
}
$api->out("No new Data...",0,"");

 ?>
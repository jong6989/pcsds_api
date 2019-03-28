<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("offset","last_id","user_id"));

$user = $api->users->search(array("id"=>$api->params->user_id));
if(count($user) == 0) 
	$api->out( $api->params->user_id,0,"User Not Found!" );
$user = $user[0];

$where_a = array(
    "user_level" => "%" . $user->user_level . "%"
);
$where_b = array(
    "user_id" => "%" . $user->id . "%"
);

$a = $api->notification->get($where_a);
$b = $api->notification->get($where_b);

$c = array();

foreach ($a as $key => $value) {
    $c[$value->id] = $value;
}
foreach ($b as $key => $value) {
    if(!isset($c[$value->id]))
        $c[$value->id] = $value;
}

$d = array();
$limit = 0;
$offset = 0;
foreach ($c as $key => $value) {
    if(!empty($value)){
        if($offset == $api->params->offset){
            if($limit !== 10){
                $d[] = $value;
                $limit++;
            }
        }else {
            $offset++;
        }
    }
}

if(count($d) > 0){
    if($d[ count($d) - 1 ]->id != $api->params->last_id){
        $api->out( $d );
    }
}
$api->out("No new Data...",0,"");


 ?>
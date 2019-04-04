<?php 

global $api;
if(empty($api)) die();

//check fields
$api->required_fields(array("data_name","data_item","user_id","type","sheet","item"));


$d = $api->permits->get(array(
        "type"=>$api->params->type,
        "user_id"=>$api->params->user_id
    ));
if( count($d) > 0 ) {
    $d = $d[0];
    if($api->params->sheet > (count($d->data)  + 1) ) $api->params->sheet = null;
    $d->data[$api->params->sheet]->{"name"} = $api->params->data_name;
    $d->data[$api->params->sheet]->{"data"}[] = json_decode( $api->params->data_item );
    $api->permits->update(
        array(
            "data" => $d->data
        ),
        array("id" => $d->id )
    );    
}else {
    $api->permits->create(
    array(
        "data" => array(
            $api->params->sheet => array(
                "name" => $api->params->data_name,
                "data" => array( $api->params->item => json_decode($api->params->data_item) )
            )  ),
        "user_id" => $api->params->user_id,
        "type" => $api->params->type,
        "date" => date("Y-m-d H:i:s")
    ));
}

$api->out( $api->permits->last() );



 ?>
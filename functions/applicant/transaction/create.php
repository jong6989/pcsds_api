<?php 
    global $api;
    
    //require some fields
    $api->required_fields(array("user_id","name","data"));

    //check for duplicate 
    $exist = $api->transactions->exist(array("user_id"=>$api->params->user_id,"data"=>$api->params->data));
    if($exist)
        $api->out($api->params->name,0,"Duplicated Application Request...");

    //set array for creating transaction
    $new = array(
        "user_id"=> $api->params->user_id,
        "name"=> $api->params->name,
        "data" => $api->params->data,
        "date" => date("Y-m-d H:i:s")
    );

    //create data
    $api->transactions->create($new);

    //return
    $api->out( $api->transactions->last() );

?>
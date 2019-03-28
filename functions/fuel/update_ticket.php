<?php
global $api;
if(empty($api)) die();

$api->required_fields(array("trip_ticket_id","data"));
         //table name
    //table name -> JongDb function
$api->fuel_logs->update(
    //update has 2 parameters

    //"data"= field to be updated
    //$api->params->data = "data" from controller(data : new_data.data)
    array( "data" => $api->params->data),

    //WHERE(identify which record to update)
    //$api->params->trip_ticket_id = "trip_ticket_id" from controller(trip_ticket_id : new_data.trip_ticket_id,)
    array( "trip_ticket_id" => $api->params->trip_ticket_id)
);
//toast display 
$api->out("DATA Updated");

?>
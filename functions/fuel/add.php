
<?php
global $api;
if(empty($api)) die();

$api->required_fields(array("trip_ticket_id","data"));
         //table name
if($api->fuel_logs->exist(array("trip_ticket_id"=>$api->params->trip_ticket_id))) $api->out( $api->params->trip_ticket_id,0, "Trip Ticket Already Exists!" );
      //table name
$api->fuel_logs->create(array (
    "trip_ticket_id" => $api->params->trip_ticket_id,
    "data" => $api->params->data,
    "date" => date("Y-m-d H:i:s")

));

$api->out("DATA Added");

?>
<?php 

global $api;
if(empty($api)) die();

$d = $api->wp53_pdt_meta->get(array("name"=>"DOCUMENT_CATEGORY") , "value,hint,id" );

foreach($d as $k => $v){
    $d[$k]->{"documents"} = $api->wp53_pdt_documents->count(array("doc_category"=>$v->value,"doc_deleted"=>"0"));
}

$api->out( $d );

 ?>
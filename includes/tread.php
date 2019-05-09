<?php
    class tread
    {

        public function __construct($api){
            $this->api = $api;
        }

        public function single($item_id,$data,$item_type="transaction"){
            $where_array = array("item_id"=>$item_id,"item_type"=>$item_type);
            $conv = $this->api->conversation->get($where_array);
            if(count($conv) > 0){
                $conv = $conv[0];
                $conv->data[] = $data;
                $this->api->conversation->update(
                    array("data" => $conv->data), array("id"=>$conv->id)
                );
            }else {
                $this->api->conversation->create(array(
                    "item_id" => $item_id,
                    "item_type" => $item_type,
                    "data" => array( $data ),
                    "date" => date("Y-m-d H:i:s")
                ));
            }
            
        }

        public function by_level($user_level_array,$item_type,$item_id,$data){
            $ids = array();
            foreach ($user_level_array as $key => $value) {
                $q = $this->api->users->get(array("user_level"=>$value));
                if(count($q) > 0){
                    foreach ($q as $k => $v) {
                        $ids[] = $v->id;
                    }
                }
            }
            $this->set($ids,$item_type,$item_id,$data);
        }

        public function set($id_array,$item_type,$item_id,$data){
            $user_ids_string = "";
            foreach ($id_array as $k => $v) {
                if($user_ids_string == "") $user_ids_string .= ",";
                $user_ids_string .= $v . ",";
            }
            return $this->api->conversation->create(array(
                "item_id" => $item_id,
                "item_type" => $item_type,
                "user_id" => $user_ids_string,
                "data" => $data,
                "date" => date("Y-m-d H:i:s")
            ));
        }

    }
    
?>
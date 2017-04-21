<?php
class coremodel extends CI_Model {
        function coremodel() {
                parent::__construct();
        }
        
var $arr_bulan = array(1=>"JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI",
  "AGUSTUS","SEPTERMBER","OKTOBER","NOVEMBER","DESEMBER");


        function get_arr_leasing(){
                // get data leasing
                $data['method']='get_data_leasing';
                $url = service_url($data);
                
                $xml = file_get_contents($url);
                $arr = xml_to_array($xml);
                echo "<pre>";
                print_r($arr);
                echo "</pre>";
        }

  var  $arr_status =  array(
            0=>"Pilih Status",
            "Level 2",
            "Menunggu Blokir",
            "Gagal Blokir",
            "Berhasil Blokir");

  var  $arr_status2 =  array(
            0=>"- SEMUA STATUS - ",
            "Level 2",
            "Menunggu Blokir",
            "Gagal Blokir",
            "Berhasil Blokir");

        function arr_dropdown($vTable, $vINDEX, $vVALUE, $vORDERBY){
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
		//echo $this->db->last_query(); exit;

                $ret = array();
                $ret = array('' => '- Pilih Satu -', );
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

        }

        function arr_tahun(){

            $ret = array();
            $ret = array('' => '- Pilih Tahun -', );
                for($i=date('Y'); $i>=date('Y')-32; $i-=1){
                   $ret[$i] = $i; 
               }
               return $ret;

        }

        function arr_type($vTable, $vWHERE, $vorder_by, $vSelect){


        
        $this->db->select($vSelect);
        $this->db->where('id_birojasa', $vWHERE);
        $this->db->group_by($vSelect);
        $this->db->order_by($vorder_by);
        $res  = $this->db->get($vTable);


                $ret = array();
                $ret = array('' => '- Pilih Type -', );
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vSelect]] = $row[$vSelect];
                endforeach;
        
               return $ret;

        }

        function arr_dropdown2($vTable, $vINDEX, $vVALUE, $vORDERBY, $vCONDITION, $vWHERE){
                $this->db->where($vCONDITION, $vWHERE);
                $this->db->where('level', 3);
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
        //echo $this->db->last_query(); exit;

                $ret = array();
                $ret = array('' => '- Pilih Satu -', );
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

        }

        function arr_dropdown4($vTable, $vINDEX, $vVALUE, $vWHERE){
                $this->db->where('id_birojasa', $vWHERE);
                $this->db->order_by($vINDEX);
                $res  = $this->db->get($vTable);
        //echo $this->db->last_query(); exit;

                $ret = array();
                $ret = array('' => '- Pilih Satu -', );
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vINDEX].' - '.$row[$vVALUE];
                endforeach;
                return $ret;

        }

                function arr_dropdown3($vTable, $vINDEX, $vVALUE, $vORDERBY, $vCONDITION, $vWHERE){
                $this->db->where($vCONDITION, $vWHERE);
                $this->db->order_by($vORDERBY);
                $res  = $this->db->get($vTable);
        //echo $this->db->last_query(); exit;

                $ret = array();
                $ret = array('' => '- Pilih Satu -', );
                foreach($res->result_array() as $row) : 
                        $ret[$row[$vINDEX]] = $row[$vVALUE];
                endforeach;
                return $ret;

        }


        

        function arr_level() {
                $arr = array(1=>"Level 1","Level 2","Level 3");
                return $arr;
        }


 



}
?>

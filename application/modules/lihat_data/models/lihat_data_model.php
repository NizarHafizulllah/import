<?php 

class lihat_data_model extends CI_Model {


	function lihat_data_model(){
		parent::__construct();
	}




 function data($param)
	{		

		// show_array($param);
		// exit;

		 extract($param);

		 $kolom = array(0=>"id",
							"no_reg",
							"tgl_masuk", 
							'tgl_ekpirasi'							 
		 	);

				

		 
		

		

		 
		 	
		 if(!empty($tgl_masuk)) {
		 	$this->db->like("tgl_masuk",$tgl_masuk);
		 }
		 if(!empty($tgl_ekspirasi)) {
		 	$this->db->like("tgl_ekspirasi",$tgl_ekspirasi);
		 }
		 if(!empty($asal_upt)) {
		 	$this->db->like("asal_upt",$asal_upt);
		 }

		 if(!empty($nama)) {
		 	$this->db->like("nama",$nama);
		 }

		($param['limit'] != null ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '');
		//$this->db->limit($param['limit']['end'], $param['limit']['start']) ;
       
       ($param['sort_by'] != null) ? $this->db->order_by($kolom[$param['sort_by']], $param['sort_direction']) :'';
        
		$res = $this->db->get('main');
		// echo $this->db->last_query(); exit;
 		return $res;
	}


	


}

?>
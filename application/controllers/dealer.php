<?php 


class dealer extends dealer_controller {
	
	var $controller;
	public function dealer(){
		parent::__construct();
		$this->controller = get_class($this);
	}
	
		function index(){
		



		$data_array=array();
		$content = $this->load->view("dealer/index_view",$data_array,true);
			
		$this->set_subtitle("DASHBOARD");
		$this->set_title("DASHBOARD");
		$this->set_content($content);
		$this->cetak();


				
			
		
	}


}
?>
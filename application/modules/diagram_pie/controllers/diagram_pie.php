<?php 
class diagram_pie extends admin_controller{
	var $controller;
	function diagram_pie(){
		parent::__construct();

		$this->controller = get_class($this);
		$this->load->model($this->controller.'_model','dm');
        $this->load->model("coremodel","cm");
		
		//$this->load->helper("serviceurl");
		
	}









function index(){
		$data_array=array();
        $userdata = $this->session->userdata('admin_login');

        $query  = "SELECT asal_upt, COUNT(no_reg) jumlah FROM main group by asal_upt";
        // $jml    = $this->db->query($query)->result();
        $data_array['jml'] = $this->db->query($query)->result_array();
        // show_array($data_array);
        // exit();
		$content = $this->load->view($this->controller."_view",$data_array,true);

		$this->set_subtitle("Diagram");
		$this->set_title("Diagram");
		$this->set_content($content);
		$this->cetak();


}
























	

}

?>
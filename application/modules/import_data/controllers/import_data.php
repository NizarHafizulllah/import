<?php 
class import_data extends admin_controller{
	var $controller;
	function import_data(){
		parent::__construct();

		$this->controller = get_class($this);
		// $this->load->model('admin_penduduk_model','dm');
        $this->load->model("coremodel","cm");
		
		$this->load->library("session");
		
	}


    function cekNIK(){
        $nik = $this->input->post('nik');
        $valid = true;
        $this->db->where('nik', $nik);
        $jumlah = $this->db->get("penduduk")->num_rows();    
        if($jumlah == 1) {
            $valid = false;
        }
        
        echo json_encode(array('valid' => $valid));
    
    }






function index(){
		$data_array=array();

		$content = $this->load->view($this->controller."_view",$data_array,true);

		$this->set_subtitle("Data");
		$this->set_title("Data");
		$this->set_content($content);
		$this->cetak();
}



function import(){
	$userdata = $this->session->userdata('admin_login');
	$config['upload_path'] = './temp_upload/';
	$this->db->where('id_user', $userdata['id']);
	$this->db->delete('temp_main');
	
	if(!is_uploaded_file($_FILES['xlsfile']['tmp_name'])) {
			$ret = array("error"=>true,'pesan'=>"error");
			echo json_encode($ret);
			redirect(site_url('import_data'));
		}
	else {
		$full_path = $config['upload_path']. date("dmYhis")."_".$_FILES['xlsfile']['name'];
		copy($_FILES['xlsfile']['tmp_name'],$full_path);
		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::load($full_path);
		$arr_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);	

		
		$filename = $_FILES['xlsfile']['name'];
		

		$i=3;


		$hasil = array();

		foreach($arr_data   as  $index =>  $data) : 
			//echo "index $index <br />" ;
			// show_array($data);
		// echo $i.'<br />';
		// echo $data[$i]['A'] . '<br />'; 
		// $i++;
		
		if($index == 1)  continue;

		// $nama_pekerjaan = ;
		// $pekerjaan = ;
		// $id_pekerjaan = $pekerjaan;
		// echo $id_pekerjaan;exit;	

			$hasil = array(
			 
		
		"no_reg" 				=>$data['B'],
		"asal_upt" 					=>$data['C'],
		"nama" 				=>$data['D'],
		"nama_alias" 					=>$data['E'],
		"pasal_kejahatan" 					=>$data['F'],
		"tgl_masuk" 					=>$data['G'],
		"hukuman" 			=>$data['H'],
		"tgl_ekspirasi" 					=>$data['I'],
		"status" 	=>$data['J'],
		"verifikasi" 			=>$data['K'],
		"id_user" => $userdata['id'],
		"jenis_perubahan" => 'T',
		
					);

			$this->db->insert('temp_main', $hasil);
			endforeach;
			// show_array($hasil); exit;

				$xdata = $hasil;
				// $this->session->set_userdata('agu', $xdata);
				// $userdata = $this->session->userdata('agu');
				// show_array($userdata);exit;
				// $_SESSION['xdata'] = $xdata;
				$arrdata['title'] = "IMPORT DATA";
				$this->db->where('id_user', $userdata['id']);
		 		$arrdata['data'] = $this->db->get('temp_main')->result_array();
		 		$arrdata['controller'] = "import_data";
			   	$content = $this->load->view($this->controller."_preview",$arrdata,true);
		}

		// show_array($penduduk);
		// exit();

			$this->set_subtitle("Data Import");
			$this->set_title("Data Import");
			$this->set_content($content);
			$this->cetak();

}


function save(){

		
		$userdata = $this->session->userdata("admin_login");
		// $tes = $this->session->userdata("hello");
		// show_array($hasil_data); exit;

		// session_start();
		// show_array($_POST['data']);exit();
		$post = $this->input->post();
		// $xdata = $datalogin['xdata']; 
		
		$true = 0;
		$false = 0; 

		$arr_berhasil = array();
		$arr_gagal = array();

		if (!empty($post['data'])) {
			foreach($post['data'] as $index) : 
			
			$this->db->where('id', $index);
			$res = $this->db->get('temp_main')->row_array();
			$id = $res['id'];
			unset($res['id_user']);
			unset($res['id']);
			unset($res['jenis_perubahan']);
					
			// echo $res['no_reg'];
			// exit;
			$data_update = array();
			$this->db->where('no_reg', $res['no_reg']);
			$res2 = $this->db->get('main');

			$baris = $res2->num_rows();
			// echo $this->db->last_query();
			// exit();
			if ($baris>=1) {
				$update = $res2->row_array();
				
				// show_array($update);
				// echo "FUCK";
				// exit;
				$this->db->where('id', $update['id']);
				$this->db->update('main', $res);
				$data_update = array('jenis_perubahan' => 'U' );
				$this->db->where('id', $id);
				$this->db->update('temp_main', $data_update);
			}else{
				
				
				$this->db->insert('main', $res);

				$data_update = array('jenis_perubahan' => 'S' );
				$this->db->where('id', $id);
				$this->db->update('temp_main', $data_update);
			}



				
				
			
			
			endforeach;
		}

		

		// exit;
				

				$this->db->where('jenis_perubahan', 'S');
				$this->db->where('id_user', $userdata['id']);
				$simpan = $this->db->get('temp_main')->num_rows();

				$this->db->where('jenis_perubahan', 'U');
				$this->db->where('id_user', $userdata['id']);
				$update = $this->db->get('temp_main')->num_rows();

				$this->db->where('jenis_perubahan', 'T');
				$this->db->where('id_user', $userdata['id']);
				$tidak_dipilih = $this->db->get('temp_main')->num_rows();
		
		 		
		 		$arrdata['simpan'] = $simpan;
		 		$arrdata['update'] = $update;
		 		$arrdata['tidak_dipilih'] = $tidak_dipilih;
		 		$arrdata['arr_berhasil'] = $arr_berhasil;
		 		$arrdata['arr_gagal'] = $arr_gagal;
		 		$arrdata['controller'] = "penduduk_import";
			   	$content = $this->load->view("import_data_result",$arrdata,true);
			   	$now = date('Y-m-d');
				$this->set_subtitle("Hasil Import Data Tanggal ".flipdate($now));
				$this->set_title("Hasil Import Data ");
				$this->set_content($content);
				$this->cetak();
	}



    function coba() {
    	$data1 = array(
    			'1' => '1234',
    			'2' => '1234',
    			'3' => '1234',
    			'4' => '1234',
    		);

    	$data = array(
    			'satu' => $data1,
    			'dua' => 'kambing',
    			'tiga' => 'kambing',
    			'empat' => 'kambing',
    			'df' => $data1,
    			'ssfatsu' => $data1,
    			'safdtu' => $data1,
    			'safdftu' => $data1,
    			'safdfdsertu' => $data1,
    			'satdfdfu' => $data1,

    		);
    	$this->session->set_userdata('coba', $data);


    }

    function tes() {

$tes = $this->session->userdata("hello");
		show_array($tes);
    }

    function tes2() {

    	$this->session->unset_userdata('coba');

    }



}

?>

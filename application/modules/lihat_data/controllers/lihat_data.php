<?php 
class lihat_data extends admin_controller{
	var $controller;
	function lihat_data(){
		parent::__construct();

		$this->controller = get_class($this);
		$this->load->model($this->controller.'_model','dm');
        $this->load->model("coremodel","cm");
		
		//$this->load->helper("serviceurl");
		
	}









function index(){
		$data_array=array();
        $userdata = $this->session->userdata('user_login');

        
		$content = $this->load->view($this->controller."_view",$data_array,true);

		$this->set_subtitle("Data Hasil Import");
		$this->set_title("Data Hasil Import");
		$this->set_content($content);
		$this->cetak();
}


function baru(){
        $data_array=array();

        $data_array['action'] = 'simpan';

        $this->session->set_userdata('jenis', array('action'=>'baru'));

        $content = $this->load->view($this->controller."_form_view",$data_array,true);

        $this->set_subtitle("Tambah Dealer");
        $this->set_title("Tambah Dealer");
        $this->set_content($content);
        $this->cetak();
}




function simpan(){


    $post = $this->input->post();
    
       


        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Dealer','required'); 
        $this->form_validation->set_rules('alamat','Alamat Dealer','required');   
        // $this->form_validation->set_rules('pelaksana_nip','NIP','required');         
         
        $this->form_validation->set_message('required', ' %s Harus diisi ');
        
        $this->form_validation->set_error_delimiters('', '<br>');

     

       

if($this->form_validation->run() == TRUE ) { 

        
        $res = $this->db->insert('dealer', $post); 
        if($res){
            $arr = array("error"=>false,'message'=>"BERHASIL DISIMPAN");
        }
        else {
             $arr = array("error"=>true,'message'=>"GAGAL  DISIMPAN");
        }
}
else {
    $arr = array("error"=>true,'message'=>validation_errors());
}
        echo json_encode($arr);
}




    function get_data() {

    	

        // $this->db->select('nama_file, COUNT(nama_file) as total');
        // $this->db->group_by('nama_file'); 
        // $this->db->order_by('total', 'desc'); 
        // $group = $this->db->get('stck_non_provite')->result_array();
        // // echo $this->db->last_query();
        // foreach ($group as $row) {
        //     echo $row['nama_file'];
        //     echo $row['total'];
        // }
        // exit;
    	// show_array($userdata);

    	$draw = $_REQUEST['draw']; // get the requested page 
    	$start = $_REQUEST['start'];
        $limit = $_REQUEST['length']; // get how many rows we want to have into the grid 
        $sidx = isset($_REQUEST['order'][0]['column'])?$_REQUEST['order'][0]['column']:0; // get index row - i.e. user click to sort 
        $sord = isset($_REQUEST['order'][0]['dir'])?$_REQUEST['order'][0]['dir']:"asc"; // get the direction if(!$sidx) $sidx =1;  
        
        $tgl_masuk = $_REQUEST['columns'][1]['search']['value'];
        $tgl_ekspirasi = $_REQUEST['columns'][2]['search']['value'];
        $asal_upt = $_REQUEST['columns'][3]['search']['value'];
        $nama = $_REQUEST['columns'][4]['search']['value'];

        $userdata = $this->session->userdata('admin_login');



        // show_array($userdata);exit();
      //  order[0][column]
        $req_param = array (
				"sort_by" => $sidx,
				"sort_direction" => $sord,
				"limit" => null,
                "tgl_masuk" => flipdate($tgl_masuk),
                "tgl_ekspirasi" => flipdate($tgl_ekspirasi),
				"asal_upt" => $asal_upt,
                "nama" => $nama,
				
				 
		);     
           
        $row = $this->dm->data($req_param)->result_array();
        // echo $this->db->last_query();exit;
		
        $count = count($row); 
       
        
        $req_param['limit'] = array(
                    'start' => $start,
                    'end' => $limit
        );
          
        
        $result = $this->dm->data($req_param)->result_array();
        

       
        $arr_data = array();
        foreach($result as $row) : 
		// $daft_id = $row['daft_id'];
        $id = $row['id'];
        
        
        	$arr_data[] = array(
                $row['no_reg'],
        		$row['nama'],
                flipdate($row['tgl_masuk']),
                flipdate($row['tgl_ekspirasi']),
                $row['asal_upt'],
                $row['pasal_kejahatan'],
        		
         			 
        		  				);
        endforeach;

         $responce = array('draw' => $draw, // ($start==0)?1:$start,
        				  'recordsTotal' => $count, 
        				  'recordsFiltered' => $count,
        				  'data'=>$arr_data
        	);
         
        echo json_encode($responce); 
    }

    

    function excel(){
       // $data_desa = $this->cm->data_desa();

        $post = $this->input->get();

        $tanggal_awal = $post['tanggal_awal'];
        $tanggal_akhir = $post['tanggal_akhir'];
        $nama_file = $post['nama_file'];
        $id_user = $post['id_user'];

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Data Eksport');

         $arr_kolom = array('a','b','c','d','e','f','g','h','i','j','k','l','m');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   // no     
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);  // no_rangka 
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // no_mesin
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  // tipe 
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // model
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);  // jenis 
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);  // warna 
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);  // silinder 
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // tahunbuat
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15); // tahun rakit
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // merek 
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(40);  // Nama Pemilik
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(50); // alamat pemilik


        

         $baris = 1;

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':m'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "DATA EKSPORT");
        
        $styleArray = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '2F4F4F')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

        $this->excel->getActiveSheet()->getStyle('a'.$baris.':n'.$baris)->applyFromArray($styleArray);
        
       // $this->format_center($arr_kolom,$baris);
 

        $baris++; 

        


        
        if(!empty($tanggal_awal) and !empty($tanggal_akhir) ) {
        $tanggal_awal = flipdate($tanggal_awal);       
        $stamp = strtotime($tanggal_awal);
        $bln = date("m", $stamp);
        $tahun = date("Y", $stamp);
        $tgl = date("d", $stamp);   
        $monthNum  = $bln;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); 
        $new_format_awal = $tgl.' '.$monthName.' '.$tahun;

        $tanggal_akhir = flipdate($tanggal_akhir);       
        $stamp = strtotime($tanggal_akhir);
        $bln = date("m", $stamp);
        $tahun = date("Y", $stamp);
        $tgl = date("d", $stamp);   
        $monthNum  = $bln;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); 
        $new_format_akhir = $tgl.' '.$monthName.' '.$tahun;

            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':m'.$baris);
         $this->excel->getActiveSheet()->setCellValue('A' . $baris, 'Tanggal '.$new_format_awal.' Sampai Dengan Tanggal '.$new_format_akhir );
         $this->excel->getActiveSheet()->getStyle('a'.$baris.':m'.$baris)->applyFromArray($styleArray);    
         }else{
            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':m'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, "Data Kesulurhan Tanggal" );
            $this->excel->getActiveSheet()->getStyle('a'.$baris.':m'.$baris)->applyFromArray($styleArray);
        // $this->format_center($arr_kolom,$baris);

             
         }


        $baris +=2;

        

        
          


          // $this->db->select('p.*')
          // $this->db->where("no_kk",$row->no_kk);
           $this->excel->getActiveSheet()
                ->setCellValue('A' . $baris, "NO.")
                ->setCellValue('B' . $baris, "NOMOR RANGKA")
                ->setCellValue('C' . $baris, "NOMOR MESIN")
                ->setCellValue('D' . $baris, "TIPE")    
                ->setCellValue('E' . $baris, "MODEL")
                ->setCellValue('F' . $baris, "JENIS")
                ->setCellValue('G' . $baris, "WARNA")
                ->setCellValue('H' . $baris, "SILINDER")
                ->setCellValue('I' . $baris, "TAHUN BUAT")
                ->setCellValue('J' . $baris, "TAHUN RAKIT")
                ->setCellValue('K' . $baris, "MERK")
                ->setCellValue('L' . $baris, "NAMA PEMILIK")
                ->setCellValue('M' . $baris, "ALAMAT PEMILIK");   
          // $this->format_header($arr_kolom,$baris);
          $baris++;

           $userdata = $this->session->userdata('dealer_login');
            $this->db->where('id_dealer', $userdata['id_dealer']);
           $this->db->select('*')->from('stck_non_provite p')
           ->order_by('no_rangka')
           ->order_by('nama_file');



        if(!empty($nama_file)) {
            $this->db->like("p.nama_file",$nama_file);
         }

         if(!empty($tanggal_awal) and !empty($tanggal_akhir) ) {
            
            $this->db->where("lastupdate between '$tanggal_awal' and '$tanggal_akhir'",null,false);     
         }

         if(!empty($id_user)) {
            $this->db->like("p.id_user",$id_user);
         }

            $resx = $this->db->get();
            // echo $this->db->last_query(); exit;
            // show_array($resx);exit();
            $xx = 0;
            foreach($resx->result() as  $rowx) : 
              $xx++;


                

                    

                 $this->excel->getActiveSheet()
                ->setCellValue('A' . $baris, $xx)
                ->setCellValue('B' . $baris, ' '.$rowx->no_rangka.'')
                ->setCellValue('C' . $baris, ' '.$rowx->no_mesin.'')
                ->setCellValue('D' . $baris, $rowx->tipe)      
                ->setCellValue('E' . $baris, $rowx->model)
                ->setCellValue('F' . $baris, $rowx->jenis)
                ->setCellValue('G' . $baris, $rowx->warna)
                ->setCellValue('H' . $baris, $rowx->silinder)
                ->setCellValue('I' . $baris, $rowx->thn_buat)
                ->setCellValue('J' . $baris, $rowx->thn_rakit)
                ->setCellValue('K' . $baris, $rowx->merk)
                ->setCellValue('L' . $baris, $rowx->nama_pemilik)
                ->setCellValue('M' . $baris, $rowx->alamat_pemilik);

                // $this->format_baris($arr_kolom,$baris);
                $baris++;
            endforeach;

            


        $filename = "LAPORAN DATA.xls";

        //exit;

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');




}



    function editdata(){
    	 $get = $this->input->get(); 
    	 $id = $get['id'];

    	 $this->db->where('id',$id);
    	 $res = $this->db->get('dealer');
    	 $data = $res->row_array();

         $this->session->set_userdata('jenis', array('action'=>'update', 'id'=>$id));

        $data['arr_dealer'] = $this->cm->arr_dropdown("dealer", "id", "nama", "nama");


        $data['action'] = 'update';
         // show_array($data); exit;
    	 
		

    	// $data_array=array(
    	// 		'id' => $data->id,
    	// 		'nama' => $data->nama,
    	// 		'no_siup' => $data->no_siup,
    	// 		'no_npwp' => $data->no_npwp,
    	// 		'no_tdp' => $data->no_tdp,
    	// 		'telp' => $data->telp,
    	// 		'alamat' => $data->alamat,
    	// 		'email' => $data->email,
    	// 		'hp' => $data->hp,

    	// 	);
		$content = $this->load->view($this->controller."_form_view",$data,true);

         // $content = $this->load->view($this->controller."_form_view",$data,true);

		$this->set_subtitle("Edit Biro Jasa");
		$this->set_title("Edit Biro Jasa");
		$this->set_content($content);
		$this->cetak();

    }







function update(){

    $post = $this->input->post();
   
       


        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama','Nama Dealer','required');    
        $this->form_validation->set_rules('alamat','Alamat Dealer','required');          
         
        $this->form_validation->set_message('required', ' %s Harus diisi ');
        
        $this->form_validation->set_error_delimiters('', '<br>');

     

        //show_array($data);

if($this->form_validation->run() == TRUE ) { 


        $this->db->where("id",$post['id']);
        $res = $this->db->update('dealer', $post); 
        if($res){
            $arr = array("error"=>false,'message'=>"BERHASIL DIUPDATE");
        }
        else {
             $arr = array("error"=>true,'message'=>"GAGAL  DIUPDATE");
        }
}
else {
    $arr = array("error"=>true,'message'=>validation_errors());
}
        echo json_encode($arr);
}



    function hapusdata(){
    	$get = $this->input->post();
    	$id = $get['id'];

    	$data = array('id' => $id, );

    	$res = $this->db->delete('dealer', $data);
        if($res){
            $arr = array("error"=>false,"message"=>"DATA BERHASIL DIHAPUS");
        }
        else {
            $arr = array("error"=>true,"message"=>"DATA GAGAL DIHAPUS ".mysql_error());
        }
    	//redirect('sa_birojasa_user');
        echo json_encode($arr);
    }



	// function simpan(){
	// 	$post = $this->input->post();
	// 	$password = md5($post['password']);
	// 	$data = array('nama' => $post['nama'],
	// 					'email' => $post['email'],
	// 					'alamat' => $post['alamat'],
	// 					'password' => $password,
	// 					'level' => 2);
	// 	$this->db->insert('sa_birojasa_user', $data); 

	// 	redirect('sa_birojasa_user');
	// }





	

}

?>
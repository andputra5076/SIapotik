<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tools extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('tools_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
	public function index()
	{   
        level_user('tools','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/tools/beranda');
    }  
	public function profil()
	{   
        level_user('tools','profil',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['profil'] = $this->db->get_where('profil_apotek', array('id' => '1'),1); 
        $this->load->view('member/tools/profil',$data);
    }   
    
    public function editprofile(){ 
        cekajax(); 
        $simpan = $this->tools_model; 
        $post = $this->input->post();
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesprofiledit());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{       
            if($simpan->updatedataprofile()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";   
            }else{
                $errors['fail'] = "gagal melakukan update data";
                $data['errors'] = $errors;
            }  				
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
       
	public function view_upload()
	{    
        $nama_file = $this->security->get_csrf_hash(); 
        $aksi = $this->tools_model->upload_file($nama_file);  
        $arraysub = array();
		if($aksi['result'] == "success"){  
            include APPPATH.'third_party/PHPExcel/PHPExcel.php'; 
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('excel/'.$nama_file.'.xlsx');
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);   
            $data = array();
            $baris = 1;
            foreach($sheet as $row){    
                if($baris > 1){ 
                    $jenis = $row['C'] == 'obat' ? 'obat':'alkes';
                    $harga = bilanganbulat($row['E']);
                    array_push($data, array(
                        'kode_item'=>$row['A'],  
                        'nama_item'=>$row['B'],  
                        'jenis'=>$jenis,  
                        'kategori'=>$row['D'],  
                        'harga_jual'=> $harga,  
                        'lokasi'=>$row['F'],  
                        'satuan'=>$row['G'],  
                        'merk'=>$row['H'],  
                    ));
                } 
                $baris++;  
            } 
            if($this->tools_model->input_semua($data)){ 
                $data['success']= true;
                $data['message']="Berhasil upload file ke database";   
            }else{
                $errors['fail'] =  'gagal mengupload semua data, pastikan tidak ada duplikasi kode produk';; 
                $data['errors'] = $errors;
            }  
        }else{
            $errors['fail'] =  $aksi['error']; 
            $data['errors'] = $errors;
        } 
        $data['token'] = $this->security->get_csrf_hash(); 
        echo json_encode($data);  
    }   
    
}
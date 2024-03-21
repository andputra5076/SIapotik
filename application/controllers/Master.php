<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('master_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
    
	public function index()
	{    
        level_user('master','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['total_dokter'] = $this->db->count_all('master_dokter'); 
        $data['total_pembeli'] = $this->db->count_all('master_pembeli'); 
        $data['total_supplier'] = $this->db->count_all('master_supplier'); 
        $data['total_kategori'] = $this->db->count_all('master_kategori'); 
        $data['total_satuan'] = $this->db->count_all('master_satuan'); 
        $data['total_item'] = $this->db->where('jenis !=','racikan')->get('master_item')->num_rows(); 
        $data['total_racikan'] = $this->db->where('jenis','racikan')->get('master_item')->num_rows(); 
        $data['total_merk'] = $this->db->count_all('master_merk'); 
        $this->load->view('member/master/beranda',$data);
    }  
	  
	public function dokter()
	{   
        level_user('master','dokter',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/dokter');
    }  
    public function datadokter()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_dokter_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array();  
            $tombolhapus = level_user('master','dokter',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','dokter',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_dokter).'">Detail</a></li>   
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->kode_dokter);
            $row[] = $this->security->xss_clean($r->nama_dokter);
            $row[] = $this->security->xss_clean($r->jenis_kelamin);
            $row[] = $this->security->xss_clean($r->spesialis); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_dokter(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_dokter(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }
    public function doktertambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesdokter());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->simpandatadokter()){ 
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
    
    public function dokterdetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_dokter', array('kode_dokter' => $this->input->get("id")),1);
        $result = array(  
            "nama_dokter" => $this->security->xss_clean($query->row()->nama_dokter),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone),
            "spesialis" => $this->security->xss_clean($query->row()->spesialis),
            "kode_dokter" => $this->security->xss_clean($query->row()->kode_dokter), 
        );    
    	echo'['.json_encode($result).']';
    }
    public function dokteredit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesdokteredit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->updatedatadokter()){
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
    public function dokterhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatadokter()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors="fail";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
	public function supplier()
	{   
        level_user('master','supplier',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/supplier');
    }  
    public function datasupplier()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_supplier_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','supplier',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','supplier',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">   
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->nama_supplier);
            $row[] = $this->security->xss_clean($r->kontak_person);
            $row[] = $this->security->xss_clean($r->telepon);
            $row[] = $this->security->xss_clean($r->alamat);  
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_supplier(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_supplier(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }
    public function suppliertambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessupplier());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->simpandatasupplier()){
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
    public function supplierdetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('master_supplier', array('id' => $idd),1);
        $result = array(  
            "nama_supplier" => $this->security->xss_clean($query->row()->nama_supplier),
            "kontak_person" => $this->security->xss_clean($query->row()->kontak_person),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
        );    
    	echo'['.json_encode($result).']';
    }
    public function supplieredit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessupplier());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->updatedatasupplier()){
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
    public function supplierhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatasupplier()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function pembeli()
	{     
        level_user('master','pembeli',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['dokter'] = $this->db->get('master_dokter')->result();
        $this->load->view('member/master/pembeli',$data);
    }  
    
    public function datapembeli()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_pembeli_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','pembeli',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','pembeli',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu"> 
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->id).'">Detail</a></li>
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->nama_pembeli);
            $row[] = $this->security->xss_clean($r->jenis_kelamin);
            $row[] = $this->security->xss_clean($r->handphone);
            $row[] = $this->security->xss_clean($r->email);  
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_pembeli(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_pembeli(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }

    public function pembelitambah(){ 
        cekajax(); 
        $post = $this->input->post();
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembeli());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            $insert_id = $simpan->simpandatapembeli();
            if($insert_id > 0) { 
                $data['success']= true;
                $data['pembeli']= $post["nama_pembeli"];
                $data['id_pembeli']= $insert_id;
                $data['message']="Berhasil menyimpan data";
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }  
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    public function pembelidetail(){  
        cekajax(); 
       $idd = intval($this->input->get("id")); 
       $nama_dokter ="";
       $query = $this->db->select("nama_pembeli, kode_dokter, jenis_kelamin, alamat, telepon, handphone, email, kode_dokter")->get_where('master_pembeli', array('id' => $idd),1);
       if(!empty($query->row()->kode_dokter)){    
           $dokter = $this->db->select("nama_dokter")->get_where('master_dokter', array('kode_dokter' => $query->row()->kode_dokter),1);
           $nama_dokter = $dokter->row()->nama_dokter;
       }

        $result = array(  
            "nama_pembeli" => $this->security->xss_clean($query->row()->nama_pembeli),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone),
            "email" => $this->security->xss_clean($query->row()->email), 
            "nama_dokter" => $this->security->xss_clean($nama_dokter),  
            "kode_dokter" => $this->security->xss_clean($query->row()->kode_dokter), 
        );    
    	echo'['.json_encode($result).']';
    }
    public function pembeliedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembeli());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            $simpan->updatedatapembeli();
            $data['success']= true;
            $data['message']="Berhasil menyimpan data";
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function pembelihapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatapembeli()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors="fail";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function itemkategori()
	{   
        level_user('master','itemkategori',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/itemkategori');
    }  
    public function datakategori()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_kategori_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','itemkategori',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','itemkategori',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_kategori(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_kategori(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }
    public function kategoritambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->ruleskategori());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
            if($simpan->simpandatakategori()){
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
    
    public function kategoridetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_kategori', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namakategori" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 
    public function kategoriedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->ruleskategori());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{    
                if($simpan->updatedatakategori()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function kategorihapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatakategori()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
	public function satuan()
	{   
        level_user('master','satuan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/satuan');
    }  
    public function datasatuan()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_satuan_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','satuan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','satuan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_satuan(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_satuan(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function satuantambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulessatuan());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
			if($simpan->simpandatasatuan()){
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
    
    public function satuandetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_satuan', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namasatuan" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 
    public function satuanedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulessatuan());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{     
				if($simpan->updatedatasatuan()){
					$data['success']= true;
					$data['message']="Berhasil menyimpan data";   
				}else{
					$errors['fail'] = "gagal melakukan update data";
					$data['errors'] = $errors;
				}						
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function satuanhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatasatuan()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
    
    public function merk()
	{   
        level_user('master','merk',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/master/merk');
    }
    public function datamerk()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_merk_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','satuan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->id).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','satuan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->id).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu"> 
                        '.$tomboledit.'
                        '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->id); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_merk(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_merk(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    public function merktambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesmerk());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{      			
			if($simpan->simpandatamerk()){
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

    public function merkdetail(){  
        cekajax(); 
        $query = $this->db->get_where('master_merk', array('id' => $this->input->get("id")),1);
        $result = array(  
            "namamerk" => $this->security->xss_clean($query->row()->id), 
        );    
    	echo'['.json_encode($result).']';
    } 

    public function merkedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
        $post = $this->input->post();
        if($post["id"] == $post["idd"]){  
            $data['success']= true;
            $data['message']="Data tidak berubah";  
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesmerk());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{      
                if($simpan->updatedatamerk()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function merkhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdatamerk()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
	
	public function items()
	{  
        level_user('master','items',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['kategori'] = $this->db->get('master_kategori')->result(); 
        $data['satuan'] = $this->db->get('master_satuan')->result(); 
        $data['merk'] = $this->db->get('master_merk')->result(); 
        $this->load->view('member/master/items',$data);
    }  
    public function dataitems()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_item_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','items',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','items',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Edit</a></li>':'';
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu"> 
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Detail</a></li> 
                            '.$tomboledit.'
                            '.$tombolhapus.' 
                        </ul>
                    </div>
                    ';
				    
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean($r->jenis); 
            $row[] = $this->security->xss_clean($r->kategori);   
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual)); 
            $row[] = $this->security->xss_clean($r->lokasi); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_item(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_item(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function itemstambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitems());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{      			
			if($simpan->simpandataitems()){
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
    
    public function itemdetail(){  
        cekajax(); 
        $idd = $this->input->get("id"); 
        $query = $this->db->get_where('master_item', array('kode_item' => $idd),1);
        $result = array(  
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "jenis" => $this->security->xss_clean($query->row()->jenis),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "satuan" => $this->security->xss_clean($query->row()->satuan),
            "merk" => $this->security->xss_clean($query->row()->merk),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan), 
            "lokasi" => $this->security->xss_clean($query->row()->lokasi), 
            "harga_jual" => $this->security->xss_clean(rupiah($query->row()->harga_jual)),
            "harga_jual_edit" => $this->security->xss_clean($query->row()->harga_jual),
            "gambar" => $this->security->xss_clean($query->row()->gambar), 
        );    
    	echo'['.json_encode($result).']';
    }
    
    public function itemsedit(){ 
        cekajax(); 
        $simpan = $this->master_model; 
        $post = $this->input->post();
        if($post["kode_item"] == $post["idd"]){  
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesitemsedit());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{       
                if($simpan->updatedataitems()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  				
            }
        }else{          
            $validation = $this->form_validation; 
            $validation->set_rules($simpan->rulesitems());
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            }else{          
                if($simpan->updatedataitems()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }  
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function itemshapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdataitem()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function racikan()
	{    
        level_user('master','racikan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['itemobat'] = $this->db->get_where('master_item', array('jenis' => 'obat'))->result();
        $data['kategori'] = $this->db->get('master_kategori')->result(); 
        $data['satuan'] = $this->db->get('master_satuan')->result(); 
        $this->load->view('member/master/racikan',$data);
    }  
    
    public function dataracikan()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_dataracikan_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('master','racikan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Hapus</a></li>':'';
            $tomboledit = level_user('master','racikan',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Edit</a></li>':'';
            $row[] = ' <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$this->security->xss_clean($r->kode_item).'">Detail</a></li> 
                            '.$tomboledit.'
                            '.$tombolhapus.' 
                        </ul>
                    </div>
                    '; 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual));   
            $row[] = $this->security->xss_clean(rupiah($r->upah_peracik));  
            $row[] = $this->security->xss_clean($r->aturan_pakai); 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_dataracikan(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_dataracikan(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function racikandetail(){  
        cekajax(); 
        $idd = $this->input->get("id");
        $query = $this->db->get_where('master_item', array('kode_item' => $idd),1);
        $result = array(  
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "jenis" => $this->security->xss_clean($query->row()->jenis),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "satuan" => $this->security->xss_clean($query->row()->satuan),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan), 
            "lokasi" => $this->security->xss_clean($query->row()->lokasi), 
            "harga_jual" => $this->security->xss_clean(rupiah($query->row()->harga_jual)), 
            "harga_jual_edit" => $this->security->xss_clean($query->row()->harga_jual), 
            "aturan_pakai" => $this->security->xss_clean($query->row()->aturan_pakai), 
            "upah_peracik" => $this->security->xss_clean(rupiah($query->row()->upah_peracik)), 
            "upah_peracik_edit" => $this->security->xss_clean($query->row()->upah_peracik), 
            "gambar" => $this->security->xss_clean($query->row()->gambar), 
        );     
        
		$subitem= $this->master_model->get_dataracikan($idd); 
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_obat;
			$subArray['nama_item']=$r->nama_item;  
			$subArray['jumlah_obat_dibuat']=$r->jumlah_obat_dibuat;   
			$subArray['jumlah_obat_dipakai']=$r->jumlah_obat_dipakai;     
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    
    public function pilihanobat()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->master_model->get_pilihanobat_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean($r->kategori);   
            $row[] = ' 
            <a onclick="pilihobat(this)"  data-namaitem="'.$r->nama_item.'" data-id="'.$r->kode_item.'" class="mt-xs mr-xs btn btn-info datarowobat" role="button"><i class="fa fa-check-square-o"></i></a>
            '; 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master_model->count_all_datatable_pilihanobat(),
            "recordsFiltered" => $this->master_model->count_filtered_datatable_pilihanobat(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }  
    public function racikantambah(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitems());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_obat = $this->input->post("kode_obat");   
            if(isset($kode_obat) === TRUE AND $kode_obat[0]!='')
            {  
                if($simpan->simpandataracikan()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                } 
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih obat yang ingin diracik";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function racikanhapus(){ 
        cekajax(); 
        $hapus = $this->master_model;
        if($hapus->hapusdataracikan()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    public function racikanedit(){ 
        cekajax(); 
        $simpan = $this->master_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesitemsedit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_obat = $this->input->post("kode_obat");   
            if(isset($kode_obat) === TRUE AND $kode_obat[0]!='')
            {  
                if($simpan->updatedataracikan()){
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";   
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                } 
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih obat yang ingin diracik";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
}
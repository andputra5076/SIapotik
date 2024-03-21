<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
	public function index()
	{   
        level_user('user','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/user/beranda');
    }   
     
	public function user()
	{   
        level_user('user','user',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['kategori'] = $this->db->get('kategori_user')->result();  
        $this->load->view('member/user/user',$data);
    }   
    

    public function datausers()
    {   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length"));
        $query = $this->db->select("a.id, a.username, a.nama_admin, a.email, a.jenis_kelamin, a.aktif, b.kategori_user")->from("master_admin a")->join('kategori_user b', 'a.kategori = b.id')->get();  
        $data = []; 
        foreach($query->result() as $r) {   
            $status = $r->aktif == '1' ? "<span class='btn   btn-xs  btn-success'>Aktif</span>":"<span class='btn  btn-xs btn-danger'>Blokir</span>";
            $tombolhapus = level_user('user','user',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$r->id.'">Hapus</a></li>':'';
            $tomboledit = level_user('user','user',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$r->id.'">Edit</a></li>':'';
				
            $data[] = array(   
            ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Detail</a></li>  
                            '.$tomboledit.'
                            '.$tombolhapus.' 
                        </ul>
                    </div>
            ',  
            $this->security->xss_clean($r->nama_admin),
            $this->security->xss_clean($r->username),
            $this->security->xss_clean($r->email),   
            $this->security->xss_clean($r->kategori_user),    
            $this->security->xss_clean($r->jenis_kelamin),   
            $this->security->xss_clean($status),   
            ); 
        }  
        $result = array( 
                 "draw" => $draw, 
                   "recordsTotal" => $query->num_rows(), 
                   "recordsFiltered" => $query->num_rows(), 
                   "data" => $data 
        );  
        echo json_encode($result);  
    }
    
    public function tambahuser(){ 
        cekajax(); 
        $simpan = $this->user_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesuser());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{      			
			if($simpan->simpandatauser()){
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
    
    public function userdetail(){  
        cekajax(); 
        $idd = $this->input->get("id");   
        $query = $this->db->select("a.id, a.kategori, a.username, a.nama_admin, a.email, a.jenis_kelamin, a.aktif, a.alamat, a.telepon, a.handphone, a.email, b.kategori_user")->from("master_admin a")->join('kategori_user b', 'a.kategori = b.id')->where('a.id', $idd, 1)->get(); 
        $status = $query->row()->aktif == '1' ? "<span class='btn   btn-xs  btn-success'>Aktif</span>":"<span class='btn  btn-xs btn-danger'>Blokir</span>";
        $result = array(  
            "kategori" => $this->security->xss_clean($query->row()->kategori_user),
            "kategori_value" => $this->security->xss_clean($query->row()->kategori),
            "username" => $this->security->xss_clean($query->row()->username),
            "nama_admin" => $this->security->xss_clean($query->row()->nama_admin),
            "jenis_kelamin" => $this->security->xss_clean($query->row()->jenis_kelamin),
            "alamat" => $this->security->xss_clean($query->row()->alamat),
            "telepon" => $this->security->xss_clean($query->row()->telepon),
            "handphone" => $this->security->xss_clean($query->row()->handphone), 
            "email" => $this->security->xss_clean($query->row()->email),  
            "aktif_value" => $this->security->xss_clean($query->row()->aktif),  
            "aktif" => $status, 
        );    
    	echo'['.json_encode($result).']';
    }
    public function useredit(){ 
        cekajax(); 
        $simpan = $this->user_model; 
        $post = $this->input->post();
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesuseredit());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{       
            if($simpan->updatedatauser()){
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
    
    public function userhapus(){ 
        cekajax(); 
        $hapus = $this->user_model;
        if($hapus->hapusdatauser()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
}
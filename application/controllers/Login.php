<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller { 
    function __construct(){
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form')); 
    }
    public function index()
	{  
        if($this->session->userdata('login') == TRUE){
            redirect(base_url());
        }else{ 
            $this->load->view('guest/login');
        }  
    }
    function authlogin(){ 
        if(!isset($_POST) OR !isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') exit('No direct script access allowed'); 
        $login = $this->login_model;
		$validation = $this->form_validation; 
        $validation->set_rules($login->rules());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{   
            $post = $this->input->post();
            $cek_username=$login->auth_user($post["username"]); 
            $r=$cek_username->row_array();
            if(($cek_username->num_rows() > 0)  AND password_verify($post["password"], $r['password'])==TRUE){  
                $this->session->set_userdata('login',TRUE);  
                $this->session->set_userdata('nama_admin',$r['nama_admin']);
                $this->session->set_userdata('idadmin',$r['id']);
                $this->session->set_userdata('kategori',$r['kategori']); 
                
                $kategori = $this->db->select("a.kategori_user, b.controller, b.nama_function")
                ->from("kategori_user a")
                ->join('modul b', 'b.id = a.beranda ') 
                ->where('a.id', $r['kategori'])->get()->row();  
                $beranda = $kategori->controller == 'index' ? $kategori->controller : $kategori->controller."/".$kategori->nama_function;
                $this->session->set_userdata('nama_kategori',$kategori->kategori_user); 
                $data['success']= true;
                $data['message']="berhasil login"; 
                $data['beranda']= $beranda; 
            }else{ 
                $errors['username'] ="Email/Username and Password not match";
                $data['errors'] = $errors; 
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
}

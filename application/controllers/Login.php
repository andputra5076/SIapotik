<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string', 'security', 'form'));
    }
    public function index()
    {
        if ($this->session->userdata('login') == TRUE) {
            redirect(base_url());
        } else {
            $this->load->view('guest/login');
        }
    }
    function authlogin()
    {
        if (!isset($_POST) || !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            exit('No direct script access allowed');
        }

        $login = $this->login_model;
        $validation = $this->form_validation;
        $validation->set_rules($login->rules());

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        } else {
            $post = $this->input->post();
            $result = $login->auth_user($post["username"]);

            if ($result) {
                // User found in either table
                $table = $result['table'];
                $storedPassword = $result['password'];

                // Check password based on user type
                if ($table == 'master_admin') {
                    // Verify password for master_admin using password_verify
                    if (password_verify($post["password"], $storedPassword)) {
                        // Set session data for admin
                        $this->session->set_userdata('login', TRUE);
                        $this->session->set_userdata('nama_admin', $result['nama_admin']);
                        $this->session->set_userdata('idadmin', $result['id']);
                        $this->session->set_userdata('kategori', $result['kategori']);

                        // Fetch category info
                        $kategori = $this->db->select("a.kategori_user, b.controller, b.nama_function")
                            ->from("kategori_user a")
                            ->join('modul b', 'b.id = a.beranda')
                            ->where('a.id', $result['kategori'])
                            ->get()
                            ->row();

                        $beranda = $kategori->controller == 'index' ? $kategori->controller : $kategori->controller . "/" . $kategori->nama_function;
                        $this->session->set_userdata('nama_kategori', $kategori->kategori_user);

                        $data['success'] = true;
                        $data['message'] = "Berhasil login";
                        $data['beranda'] = $beranda;
                    } else {
                        $errors['username'] = "Email/Username and Password do not match";
                        $data['errors'] = $errors;
                    }
                } elseif ($table == 'master_dokter') {
                    // Verifikasi password untuk master_dokter menggunakan MD5
                    if (md5($post["password"]) === $storedPassword) {
                        // Set session data untuk dokter
                        $this->session->set_userdata('login', TRUE);
                        $this->session->set_userdata('nama_dokter', $result['nama_dokter']);
                        $this->session->set_userdata('kode_dokter', $result['kode_dokter']); // Ganti id dengan kode_dokter
                        $this->session->set_userdata('kategori', $result['kategori']);
                
                        // Ambil informasi kategori
                        $kategori = $this->db->select("a.kategori_user, b.controller, b.nama_function")
                            ->from("kategori_user a")
                            ->join('modul b', 'b.id = a.beranda')
                            ->where('a.id', $result['kategori'])
                            ->get()
                            ->row();
                
                        // Tentukan beranda berdasarkan controller dan nama_function
                        $beranda = $kategori->controller == 'index' ? $kategori->controller : $kategori->controller . "/" . $kategori->nama_function;
                        $this->session->set_userdata('nama_kategori', $kategori->kategori_user);
                
                        $data['success'] = true;
                        $data['message'] = "Berhasil login";
                        $data['beranda'] = $beranda;
                    } else {
                        $errors['username'] = "Email/Username dan Password tidak cocok";
                        $data['errors'] = $errors;
                    }
                } else {
                    // Kode lain untuk kategori atau tabel lainnya jika ada
                
                    $errors['username'] = "Email/Username and Password do not match";
                    $data['errors'] = $errors;
                }
            } else {
                $errors['username'] = "Email/Username and Password do not match";
                $data['errors'] = $errors;
            }
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }
}

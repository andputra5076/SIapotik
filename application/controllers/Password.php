<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Password extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url('login'));
        }
        $this->load->model('password_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string', 'security', 'form'));
    }
    public function index()
    {
        if (level_user('password', 'index', $this->session->userdata('kategori'), 'read') > 0) {
            // Izin ditemukan, maka lanjutkan menampilkan halaman
            $this->load->view('member/password/password');
        } else {
            // Izin tidak ditemukan, lakukan tindakan yang sesuai, seperti menampilkan pesan kesalahan atau melakukan redirect.
            // Misalnya, Anda bisa menampilkan pesan kesalahan:
            echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
        }
    }
    public function gantipassword()
    {
        if (level_user('password', 'index', $this->session->userdata('kategori'), 'edit') > 0) {
            // Izin ditemukan, lanjutkan dengan proses ganti password

            $password_model = $this->password_model;
            $validation = $this->form_validation;
            $validation->set_rules($password_model->rules());

            if ($this->form_validation->run() == FALSE) {
                // Jika validasi gagal, kirimkan pesan kesalahan
                $errors = $this->form_validation->error_array();
                $data['errors'] = $errors;
            } else {
                // Jika validasi berhasil, lakukan proses ganti password
                $post = $this->input->post();
                $new_password = $post['password'];

                // Tentukan metode hashing berdasarkan kategori pengguna
                $kategori = $this->session->userdata('nama_kategori');
                if ($kategori == 'Manager' || $kategori == 'Kasir') {
                    // Jika admin, gunakan bcrypt
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                } elseif ($kategori == 'Dokter') {
                    // Jika dokter, gunakan MD5
                    $hashed_password = md5($new_password);
                } else {
                    // Jika kategori tidak dikenal, set error
                    $errors['fail'] = "Kategori pengguna tidak dikenal.";
                    $data['errors'] = $errors;
                    $data['token'] = $this->security->get_csrf_hash();
                    echo json_encode($data);
                    return;
                }

                // Siapkan data untuk diupdate
                $datapass['password'] = $hashed_password;

                // Panggil fungsi editpassword dengan data password
                if ($password_model->editpassword($datapass)) {
                    $data['success'] = true;
                    $data['message'] = "Berhasil merubah password";
                } else {
                    $errors['fail'] = "Gagal melakukan update data";
                    $data['errors'] = $errors;
                }
            }
        } else {
            // Izin tidak ditemukan, lakukan tindakan yang sesuai
            $data['errors'] = "Anda tidak memiliki izin untuk mengakses halaman ini.";
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }
}

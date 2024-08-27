<?php
class Password_model extends CI_Model
{
    public function rules()
    {
        return [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
            ],
            [
                'field' => 'password2',
                'label' => 'Password Konfirmasi',
                'rules' => 'trim|required|matches[password]'
            ]
        ];
    }
    public function editpassword($datapass)
    {
        // Mengambil nilai dari array $datapass
        extract($datapass);

        // Ambil ID pengguna dan kategori dari session
        $admin_id = $this->session->userdata('idadmin');
        $dokter_id = $this->session->userdata('kode_dokter');
        $kategori = $this->session->userdata('nama_kategori');

        // Periksa kategori dan ID yang relevan untuk melakukan update
        if ($kategori == 'Manager' || $kategori == 'Kasir') {
            // Jika kategori adalah 'Manager' atau 'Kasir', perbarui password di master_admin
            if ($admin_id) {
                $this->db->where('id', $admin_id);
                return $this->db->update('master_admin', array('password' => $password));
            }
        } elseif ($kategori == 'Dokter') {
            // Jika kategori adalah 'Dokter', perbarui password di master_dokter
            if ($dokter_id) {
                $this->db->where('kode_dokter', $dokter_id);
                return $this->db->update('master_dokter', array('password' => $password));
            }
        }

        // Jika tidak ada ID yang ditemukan di session atau kategori tidak valid
        return false;
    }
}

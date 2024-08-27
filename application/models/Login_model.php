<?php
class Login_model extends CI_Model
{
    public function rules()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
    }
    function auth_user($username)
    {
        // Query both tables and check if the username exists in either of them
        $this->db->select('*');
        $this->db->from('master_admin');
        $this->db->where('username', $username);
        $admin_query = $this->db->get();

        if ($admin_query->num_rows() > 0) {
            // If user found in master_admin, return the result with a flag indicating the source table
            $result = $admin_query->row_array();
            $result['table'] = 'master_admin';
            return $result;
        }

        // If not found in master_admin, check in master_dokter
        $this->db->select('*');
        $this->db->from('master_dokter');
        $this->db->where('username', $username);
        $dokter_query = $this->db->get();

        if ($dokter_query->num_rows() > 0) {
            // If user found in master_dokter, return the result with a flag indicating the source table
            $result = $dokter_query->row_array();
            $result['table'] = 'master_dokter';
            return $result;
        }

        // If no user found in both tables, return false
        return false;
    }
}

<?php
class Password_model extends CI_Model{  
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
    function editpassword($datapass){   
        extract($datapass);
        $this->db->where('id', $this->session->userdata('idadmin'));
        return $this->db->update('master_admin', array('password' => $password)); 
    }   
}
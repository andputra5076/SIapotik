<?php
class Login_model extends CI_Model{  
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
    function auth_user($username){   
        return  $this->db->get_where(
            'master_admin',array(
                'username' => $username, 
            )
        ); 
    }   
}
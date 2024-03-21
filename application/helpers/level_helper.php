<?php
function level_user($nama_controller,$nama_function,$kategori,$akses){ 
    $ci =& get_instance(); 
    return $ci->db->select("a.kategori_user")
                ->from("kategori_user_modul a")
                ->join('modul b', 'b.id = a.modul AND b.controller ="'.$nama_controller.'"')  
                ->where(array('a.kategori_user' => $kategori, 'a.akses' => $akses, 'b.nama_function' => $nama_function))->get()->num_rows(); 
} 
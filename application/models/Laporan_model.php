<?php
class Laporan_model extends CI_Model{   
     
    function getrowspo($params = array()){ 
        $this->db->select("a.nomor_po, a.tgl_po, a.termin,
         a.pembayaran, a.supplier, a.total, a.keterangan, b.nama_supplier");
        $this->db->from("purchase_order a");
        $this->db->join('master_supplier b', 'b.id = a.supplier');   
        if(!empty($params['search']['supplier'])){
            $this->db->where('a.supplier',$params['search']['supplier']);
        } 
        if(!empty($params['search']['firstdate']) AND !empty($params['search']['lastdate'])){
            $this->db->where('a.tgl_po BETWEEN "'.$params['search']['firstdate']. '" and "'. $params['search']['lastdate'].'"');
        }
        $this->db->order_by('a.tgl_po','ASC'); 
        if(empty($params['kategori']['excel']) OR $params['kategori']['excel'] != 'excel'){
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            } 
        }

        $query = $this->db->get(); 
        return $query->result_array();
    }
    
    function getrowspembelian($params = array()){ 
        $this->db->select("a.nomor_faktur, a.tgl_pembelian, a.termin,
         a.pembayaran, a.supplier, a.total, a.keterangan, b.nama_supplier");
        $this->db->from("pembelian_langsung a");
        $this->db->join('master_supplier b', 'b.id = a.supplier');   
        if(!empty($params['search']['supplier'])){
            $this->db->where('a.supplier',$params['search']['supplier']);
        } 
        if(!empty($params['search']['firstdate']) AND !empty($params['search']['lastdate'])){
            $this->db->where('a.tgl_pembelian BETWEEN "'.$params['search']['firstdate']. '" and "'. $params['search']['lastdate'].'"');
        }
        $this->db->order_by('a.tgl_pembelian','ASC'); 
        if(empty($params['kategori']['excel']) OR $params['kategori']['excel'] != 'excel'){
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            } 
        }

        $query = $this->db->get(); 
        return $query->result_array();
    } 
     
    function getrowsstok($params = array()){ 
        $this->db->select("a.kode_item, a.tanggal, a.jumlah_masuk, a.jenis_transaksi,
         a.jumlah_keluar, a.satuan_kecil, a.tgl_expired, b.nama_item");
        $this->db->from("kartu_stok a");
        $this->db->join('master_item b', 'b.kode_item = a.kode_item');    
        if(!empty($params['search']['firstdate']) AND !empty($params['search']['lastdate'])){
            $this->db->where('a.tanggal BETWEEN "'.$params['search']['firstdate']. '" and "'. $params['search']['lastdate'].'"');
        }
        $this->db->order_by('a.tanggal','ASC'); 
        if(empty($params['kategori']['excel']) OR $params['kategori']['excel'] != 'excel'){
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            } 
        }

        $query = $this->db->get(); 
        return $query->result_array();
    }
    
    function getrowspenjualan($params = array()){ 
        $this->db->select("a.total_upah_peracik, a.total_harga_item, a.total,
         a.tanggal, b.nama_admin");
        $this->db->from("penjualan a");
        $this->db->join('master_admin b', 'b.id = a.id_admin');   
        if(!empty($params['search']['kasir'])){
            $this->db->where('a.id_admin',$params['search']['kasir']);
        } 
        if(!empty($params['search']['firstdate']) AND !empty($params['search']['lastdate'])){
            $this->db->where('a.tanggal BETWEEN "'.$params['search']['firstdate']. '" and "'. $params['search']['lastdate'].'"');
        }
        $this->db->order_by('a.tanggal_jam','ASC'); 
        if(empty($params['kategori']['excel']) OR $params['kategori']['excel'] != 'excel'){
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            } 
        }

        $query = $this->db->get(); 
        return $query->result_array();
    } 

}
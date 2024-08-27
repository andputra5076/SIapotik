<?php
class Master_model extends CI_Model{   
      
    // datatable dokter start
    var $column_search_dokter = array('kode_dokter', 'username', 'alamat', 'nama_dokter','jenis_kelamin','handphone','telepon'); 
    var $column_order_dokter = array(null,'kode_dokter', 'username', 'alamat', 'nama_dokter','jenis_kelamin','handphone','telepon');
    var $order_dokter = array('waktu_update' => 'DESC');
    private function _get_query_dokter()
    { 
        $get = $this->input->get();
        $this->db->from('master_dokter'); 
        $i = 0; 
        foreach ($this->column_search_dokter as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_dokter) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_dokter[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_dokter))
        {
            $order = $this->order_dokter;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_dokter_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_dokter();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_dokter()
    {
        $this->_get_query_dokter();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_dokter()
    {
        $this->db->from('master_dokter');
        return $this->db->count_all_results();
    } 
    //datatable dokter end
	
	// CRUD dokter start
    public function rulesdokter()
    {
        return [
            [
            'field' => 'nama_dokter',
            'label' => 'Nama Dokter',
            'rules' => 'required',
            ] ,
            [
            'field' => 'kode_dokter',
            'label' => 'Kode Dokter',
            'rules' => 'is_unique[master_dokter.kode_dokter]|required',
            ] , 
            [
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'is_unique[master_dokter.username]|required',
            ] , 
            [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'is_unique[master_dokter.password]|required',
            ] 
        ];
    } 
    public function rulesdokteredit()
    {
        return [
            [
            'field' => 'nama_dokter',
            'label' => 'Nama Dokter',
            'rules' => 'required',
            ] ,
            [
            'field' => 'kode_dokter',
            'label' => 'Kode Dokter',
            'rules' => 'required',
            ] ,
            [
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required',
            ]
        ];
    } 
    function simpandatadokter(){   
        $post = $this->input->post();   
        $array = array(
            'username'=>$post["username"], 
            'password' => md5($post["password"]), 
            'nama_dokter'=>$post["nama_dokter"], 
            'jenis_kelamin'=>$post["jenis_kelamin"], 
            'alamat'=>$post["alamat"],  
            'telepon'=>$post["telepon"], 
            'handphone'=>$post["handphone"], 
            'spesialis'=>$post["spesialis"], 
            'kode_dokter'=>$post["kode_dokter"], 
        );
        return $this->db->insert("master_dokter", $array);
    }   
    public function updatedatadokter()
    {
        $post = $this->input->post();
        $this->username = $post["username"];
        $this->password = md5($post["password"]);
        $this->nama_dokter = $post["nama_dokter"];
        $this->jenis_kelamin = $post["jenis_kelamin"];
        $this->alamat = $post["alamat"];
        $this->telepon = $post["telepon"]; 
        $this->kode_dokter = $post["kode_dokter"]; 
        $this->handphone = $post["handphone"];   
        $this->spesialis = $post["spesialis"];   
        return $this->db->where('kode_dokter',$post['idd'])->update("master_dokter", $this);
    }
    public function hapusdatadokter()
    {
        $post = $this->input->post(); 
        $this->db->where('kode_dokter', $post['idd']);
        return $this->db->delete('master_dokter');  
    } 
	// CRUD dokter end
    
    

    // datatable supplier start
    var $column_search_supplier = array('nama_supplier','kontak_person','telepon','alamat'); 
    var $column_order_supplier = array(null, 'nama_supplier','kontak_person','telepon','alamat');
    var $order_supplier = array('waktu_update' => 'DESC');
    private function _get_query_supplier()
    { 
        $get = $this->input->get();
        $this->db->from('master_supplier'); 
        $i = 0; 
        foreach ($this->column_search_supplier as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_supplier) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_supplier[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_supplier))
        {
            $order = $this->order_supplier;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_supplier_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_supplier();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_supplier()
    {
        $this->_get_query_supplier();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_supplier()
    {
        $this->db->from('master_supplier');
        return $this->db->count_all_results();
    } 
    //datatable supplier end

		// CRUD supplier start
    public function rulessupplier()
    {
        return [
            [
            'field' => 'nama_supplier',
            'label' => 'Nama supplier',
            'rules' => 'required',
            ] 
        ];
    } 
    function simpandatasupplier(){   
        $post = $this->input->post();   
        $array = array(
            'nama_supplier'=>$post["nama_supplier"], 
            'kontak_person'=>$post["kontak_person"], 
            'alamat'=>$post["alamat"],  
            'telepon'=>$post["telepon"],  
        );
        return $this->db->insert("master_supplier", $array);   
    } 
    public function updatedatasupplier()
    {
        $post = $this->input->post();
        $this->nama_supplier = $post["nama_supplier"];
        $this->kontak_person = $post["kontak_person"];
        $this->alamat = $post["alamat"];
        $this->telepon = $post["telepon"];  
        return $this->db->update("master_supplier", $this, array('id' => $post['idd']));
    }
    public function hapusdatasupplier()
    {
        $post = $this->input->post();
        $this->db->where('id', $post['idd']);
        return $this->db->delete('master_supplier');
    }
        // CRUD supplier end
         
    // datatable pembeli start
    var $column_search_pembeli = array('nama_pembeli','jenis_kelamin','handphone','email'); 
    var $column_order_pembeli = array(null, 'nama_pembeli','jenis_kelamin','handphone','email');
    var $order_pembeli = array('waktu_update' => 'DESC');
    private function _get_query_pembeli()
    { 
        $get = $this->input->get();
        $this->db->from('master_pembeli'); 
        $i = 0; 
        foreach ($this->column_search_pembeli as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_pembeli) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_pembeli[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_pembeli))
        {
            $order = $this->order_pembeli;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_pembeli_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_pembeli();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_pembeli()
    {
        $this->_get_query_pembeli();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_pembeli()
    {
        $this->db->from('master_pembeli');
        return $this->db->count_all_results();
    } 
    //datatable pembeli end

    //CRUD pembeli start 
    public function rulespembeli()
    {
        return [
            [
            'field' => 'nama_pembeli',
            'label' => 'Nama pembeli',
            'rules' => 'required',
            ] 
        ];
    } 
    function simpandatapembeli(){   
        $post = $this->input->post();   
        if($post['kode_dokter']==""){
            $kode_dokter = NULL;     
        }else{ 
            $kode_dokter = $post["kode_dokter"];   
        }
        $array = array(
            'nama_pembeli'=>$post["nama_pembeli"], 
            'jenis_kelamin'=>$post["jenis_kelamin"], 
            'alamat'=>$post["alamat"],  
            'telepon'=>$post["telepon"], 
            'handphone'=>$post["handphone"], 
            'email'=>$post["email"],  
            'kode_dokter'=>$kode_dokter, 
        );
        $this->db->insert("master_pembeli", $array);  
        return $this->db->insert_id();
    } 
    public function updatedatapembeli()
    {
        $post = $this->input->post();
        $this->nama_pembeli = $post["nama_pembeli"];
        $this->jenis_kelamin = $post["jenis_kelamin"];
        $this->alamat = $post["alamat"];
        $this->telepon = $post["telepon"]; 
        $this->email = $post["email"]; 
        $this->handphone = $post["handphone"];   
        if($post['kode_dokter']==""){
            $this->kode_dokter = NULL;     
        }else{ 
            $this->kode_dokter = $post["kode_dokter"];   
        }
        return $this->db->update("master_pembeli", $this, array('id' => $post['idd']));
    } 
    public function hapusdatapembeli()
    {
        $post = $this->input->post(); 
        $this->db->where('id', $post['idd']);
        return $this->db->delete('master_pembeli');  
    }
    //CRUD pembeli end 
    

    // datatable kategori start
    var $column_search_kategori = array('id'); 
    var $column_order_kategori = array(null, 'id');
    var $order_kategori = array('waktu_update' => 'DESC');
    private function _get_query_kategori()
    { 
        $get = $this->input->get();
        $this->db->from('master_kategori'); 
        $i = 0; 
        foreach ($this->column_search_kategori as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_kategori) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_kategori[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_kategori))
        {
            $order = $this->order_kategori;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_kategori_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_kategori();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_kategori()
    {
        $this->_get_query_kategori();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_kategori()
    {
        $this->db->from('master_kategori');
        return $this->db->count_all_results();
    } 
    //datatable kategori end

    //CRUD kategori start
    public function ruleskategori()
    {
        return [
            [
            'field' => 'id',
            'label' => 'Nama kategori',
            'rules' => 'is_unique[master_kategori.id]|required',
            ] 
        ];
    } 
    function simpandatakategori(){   
        $post = $this->input->post();   
        $array = array(
            'id'=>$post["id"], 
        );
        return $this->db->insert("master_kategori", $array);   
    } 
    public function updatedatakategori()
    {
        $post = $this->input->post();
        $this->id = $post["id"]; 
        return $this->db->update("master_kategori", $this, array('id' => $post['idd']));
    } 
    public function hapusdatakategori()
    {
        $post = $this->input->post(); 
        $this->db->where('id', $post['idd']);
        return $this->db->delete('master_kategori');  
    }
    //CRUD kategori end
 
    // datatable satuan start
    var $column_search_satuan = array('id'); 
    var $column_order_satuan = array(null, 'id');
    var $order_satuan = array('waktu_update' => 'DESC');
    private function _get_query_satuan()
    { 
        $get = $this->input->get();
        $this->db->from('master_satuan'); 
        $i = 0; 
        foreach ($this->column_search_satuan as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_satuan) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_satuan[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_satuan))
        {
            $order = $this->order_satuan;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_satuan_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_satuan();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_satuan()
    {
        $this->_get_query_satuan();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_satuan()
    {
        $this->db->from('master_satuan');
        return $this->db->count_all_results();
    } 
    //datatable satuan end
	
	//CRUD satuan start
    public function rulessatuan()
    {
        return [
            [
            'field' => 'id',
            'label' => 'Nama satuan',
            'rules' => 'is_unique[master_satuan.id]|required',
            ] 
        ];
    } 
    function simpandatasatuan(){   
        $post = $this->input->post();   
        $array = array(
            'id'=>$post["id"], 
        );
        return $this->db->insert("master_satuan", $array); 
    } 
    public function updatedatasatuan()
    {
        $post = $this->input->post();
        $this->id = $post["id"]; 
        return $this->db->update("master_satuan", $this, array('id' => $post['idd']));
    } 
    public function hapusdatasatuan()
    {
        $post = $this->input->post(); 
        $this->db->where('id', $post['idd']);
        return $this->db->delete('master_satuan');  
    }
    //CRUD satuan end
	
    // datatable merk start
    var $column_search_merk = array('id'); 
    var $column_order_merk = array(null, 'id');
    var $order_merk = array('waktu_update' => 'DESC');
    private function _get_query_merk()
    { 
        $get = $this->input->get();
        $this->db->from('master_merk'); 
        $i = 0; 
        foreach ($this->column_search_merk as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_merk) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_merk[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_merk))
        {
            $order = $this->order_merk;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_merk_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_merk();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_merk()
    {
        $this->_get_query_merk();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_merk()
    {
        $this->db->from('master_merk');
        return $this->db->count_all_results();
    } 
    //datatable merk end

	//CRUD merk start
    public function rulesmerk()
    {
        return [
            [
            'field' => 'id',
            'label' => 'Nama Merk',
            'rules' => 'is_unique[master_merk.id]|required',
            ] 
        ];
    }  
    function simpandatamerk(){   
        $post = $this->input->post();   
        $array = array(
            'id'=>$post["id"], 
        );
        return $this->db->insert("master_merk", $array);   
    } 
    
    public function hapusdatamerk()
    {
        $post = $this->input->post(); 
        $this->db->where('id', $post['idd']);
        return $this->db->delete('master_merk');  
    }
    public function updatedatamerk()
    {
        $post = $this->input->post();
        $this->id = $post["id"]; 
        return $this->db->update("master_merk", $this, array('id' => $post['idd']));
    } 
	//CRUD merk end
	
	// datatable item start
    var $column_search_item = array('kode_item','nama_item','jenis','kategori','harga_jual','lokasi'); 
    var $column_order_item = array(null, 'kode_item','nama_item','jenis','kategori','harga_jual','lokasi');
    var $order_item = array('waktu_update' => 'DESC');
    private function _get_query_item()
    { 
        $get = $this->input->get();
        $this->db->from('master_item'); 
        $i = 0; 
        foreach ($this->column_search_item as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_item) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_item[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_item))
        {
            $order = $this->order_item;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_item_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_item();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_item()
    {
        $this->_get_query_item();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_item()
    {
        $this->db->from('master_item');
        return $this->db->count_all_results();
    } 
    //datatable item end
	
	//CRUD item start
    public function rulesitems()
    {
        return [
            [
            'field' => 'kode_item',
            'label' => 'Kode Item',
            'rules' => 'is_unique[master_item.kode_item]|required',
            ] ,
            [
            'field' => 'nama_item',
            'label' => 'Nama Item',
            'rules' => 'required',
            ], 
        ];
    } 
    public function rulesitemsedit()
    {
        return [
            [
            'field' => 'kode_item',
            'label' => 'Kode Item',
            'rules' => 'required',
            ],
            [
            'field' => 'nama_item',
            'label' => 'Nama Item',
            'rules' => 'required',
            ], 
        ];
    } 
    function simpandataitems(){   
        $post = $this->input->post();   
        $array = array(
            'kode_item'=>$post["kode_item"], 
            'jenis'=>$post["jenis"], 
            'kategori'=>$post["kategori"],  
            'satuan'=>$post["satuan"], 
            'merk'=>$post["merk"], 
            'nama_item'=>$post["nama_item"], 
            'keterangan'=>$post["keterangan"], 
            'lokasi'=>$post["lokasi"],  
            'gambar'=>$this->_uploadGambarProduk(),  
            'harga_jual'=>bilanganbulat($post["harga_jual"]), 
        );
        return $this->db->insert("master_item", $array);  
    }    
     
    public function updatedataitems()
    {
        $post = $this->input->post();
        $this->kode_item = $post["kode_item"];
        $this->jenis = $post["jenis"];
        $this->kategori = $post["kategori"];
        $this->merk = $post["merk"];
        $this->satuan = $post["satuan"]; 
        $this->nama_item = $post["nama_item"]; 
        $this->keterangan = $post["keterangan"];  
        $this->lokasi = $post["lokasi"];  
        $this->harga_jual = bilanganbulat($post["harga_jual"]);  
        
        if (!empty($_FILES["gambar"]["name"])) {
            $this->gambar = $this->_uploadGambarProduk();
        }   
        return $this->db->update("master_item", $this, array('kode_item' => $post['idd']));
    }
    private function _uploadGambarProduk()
    {
        $post = $this->input->post();
        $config['upload_path']          = './images/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['file_name']            = $post["kode_item"];
        $config['overwrite']			= true;
        $config['max_size']             = 1024;  
        $this->load->library('upload', $config); 
        if ($this->upload->do_upload('gambar')) {
            return $this->upload->data("file_name");
        } 
        return "default.jpg";
    } 
    private function _hapusGambarProduk($id)
    {
        $product = $this->_namagambar($id);
        if ($product->gambar != "default.jpg") {
            $filename = explode(".", $product->gambar)[0];
            return array_map('unlink', glob(FCPATH."images/$filename.*"));
        }
    }
    private function _namagambar($id)
    {
        return $this->db->get_where('master_item', ["kode_item" => $id])->row();
    }
    public function hapusdataitem()
    {
        $post = $this->input->post(); 
        $this->_hapusGambarProduk($post['idd']);
        $this->db->where('kode_item', $post['idd']);
        return $this->db->delete('master_item');  
    } 
    //CRUD item end
     // datatable pilihan obat start
     var $column_search_pilihanobat = array('kode_item','nama_item','kategori'); 
     var $column_order_pilihanobat = array(null, 'kode_item','nama_item','kategori');
     var $order_pilihanobat = array('waktu_update' => 'DESC');
     private function _get_query_pilihanobat()
     { 
         $get = $this->input->get();
         $this->db->where('jenis = "obat"')->from('master_item');
         $i = 0; 
         foreach ($this->column_search_pilihanobat as $item)
         {
             if($get['search']['value'])
             { 
                 if($i===0) 
                 {
                     $this->db->group_start(); 
                     $this->db->like($item, $get['search']['value']);
                 }
                 else
                 {
                     $this->db->or_like($item, $get['search']['value']);
                 }
  
                 if(count($this->column_search_pilihanobat) - 1 == $i) 
                     $this->db->group_end(); 
             }
             $i++;
         } 
         if(isset($get['order'])) 
         {
             $this->db->order_by($this->column_order_pilihanobat[$get['order']['0']['column']], $get['order']['0']['dir']);
         } 
         else if(isset($this->order_pilihanobat))
         {
             $order = $this->order_pilihanobat;
             $this->db->order_by(key($order), $order[key($order)]);
         }
     }
  
     function get_pilihanobat_datatable()
     {
         $get = $this->input->get();
         $this->_get_query_pilihanobat();
         if($get['length'] != -1)
         $this->db->limit($get['length'], $get['start']);
         $query = $this->db->get();
         return $query->result();
     }
  
     function count_filtered_datatable_pilihanobat()
     {
         $this->_get_query_pilihanobat();
         $query = $this->db->get();
         return $query->num_rows();
     }
  
     public function count_all_datatable_pilihanobat()
     {
         $this->db->where('jenis = "obat"')->from('master_item');
         return $this->db->count_all_results();
     } 
     //datatable pilihan obat end

      // datatable racikan start
    var $column_search_dataracikan = array('kode_item','nama_item','harga_jual','upah_peracik','aturan_pakai'); 
    var $column_order_dataracikan = array(null, 'kode_item','nama_item','harga_jual','upah_peracik','aturan_pakai');
    var $order_dataracikan = array('waktu_update' => 'DESC');
    private function _get_query_dataracikan()
    { 
        $get = $this->input->get();
        $this->db->where('jenis','racikan'); 
        $this->db->from('master_item'); 
        $i = 0; 
        foreach ($this->column_search_dataracikan as $item)
        {
            if($get['search']['value'])
            { 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $get['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $get['search']['value']);
                }
 
                if(count($this->column_search_dataracikan) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_dataracikan[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_dataracikan))
        {
            $order = $this->order_dataracikan;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_dataracikan_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_dataracikan();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_dataracikan()
    {
        $this->_get_query_dataracikan();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_dataracikan()
    {
        $this->db->where('jenis','racikan'); 
        $this->db->from('master_item');
        return $this->db->count_all_results();
    } 
    //datatable racikan end
    
    //CRUD racikan start
    public function get_dataracikan($idd){ 
        $this->db->select("a.kode_obat, a.jumlah_obat_dibuat, a.jumlah_obat_dipakai, b.nama_item");
        $this->db->from("master_racikan a");
        $this->db->join('master_item b', 'a.kode_obat = b.kode_item AND a.kode_racikan="'.$idd.'"');  
        return $this->db->get()->result();
    }
    
    function simpandataracikan(){   
        $post = $this->input->post();   
        $array = array(
            'kode_item'=>$post["kode_item"], 
            'jenis'=>'racikan', 
            'kategori'=>$post["kategori"],  
            'satuan'=>$post["satuan"], 
            'nama_item'=>$post["nama_item"], 
            'upah_peracik'=>bilanganbulat($post["upah_peracik"]), 
            'aturan_pakai'=>$post["aturan_pakai"], 
            'keterangan'=>$post["keterangan"],  
            'gambar'=>$this->_uploadGambarProduk(),  
            'harga_jual'=>bilanganbulat($post["harga_jual"]), 
        ); 
        
        $this->db->insert("master_item", $array);  
        $kode_item = $this->input->post("kode_item");   
        $kode_obat = $this->input->post("kode_obat");   
        $jumlah_obat_dibuat = $this->input->post("jumlah_obat_dibuat"); 
        $jumlah_obat_dipakai = $this->input->post("jumlah_obat_dipakai"); 
        for($i = 0; $i < count($kode_obat); $i++){         
            $listobat = array(
                'kode_racikan'=>$kode_item,  
                'kode_obat'=>$kode_obat[$i],  
                'jumlah_obat_dibuat'=>$jumlah_obat_dibuat[$i],  
                'jumlah_obat_dipakai'=>$jumlah_obat_dipakai[$i],  
            );   
            $this->db->insert("master_racikan", $listobat);  
        }
        return TRUE;
    }    
    public function hapusdataracikan()
    {
        $post = $this->input->post(); 
        $this->_hapusGambarProduk($post['idd']);
        $this->db->where('kode_item', $post['idd']);
        return $this->db->delete('master_item');  
    }
    public function updatedataracikan()
    {
        $post = $this->input->post();
        $this->kode_item = $post["kode_item"]; 
        $this->kategori = $post["kategori"];
        $this->satuan = $post["satuan"]; 
        $this->nama_item = $post["nama_item"]; 
        $this->upah_peracik = bilanganbulat($post["upah_peracik"]);  
        $this->aturan_pakai = $post["aturan_pakai"];    
        $this->keterangan = $post["keterangan"];    
        $this->harga_jual = bilanganbulat($post["harga_jual"]);            
        if (!empty($_FILES["gambar"]["name"])) {
            $this->gambar = $this->_uploadGambarProduk();
        }   
        $this->db->update("master_item", $this, array('kode_item' => $post['idd']));
        $this->db->where('kode_racikan', $post['idd'])->delete('master_racikan'); 
        $kode_item = $this->input->post("kode_item");   
        $kode_obat = $this->input->post("kode_obat");   
        $jumlah_obat_dibuat = $this->input->post("jumlah_obat_dibuat"); 
        $jumlah_obat_dipakai = $this->input->post("jumlah_obat_dipakai"); 
        for($i = 0; $i < count($kode_obat); $i++){         
            $listobat = array(
                'kode_racikan'=>$kode_item,  
                'kode_obat'=>$kode_obat[$i],  
                'jumlah_obat_dibuat'=>$jumlah_obat_dibuat[$i],  
                'jumlah_obat_dipakai'=>$jumlah_obat_dipakai[$i],  
            );   
            $this->db->insert("master_racikan", $listobat);  
        }
        return TRUE;
    }  
}
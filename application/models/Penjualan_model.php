<?php

require './mike42/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector; 

class Penjualan_model extends CI_Model{  
    
    public function data_diskon(){ 
        $this->db->select("a.id, a.kode_item, a.min_kuantiti,
         a.diskon, a.tanggal_berakhir, b.nama_item");
        $this->db->from("master_diskon_kelipatan a");
        $this->db->join('master_item b', 'b.kode_item = a.kode_item');  
        return $this->db->get()->result_array();
    }

    public function rulesdiskon()
    {
        return [
            [
            'field' => 'kode_item',
            'label' => 'Kode Produk',
            'rules' => 'is_unique[master_diskon_kelipatan.kode_item]|required',
            ] ,
            [
            'field' => 'min_kuantiti',
            'label' => 'Minimum kuantiti',
            'rules' => 'required',
            ] ,
            [
            'field' => 'diskon',
            'label' => 'Diskon',
            'rules' => 'required',
            ] 
        ];
    }  

    function simpandatadiskon(){   
        $post = $this->input->post();    
        $array = array(
            'kode_item'=>$post["kode_item"],  
            'min_kuantiti'=>$post["min_kuantiti"],   
            'diskon'=>bilanganbulat($post["diskon"]), 
            'tanggal_berakhir'=>$post["tanggal_berakhir"] 
        );  
        $this->db->insert("master_diskon_kelipatan", $array);   
        return TRUE;
    }    

    public function hapusdatadiskon()
    {
        $post = $this->input->post();    
        return $this->db->where('id', $post['idd'])->delete('master_diskon_kelipatan');   
    }
    
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('master_item');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            $this->db->like('nama_item',$params['search']['keywords']);
        }
        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('nama_item',$params['search']['sortBy']);
        }else{
            $this->db->order_by('kode_item','desc');
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return $query->result_array();
    }


    // datatable databank start
    var $column_search_databank = array('jenis','singkatan','nama_bank'); 
    var $column_order_databank = array(null, 'jenis','singkatan','nama_bank');
    var $order_databank = array('waktu_update' => 'DESC');
    private function _get_query_databank()
    { 
        $get = $this->input->get();
        $this->db->from('master_bank'); 
        $i = 0; 
        foreach ($this->column_search_databank as $item)
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
 
                if(count($this->column_search_databank) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_databank[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_databank))
        {
            $order = $this->order_databank;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_databank_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_databank();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_databank()
    {
        $this->_get_query_databank();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_databank()
    {
        $this->db->from('master_bank');
        return $this->db->count_all_results();
    } 
    //datatable databank end

    	// CRUD data bank start
        public function rulesbank()
        {
            return [
                [
                'field' => 'singkatan',
                'label' => 'singkatan bank',
                'rules' => 'required',
                ] ,
                [
                'field' => 'nama_bank',
                'label' => 'nama bank',
                'rules' => 'required',
                ] 
            ];
        } 
        function simpandatabank(){   
            $post = $this->input->post();   
            $array = array(
                'singkatan'=>$post["singkatan"], 
                'nama_bank'=>$post["nama_bank"], 
                'jenis'=>$post["jenis"],   
            );
            return $this->db->insert("master_bank", $array);   
        } 

        public function updatedatabank()
        {
            $post = $this->input->post();
            $this->singkatan = $post["singkatan"];
            $this->nama_bank = $post["nama_bank"];
            $this->jenis = $post["jenis"]; 
            return $this->db->update("master_bank", $this, array('singkatan' => $post['idd']));
        }

        public function hapusdatabank()
        {
            $post = $this->input->post();
            $this->db->where('singkatan', $post['idd']);
            return $this->db->delete('master_bank');
        }
            // CRUD supplier end


    public function stokracikan($kode){ 
        $this->db->select("a.kode_racikan, b.stok");
        $this->db->from("master_racikan a");
        $this->db->join('master_item b', 'a.kode_racikan = "'.$kode.'" AND b.kode_item = a.kode_obat AND b.stok < 1');  
        if($this->db->get()->num_rows() > 0){
            return '0';
        }else{
            return '1';
        }
    }
    private function diskon_produk($kodeproduk,$kuantiti){ 
        $datadiskon = $this->db->select('*')->from('master_diskon_kelipatan')->where('kode_item',$kodeproduk)->where('tanggal_berakhir >=',date('Y-m-d'))->get();     
        if($datadiskon->num_rows() < 1){
            return '0';
        }else{
            if($kuantiti >= $datadiskon->row()->min_kuantiti){ 
                return $datadiskon->row()->diskon;
            } else{ 
                return '0';
            }
        }
    }
    private function updatekeranjang($idkeranjang){
        $total_upah_peracik = $this->db->select('SUM(upah_peracik) as total')->from('keranjang_detail')->where('id_keranjang ="'.$idkeranjang.'"')->get()->row();
        $total_harga_item = $this->db->select('SUM((harga*kuantiti) -(diskon*kuantiti)) as total')->from('keranjang_detail')->where('id_keranjang ="'.$idkeranjang.'"')->get()->row();
        $total_semua = $this->db->select('SUM(total) as total')->from('keranjang_detail')->where('id_keranjang ="'.$idkeranjang.'"')->get()->row();       
        $total = $total_semua->total +  $total_upah_peracik->total;
        $array = array(
            'total_upah_peracik'=>$total_upah_peracik->total, 
            'total_harga_item'=>$total_harga_item->total, 
            'total'=>$total,  
        );
        $this->db->update("keranjang", $array,array('id' => $idkeranjang ));
    }
    private function simpan_keranjang($idkeranjang,$kodeproduk,$kuantiti,$racikan){  
        $produk = $this->db->get_where('master_item', array('kode_item' => $kodeproduk),1);
        $query = $this->db->get_where('keranjang_detail', array('id_keranjang' => $idkeranjang,'kode_item' => $kodeproduk),1);
        if($query->num_rows() < 1){ 
            $diskon =  $this->diskon_produk($kodeproduk,1); 
            $upah_peracik = $produk->row()->upah_peracik;
            $harga = $produk->row()->harga_jual; 
            $total = ( $harga * $kuantiti) - ($diskon * $kuantiti); 
            $array = array(
                'id_keranjang'=>$idkeranjang, 
                'kode_item'=>$kodeproduk, 
                'racikan'=>$racikan,  
                'upah_peracik'=>$upah_peracik, 
                'harga'=> $harga,   
                'diskon'=> $diskon,   
                'kuantiti'=> $kuantiti,   
                'total'=> $total,   
            );
            $this->db->insert("keranjang_detail", $array); 
            $this->updatekeranjang($idkeranjang);
            return TRUE;
        }else{
            $kuantiti = $query->row()->kuantiti + $kuantiti;
            $diskon =  $this->diskon_produk($kodeproduk,$kuantiti); 
            $upah_peraciktotal = $produk->row()->upah_peracik * $kuantiti;
            $upah_peracik = $produk->row()->upah_peracik;
            $harga = $produk->row()->harga_jual; 
            $total = ( $harga * $kuantiti) - ($diskon * $kuantiti); 
            $this->racikan = $racikan;
            $this->upah_peracik = $upah_peraciktotal;
            $this->harga = $harga;
            $this->diskon = $diskon; 
            $this->kuantiti = $kuantiti; 
            $this->total = $total; 
            $this->db->update("keranjang_detail", $this, array('id_keranjang' => $idkeranjang ,'kode_item' => $kodeproduk));   
            $this->updatekeranjang($idkeranjang);
            return TRUE; 
        }
    }
    public function tambahkeranjang($idd){ 
        $query = $this->db->get_where('keranjang_detail', array('id' => $idd),1);
        $idkeranjang = $query->row()->id_keranjang;
        $produk = $this->db->get_where('master_item', array('kode_item' => $query->row()->kode_item),1);     
        $kuantiti = $query->row()->kuantiti + 1;
        $diskon =  $this->diskon_produk($query->row()->kode_item,$kuantiti); 
        $upah_peraciktotal = $produk->row()->upah_peracik * $kuantiti;
        $upah_peracik = $produk->row()->upah_peracik;
        $harga = $produk->row()->harga_jual; 
        $total = ( $harga * $kuantiti) - ($diskon * $kuantiti); 
        $this->upah_peracik = $upah_peraciktotal;
        $this->harga = $harga;
        $this->diskon = $diskon; 
        $this->kuantiti = $kuantiti; 
        $this->total = $total; 
        $this->db->update("keranjang_detail", $this, array('id' => $idd ,'kode_item' => $query->row()->kode_item));    
        $this->updatekeranjang($idkeranjang);
        return TRUE; 
    }

    public function kurangkeranjang($idd){ 
        $query = $this->db->get_where('keranjang_detail', array('id' => $idd),1); 
        $idkeranjang = $query->row()->id_keranjang;
        if($query->row()->kuantiti > 1){  
        $produk = $this->db->get_where('master_item', array('kode_item' => $query->row()->kode_item),1);     
        $kuantiti = $query->row()->kuantiti - 1;
        $diskon =  $this->diskon_produk($query->row()->kode_item,$kuantiti); 
        $upah_peraciktotal = $produk->row()->upah_peracik * $kuantiti;
        $upah_peracik = $produk->row()->upah_peracik;
        $harga = $produk->row()->harga_jual; 
        $total = ( $harga * $kuantiti) - ($diskon * $kuantiti); 
        $this->upah_peracik = $upah_peraciktotal;
        $this->harga = $harga;
        $this->diskon = $diskon; 
        $this->kuantiti = $kuantiti; 
        $this->total = $total; 
        $this->db->update("keranjang_detail", $this, array('id' => $idd ,'kode_item' => $query->row()->kode_item));    
        $this->updatekeranjang($idkeranjang);
        }else{ 
            $this->db->where('id', $idd)->delete('keranjang_detail');
            $this->updatekeranjang($idkeranjang);
        }
        return TRUE; 
    }

    public function hapuskeranjang($idd){ 
        $query = $this->db->get_where('keranjang_detail', array('id' => $idd),1);  
        $idkeranjang = $query->row()->id_keranjang;  
        $this->db->where('id', $idd)->delete('keranjang_detail'); 
        $this->updatekeranjang($idkeranjang); 
        return TRUE; 
    }
    public function cek_keranjang($kode,$pembeli,$racikan){ 
        if($pembeli==''){
            $pembeli = NULL;
        }
        $query = $this->db->get_where('keranjang', array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')),1);
        if($query->num_rows() < 1){
            $array = array(
                'token'=>$this->security->get_csrf_hash(), 
                'tanggal_jam'=>date('Y-m-d h:i:s'), 
                'id_admin'=>$this->session->userdata('idadmin'),  
                'id_pembeli'=>$pembeli, 
                'total_upah_peracik'=> '0', 
                'total_harga_item'=>'0',  
                'total'=>'0', 
                'hold'=>'0', 
            );
            $this->db->insert("keranjang", $array);  
            $idkeranjang = $this->db->insert_id();
            $this->simpan_keranjang($idkeranjang,$kode,1,$racikan);  
        }else{ 
            $idkeranjang = $query->row()->id;
            $this->simpan_keranjang($idkeranjang,$kode,1,$racikan); 
        }
    }

    public function get_keranjang(){ 
        return $this->db->get_where('keranjang', array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')),1);
    }  
    public function detail_keranjang($idd){ 
        $this->db->select("a.nama_item, a.satuan, b.kode_item, a.jenis, b.id, b.kuantiti, b.diskon, b.harga, b.upah_peracik ,b.total");
        $this->db->from("master_item a");
        $this->db->join('keranjang_detail b', 'b.kode_item = a.kode_item');  
        $this->db->where('b.id_keranjang', $idd); 
        $this->db->order_by('b.id', 'DESC'); 
        return $this->db->get();
    }

    public function rulesholdtransaksi()
    {
        return [
            [
            'field' => 'keterangan_hold',
            'label' => 'Keterangan',
            'rules' => 'required',
            ]  
        ];
    } 
    public function holdtransaksi(){ 
        $post = $this->input->post(); 
        $this->hold = '1';    
        $this->keterangan_hold = $post['keterangan_hold']; 
        $this->waktu_hold = time();    
        return $this->db->update("keranjang", $this, array('hold' => '0','token' => $this->security->get_csrf_hash() ,'id_admin' => $this->session->userdata('idadmin')));
    }

    public function bukaholdtransaksi($idkeranjang){  
        $this->hold = '0';     
        return $this->db->update("keranjang", $this, array('id' => $idkeranjang, 'hold' => '1','token' => $this->security->get_csrf_hash() ,'id_admin' => $this->session->userdata('idadmin')));
    }

    public function bankjenis($jenis){ 
        return $this->db->get_where('master_bank', array('jenis' => $jenis));
    }  

    
    private function _kode_penjualan()
    { 
        $jumlah = $this->db->select('*')->from('penjualan')->get()->num_rows();
        $jml_baru = $jumlah + 1; 
        $kode = sprintf("%06s", $jml_baru);
        $kode = date('dmy').$kode;
        $cek_ada = $this->db->select('*')->from('penjualan')->where('id ="'. $kode.'"')->get()->num_rows();
        if($cek_ada > 0){
            return $this->_kode_penjualan();
        }else{
            return $kode ;
        } 
    }
    function submitpayment(){   
        $post = $this->input->post();   
        $keranjang = $this->db->get_where('keranjang', array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')),1);
        $kode_penjualan = $this->_kode_penjualan();
        $array = array(
            'id'=> $kode_penjualan, 
            'id_pembeli'=> $keranjang->row()->id_pembeli, 
            'id_admin'=> $this->session->userdata('idadmin') ,  
            'total_upah_peracik'=> $keranjang->row()->total_upah_peracik, 
            'total_harga_item'=> $keranjang->row()->total_harga_item, 
            'total'=> $keranjang->row()->total, 
            'tanggal'=> date('Y-m-d'), 
            'tanggal_jam'=> date('Y-m-d H:i:s'),  
            'retur'=>'0'  
        );  
        $this->db->insert("penjualan", $array);   
        $cashinout = array(
            'kode_rekening'=> '10001', 
            'tanggal'=> date('Y-m-d'), 
            'masuk'=> $keranjang->row()->total, 
            'id_penjualan'=> $kode_penjualan ,   
        ); 
        $this->db->insert("cash_in_out", $cashinout);   

        $cara_bayar_1 = $post['cara_bayar'][0];
        if($cara_bayar_1 == 'cash'){ 
            $pembayaran_1 = array(
                'id_penjualan'=> $kode_penjualan, 
                'nominal'=> bilanganbulat($post['totaldibayar'][0]), 
                'cara_bayar'=> $cara_bayar_1,  
                'catatan'=> $post['catatan'][0],  
            );
            $this->db->insert("penjualan_pembayaran", $pembayaran_1); 
        }else{ 
            $pembayaran_1 = array(
                'id_penjualan'=> $kode_penjualan, 
                'nominal'=> bilanganbulat($post['totaldibayar'][0]), 
                'cara_bayar'=> $cara_bayar_1,  
                'swipe'=> $post['swipe'][0],  
                'card_no'=> $post['card_no'][0],  
                'holder_name'=> $post['holder_name'][0],  
                'bank'=> $post['bank'][0],  
                'month'=> $post['month'][0],  
                'year'=> $post['year'][0],  
                'security_code'=> $post['security_code'][0],  
                'catatan'=> $post['catatan'][0],  
            );
            $this->db->insert("penjualan_pembayaran", $pembayaran_1); 
        }
        
        $totaldibayar_2 = bilanganbulat($post['totaldibayar'][1]);
        if($totaldibayar_2 > 0 ){ 
        $cara_bayar_2 = $post['cara_bayar'][1];
        if($cara_bayar_2 == 'cash'){ 
            $pembayaran_2 = array(
                'id_penjualan'=> $kode_penjualan, 
                'nominal'=> bilanganbulat($totaldibayar_2), 
                'cara_bayar'=> $cara_bayar_2,  
                'catatan'=> $post['catatan'][1],  
            );
            $this->db->insert("penjualan_pembayaran", $pembayaran_2); 
            }else{ 
                $pembayaran_2 = array(
                    'id_penjualan'=> $kode_penjualan, 
                    'nominal'=> bilanganbulat($totaldibayar_2), 
                    'cara_bayar'=> $cara_bayar_2,  
                    'swipe'=> $post['swipe'][1],  
                    'card_no'=> $post['card_no'][1],  
                    'holder_name'=> $post['holder_name'][1],  
                    'bank'=> $post['bank'][1],  
                    'month'=> $post['month'][1],  
                    'year'=> $post['year'][1],  
                    'security_code'=> $post['security_code'][1],  
                    'catatan'=> $post['catatan'][1],  
                );
                $this->db->insert("penjualan_pembayaran", $pembayaran_2); 
            }
        } 

        
        $items = [];
        $detailkeranjang = $this->detail_keranjang($keranjang->row()->id);  
        foreach($detailkeranjang->result_array() as $r) {    
            $stok = $this->db->order_by('tgl_expired','ASC')->get_where('kartu_stok', array('kode_item' => $r['kode_item']),1);

            $nama_produk = $this->db->get_where('master_item', array('kode_item' => $r['kode_item']),1)->row()->nama_item;
            $harga = rupiah($r['total']);
            $items[] = [
                'name' => $nama_produk, 
                'total_price' => $harga, 
            ];
            $keranjangdetail_input = array(
                'id_penjualan'=> $kode_penjualan, 
                'kode_item'=> $r['kode_item'],  
                'racikan'=> $r['jenis'] == 'racikan' ? '1' : '0',  
                'upah_peracik'=> $r['upah_peracik'],  
                'harga'=> $r['harga'],  
                'diskon'=> $r['diskon'],    
                'kuantiti'=> $r['kuantiti'],   
                'total'=> $r['total'],  
            );
            $this->db->insert("penjualan_detail", $keranjangdetail_input);  
            if($r['jenis'] != 'racikan'){ 
                $stok_input = array(
                    'id_penjualan'=> $kode_penjualan, 
                    'kode_item'=> $r['kode_item'],  
                    'tanggal'=> date('Y-m-d'),  
                    'jenis_transaksi'=> 'penjualan',   
                    'jumlah_keluar'=> $r['kuantiti'],   
                    'satuan_kecil'=> $r['satuan'],  
                    'tgl_expired'=> $stok->row()->tgl_expired,  
                ); 
                $this->db->insert("kartu_stok", $stok_input); 
                $this->db->set('stok', 'stok - ' . (int) $r['kuantiti'], FALSE)->where('kode_item', $r['kode_item'])->update('master_item');   
            }else{
                $racikan = $this->db->get_where('master_racikan', array('kode_racikan' => $r['kode_item']));
                foreach($racikan->result_array() as $racik) { 
                    $stok = $this->db->order_by('tgl_expired','ASC')->get_where('kartu_stok', array('kode_item' => $racik['kode_obat']),1);
                    $jumlah = $r['kuantiti'] * $racik['jumlah_obat_dipakai'];
                    $stok_input = array(
                        'id_penjualan'=> $kode_penjualan, 
                        'kode_item'=> $racik['kode_obat'],  
                        'tanggal'=> date('Y-m-d'),  
                        'jenis_transaksi'=> 'penjualan',   
                        'jumlah_keluar'=> $jumlah,   
                        'satuan_kecil'=> $r['satuan'],  
                        'tgl_expired'=> $stok->row()->tgl_expired,  
                    ); 
                    $this->db->insert("kartu_stok", $stok_input); 
                    $this->db->set('stok', 'stok - ' . (int) $jumlah, FALSE)->where('kode_item', $racik['kode_obat'])->update('master_item');  
                }
            }

        }     
		
        $profil = $this->db->get_where('profil_apotek', array('id' => '1')); 

        $date = tgl_indo(date('Y-m-d')) ." ".date('H:i:s'); 
		
		/* Printer  Start  (hapus baris ini, kalau sudah ada printer thermalnya)
		
        // Fill in your own connector here  
        $connector = new WindowsPrintConnector("KASIR"); 
        // Start the printer  
        $printer = new Printer($connector); 

        function addSpaces($string = '', $valid_string_length = 0) {
            if (strlen($string) < $valid_string_length) {
                $spaces = $valid_string_length - strlen($string);
                for ($index1 = 1; $index1 <= $spaces; $index1++) {
                    $string = $string . ' ';
                }
            } 
            return $string;
        } 

		// logo  
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load("assets/images/cetaklogo.png", false);
        $printer -> bitImage($logo);
        

        // judul bawah logo  
        $printer -> text($profil->row()->alamat);
        $printer -> feed(2); 
        
        // belanjaan  
        $printer->feed();
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(addSpaces('Item', 22) . addSpaces('Total', 20) . "\n");
        $printer->setEmphasis(false);  
        foreach ($items as $item) { 
            $name_lines = str_split($item['name'], 18);
            foreach ($name_lines as $k => $l) {
                $l = trim($l);
                $name_lines[$k] = addSpaces($l, 20);
            }
        
            $total_price = str_split($item['total_price'], 15);
            foreach ($total_price as $k => $l) {
                $l = trim($l);
                $total_price[$k] = addSpaces($l, 14);
            } 
            $counter = 0;
            $temp = [];
            $temp[] = count($name_lines); 
            $temp[] = count($total_price);
            $counter = max($temp);

            for ($i = 0; $i < $counter; $i++) {
                $line = '';
                if (isset($name_lines[$i])) {
                    $line .= ($name_lines[$i]);
                } 
                if (isset($total_price[$i])) {
                    $line .= ($total_price[$i]);
                }
                $printer->text($line . "\n");
            } 
            $printer->feed(2); 
        }
        
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(addSpaces('Sub Total', 20) . addSpaces(rupiah($keranjang->row()->total_harga_item), 14) . "\n");
        $printer->setEmphasis(false);   
        
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(addSpaces('Upah Peracik', 20) . addSpaces(rupiah($keranjang->row()->total_upah_peracik), 14) . "\n");
        $printer->setEmphasis(false);   
        
        $printer->setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(addSpaces('Total', 20) . addSpaces(rupiah($keranjang->row()->total), 14) . "\n");
        $printer->setEmphasis(false);   

        // barcode  
        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        $printer->barcode($kode_penjualan, Printer::BARCODE_JAN13);
        $printer -> feed(2);

        //Footer  
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text($profil->row()->footer_struk."\n"); 
        $printer -> feed();
        $printer -> text($date . "\n");
        $printer->feed(2); 

        // Cut the receipt and open the cash drawer  
        $printer -> cut();
        $printer -> pulse(); 
        $printer -> close();
		
		Printer END (hapus baris ini, kalau sudah ada printer thermalnya) */
  

        return $this->db->where('id', $keranjang->row()->id)->delete('keranjang');
    }    
}
<?php
class Pembelian_model extends CI_Model{  
    
     // datatable pilihan item start
     var $column_search_pilihanitem = array('kode_item','nama_item','kategori','satuan'); 
     var $column_order_pilihanitem = array('kode_item','nama_item','kategori','satuan',null);
     var $order_pilihanitem = array('waktu_update' => 'DESC');
     private function _get_query_pilihanitem()
     { 
         $get = $this->input->get();
         $this->db->where('jenis != "racikan"')->from('master_item');
         $i = 0; 
         foreach ($this->column_search_pilihanitem as $item)
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
  
                 if(count($this->column_search_pilihanitem) - 1 == $i) 
                     $this->db->group_end(); 
             }
             $i++;
         } 
         if(isset($get['order'])) 
         {
             $this->db->order_by($this->column_order_pilihanitem[$get['order']['0']['column']], $get['order']['0']['dir']);
         } 
         else if(isset($this->order_pilihanitem))
         {
             $order = $this->order_pilihanitem;
             $this->db->order_by(key($order), $order[key($order)]);
         }
     }
  
     function get_pilihanitem_datatable()
     {
         $get = $this->input->get();
         $this->_get_query_pilihanitem();
         if($get['length'] != -1)
         $this->db->limit($get['length'], $get['start']);
         $query = $this->db->get();
         return $query->result();
     }
  
     function count_filtered_datatable_pilihanitem()
     {
         $this->_get_query_pilihanitem();
         $query = $this->db->get();
         return $query->num_rows();
     }
  
     public function count_all_datatable_pilihanitem()
     {
         $this->db->where('jenis != "racikan"')->from('master_item');
         return $this->db->count_all_results();
     } 
     //datatable pilihan item end

	// datatable purchase order start
    function getallpo(){   
        $tombolhapus = level_user('pembelian','po',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="$2">Hapus</a></li>':'';
        $tomboledit = level_user('pembelian','po',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="$2">Edit</a></li>':'';
        
        $this->datatables->select('nomor_po,tgl_po,pembayaran,
		termin,id,nama_supplier');
        $this->datatables->from('purchase_order');
        $this->datatables->join('master_supplier', 'supplier=id');
        $this->datatables->add_column('tombol', 
		'	<div class="btn-group dropup">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" onclick="detail(this)"  data-id="$2">Detail</a></li>
                    '.$tomboledit.'
                    '.$tombolhapus.'
				</ul>
			</div>
		','tgl_po,nomor_po,pembayaran,nama_supplier,termin'); 
        $this->datatables->edit_column('tgl_po','$1', 'tgl_indo(tgl_po)'); 
        return $this->datatables->generate();
    }  
	// datatable purchase order end 
	
	// CRUD purchase order start 
	public function get_po($idd){ 
        $this->db->select("a.nomor_po, a.tgl_po, a.total, a.termin, a.pembayaran, a.supplier, a.keterangan, b.nama_supplier, b.telepon, b.alamat");
        $this->db->from("purchase_order a");
        $this->db->join('master_supplier b', 'a.supplier = b.id'); 
        $this->db->where('a.nomor_po', $idd,'1'); 
        return $this->db->get()->result_array();
    }  

    private function _kode_po()
    { 
        $jumlah = $this->db->select('*')->from('purchase_order')->get()->num_rows();
        $jml_baru = $jumlah + 1; 
        $kode = sprintf("%04s", $jml_baru);
        $kode = "PO".date('dmy').$kode;
        $cek_ada = $this->db->select('*')->from('purchase_order')->where('nomor_po ="'. $kode.'"')->get()->num_rows();
        if($cek_ada > 0){
            return $this->_kode_po();
        }else{
            return $kode ;
        } 
    }

    public function detail_po($idd){ 
        return $this->db->get_where('purchase_order_detail', array('nomor_po' => $idd)); 
    } 
    public function data_profil(){ 
        return $this->db->get_where('profil_apotek', array('id' => '1')); 
    }  
    public function rulespo()
    {
        return [
            [
            'field' => 'tgl_po',
            'label' => 'Tanggal PO',
            'rules' => 'required',
            ] ,
            [
            'field' => 'termin',
            'label' => 'Termin',
            'rules' => 'required',
            ] 
        ];
    } 
    
    function povalid($nomor_po){   
        return  $this->db->get_where(
            'purchase_order',array(
                'nomor_po' => $nomor_po, 
            )
        ); 
    }   
    
    function simpandatapo(){   
        $post = $this->input->post(); 
        $kodepo = $this->_kode_po();
        if($post['termin'] < 1 || $post["pembayaran"] == 'cash'){
            $post['termin'] = 0; $post["pembayaran"] = 'cash';
        }
        if($post['termin'] > 0 && $post["pembayaran"] == 'cash'){
            $post["pembayaran"] = 'hutang';
        }
        $array = array(
            'nomor_po'=> $kodepo, 
            'tgl_po'=>$post["tgl_po"],  
            'termin'=>$post["termin"], 
            'pembayaran'=>$post["pembayaran"], 
            'supplier'=>$post["supplier"], 
            'keterangan'=>$post["keterangan"],  
            'termin'=>$post['termin'],  
        );  
        $this->db->insert("purchase_order", $array);  
        $nomor_po = $kodepo;   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");    
        $harga = bilanganbulat($this->input->post("harga"));    
        $satuan_besar = $this->input->post("satuan_besar");    
        $satuan_kecil = $this->input->post("satuan_kecil");    
        $konversi = $this->input->post("konversi");    
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));    
        $diskon = $this->input->post("diskon");    
        $total = 0;
        for($i = 0; $i < count($kode_item); $i++){         
            $diskon[$i] = floatval($diskon[$i]);
            $total_harga[$i] =  ($kuantiti[$i]*$konversi[$i]*$harga[$i])-(($kuantiti[$i]*$konversi[$i]*$harga[$i])*($diskon[$i]/100));    
            $listitem = array(
                'nomor_po'=>$nomor_po,  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],  
                'harga'=>$harga[$i],  
                'satuan_besar'=>$satuan_besar[$i],  
                'satuan_kecil'=>$satuan_kecil[$i],  
                'konversi'=>$konversi[$i],  
                'kuantiti'=>$kuantiti[$i],  
                'total_harga'=>$total_harga[$i],  
                'diskon'=>$diskon[$i],  
            );  
            $total = $total + $total_harga[$i]; 
            $this->db->insert("purchase_order_detail", $listitem);  
        } 
        $this->total = $total;
        $this->db->update("purchase_order", $this, array('nomor_po' => $nomor_po));
        return TRUE;
    }    
     
    public function updatedatapo()
    {
        $post = $this->input->post();   
        if($post['termin'] < 1 || $post["pembayaran"] == 'cash'){
            $post['termin'] = 0; $post["pembayaran"] = 'cash';
        }
        if($post['termin'] > 0 && $post["pembayaran"] == 'cash'){
            $post["pembayaran"] = 'hutang';
        }
        $this->nomor_po = $post["nomor_po"]; 
        $this->tgl_po = $post["tgl_po"];
        $this->termin = $post["termin"]; 
        $this->pembayaran = $post["pembayaran"]; 
        $this->supplier = $post["supplier"];    
        $this->keterangan = $post["keterangan"];      
        $this->termin = $post["termin"];         
        $this->db->update("purchase_order", $this, array('nomor_po' => $post['idd']));
        $this->db->where('nomor_po', $post['idd'])->delete('purchase_order_detail');  
        $nomor_po = $this->input->post("nomor_po");   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");    
        $harga = bilanganbulat($this->input->post("harga"));    
        $satuan_besar = $this->input->post("satuan_besar");    
        $satuan_kecil = $this->input->post("satuan_kecil");    
        $konversi = $this->input->post("konversi");    
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));    
        $diskon = $this->input->post("diskon");    
        $total = 0;
        for($i = 0; $i < count($kode_item); $i++){         
            $diskon[$i] = floatval($diskon[$i]);
            $total_harga[$i] =  ($kuantiti[$i]*$konversi[$i]*$harga[$i])-(($kuantiti[$i]*$konversi[$i]*$harga[$i])*($diskon[$i]/100));    
            $listitem = array(
                'nomor_po'=>$nomor_po,  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],  
                'harga'=>$harga[$i],  
                'satuan_besar'=>$satuan_besar[$i],  
                'satuan_kecil'=>$satuan_kecil[$i],  
                'konversi'=>$konversi[$i],  
                'kuantiti'=>$kuantiti[$i],  
                'total_harga'=>$total_harga[$i],  
                'diskon'=>$diskon[$i],  
            );  
            $total = $total + $total_harga[$i]; 
            $this->db->insert("purchase_order_detail", $listitem);  
        } 
        $this->total = $total;
        $this->db->update("purchase_order", $this, array('nomor_po' => $post['nomor_po']));
        return TRUE;
    }

    public function hapusdatapo()
    {
        $post = $this->input->post();  
        $this->db->where('nomor_po', $post['idd']);
        return $this->db->delete('purchase_order');  
    }
    // CRUD purchase order end
	
    //datatable pembelian start
    function getallpembelian(){   
        $tombolhapus = level_user('pembelian','langsung',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="$2">Hapus</a></li>':'';
        $tomboledit = level_user('pembelian','langsung',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="$2">Edit</a></li>':'';
        $this->datatables->select('nomor_faktur,tgl_pembelian,pembayaran,
		termin,id,nama_supplier');
        $this->datatables->from('pembelian_langsung');
        $this->datatables->join('master_supplier', 'supplier=id');
        $this->datatables->add_column('tombol', 
		'	<div class="btn-group dropup">
				<button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" onclick="detail(this)"  data-id="$2">Detail</a></li>
                    '.$tomboledit.'
                    '.$tombolhapus.'
				</ul>
			</div>
		','tgl_pembelian,nomor_faktur,pembayaran,nama_supplier,termin'); 
        $this->datatables->edit_column('tgl_pembelian','$1', 'tgl_indo(tgl_pembelian)'); 
        return $this->datatables->generate();
    }   
    //datatable pembelian end
	
    //CRUD pembelian end
	    public function rulespembelian()
    {
        return [
            [
            'field' => 'tgl_pembelian',
            'label' => 'Tanggal pembelian',
            'rules' => 'required',
            ] 
        ];
    } 
    private function _kode_pembelian()
    {   
        $jumlah = $this->db->select('*')->from('pembelian_langsung')->get()->num_rows();
        $jml_baru = $jumlah + 1; 
        $kode = sprintf("%04s", $jml_baru);
        $kode = "F".date('dmy').$kode;
        $cek_ada = $this->db->select('*')->from('pembelian_langsung')->where('nomor_faktur ="'. $kode.'"')->get()->num_rows();
        if($cek_ada > 0){
            return $this->_kode_pembelian();
        }else{
            return $kode ;
        } 
    }
    function simpandatapembelian(){   
        $post = $this->input->post();   
        $nomor_faktur = $this->_kode_pembelian();
        if($post['termin'] < 1 || $post["pembayaran"] == 'cash'){
            $post['termin'] = 0; $post["pembayaran"] = 'cash';
        }
        if($post['termin'] > 0 && $post["pembayaran"] == 'cash'){
            $post["pembayaran"] = 'hutang';
        }
        $array = array(
            'nomor_faktur'=>$nomor_faktur, 
            'tgl_pembelian'=>$post["tgl_pembelian"],  
            'kategori'=>$post["kategori"],  
            'nomor_po'=>$post["nomor_po"],  
            'termin'=>$post["termin"], 
            'pembayaran'=>$post["pembayaran"], 
            'supplier'=>$post["supplier"], 
            'keterangan'=>$post["keterangan"],  
            'termin'=>$post['termin'],  
        );  
        $this->db->insert("pembelian_langsung", $array);   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");    
        $harga = bilanganbulat($this->input->post("harga"));    
        $satuan_besar = $this->input->post("satuan_besar");    
        $satuan_kecil = $this->input->post("satuan_kecil");
        $konversi = $this->input->post("konversi");    
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));    
        $diskon = $this->input->post("diskon");    
        $total = 0;
        for($i = 0; $i < count($kode_item); $i++){         
            $diskon[$i] = floatval($diskon[$i]);
            $total_harga[$i] =  ($kuantiti[$i]*$konversi[$i]*$harga[$i])-(($kuantiti[$i]*$konversi[$i]*$harga[$i])*($diskon[$i]/100));    
            $listitem = array(
                'nomor_faktur'=>$nomor_faktur,  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],  
                'harga'=>$harga[$i],  
                'satuan_besar'=>$satuan_besar[$i],  
                'satuan_kecil'=>$satuan_kecil[$i],  
                'konversi'=>$konversi[$i],  
                'kuantiti'=>$kuantiti[$i],  
                'total_harga'=>$total_harga[$i],  
                'diskon'=>$diskon[$i],  
            );  
            $total = $total + $total_harga[$i]; 
            $this->db->insert("pembelian_langsung_detail", $listitem);  
        } 
        $this->total = $total;
        $this->db->update("pembelian_langsung", $this, array('nomor_faktur' => $nomor_faktur));
        $judul ="pembelian ke supplier";
        $jatuhtempo = $post["tgl_pembelian"];
        if($post["pembayaran"] == "hutang"){ 
            $date = strtotime($jatuhtempo);
            $jatuhtempo = strtotime("+".$post['termin']." day", $date);
            $jatuhtempo = date('Y-m-d', $jatuhtempo);
        }
        $arrayhutang = array(
            'judul'=>$judul, 
            'tanggal'=>$post["tgl_pembelian"],  
            'nominal'=>$total,   
            'nomor_faktur'=>$nomor_faktur,  
            'id_supplier'=>$post["supplier"], 
            'tanggal_jatuh_tempo'=>$jatuhtempo,   
            'keterangan'=>'-',   
        );  
        $this->db->insert("hutang_history", $arrayhutang);   
        return TRUE;
    }    
	
    public function get_pembelian($idd){ 
        $this->db->select("a.nomor_faktur, a.kategori, a.nomor_po, a.tgl_pembelian, a.total, a.termin, a.pembayaran, a.supplier, a.keterangan, b.nama_supplier, b.telepon, b.alamat");
        $this->db->from("pembelian_langsung a");
        $this->db->join('master_supplier b', 'a.supplier = b.id'); 
        $this->db->where('a.nomor_faktur', $idd,'1'); 
        return $this->db->get()->result_array();
    } 
    public function detail_pembelian($idd){ 
        return $this->db->get_where('pembelian_langsung_detail', array('nomor_faktur' => $idd)); 
    } 
      
    public function updatedatapembelian()
    {
        $post = $this->input->post();   
        if($post['termin'] < 1 || $post["pembayaran"] == 'cash'){
            $post['termin'] = 0; $post["pembayaran"] = 'cash';
        }
        if($post['termin'] > 0 && $post["pembayaran"] == 'cash'){
            $post["pembayaran"] = 'hutang';
        }
        $this->nomor_faktur = $post["nomor_faktur"]; 
        $this->tgl_pembelian = $post["tgl_pembelian"];
        $this->kategori = $post["kategori"];
        $this->nomor_po = $post["nomor_po"];
        $this->termin = $post["termin"]; 
        $this->pembayaran = $post["pembayaran"]; 
        $this->supplier = $post["supplier"];    
        $this->keterangan = $post["keterangan"];      
        $this->termin = $post["termin"];         
        $this->db->update("pembelian_langsung", $this, array('nomor_faktur' => $post['idd']));
        $this->db->where('nomor_faktur', $post['idd'])->delete('pembelian_langsung_detail');   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");    
        $harga = bilanganbulat($this->input->post("harga"));    
        $satuan_besar = $this->input->post("satuan_besar");    
        $satuan_kecil = $this->input->post("satuan_kecil");    
        $konversi = $this->input->post("konversi");    
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));    
        $diskon = $this->input->post("diskon");    
        $total = 0;
        for($i = 0; $i < count($kode_item); $i++){         
            $diskon[$i] = floatval($diskon[$i]);
            $total_harga[$i] =  ($kuantiti[$i]*$konversi[$i]*$harga[$i])-(($kuantiti[$i]*$konversi[$i]*$harga[$i])*($diskon[$i]/100));    
            $listitem = array(
                'nomor_faktur'=>$post["nomor_faktur"],  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],  
                'harga'=>$harga[$i],  
                'satuan_besar'=>$satuan_besar[$i],  
                'satuan_kecil'=>$satuan_kecil[$i],  
                'konversi'=>$konversi[$i],  
                'kuantiti'=>$kuantiti[$i],  
                'total_harga'=>$total_harga[$i],  
                'diskon'=>$diskon[$i],  
            );  
            $total = $total + $total_harga[$i]; 
            $this->db->insert("pembelian_langsung_detail", $listitem);  
        } 
        $this->total = $total;
        $this->db->update("pembelian_langsung", $this, array('nomor_faktur' => $post['nomor_faktur']));
        return TRUE;
    }

    public function hapusdatapembelian()
    {
        $post = $this->input->post();  
        $this->db->where('nomor_faktur', $post['idd']);
        return $this->db->delete('pembelian_langsung');  
    }
    //CRUD pembelian end
	
    // datatable penerimaan start
    var $column_search_penerimaan = array('tanggal_penerimaan','nomor_rec','nomor_faktur','penerima'); 
    var $column_order_penerimaan = array(null, 'tanggal_penerimaan','nomor_rec','nomor_faktur','penerima');
    var $order_penerimaan = array('waktu_update' => 'DESC');
    private function _get_query_penerimaan()
    { 
        $get = $this->input->get();
        $this->db->from('penerimaan_barang'); 
        $i = 0; 
        foreach ($this->column_search_penerimaan as $item)
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
 
                if(count($this->column_search_penerimaan) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_penerimaan[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_penerimaan))
        {
            $order = $this->order_penerimaan;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_penerimaan_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_penerimaan();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_penerimaan()
    {
        $this->_get_query_penerimaan();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_penerimaan()
    {
        $this->db->from('penerimaan_barang');
        return $this->db->count_all_results();
    } 
    //datatable penerimaan end
    
    //CRUD penerimaan start
	public function rulespenerimaan()
    {
        return [
            [
            'field' => 'tanggal_penerimaan',
            'label' => 'Tanggal Penerimaan',
            'rules' => 'required',
            ] 
        ];
    } 
    private function _kode_penerimaan()
    {   
        $jumlah = $this->db->select('*')->from('penerimaan_barang')->get()->num_rows();
        $jml_baru = $jumlah + 1; 
        $kode = sprintf("%04s", $jml_baru);
        $kode = "PE".date('dmy').$kode;
        $cek_ada = $this->db->select('*')->from('penerimaan_barang')->where('nomor_rec ="'. $kode.'"')->get()->num_rows();
        if($cek_ada > 0){
            return $this->_kode_penerimaan();
        }else{
            return $kode ;
        } 
    }
    function simpandatapenerimaan(){   
        $post = $this->input->post();    
        $nomor_rec = $this->_kode_penerimaan();
        $array = array(
            'nomor_rec'=>$nomor_rec, 
            'nomor_faktur'=>$post["nomor_faktur"],  
            'nomor_po'=>$post["nomor_po"],  
            'tanggal_penerimaan'=>$post["tanggal_penerimaan"],  
            'penerima'=>$post["penerima"], 
            'keterangan'=>$post["keterangan"],
        );  
        $this->db->insert("penerimaan_barang", $array);   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");       
        $satuan_kecil = $this->input->post("satuan_kecil"); 
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));   
        for($i = 0; $i < count($kode_item); $i++){         
            $listitem = array(
                'nomor_rec'=>$nomor_rec,  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],   
                'satuan_kecil'=>$satuan_kecil[$i],   
                'kuantiti'=>$kuantiti[$i],   
            );   
            $this->db->insert("penerimaan_barang_detail", $listitem);  
            $list_kartustok = array(
                'nomor_rec_penerimaan'=>$nomor_rec,  
                'kode_item'=>$kode_item[$i],  
                'tanggal'=>$post["tanggal_penerimaan"],  
                'tgl_expired'=>$tgl_expired[$i],  
                'jenis_transaksi'=>"pembelian ke supplier",   
                'jumlah_masuk'=>$kuantiti[$i],     
                'jumlah_keluar'=>0,   
                'satuan_kecil'=>$satuan_kecil[$i]
            ); 
            $this->db->insert("kartu_stok", $list_kartustok);  
            $this->db->set('stok', 'stok + ' . (int) $kuantiti[$i], FALSE)->where('kode_item', $kode_item[$i])->update('master_item');  
        }    
        return TRUE;
    }     
    public function get_penerimaan($idd){ 
        $this->db->select("a.nomor_faktur, a.nomor_rec, a.nomor_po, a.tanggal_penerimaan, a.penerima, a.keterangan, b.supplier, c.nama_supplier");
        $this->db->from("penerimaan_barang a");
        $this->db->join('pembelian_langsung b', 'a.nomor_faktur = b.nomor_faktur');  
        $this->db->join('master_supplier c', 'b.supplier = c.id');  
        $this->db->where('a.nomor_rec', $idd,'1'); 
        return $this->db->get()->result_array();
    }  
    public function detail_penerimaan($idd){ 
        return $this->db->get_where('penerimaan_barang_detail', array('nomor_rec' => $idd)); 
    }  

    public function hapusdatapenerimaan()
    {
        $post = $this->input->post(); 
        $detailpo = $this->db->get_where('penerimaan_barang_detail', array('nomor_rec' => $post['idd'])); 
        foreach($detailpo->result() as $r) {      
            $this->db->set('stok', 'stok - ' . (int) $r->kuantiti, FALSE)->where('kode_item', $r->kode_item)->update('master_item');  
        } 
        $this->db->where('nomor_rec', $post['idd']);
        return $this->db->delete('penerimaan_barang');  
    }
    //CRUD penerimaan end
	
	
    //datatable retur start
	
	var $column_search_retur = array('tanggal_retur','nomor_retur','nomor_rec_penerimaan','nomor_faktur'); 
    var $column_order_retur = array(null, 'tanggal_retur','nomor_retur','nomor_rec_penerimaan','nomor_faktur');
    var $order_retur = array('waktu_update' => 'DESC');
    private function _get_query_retur()
    { 
        $get = $this->input->get();
        $this->db->from('retur_pembelian'); 
        $i = 0; 
        foreach ($this->column_search_retur as $item)
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
 
                if(count($this->column_search_retur) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        } 
        if(isset($get['order'])) 
        {
            $this->db->order_by($this->column_order_retur[$get['order']['0']['column']], $get['order']['0']['dir']);
        } 
        else if(isset($this->order_retur))
        {
            $order = $this->order_retur;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_retur_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_retur();
        if($get['length'] != -1)
        $this->db->limit($get['length'], $get['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered_datatable_retur()
    {
        $this->_get_query_retur();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all_datatable_retur()
    {
        $this->db->from('retur_pembelian');
        return $this->db->count_all_results();
    } 
    //datatable retur end
    public function rulesretur()
    {
        return [
            [
            'field' => 'tanggal_retur',
            'label' => 'Tanggal Retur',
            'rules' => 'required',
            ],
            [
            'field' => 'nomor_faktur',
            'label' => 'Nomor Faktur',
            'rules' => 'required',
            ],
            [
            'field' => 'nomor_rec_penerimaan',
            'label' => 'Nomor Penerimaan',
            'rules' => 'required',
            ] 
        ];
    }  
    public function rulesreturedit()
    {
        return [
            [
            'field' => 'tanggal_retur',
            'label' => 'Tanggal Retur',
            'rules' => 'required',
            ], 
        ];
    }  
    private function _kode_retur()
    {   
        $jumlah = $this->db->select('*')->from('retur_pembelian')->get()->num_rows();
        $jml_baru = $jumlah + 1; 
        $kode = sprintf("%04s", $jml_baru);
        $kode = "RE".date('dmy').$kode;
        $cek_ada = $this->db->select('*')->from('retur_pembelian')->where('	nomor_retur ="'. $kode.'"')->get()->num_rows();
        if($cek_ada > 0){
            return $this->_kode_retur();
        }else{
            return $kode ;
        } 
    }
    function simpandataretur(){   
        $post = $this->input->post(); 
        $nomor_retur = $this->_kode_retur();   
        $array = array(
            'nomor_retur'=>$nomor_retur, 
            'nomor_faktur'=>$post["nomor_faktur"],  
            'nomor_rec_penerimaan'=>$post["nomor_rec_penerimaan"],  
            'tanggal_retur'=>$post["tanggal_retur"],  
            'keterangan'=>$post["keterangan"],  
        );  
        $this->db->insert("retur_pembelian", $array);   
        $kode_item = $this->input->post("kode_item");    
        $sku = $this->input->post("sku");    
        $nama_item = $this->input->post("nama_item");    
        $tgl_expired = $this->input->post("tgl_expired");       
        $satuan_kecil = $this->input->post("satuan_kecil"); 
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));   
        for($i = 0; $i < count($kode_item); $i++){         
            $listitem = array(
                'nomor_retur'=>$nomor_retur,  
                'kode_item'=>$kode_item[$i],  
                'sku'=>$sku[$i],  
                'nama_item'=>$nama_item[$i],  
                'tgl_expired'=>$tgl_expired[$i],   
                'satuan_kecil'=>$satuan_kecil[$i],   
                'kuantiti'=>$kuantiti[$i],   
            );   
            $this->db->insert("retur_detail", $listitem);  
        }   
        return TRUE;
    }   
    public function get_retur($idd){ 
        $this->db->select("a.nomor_faktur, a.nomor_retur, a.nomor_rec_penerimaan, a.tanggal_retur, d.penerima, a.keterangan, b.supplier, c.nama_supplier,c.telepon");
        $this->db->from("retur_pembelian a");
        $this->db->join('pembelian_langsung b', 'a.nomor_faktur = b.nomor_faktur');  
        $this->db->join('master_supplier c', 'b.supplier = c.id');  
        $this->db->join('penerimaan_barang d', 'a.nomor_rec_penerimaan = d.nomor_rec');  
        $this->db->where('a.nomor_retur', $idd,'1'); 
        return $this->db->get()->result_array();
    }  
    public function updatedataretur()
    {
        $post = $this->input->post();    
        $this->tanggal_retur = $post["tanggal_retur"];  
        $this->keterangan = $post["keterangan"];  
        $this->db->update("retur_pembelian", $this, array('nomor_retur' => $post['idd']));     
        $kuantiti = bilanganbulat($this->input->post("kuantiti"));    
        $id_item = $this->input->post("id_item");     
        for($i = 0; $i < count($id_item); $i++){         
            $listitem = array(
                'kuantiti'=>$kuantiti[$i],  
            );     
            $this->db->where('idd', $id_item[$i]);
            $this->db->update("retur_detail", $listitem);  
        }  
        return TRUE;
    }
    public function hapusdataretur()
    {
        $post = $this->input->post();  
        $this->db->where('nomor_retur', $post['idd']);
        return $this->db->delete('retur_pembelian');  
    }
    public function detail_retur($idd){ 
        return $this->db->get_where('retur_detail', array('nomor_retur' => $idd)); 
    }
}
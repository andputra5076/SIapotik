<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('penjualan_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
        $this->load->library('Ajax_pagination');
        $this->perPage = 12;
    } 
	public function index()
	{    
        level_user('penjualan','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['total_po'] = $this->db->count_all('purchase_order'); 
        $data['total_pembelian'] = $this->db->count_all('pembelian_langsung'); 
        $data['total_penerimaan'] = $this->db->count_all('penerimaan_barang'); 
        $data['total_retur'] = $this->db->count_all('retur_pembelian');  
        $this->load->view('member/penjualan/beranda',$data);
    }   
	public function diskon()
	{    
        level_user('penjualan','diskon',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/penjualan/diskon'); 
    }  

    public function datadiskon()
	{   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length")); 
        $query = $this->penjualan_model->data_diskon();  
        $totalrows = $this->db->count_all_results();
        $data = []; 
        foreach($query as $r) {  
            $tombolhapus = level_user('penjualan','diskon',$this->session->userdata('kategori'),'delete') > 0 ? '<a class="mt-xs mr-xs btn btn-danger" onclick="hapus(this)"  data-id="'.$this->security->xss_clean($r['id']).'" role="button"><i class="fa  fa-trash-o"></i></a>':'';
            $data[] = array(   
                '  
                '.$tombolhapus.'
                ',
            $this->security->xss_clean(tgl_indo($r['tanggal_berakhir'])), 
            $this->security->xss_clean($r['min_kuantiti']),   
            $this->security->xss_clean($r['kode_item']), 
            $this->security->xss_clean($r['nama_item']), 
            $this->security->xss_clean(rupiah($r['diskon'])), 
            ); 
        }  
        $result = array( 
                 "draw" => $draw, 
                   "recordsTotal" => $totalrows, 
                   "recordsFiltered" => $totalrows, 
                   "data" => $data 
        );  
        echo json_encode($result);  
    }  

    public function diskontambah(){ 
        cekajax(); 
        $simpan = $this->penjualan_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesdiskon());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{  
			if($simpan->simpandatadiskon()){ 
				$data['success']= true;
				$data['message']="Berhasil menyimpan data";  
			}else{
				$errors['fail'] = "gagal melakukan update data";
				$data['errors'] = $errors;
			}					
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    public function hapusdiskon(){ 
        cekajax(); 
        $hapus = $this->penjualan_model;
        if($hapus->hapusdatadiskon()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    
	public function jenispembayaran()
	{    
        level_user('penjualan','jenispembayaran',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/penjualan/jenispembayaran'); 
    }  
    public function databank()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->penjualan_model->get_databank_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('penjualan','jenispembayaran',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->singkatan).'">Hapus</a></li>':'';
            $tomboledit = level_user('penjualan','jenispembayaran',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->singkatan).'">Edit</a></li>':'';
				
            $row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">  
                        '.$tomboledit.'
                        '.$tombolhapus.' 
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean($r->jenis); 
            $row[] = $this->security->xss_clean($r->singkatan);
            $row[] = $this->security->xss_clean($r->nama_bank);
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->penjualan_model->count_all_datatable_databank(),
            "recordsFiltered" => $this->penjualan_model->count_filtered_datatable_databank(),
            "data" => $data,
        ); 
        echo json_encode($result); 
    }
    public function banktambah(){ 
        cekajax(); 
        $simpan = $this->penjualan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesbank());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->simpandatabank()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";  
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
           
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function bankdetail(){  
        cekajax(); 
        $idd = $this->input->get("id");
        $query = $this->db->get_where('master_bank', array('singkatan' => $idd),1);
        $result = array(  
            "nama_bank" => $this->security->xss_clean($query->row()->nama_bank),
            "singkatan" => $this->security->xss_clean($query->row()->singkatan),
            "jenis" => $this->security->xss_clean($query->row()->jenis), 
        );    
    	echo'['.json_encode($result).']';
    }

    public function bankedit(){ 
        cekajax(); 
        $simpan = $this->penjualan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesbank());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{    
            if($simpan->updatedatabank()){
                $data['success']= true;
                $data['message']="Berhasil menyimpan data";
            }else{
                $errors['fail'] = "gagal melakukan update data";
			    $data['errors'] = $errors;
            }
              
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    public function bankhapus(){ 
        cekajax(); 
        $hapus = $this->penjualan_model;
        if($hapus->hapusdatabank()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    


    public function kasir()
    {    
        level_user('penjualan','kasir',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        
        $data = array();
        
        //total rows count
        $totalRec = count($this->penjualan_model->getRows()); 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'posts/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->penjualan_model->getRows(array('limit'=>$this->perPage)); 
        $data['dokter'] = $this->db->get('master_dokter')->result();
        $this->load->view('member/penjualan/kasir',$data); 
    }  

    public function tambahkeranjangbarcode(){  
        cekajax();   
        $simpan = $this->penjualan_model;
        $get = $this->input->get();   
        $query = $this->db->select('*')->from('master_item')->where('kode_item ="'.$get['barcode'].'"')->get();
        if($query->num_rows() > 0 ){
            if($query->row()->jenis == 'racikan'){
                    $stok = $simpan->stokracikan($get['barcode']);
                    if($stok == '0'){
                        $data['response'] = "stok kosong";
                    }else{
                        $simpankeranjang = $simpan->cek_keranjang($get['barcode'],$get['pembeli'],'1');
                        $data['response'] = "tersedia";
                    }
            }else{
                if($query->row()->stok > 0){ 
                    $simpankeranjang = $simpan->cek_keranjang($get['barcode'],$get['pembeli'],'0');$data['response'] = "tersedia";
                }else{ 
                    $data['response'] = "stok kosong";
                }
            }   
        } else{
            $data['response'] = '0';   
        } 
        echo json_encode($data);
    } 

    public function keranjangtambah(){  
        cekajax();   
        $simpan = $this->penjualan_model;
        $get = $this->input->get();    
        $stok = $simpan->tambahkeranjang($get['idd']);
        $data['response'] = "berhasil";
        echo json_encode($data);
    } 
    public function update_pembeli(){  
        $get = $this->input->get();   
        $pembeli = $get['pembeli'];
        if($pembeli==''){
            $pembeli = NULL;
        }
        $query = $this->db->get_where('keranjang', array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')),1);
        $idkeranjang = $query->row()->id;
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
        }else{ 
            $array = array( 
                'tanggal_jam'=>date('Y-m-d h:i:s'),  
                'id_pembeli'=>$pembeli,
            );
            $this->db->update("keranjang", $array,array('id' => $idkeranjang ));
        } 
    }
    public function keranjangkurang(){  
        cekajax();   
        $simpan = $this->penjualan_model;
        $get = $this->input->get();    
        $stok = $simpan->kurangkeranjang($get['idd']);
        $data['response'] = "berhasil";
        echo json_encode($data);
    } 
    public function keranjanghapus(){  
        cekajax();   
        $simpan = $this->penjualan_model;
        $get = $this->input->get();    
        $stok = $simpan->hapuskeranjang($get['idd']);
        $data['response'] = "berhasil";
        echo json_encode($data);
    } 
    public function canceltransaksi(){ 
        cekajax();    
        $hapus = $this->db->where(array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')))->delete('keranjang'); 
        if($hapus == TRUE){ 
            $data['response'] = "berhasil";
        }else{
            $data['response'] = "gagal"; 
        }
        echo json_encode($data);
    }

    public function tampilkanhold(){  
        cekajax();    
        $hold = $this->penjualan_model;
        $get = $this->input->get(); 
        $hapus = $this->db->where(array('hold' => '0','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')))->delete('keranjang'); 
        if($hapus == TRUE){ 
            $hold->bukaholdtransaksi($get['idkeranjang']); 
            $query = $this->db->get_where('keranjang', array('id' => $get['idkeranjang'],'token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')),1); 
            if(empty($query->row()->id_pembeli)){  
                $nama_pembeli ="Walk in Customer";
                $id_pembeli ="";
            }else{
                $pembeli = $this->db->get_where('master_pembeli', array('id' => $query->row()->id_pembeli),1); 
                $nama_pembeli = $pembeli->row()->nama_pembeli;
                $id_pembeli = $pembeli->row()->id;
            } 
            $data['nama_pembeli'] = $nama_pembeli;
            $data['id_pembeli'] = $id_pembeli;
        }else{
            $data['response'] = "gagal"; 
        } 
        echo json_encode($data);
    } 

    public function holdtransaksi(){ 
        cekajax();       
        $hold = $this->penjualan_model; 
        $validation = $this->form_validation; 
        $validation->set_rules($hold->rulesholdtransaksi());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{    
            if($hold->holdtransaksi() == TRUE){ 
                $data['success']= true;
                $data['message']="Berhasil hold transaksi";     
            }else{ 
                $errors="fail";
                $data['errors'] = $errors;
            }
        } 
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    function ajaxPaginationData(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        
        //total rows count
        $totalRec = count($this->penjualan_model->getRows($conditions)); 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'penjualan/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->penjualan_model->getRows($conditions);
        
        //load the view
        $this->load->view('member/penjualan/ajax-pagination-data', $data, false);
    }

    public function datapembeli()
    {   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length"));
        $query = $this->db->get("master_pembeli");
        $data = []; 
        foreach($query->result() as $r) { 
            $data[] = array(   
            $this->security->xss_clean($r->nama_pembeli), 
            $this->security->xss_clean($r->jenis_kelamin), 
            $this->security->xss_clean($r->handphone), 
            $this->security->xss_clean($r->email),
            '    <a onclick="pilihpembeli(this)" data-namapembeli="'.$r->nama_pembeli.'" data-id="'.$r->id.'" class="mt-xs mr-xs btn btn-info" role="button"><i class="fa fa-check-square-o"></i></a>
           
            '
            ); 
        }  
        $result = array( 
                 "draw" => $draw, 
                   "recordsTotal" => $query->num_rows(), 
                   "recordsFiltered" => $query->num_rows(), 
                   "data" => $data 
        );  
        echo json_encode($result);  
    }

    public function datahold()
    {   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length"));
        $query = $this->db->order_by("id","ASC")->where(array('hold' => '1','token' => $this->security->get_csrf_hash(),'id_admin' => $this->session->userdata('idadmin')))->get("keranjang");
        $data = []; 
        $no = 0;
        foreach($query->result() as $r) { 
            $no = $no + 1;
            $tgl = date('Y-m-d', $r->waktu_hold);
            $jam = date('H:i:s', $r->waktu_hold);
            $waktu = tgl_indo($tgl)." ".$jam;
            $data[] = array(   
            $no, 
            $this->security->xss_clean($r->keterangan_hold), 
            $this->security->xss_clean($waktu),  
            '    <a onclick="pilihhold(this)" data-id="'.$r->id.'" class="mt-xs mr-xs btn btn-info" role="button"><i class="fa fa-check-square-o"></i></a>
           
            '
            ); 
        }  
        $result = array( 
                 "draw" => $draw, 
                   "recordsTotal" => $query->num_rows(), 
                   "recordsFiltered" => $query->num_rows(), 
                   "data" => $data 
        );  
        echo json_encode($result);  
    }

    public function keranjangdetail(){  
        cekajax();      
        $result =  array();   
        $arraysub=   array();  
        $query = $this->penjualan_model->get_keranjang();   
        if($query->num_rows() > 0){   
            $kuantiti = 0;
            $detailkeranjang = $this->penjualan_model->detail_keranjang($query->row()->id); 
            if($detailkeranjang->num_rows() > 0){      
                foreach($detailkeranjang->result_array() as $r) {   
                    $kuantiti = $kuantiti + $r['kuantiti'];
                    if($r['upah_peracik'] > 0){
                        $nama_item = "<b>[racikan] </b>".$r['nama_item'];
                    }else{ 
                        $nama_item = $r['nama_item'];
                    }   
                    $subArray['nama_item']=$this->security->xss_clean($nama_item); 
                    $subArray['id']=$this->security->xss_clean($r['id']); 
                    $subArray['harga']=$this->security->xss_clean(rupiah($r['harga'])); 
                    $subArray['diskon']=$this->security->xss_clean(rupiah($r['diskon']));
                    $subArray['kuantiti']=$this->security->xss_clean($r['kuantiti']);
                    $subArray['total']=$this->security->xss_clean(rupiah($r['total'])); 
                    $arraysub[] =  $subArray ;  
                }    
            } 
            $result = array(  
                "total_upah_peracik_int" => $this->security->xss_clean($query->row()->total_upah_peracik),
                "total_upah_peracik" => $this->security->xss_clean(rupiah($query->row()->total_upah_peracik)),
                "total_harga_item" => $this->security->xss_clean(rupiah($query->row()->total_harga_item)),
                "total" => $this->security->xss_clean(rupiah($query->row()->total)), 
                "totalInt" => $this->security->xss_clean($query->row()->total), 
                "totalKuantiti" => $this->security->xss_clean($kuantiti), 
            );
        } 
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    }

    public function bankjenis(){  
        cekajax();       
        $get = $this->input->get();    
        $bank = $this->penjualan_model->bankjenis($get['jenis']);  
        foreach($bank->result_array() as $r) {    
            $subArray['singkatan']=$this->security->xss_clean($r['singkatan']);  
            $arraysub[] =  $subArray ;  
        }   
        $datasub = $arraysub; 
        echo'{"datasub":'.json_encode($datasub).'}';
    }

    public function updateStok()
    {
        // Ambil data stok terbaru dari model
        $stok = $this->penjualan_model->getStokTerbaru();

        // Keluarkan data stok dalam format JSON
        echo json_encode($stok);
    }

    public function submitpayment()
    {
        cekajax();
        $simpan = $this->penjualan_model;
        $post = $this->input->post();
        $total_pembayaran = bilanganbulat($post['totaldibayar'][0]) + bilanganbulat($post['totaldibayar'][1]);
        if (bilanganbulat($post['post_totalbelanja']) > 0 && $total_pembayaran >= bilanganbulat($post['post_totalbelanja'])) {
            if ($simpan->submitpayment()) {
                // // Update stok
                // $this->updateStok($post); // Panggil fungsi update stok
                $data['success'] = true;
                $data['message'] = "Transaksi berhasil";
            } else {
                $errors['fail'] = "gagal melakukan checkout";
                $data['errors'] = $errors;
            }
        } else {
            $errors['fail'] = "mohon isi form pembayaran dengan benar";
            $data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Keuangan extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('keuangan_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    } 
	public function index()
	{   
        level_user('keuangan','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/keuangan/beranda');
    }   
    public function koderekening()
	{   
        level_user('keuangan','koderekening',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/keuangan/koderekening');
    }  
    public function datarekening()
	{  
	cekajax();
        $get = $this->input->get();
        $list = $this->keuangan_model->get_datarekening_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            if($r->editable == '1'){ 
                $tombolhapus = level_user('keuangan','koderekening',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$r->kode_rekening.'">Hapus</a></li>':'';
                $tomboledit = level_user('keuangan','koderekening',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$r->kode_rekening.'">Edit</a></li>':'';
				$row[] = ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
				';
			}else{
				$row[] = '';
			}
            $row[] = $this->security->xss_clean($r->kategori);
            $row[] = $this->security->xss_clean($r->kode_rekening);
            $row[] = $this->security->xss_clean($r->nama_rekening);  
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->keuangan_model->count_all_datatable_datarekening(),
            "recordsFiltered" => $this->keuangan_model->count_filtered_datatable_datarekening(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }
    public function rekeningtambah(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->ruleskeuangan());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{  
            if($simpan->simpandatarekening()){ 
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
    public function rekeningdetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('rekening_kode', array('kode_rekening' => $idd),1);
        $result = array(  
            "kode_rekening" => $this->security->xss_clean($query->row()->kode_rekening),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "nama_rekening" => $this->security->xss_clean($query->row()->nama_rekening) 
        );    
    	echo'['.json_encode($result).']';
    }
    public function rekeningedit(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesrekeningedit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
            if($simpan->updatedatarekening()){ 
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
    public function rekeninghapus(){ 
        cekajax(); 
        $hapus = $this->keuangan_model;
        if($hapus->hapusdatarekening()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{       
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function hutang()
	{   
        level_user('keuangan','hutang',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['supplier'] = $this->db->get('master_supplier')->result(); 
        $this->load->view('member/keuangan/hutang',$data);
    } 
    public function datahutang()
	{   
        cekajax();
        $get = $this->input->get();
        $list = $this->keuangan_model->get_datahutang_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
			$tombol = ''; 
            $sisa =  $r->nominal - $r->nominal_dibayar;
            $statuslunas ='<span class="btn btn-danger btn-xs">Belum</span>';
            if($r->sudah_lunas == '1'){
                $statuslunas ='<span class="btn btn-success btn-xs">Sudah</span>';
                $tombolbayar ='';
            }else{
                $tombolbayar = '<li><a href="#" onclick="bayar(this)" data-id="'.$r->id.'">Bayar</a></li>';
            }
            if($r->nomor_faktur != NULL){  
                    $tombol ='
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Rincian</a></li> 
                            '.$tombolbayar.'
                        </ul>
                    </div>
                    ';
            }else{
                $tombolhapus = level_user('keuangan','hutang',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$r->id.'">Hapus</a></li>':'';
                    $tombol ='
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Rincian</a></li> 
                            '.$tombolhapus.'
                            '.$tombolbayar.'
                        </ul>
                    </div>
                    '; 
            }
            $row[] = $tombol;
            $row[] = $this->security->xss_clean($r->id);
            $row[] = $this->security->xss_clean($r->judul);
            $row[] = $this->security->xss_clean($r->nomor_faktur); 
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal));
            $row[] = $this->security->xss_clean(rupiah($r->nominal));
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal_jatuh_tempo));
            $row[] = $this->security->xss_clean(rupiah($r->nominal_dibayar)); 
            $row[] = $this->security->xss_clean(rupiah($sisa)); 
            $row[] = $statuslunas;
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->keuangan_model->count_all_datatable_datahutang(),
            "recordsFiltered" => $this->keuangan_model->count_filtered_datatable_datahutang(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function hutangtambah(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->ruleshutang());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{     
            if($simpan->simpandatahutang()){ 
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
    
    public function hutanghapus(){ 
        cekajax(); 
        $hapus = $this->keuangan_model;
        if($hapus->hapusdatahutang()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
   
    public function hutangdetail(){  
        cekajax(); 
        $idd = $this->input->get("id");   
        $query = $this->keuangan_model->get_hutang($idd); 
            foreach ($query as $po_data) {    
                $sisa = $po_data['nominal'] - $po_data['nominal_dibayar'] ;
                if($po_data['sudah_lunas'] == '1'){
                    $statuslunas ='<span class="btn btn-success btn-xs">Sudah Lunas</span>';
                    $tombolbayar ='';
                }else{
                    $statuslunas ='<span class="btn btn-danger btn-xs">Belum Lunas</span>';
                }
                $result = array(  
                    "id" => $this->security->xss_clean($po_data['id']),
                    "judul" => $this->security->xss_clean($po_data['judul']),
                    "tanggal" => $this->security->xss_clean(tgl_indo($po_data['tanggal'])),
                    "nominal" => $this->security->xss_clean(rupiah($po_data['nominal'])), 
                    "nominal_dibayar" => $this->security->xss_clean(rupiah($po_data['nominal_dibayar'])),
                    "sisa" => $this->security->xss_clean(rupiah($sisa)),
                    "nomor_faktur" => $this->security->xss_clean($po_data['nomor_faktur']),
                    "id_supplier" => $this->security->xss_clean($po_data['id_supplier']), 
                    "tanggal_jatuh_tempo" => $this->security->xss_clean(tgl_indo($po_data['tanggal_jatuh_tempo'])),  
                    "tanggal_jatuh_tempo_ymd" => $this->security->xss_clean($po_data['tanggal_jatuh_tempo']),   
                    "supplier" => $this->security->xss_clean($po_data['nama_supplier']),
                    "telepon" => $this->security->xss_clean($po_data['telepon']),
                    "alamat" => $this->security->xss_clean($po_data['alamat']),
                    "status" => $statuslunas,
                    "keterangan" => $this->security->xss_clean($po_data['keterangan'])
                );     
        } 
        $detailpo = $this->db->get_where('hutang_dibayar_history', array('id_hutang' => $idd)); 
        if($detailpo->num_rows() > 0) { 
            foreach($detailpo->result() as $r) {     
                $subArray['id']=$this->security->xss_clean($r->id); 
                $subArray['tanggal']=$this->security->xss_clean(tgl_indo($r->tanggal)); 
                $subArray['nominal']=$this->security->xss_clean(rupiah($r->nominal));
                $subArray['keterangan']=$this->security->xss_clean($r->keterangan);
                $subArray['nominalInt']=$this->security->xss_clean($r->nominal); 
                $arraysub[] =  $subArray ; 
            }  
        }else{
                $subArray['id']=""; 
                $subArray['tanggal']=""; 
                $subArray['nominal']="";
                $subArray['keterangan']=""; 
                $arraysub[] =  $subArray ; 
        }
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    }

    public function hutanghapuspembayaran(){ 
        cekajax(); 
        $hapus = $this->keuangan_model;
        if($hapus->hapusdatapembayaranhutang()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
    public function hutangtambahpembayaran(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->ruleshutangdibayar());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{      
            if($simpan->simpandatahutangdibayar()){ 
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

    public function piutang()
	{    
        $this->load->view('member/keuangan/piutang');
    }

    public function datapiutang()
    {   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length"));
        $query = $this->db->select("a.id, a.id_penjualan, a.id_pembeli, a.judul, a.tanggal, a.tanggal_jatuh_tempo, a.nominal, a.nominal_dibayar, a.sudah_lunas, b.nama_pembeli, b.handphone")->from("piutang_history a")->join('master_pembeli b', 'a.id_pembeli = b.id')->get();  
        $data = []; 
        foreach($query->result() as $r) { 
            $tombol = ''; 
            $sisa =  $r->nominal - $r->nominal_dibayar;
            $statuslunas ='<span class="btn btn-danger btn-xs">Belum</span>';
            if($r->sudah_lunas == '1'){
                $statuslunas ='<span class="btn btn-success btn-xs">Sudah</span>';
                $tombolbayar ='';
            }  
            $data[] = array(   
            ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Rincian</a></li> 
                            <li><a href="#" onclick="bayar(this)" data-id="'.$r->id.'">Bayar</a></li>
                        </ul>
                    </div>
            ', 
            $this->security->xss_clean($r->id_penjualan),
            $this->security->xss_clean($r->nama_pembeli),
            $this->security->xss_clean($r->handphone),  
            $this->security->xss_clean(tgl_indo($r->tanggal)),  
            $this->security->xss_clean(rupiah($r->nominal)),  
            $this->security->xss_clean(tgl_indo($r->tanggal_jatuh_tempo)),   
            $this->security->xss_clean(rupiah($r->nominal_dibayar)),   
            $this->security->xss_clean(rupiah($sisa)),   
            $this->security->xss_clean($statuslunas), 
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

    public function piutangdetail(){  
        cekajax(); 
        $idd = $this->input->get("id");   
        $query = $this->keuangan_model->get_piutang($idd); 
            foreach ($query as $po_data) {    
                $sisa = $po_data['nominal'] - $po_data['nominal_dibayar'] ;
                if($po_data['sudah_lunas'] == '1'){
                    $statuslunas ='<span class="btn btn-success btn-xs">Sudah Lunas</span>';
                    $tombolbayar ='';
                }else{
                    $statuslunas ='<span class="btn btn-danger btn-xs">Belum Lunas</span>';
                }
                $result = array(  
                    "id" => $this->security->xss_clean($po_data['id']),
                    "judul" => $this->security->xss_clean($po_data['judul']),
                    "tanggal" => $this->security->xss_clean(tgl_indo($po_data['tanggal'])),
                    "nominal" => $this->security->xss_clean(rupiah($po_data['nominal'])), 
                    "nominal_dibayar" => $this->security->xss_clean(rupiah($po_data['nominal_dibayar'])),
                    "sisa" => $this->security->xss_clean(rupiah($sisa)),
                    "id_penjualan" => $this->security->xss_clean($po_data['id_penjualan']),
                    "id_pembeli" => $this->security->xss_clean($po_data['id_pembeli']), 
                    "tanggal_jatuh_tempo" => $this->security->xss_clean(tgl_indo($po_data['tanggal_jatuh_tempo'])),  
                    "tanggal_jatuh_tempo_ymd" => $this->security->xss_clean($po_data['tanggal_jatuh_tempo']),   
                    "nama_pembeli" => $this->security->xss_clean($po_data['nama_pembeli']),
                    "jenis_kelamin" => $this->security->xss_clean($po_data['jenis_kelamin']),
                    "alamat" => $this->security->xss_clean($po_data['alamat']),
                    "telepon" => $this->security->xss_clean($po_data['telepon']),
                    "handphone" => $this->security->xss_clean($po_data['handphone']),
                    "status" => $statuslunas,
                    "keterangan" => $this->security->xss_clean($po_data['keterangan'])
                );     
        } 
        $detailpo = $this->db->get_where('piutang_dibayar_history', array('id_piutang' => $idd)); 
        if($detailpo->num_rows() > 0) { 
            foreach($detailpo->result() as $r) {     
                $subArray['id']=$this->security->xss_clean($r->id); 
                $subArray['tanggal']=$this->security->xss_clean(tgl_indo($r->tanggal)); 
                $subArray['nominal']=$this->security->xss_clean(rupiah($r->nominal));
                $subArray['keterangan']=$this->security->xss_clean($r->keterangan);
                $subArray['nominalInt']=$this->security->xss_clean($r->nominal); 
                $arraysub[] =  $subArray ; 
            }  
        }else{
                $subArray['id']=""; 
                $subArray['tanggal']=""; 
                $subArray['nominal']="";
                $subArray['keterangan']=""; 
                $arraysub[] =  $subArray ; 
        }

        $query = $this->keuangan_model->get_piutangdetail($idd); 
        foreach ($query as $po_data) {   
                $subArrayProduk['nama_item']= $this->security->xss_clean($po_data['nama_item']); 
                $subArrayProduk['kode_item']= $this->security->xss_clean($po_data['kode_item']); 
                $subArrayProduk['harga']= $this->security->xss_clean(rupiah($po_data['harga'])); 
                $subArrayProduk['kuantiti']= $this->security->xss_clean($po_data['kuantiti']); 
                $subArrayProduk['diskon']= $this->security->xss_clean(rupiah($po_data['diskon'])); 
                $subArrayProduk['total']= $this->security->xss_clean(rupiah($po_data['total'])); 
                $arraysubProduk[] =  $subArrayProduk ;  
        } 
        
        $datasub = $arraysub;
        $dataproduk = $arraysubProduk;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).',"dataproduk":'.json_encode($dataproduk).'}';
    }

    public function piutanghapuspembayaran(){ 
        cekajax(); 
        $hapus = $this->keuangan_model;
        if($hapus->hapusdatapembayaranpiutang()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }  
    
    public function piutangtambahpembayaran(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespiutangdibayar());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{     
            if($simpan->simpandatapiutangdibayar()){ 
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

    public function cashinout()
    {   
        level_user('keuangan','cashinout',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/keuangan/cashinout');
    }   


    public function datacashincashout()
    {   
        cekajax(); 
        $draw = intval($this->input->get("draw")); 
        $start = intval($this->input->get("start")); 
        $length = intval($this->input->get("length"));
        $query = $this->db->select("a.id,, a.kode_rekening, a.tanggal, a.masuk, a.keluar, a.keterangan, b.kategori, b.nama_rekening, b.editable")->from("cash_in_out a")->join('rekening_kode b', 'a.kode_rekening = b.kode_rekening')->get();  
        $data = []; 
        foreach($query->result() as $r) {  
            if($r->kategori == 'pengeluaran'){
                $nominal = $r->keluar;
            } else{
                $nominal = $r->masuk; 
            }
            if($r->editable == '1'){
                $edit =''; $hapus ='';
                if(level_user('keuangan','cashinout',$this->session->userdata('kategori'),'edit') > 0 )
                {
                    $edit = '    <li><a href="#" onclick="edit(this)" data-id="'.$r->id.'">Edit</a></li>';
                }   
                if(level_user('keuangan','cashinout',$this->session->userdata('kategori'),'delete') > 0){
                    $hapus = '     <li><a href="#" onclick="hapus(this)" data-id="'.$r->id.'">Hapus</a></li>
                    '; 
                } 
                $tombol = $edit.$hapus; 
            }else{
                $tombol = '';
            }

            $data[] = array(   
            ' 
                    <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Detail</a></li> 
                            '.$tombol.'
                        </ul>
                    </div>
            ', 
            $this->security->xss_clean(tgl_indo($r->tanggal)), 
            $this->security->xss_clean($r->kode_rekening),
            $this->security->xss_clean($r->nama_rekening),
            $this->security->xss_clean($r->kategori),   
            $this->security->xss_clean(rupiah($nominal)),  
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

    public function datarekeningkode(){  
        cekajax(); 
        $kategori = $this->input->get("kategori");    
        $detailpo = $this->db->get_where('rekening_kode', array('kategori' => $kategori ,'editable' => '1')); 
        foreach($detailpo->result() as $r) {     
            $subArray['kode_rekening']=$this->security->xss_clean($r->kode_rekening);   
            $subArray['nama_rekening']=$this->security->xss_clean($r->nama_rekening);   
            $subArray['kategori']=$this->security->xss_clean($r->kategori);   
            $arraysub[] =  $subArray ; 
        }
        $datasub = $arraysub;   
        echo'{"datarows":'.json_encode($datasub).'}';
    }

    public function cashincashout_tambah(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulescash());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{     
            if($simpan->simpandatacash()){ 
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

    public function cashdetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id"));   
        $query = $this->db->select("a.id,, a.kode_rekening, a.tanggal, a.masuk, a.keluar, a.keterangan, b.kategori, b.nama_rekening")->from("cash_in_out a")->join('rekening_kode b', 'a.kode_rekening = b.kode_rekening')->where('a.id', $idd,'1')->get(); 

            if($query->row()->kategori == 'pengeluaran'){
                $nominal =  $query->row()->keluar;
            } else{
                $nominal = $query->row()->masuk;
            }
        $result = array(  
            "tanggal" => $this->security->xss_clean(tgl_indo($query->row()->tanggal)),
            "tanggalYmd" => $this->security->xss_clean($query->row()->tanggal),
            "kategori" => $this->security->xss_clean($query->row()->kategori),
            "kode_rekening" => $this->security->xss_clean($query->row()->kode_rekening),
            "nominal" => $this->security->xss_clean(rupiah($nominal)),
            "nominalInt" => $this->security->xss_clean($nominal),
            "nama_rekening" => $this->security->xss_clean($query->row()->nama_rekening),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan),
        );    
        echo'['.json_encode($result).']';
    } 


    public function cashhapus(){ 
        cekajax(); 
        $hapus = $this->keuangan_model;
        if($hapus->hapusdatacash()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }

    public function cashedit(){ 
        cekajax(); 
        $simpan = $this->keuangan_model;
        $validation = $this->form_validation; 
        $validation->set_rules($simpan->rulescash());
        if ($this->form_validation->run() == FALSE){
            $errors = $this->form_validation->error_array();
            $data['errors'] = $errors;
        }else{     
            if($simpan->updatedatacash()){ 
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

    function cashinout_data(){ 
        cekajax();
        $masuk_minggu = $this->db->select('SUM(masuk) as total')->from('cash_in_out')->where('tanggal BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->row();
        $keluar_minggu = $this->db->select('SUM(keluar) as total')->from('cash_in_out')->where('tanggal BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->row();
        $masuk_hari = $this->db->select('SUM(masuk) as total')->from('cash_in_out')->where('tanggal ="'. date('Y-m-d').'"')->get()->row();
        $keluar_hari = $this->db->select('SUM(keluar) as total')->from('cash_in_out')->where('tanggal ="'. date('Y-m-d').'"')->get()->row();
        
        $result = array(   
            "masuk_minggu" => $this->security->xss_clean(rupiah($masuk_minggu->total)),
            "keluar_minggu" => $this->security->xss_clean(rupiah($keluar_minggu->total)),
            "masuk_hari" => $this->security->xss_clean(rupiah($masuk_hari->total)),
            "keluar_hari" => $this->security->xss_clean(rupiah($keluar_hari->total)), 
        );    
        echo'['.json_encode($result).']';
    }

    function piutang_data(){ 
        cekajax(); 
        $dibayar_minggu = $this->db->select('SUM(nominal) as total')->from('piutang_dibayar_history')->where('tanggal BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->row();
        $total_piutang_belum_bayar = $this->db->select('SUM(nominal - nominal_dibayar) as total')->from('piutang_history')->where('sudah_lunas ="0"')->get()->row();
        
        $akan_jatuh_tempo = $this->db->select('*')->from('piutang_history')->where('tanggal_jatuh_tempo <= "'. date('Y-m-d',strtotime('+2 weeks')). '" and tanggal_jatuh_tempo > "'. date('Y-m-d'). '" and sudah_lunas ="0"')->get()->num_rows();
        $sudah_jatuh_tempo = $this->db->select('*')->from('piutang_history')->where('tanggal_jatuh_tempo <= "'. date('Y-m-d'). '" and sudah_lunas ="0"')->get()->num_rows(); 
        $result = array(   
            "dibayar_minggu" => $this->security->xss_clean(rupiah($dibayar_minggu->total)),
            "total_piutang_belum_bayar" => $this->security->xss_clean(rupiah($total_piutang_belum_bayar ->total)),
            "akan_jatuh_tempo" => $this->security->xss_clean($akan_jatuh_tempo." Transaksi"),   
            "sudah_jatuh_tempo" => $this->security->xss_clean($sudah_jatuh_tempo." Transaksi"),
        );    
        echo'['.json_encode($result).']';
    }

    function hutang_data(){ 
        cekajax();
        $total_hutang_belum_bayar = $this->db->select('SUM(nominal - nominal_dibayar) as total')->from('hutang_history')->where('sudah_lunas ="0"')->get()->row();
        $akan_jatuh_tempo = $this->db->select('*')->from('hutang_history')->where('tanggal_jatuh_tempo <= "'. date('Y-m-d',strtotime('+2 weeks')). '" and tanggal_jatuh_tempo > "'. date('Y-m-d'). '" and sudah_lunas ="0"')->get()->num_rows();
        $sudah_jatuh_tempo = $this->db->select('*')->from('hutang_history')->where('tanggal_jatuh_tempo <= "'. date('Y-m-d'). '" and sudah_lunas ="0"')->get()->num_rows();

        $dibayar_minggu = $this->db->select('SUM(nominal) as total')->from('hutang_dibayar_history')->where('tanggal BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->row(); 
        
        $result = array(   
            "akan_jatuh_tempo" => $this->security->xss_clean($akan_jatuh_tempo." Transaksi"),
            "sudah_jatuh_tempo" => $this->security->xss_clean($sudah_jatuh_tempo." Transaksi"),
            "total_hutang_belum_bayar" => $this->security->xss_clean(rupiah($total_hutang_belum_bayar->total)),
            "dibayar_minggu" => $this->security->xss_clean(rupiah($dibayar_minggu->total)),
         );    
        echo'['.json_encode($result).']';
    }
}
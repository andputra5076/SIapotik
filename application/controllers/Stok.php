<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stok extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('stok_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
    }
	public function index()
	{   
        level_user('stok','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/stok/beranda');
    } 
    public function keluar()
	{    
        level_user('stok','keluar',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['retur'] = $this->db->get('retur_pembelian')->result(); 
        $this->load->view('member/stok/keluar',$data);
    }   
     
    public function stokkeluar()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->stok_model->get_stokkeluar_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('stok','keluar',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-kodeitem="'.$this->security->xss_clean($r->kode_item).'"  data-kuantiti="'.$this->security->xss_clean($r->kuantiti).'" data-id="'.$r->id.'" >Hapus</a></li>':'';
                
            $row[] = ' 
					<div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Detail</a></li> 
                            '.$tombolhapus.'
                        </ul>
                    </div> 
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal));
            $row[] = $this->security->xss_clean($r->nomor_ref);
            $row[] = $this->security->xss_clean($r->nomor_retur_pembelian); 
            $row[] = $this->security->xss_clean($r->kode_item);
            $row[] = $this->security->xss_clean($r->nama_item);
            $row[] = $this->security->xss_clean($r->kuantiti);
            $row[] = $this->security->xss_clean($r->satuan_kecil);
            $data[] = $row; 
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_stokkeluar(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_stokkeluar(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }    
    public function stokkeluartambah(){ 
        cekajax(); 
        $post = $this->input->post();   
        $simpan = $this->stok_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesstokkeluar());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_item = $this->input->post("kode_item"); 
            $nama_item = $this->input->post("nama_item"); 
            if(isset($kode_item) === TRUE AND $nama_item !='')
            { 
                $cek = $this->db->select('*')->from('retur_detail')->where('kode_item ="'.$kode_item.'" AND tgl_expired="'.$post['tgl_expired'].'"')->get()->num_rows();
                if($cek > 0){              
					if($simpan->simpandatastokkeluar()){ 
						$data['success']= true;
						$data['message']="Berhasil menyimpan data";  
					}else{
						$errors['fail'] = "gagal melakukan update data";
						$data['errors'] = $errors;
					}					
                }else{  
                    $errors['kode_item'] = "Data tidak sesuai dengan database retur pembelian";
                    $errors['tgl_expired'] = "Data tidak sesuai dengan database retur pembelian";
                    $data['errors'] = $errors;
                }  
            }
            else{ 
                $errors['kode_item'] = "Mohon pilih item";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function stokkeluardetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('stok_keluar', array('id' => $idd),1);
        $result = array(    
            "tanggal" => $this->security->xss_clean(tgl_indo($query->row()->tanggal)),
            "nomor_ref" => $this->security->xss_clean($query->row()->nomor_ref),
            "nomor_retur_pembelian" => $this->security->xss_clean($query->row()->nomor_retur_pembelian),
            "kuantiti" => $this->security->xss_clean(bilanganbulat($query->row()->kuantiti)),
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "tgl_expired" => $this->security->xss_clean(tgl_indo($query->row()->tgl_expired)), 
            "satuan_kecil" => $this->security->xss_clean($query->row()->satuan_kecil),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan),
        );    
    	echo'['.json_encode($result).']';
    }
    public function stokkeluarhapus(){ 
        cekajax(); 
        $hapus = $this->stok_model;
        if($hapus->hapusdatastokkeluar()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function adjustment()
	{   
        level_user('stok','adjustment',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/stok/adjustment');
    }  
    public function stokadjustment()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->stok_model->get_stokadjustment_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('stok','adjustment',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-kodeitem="'.$r->kode_item.'"   data-kuantiti="'.$r->kuantiti_berubah.'" data-id="'.$r->id.'">Hapus</a></li>':'';
                
            $row[] = '  
                <div class="btn-group dropup">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Detail</a></li>
                        '.$tombolhapus.'
                         
                    </ul>
                </div>
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal));
            $row[] = $this->security->xss_clean($r->nomor_ref);
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item);
            $row[] = $this->security->xss_clean(tgl_indo($r->tgl_expired));
            $row[] = $this->security->xss_clean($r->kuantiti_berubah);
            $row[] = $this->security->xss_clean($r->satuan_kecil);
            $data[] = $row;  
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_stokadjustment(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_stokadjustment(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }    
    public function stokadjustmentdetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('stok_adjustment', array('id' => $idd),1);
        $result = array(    
            "tanggal" => $this->security->xss_clean(tgl_indo($query->row()->tanggal)),
            "nomor_ref" => $this->security->xss_clean($query->row()->nomor_ref),
            "stok_sebelum" => $this->security->xss_clean(bilanganbulat($query->row()->stok_sebelum)),
            "kuantiti_berubah" => $this->security->xss_clean(bilanganbulat($query->row()->kuantiti_berubah)),
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "tgl_expired" => $this->security->xss_clean(tgl_indo($query->row()->tgl_expired)), 
            "satuan_kecil" => $this->security->xss_clean($query->row()->satuan_kecil),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan),
        );    
    	echo'['.json_encode($result).']';
    }

      
    public function stokadjustmenttambah(){ 
        cekajax();  
        $post = $this->input->post();   
        $simpan = $this->stok_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesstokadjustment());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_item = $this->input->post("kode_item"); 
            $nama_item = $this->input->post("nama_item"); 
            if(isset($kode_item) === TRUE AND $nama_item !='')
            { 
                $cek = $this->db->select('*')->from('kartu_stok')->where('kode_item ="'.$kode_item.'" AND tgl_expired="'.$post['tgl_expired'].'"')->get();
                if($cek->num_rows() > 0){              
                    $masuk = $this->db->select('SUM(jumlah_masuk) as total')->from('kartu_stok')->where('kode_item ="'.$kode_item.'" AND tgl_expired="'.$post['tgl_expired'].'"')->get()->row();
                    $keluar = $this->db->select('SUM(jumlah_keluar) as total')->from('kartu_stok')->where('kode_item ="'.$kode_item.'" AND tgl_expired="'.$post['tgl_expired'].'"')->get()->row();
                    $total = $masuk->total - $keluar->total ;
                    $sisa = $total - $post["kuantiti_berubah"];
                    if($sisa < 0 )
                    { 
                        $errors['kode_item'] = "Data tidak sesuai dengan database stok";
                        $errors['tgl_expired'] = "Data tidak sesuai dengan database stok";
                        $data['errors'] = $errors;
                    }else{ 
                        if($simpan->simpandatastokadjustment()){
                            $data['success']= true;
                            $data['message']="Berhasil menyimpan data";   
                        }else{
                            $errors['fail'] = "gagal melakukan update data";
                            $data['errors'] = $errors;
                        }
                    }
                    
                }else{  
                    $errors['kode_item'] = "Data tidak sesuai dengan database stok";
                    $errors['tgl_expired'] = "Data tidak sesuai dengan database stok";
                    $data['errors'] = $errors;
                }  
            }
            else{ 
                $errors['kode_item'] = "Mohon pilih item";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function stokadjustmenthapus(){ 
        cekajax(); 
        $hapus = $this->stok_model;
        if($hapus->hapusdatastokadjustment()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function opname()
	{   
        level_user('stok','opname',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/stok/opname');
    }  
    
    public function stokopname()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->stok_model->get_stokopname_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('stok','opname',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)"data-kodeitem="'.$r->kode_item.'"  data-kuantiti="'.$r->kuantiti_berubah.'" data-id="'.$r->id.'">Hapus</a></li>':'';
            $row[] = '  
            <div class="btn-group dropup">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" onclick="detail(this)" data-id="'.$r->id.'">Detail</a></li> 
                        '.$tombolhapus.' 
                    </ul>
                </div>
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal));
            $row[] = $this->security->xss_clean($r->nomor_ref);
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item);
            $row[] = $this->security->xss_clean(tgl_indo($r->tgl_expired));
            $row[] = $this->security->xss_clean($r->kuantiti_berubah);
            $row[] = $this->security->xss_clean($r->satuan_kecil);
            $data[] = $row;  
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_stokopname(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_stokopname(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }     
    public function stokopnamedetail(){  
        cekajax(); 
        $idd = intval($this->input->get("id")); 
        $query = $this->db->get_where('stok_opname', array('id' => $idd),1);
        $result = array(    
            "tanggal" => $this->security->xss_clean(tgl_indo($query->row()->tanggal)),
            "nomor_ref" => $this->security->xss_clean($query->row()->nomor_ref),
            "stok_sebelum" => $this->security->xss_clean(bilanganbulat($query->row()->stok_sebelum)),
            "kuantiti_berubah" => $this->security->xss_clean(bilanganbulat($query->row()->kuantiti_berubah)),
            "kode_item" => $this->security->xss_clean($query->row()->kode_item),
            "nama_item" => $this->security->xss_clean($query->row()->nama_item),
            "tgl_expired" => $this->security->xss_clean(tgl_indo($query->row()->tgl_expired)), 
            "satuan_kecil" => $this->security->xss_clean($query->row()->satuan_kecil),
            "keterangan" => $this->security->xss_clean($query->row()->keterangan),
        );    
    	echo'['.json_encode($result).']';
    }
    public function stokopnametambah(){ 
        cekajax(); 
        $simpan = $this->stok_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesstokopname());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_item = $this->input->post("kode_item"); 
            $nama_item = $this->input->post("nama_item"); 
            if(isset($kode_item) === TRUE AND $nama_item !='')
            {     
				if($simpan->simpandatastokopname()){ 
					$data['success']= true;
					$data['message']="Berhasil menyimpan data";  
				}else{
					$errors['fail'] = "gagal melakukan update data";
					$data['errors'] = $errors;
				}					
            }
            else{ 
                $errors['kode_item'] = "Mohon pilih item";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function stokopnamehapus(){ 
        cekajax(); 
        $hapus = $this->stok_model;
        if($hapus->hapusdatastokopname()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function stokdataverfikasi()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->stok_model->get_stokdataverfikasi_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $row[] = '   
            <input type="checkbox" name="idstok[]" value="'.$this->security->xss_clean($r->id).'">
            <input type="hidden" name="kode_item[]" value="'.$this->security->xss_clean($r->kode_item).'">
            <input type="hidden" name="kuantiti[]" value="'.$this->security->xss_clean($r->kuantiti_berubah).'">
            <input type="hidden" name="tgl_expired[]" value="'.$this->security->xss_clean($r->tgl_expired).'">
            <input type="hidden" name="tanggal[]" value="'.$this->security->xss_clean($r->tanggal).'">
            <input type="hidden" name="satuan[]" value="'.$this->security->xss_clean($r->satuan_kecil).'">
            
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal));
            $row[] = $this->security->xss_clean($r->nomor_ref);
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item);
            $row[] = $this->security->xss_clean(tgl_indo($r->tgl_expired));
            $row[] = $this->security->xss_clean($r->kuantiti_berubah);
            $row[] = $this->security->xss_clean($r->satuan_kecil);
            $data[] = $row;  
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_stokdataverfikasi(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_stokdataverfikasi(),
            "data" => $data,
        ); 
        echo json_encode($result);
    } 
        

    public function verfikasistokopname(){ 
        cekajax(); 
        $simpan = $this->stok_model;
        $aksiverifikasi = $this->input->post("aksiverifikasi");    
        $data = array();
        $idstok = $this->input->post("idstok");   
        $kode_item = $this->input->post("kode_item");   
        $kuantiti = $this->input->post("kuantiti");   
        $tanggal = $this->input->post("tanggal");    
        $satuan = $this->input->post("satuan");   
        $tgl_expired = $this->input->post("tgl_expired");   
        if(isset($idstok) === TRUE AND $idstok[0]!=''){
            if($aksiverifikasi == 'hapus'){
                for($i = 0; $i < count($idstok); $i++){
                    $this->db->where('id', $idstok[$i])->delete('stok_opname');   
                }
                $data['success']= true;
                $data['message']= "Berhasil menghapus data stok";  
            }
            else{
                for($i = 0; $i < count($idstok); $i++){
                    $this->verifikasi = "1"; 
                    $this->db->update("stok_opname", $this, array('id' => $idstok[$i]));  
                    $list_kartustok = array(
                        'id_stok_opname'=>$idstok[$i],  
                        'kode_item'=>$kode_item[$i],  
                        'tanggal'=>$tanggal[$i],  
                        'jenis_transaksi'=>"stok opname",   
                        'jumlah_masuk'=>$kuantiti[$i],     
                        'tgl_expired'=>$tgl_expired[$i],     
                        'jumlah_keluar'=>0,   
                        'satuan_kecil'=>$satuan[$i]
                    ); 
                    $this->db->insert("kartu_stok", $list_kartustok); 
                    $this->db->set('stok', 'stok + ' . (int) $kuantiti[$i], FALSE)->where('kode_item', $kode_item[$i])->update('master_item');  
                } 
                $data['success']= true;
                $data['message']= "Berhasil verfikasi data stok";  
            }
        }
        else{ 
            $errors['jumlah_item'] = "Mohon pilih item yang ingin divalidasi";
            $data['errors'] = $errors;
        } 
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 

    public function dataitems()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->stok_model->get_pilihanitem_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean($r->kategori);  
            $row[] = $this->security->xss_clean(rupiah($r->harga_jual));   
            $row[] = $this->security->xss_clean($r->satuan);  
            $row[] = ' 
            <a onclick="pilih(this)"  data-harga="'.rupiah($r->harga_jual).'" data-stok="'.$r->stok.'" data-satuan="'.$r->satuan.'"  data-namaitem="'.$r->nama_item.'" data-id="'.$r->kode_item.'" class="mt-xs mr-xs btn btn-info datarowobat" role="button"><i class="fa fa-check-square-o"></i></a>
           
                    '; 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_pilihanitem(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_pilihanitem(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }

    public function kartustok()
	{   
        level_user('stok','kartustok',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/stok/kartustok');
    }  
	
    public function datakartustok()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->stok_model->get_datakartustok_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
			$row[] = ' 
                <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)" data-id="'.$r->kode_item.'">Detail</a></li>  
                        </ul>
                    </div>
			';
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean(bilanganbulat($r->stok));   
            $row[] = $this->security->xss_clean($r->lokasi); 
            $data[] = $row; 
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->stok_model->count_all_datatable_datakartustok(),
            "recordsFiltered" => $this->stok_model->count_filtered_datatable_datakartustok(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function viewhtmlkartustok(){ 
        $startdate = $this->input->post("startdate");   
        $enddate = $this->input->post("enddate");   
        $idd = $this->input->post("idd");   
        if(isset($idd) === TRUE AND $idd[0]!=''){        
            $data['total_keluar'] = $this->db->select_sum('jumlah_keluar')->where('kode_item', $idd )->where('tanggal <=', date('Y-m-d', strtotime($startdate)) )->get('kartu_stok')->row()->jumlah_keluar;
            $data['total_masuk'] = $this->db->select_sum('jumlah_masuk')->where('kode_item', $idd )->where('tanggal <=', date('Y-m-d', strtotime($startdate)) )->get('kartu_stok')->row()->jumlah_masuk;
            $data['rincianstok']  = $this->stok_model->rincianstok(); 
            $data['namaproduk']  = $this->stok_model->namaproduk(); 
            $this->load->model('pembelian_model'); 
            $data['profil'] = $this->pembelian_model->data_profil();  
            $this->load->view('member/stok/htmlkartustok',$data);
        }else{
            echo "<script>alert('Tidak ada item yang dipilih'); window.location='".base_url()."stok/kartustok'</script>";
        }
    }
    
}
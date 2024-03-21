<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pembelian extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        } 
		$this->load->model("pembelian_model");
        $this->load->library(array('form_validation','datatables'));
        $this->load->helper(array('string','security','form')); 
    } 
	public function index()
	{    
        level_user('pembelian','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['total_po'] = $this->db->count_all('purchase_order'); 
        $data['total_pembelian'] = $this->db->count_all('pembelian_langsung'); 
        $data['total_penerimaan'] = $this->db->count_all('penerimaan_barang'); 
        $data['total_retur'] = $this->db->count_all('retur_pembelian');  
        $this->load->view('member/pembelian/beranda',$data);
    }   

	public function po()
	{   
        level_user('pembelian','po',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['supplier'] = $this->db->get('master_supplier')->result(); 
        $this->load->view('member/pembelian/po',$data); 
    }  

    public function datapo()
	{   
        cekajax();
		header('Content-Type: application/json');
		echo $this->pembelian_model->getallpo(); 
    }  
    
    public function podetail(){  
        cekajax(); 
        $idd = $this->input->get("id");  
        $query = $this->pembelian_model->get_po($idd); 
            foreach ($query as $po_data) {        
            if($po_data['termin'] < 1){
                $termin = "-";
            }else{
                $termin = $po_data['termin']." hari";
            }     
            $result = array(  
                "nomor_po" => $this->security->xss_clean($po_data['nomor_po']),
                "tgl_po" => $this->security->xss_clean(tgl_indo($po_data['tgl_po'])),
                "tgl_po_ymd" => $this->security->xss_clean($po_data['tgl_po']),
                "termin" => $this->security->xss_clean($termin),
                "terminint" => $this->security->xss_clean($po_data['termin']),
                "pembayaran" => $this->security->xss_clean($po_data['pembayaran']),
                "kode_supplier" => $this->security->xss_clean($po_data['supplier']),
                "supplier" => $this->security->xss_clean($po_data['nama_supplier']),
                "totalbiaya" => $this->security->xss_clean(rupiah($po_data['total'])),
                "keterangan" => $this->security->xss_clean($po_data['keterangan'])
            );     
        }
        
        $detailpo = $this->db->get_where('purchase_order_detail', array('nomor_po' => $idd)); 
        foreach($detailpo->result() as $r) {    
            $kuantititotal = $r->kuantiti * $r->konversi;
			$subArray['kode_item']=$this->security->xss_clean($r->sku);
			$subArray['nama_item']=$this->security->xss_clean($r->nama_item);
			$subArray['tgl_expired']=$this->security->xss_clean(tgl_indo($r->tgl_expired)); 
			$subArray['harga']=$this->security->xss_clean(rupiah($r->harga));
			$subArray['harga_int']=$this->security->xss_clean($r->harga);
			$subArray['satuan_besar']=$this->security->xss_clean($r->satuan_besar);
			$subArray['satuan_kecil']=$this->security->xss_clean($r->satuan_kecil);   
			$subArray['konversi']=$this->security->xss_clean($r->konversi);    
			$subArray['kuantiti']=$this->security->xss_clean($r->kuantiti);     
			$subArray['kuantititotal']=$this->security->xss_clean($kuantititotal);          
			$subArray['total_harga']=$this->security->xss_clean(rupiah($r->total_harga));  
			$subArray['diskon']=$this->security->xss_clean($r->diskon);    
			$subArray['sku']=$this->security->xss_clean($r->sku);    
			$subArray['harga_int']=$this->security->xss_clean(bilanganbulat($r->harga));  
			$subArray['total_harga_int']=$this->security->xss_clean(bilanganbulat($r->total_harga));  
			$subArray['tgl_expired_ymd']=$this->security->xss_clean($r->tgl_expired); 
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    public function printpo(){ 
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_po($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_po($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
        $this->load->view('member/pembelian/printpo',$data);
    }
    public function pdfpo()
	{
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_po($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_po($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
		$data = $this->load->view('member/pembelian/pdfpo', $data, TRUE);
        $mpdf->setTitle("Purchase Order ".$idd);
		$mpdf->WriteHTML($data);
		$mpdf->Output("Purchase Order ".$idd.".pdf", "D"); 
    }
    
    public function pilihanitem()
	{   
        cekajax(); 
        $get = $this->input->get();
        $list = $this->pembelian_model->get_pilihanitem_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $row[] = $this->security->xss_clean($r->kode_item); 
            $row[] = $this->security->xss_clean($r->nama_item); 
            $row[] = $this->security->xss_clean($r->kategori);   
            $row[] = $this->security->xss_clean($r->satuan);  
            $row[] = ' 
            <a onclick="pilihitem(this)"  data-hargajual="'.rupiah($r->harga_jual).'"   data-stok="'.$r->stok.'" data-satuan="'.$r->satuan.'"  data-namaitem="'.$r->nama_item.'" data-id="'.$r->kode_item.'" class="mt-xs mr-xs btn btn-info datarowobat" role="button"><i class="fa fa-check-square-o"></i></a>
            
                    '; 
            $data[] = $row;
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->pembelian_model->count_all_datatable_pilihanitem(),
            "recordsFiltered" => $this->pembelian_model->count_filtered_datatable_pilihanitem(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function potambah(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespo());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_item = $this->input->post("kode_item"); 
            if(isset($kode_item) === TRUE AND $kode_item[0]!='')
            { 					
				if($simpan->simpandatapo()){ 
					$data['success']= true;
					$data['message']="Berhasil menyimpan data";  
				}else{
					$errors['fail'] = "gagal melakukan update data";
					$data['errors'] = $errors;
				}  
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih item";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function poedit(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespo());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $kode_item = $this->input->post("kode_item");   
            if(isset($kode_item) === TRUE AND $kode_item[0]!='')
            { 		
				if($simpan->updatedatapo()){ 
					$data['success']= true;
					$data['message']="Berhasil menyimpan data";  
				}else{
					$errors['fail'] = "gagal melakukan update data";
					$data['errors'] = $errors;
				}   
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih item";
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
    public function pohapus(){ 
        cekajax(); 
        $hapus = $this->pembelian_model;
        if($hapus->hapusdatapo()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
	public function langsung()
	{   
        level_user('pembelian','langsung',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['supplier'] = $this->db->get('master_supplier')->result(); 
        $data['po'] = $this->db->order_by("nomor_po","DESC")->get('purchase_order')->result(); 
        $this->load->view('member/pembelian/langsung',$data); 
    }  

    
    public function datapembelian()
	{   
        cekajax(); 
        header('Content-Type: application/json');
		echo $this->pembelian_model->getallpembelian(); 
    }
    
    public function pembeliantambah(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembelian());
        $kode_item = $this->input->post("kode_item"); 
        $kategori = $this->input->post("kategori"); 
        $nomor_po = $this->input->post("nomor_po");
        $povalid=$simpan->povalid($nomor_po);  
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            if($kategori == "Purchase Order" AND $povalid->num_rows() < 1){ 
                $errors['jumlah_obat'] = "Nomor PO tidak valid";
                $data['errors'] = $errors;
            } else {
                if(isset($kode_item) === TRUE AND $kode_item[0]!='')
                {  
                    if($simpan->simpandatapembelian()){ 
                        $data['success']= true;
                        $data['message']="Berhasil menyimpan data";  
                    }else{
                        $errors['fail'] = "gagal melakukan update data";
                        $data['errors'] = $errors;
                    }
                }
                else{ 
                    $errors['jumlah_obat'] = "Mohon pilih item";
                    $data['errors'] = $errors;
                }
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
     
    public function pembeliandetail(){  
        cekajax(); 
        $idd = $this->input->get("id");  
        $query = $this->pembelian_model->get_pembelian($idd); 
            foreach ($query as $po_data) {        
            if($po_data['termin'] < 1){
                $termin = "-";
            }else{
                $termin = $po_data['termin']." hari";
            }     
            $result = array(  
                "nomor_faktur" => $this->security->xss_clean($po_data['nomor_faktur']),
                "kategori" => $this->security->xss_clean($po_data['kategori']),
                "nomor_po" => $this->security->xss_clean($po_data['nomor_po']),
                "tgl_pembelian" => $this->security->xss_clean(tgl_indo($po_data['tgl_pembelian'])),
                "tgl_pembelian_ymd" => $this->security->xss_clean($po_data['tgl_pembelian']),
                "termin" => $this->security->xss_clean($termin),
                "termin_int" => $this->security->xss_clean($po_data['termin']),
                "pembayaran" => $this->security->xss_clean($po_data['pembayaran']),
                "kode_supplier" => $this->security->xss_clean($po_data['supplier']),
                "supplier" => $this->security->xss_clean($po_data['nama_supplier']),
                "totalbiaya" => $this->security->xss_clean(rupiah($po_data['total'])),
                "keterangan" => $this->security->xss_clean($po_data['keterangan'])
            );     
        }
        
        $detailpo = $this->db->get_where('pembelian_langsung_detail', array('nomor_faktur' => $idd)); 
        foreach($detailpo->result() as $r) {   
            $kuantiti = $r->kuantiti*$r->konversi;
			$subArray['kode_item']=$this->security->xss_clean($r->sku);
			$subArray['nama_item']=$this->security->xss_clean($r->nama_item);
			$subArray['tgl_expired']=$this->security->xss_clean(tgl_indo($r->tgl_expired)); 
			$subArray['tgl_expired_ymd']=$this->security->xss_clean($r->tgl_expired); 
			$subArray['harga']=$this->security->xss_clean(rupiah($r->harga));
			$subArray['satuan_besar']=$this->security->xss_clean($r->satuan_besar);
			$subArray['satuan_kecil']=$this->security->xss_clean($r->satuan_kecil);   
			$subArray['konversi']=$this->security->xss_clean($r->konversi);    
			$subArray['kuantiti']=$this->security->xss_clean($kuantiti);    
			$subArray['total_harga']=$this->security->xss_clean(rupiah($r->total_harga));  
			$subArray['diskon']=$this->security->xss_clean($r->diskon);    
			$subArray['sku']=$this->security->xss_clean($r->sku);    
			$subArray['harga_int']=$this->security->xss_clean(bilanganbulat($r->harga));  
			$subArray['total_harga_int']=$this->security->xss_clean(bilanganbulat($r->total_harga));  
			$subArray['tgl_expired_ymd']=$this->security->xss_clean($r->tgl_expired); 
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    
    public function printpembelian(){ 
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_pembelian($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_pembelian($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
        $this->load->view('member/pembelian/printpembelian',$data);
    }
    
    public function pdfpembelian()
	{
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_pembelian($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_pembelian($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
		$data = $this->load->view('member/pembelian/pdfpembelian', $data, TRUE);
        $mpdf->setTitle("Faktur Pembelian ".$idd);
		$mpdf->WriteHTML($data);
		$mpdf->Output("Faktur Pembelian ".$idd.".pdf", "D"); 
    }
    
    public function pembelianedit(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespembelian());
        $kode_item = $this->input->post("kode_item"); 
        $kategori = $this->input->post("kategori"); 
        $nomor_po = $this->input->post("nomor_po");
        $povalid=$simpan->povalid($nomor_po);  
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            if($kategori == "Purchase Order" AND $povalid->num_rows() < 1){ 
                $errors['jumlah_obat'] = "Nomor PO tidak valid";
                $data['errors'] = $errors;
            }
            else{ 
                if(isset($kode_item) === TRUE AND $kode_item[0]!='')
                {   
                    if($simpan->updatedatapembelian()){ 
                        $data['success']= true;
                        $data['message']="Berhasil menyimpan data";  
                    }else{
                        $errors['fail'] = "gagal melakukan update data";
                        $data['errors'] = $errors;
                    } 
                }
                else{ 
                    $errors['jumlah_obat'] = "Mohon pilih item";
                    $data['errors'] = $errors;
                }
            }   
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function pembelianhapus(){ 
        cekajax(); 
        $hapus = $this->pembelian_model;
        if($hapus->hapusdatapembelian()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    
	public function penerimaan()
	{   
        level_user('pembelian','penerimaan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['faktur'] = $this->db->order_by("nomor_faktur","DESC")->get('pembelian_langsung')->result(); 
        $this->load->view('member/pembelian/penerimaan',$data); 
    }   
    
    public function datapenerimaan()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->pembelian_model->get_penerimaan_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('pembelian','penerimaan',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$r->nomor_rec.'">Hapus</a></li>':'';
                
            $row[] = ' 
                 <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)"  data-id="'.$this->security->xss_clean($r->nomor_rec).'">Detail</a></li> 
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal_penerimaan));
            $row[] = $this->security->xss_clean($r->nomor_rec);
            $row[] = $this->security->xss_clean($r->nomor_faktur); 
            $row[] = $this->security->xss_clean($r->penerima);
            $data[] = $row;  
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->pembelian_model->count_all_datatable_penerimaan(),
            "recordsFiltered" => $this->pembelian_model->count_filtered_datatable_penerimaan(),
            "data" => $data,
        ); 
        echo json_encode($result);
    }
    
    public function penerimaantambah(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulespenerimaan());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{            
            $nomor_faktur = $this->input->post("nomor_faktur"); 
            if($nomor_faktur !='' || isset($nomor_faktur) === TRUE)
            {   
                if($simpan->simpandatapenerimaan()){ 
                    $data['success']= true;
                    $data['message']="Berhasil menyimpan data";  
                }else{
                    $errors['fail'] = "gagal melakukan update data";
                    $data['errors'] = $errors;
                }
            }
            else{ 
                $errors['jumlah_obat'] = "Mohon pilih faktur"; 
                $data['errors'] = $errors;
            }
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
    public function penerimaandetail(){  
        cekajax(); 
        $idd = $this->input->get("id");  
        $query = $this->pembelian_model->get_penerimaan($idd); 
            foreach ($query as $po_data) {         
            $result = array(  
                "nomor_rec" => $this->security->xss_clean($po_data['nomor_rec']),
                "tanggal_penerimaan" => $this->security->xss_clean(tgl_indo($po_data['tanggal_penerimaan'])),
                "tanggal_penerimaan_ymd" => $this->security->xss_clean($po_data['tanggal_penerimaan']),
                "nomor_faktur" => $this->security->xss_clean($po_data['nomor_faktur']), 
                "nomor_po" => $this->security->xss_clean($po_data['nomor_po']),
                "penerima" => $this->security->xss_clean($po_data['penerima']),
                "nama_supplier" => $this->security->xss_clean($po_data['nama_supplier']),
                "keterangan" => $this->security->xss_clean($po_data['keterangan'])
            );     
        }
        
        $detailpo = $this->db->get_where('penerimaan_barang_detail', array('nomor_rec' => $idd)); 
        foreach($detailpo->result() as $r) {    
			$subArray['id_item']=$this->security->xss_clean($r->idd);
			$subArray['kode_item']=$this->security->xss_clean($r->sku);
			$subArray['nama_item']=$this->security->xss_clean($r->nama_item);
			$subArray['tgl_expired']=$this->security->xss_clean(tgl_indo($r->tgl_expired));   
			$subArray['tgl_expired_ymd']=$this->security->xss_clean($r->tgl_expired);   
			$subArray['satuan_kecil']=$this->security->xss_clean($r->satuan_kecil);      
			$subArray['kuantiti']=$this->security->xss_clean($r->kuantiti);      
			$subArray['sku']=$this->security->xss_clean($r->sku);     
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    
    public function printpenerimaan(){ 
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['penerimaan_data'] = $this->pembelian_model->get_penerimaan($idd); 
        $data['detail_penerimaan']  = $this->pembelian_model->detail_penerimaan($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['penerimaan_data'] != TRUE) show_404(); 
        $this->load->view('member/pembelian/printpenerimaan',$data);
    }
    public function pdfpenerimaan()
	{
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['penerimaan_data'] = $this->pembelian_model->get_penerimaan($idd); 
        $data['detail_penerimaan']  = $this->pembelian_model->detail_penerimaan($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['penerimaan_data'] != TRUE) show_404(); 
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
		$data = $this->load->view('member/pembelian/pdfpenerimaan', $data, TRUE);
        $mpdf->setTitle("Penerimaan Barang ".$idd);
		$mpdf->WriteHTML($data);
		$mpdf->Output("Penerimaan Barang ".$idd.".pdf", "D"); 
    }
     
     
    public function penerimaanhapus(){ 
        cekajax(); 
        $hapus = $this->pembelian_model;  
        if($hapus->hapusdatapenerimaan()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors['fail'] = "gagal menghapus data";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    }
	
	public function retur()
	{   
        level_user('pembelian','retur',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['penerimaan'] = $this->db->order_by("nomor_rec","DESC")->get('penerimaan_barang')->result(); 
        $this->load->view('member/pembelian/retur',$data); 
    }  
    public function dataretur()
	{    
        cekajax();
        $get = $this->input->get();
        $list = $this->pembelian_model->get_retur_datatable();
        $data = array(); 
        foreach ($list as $r) { 
            $row = array(); 
            $tombolhapus = level_user('pembelian','retur',$this->session->userdata('kategori'),'delete') > 0 ? '<li><a href="#" onclick="hapus(this)" data-id="'.$this->security->xss_clean($r->nomor_retur).'">Hapus</a></li>':'';
                $tomboledit = level_user('pembelian','retur',$this->session->userdata('kategori'),'edit') > 0 ? '<li><a href="#" onclick="edit(this)" data-id="'.$this->security->xss_clean($r->nomor_retur).'">Edit</a></li>':''; 
            $row[] = '  
                 <div class="btn-group dropup">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="detail(this)"  data-id="'.$this->security->xss_clean($r->nomor_retur).'">Detail</a></li>
                            '.$tomboledit.'
                            '.$tombolhapus.'
                        </ul>
                    </div>
                    ';
            $row[] = $this->security->xss_clean(tgl_indo($r->tanggal_retur));
            $row[] = $this->security->xss_clean($r->nomor_retur);
            $row[] = $this->security->xss_clean($r->nomor_rec_penerimaan); 
            $row[] = $this->security->xss_clean($r->nomor_faktur);
            $data[] = $row;   
        } 
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->pembelian_model->count_all_datatable_retur(),
            "recordsFiltered" => $this->pembelian_model->count_filtered_datatable_retur(),
            "data" => $data,
        ); 
        echo json_encode($result);  
    }
    public function returtambah(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesretur());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{  
			if($simpan->simpandataretur()){ 
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
    public function returdetail(){  
        cekajax(); 
        $idd = $this->input->get("id");  
        $query = $this->pembelian_model->get_retur($idd); 
            foreach ($query as $po_data) {         
            $result = array(  
                "nomor_retur" => $this->security->xss_clean($po_data['nomor_retur']),
                "nomor_rec_penerimaan" => $this->security->xss_clean($po_data['nomor_rec_penerimaan']),
                "tanggal_retur" => $this->security->xss_clean(tgl_indo($po_data['tanggal_retur'])),
                "tanggal_retur_ymd" => $this->security->xss_clean($po_data['tanggal_retur']),
                "nomor_faktur" => $this->security->xss_clean($po_data['nomor_faktur']),  
                "penerima" => $this->security->xss_clean($po_data['penerima']),
                "nama_supplier" => $this->security->xss_clean($po_data['nama_supplier']),
                "keterangan" => $this->security->xss_clean($po_data['keterangan'])
            );     
        }
        
        $detailpo = $this->db->get_where('retur_detail', array('nomor_retur' => $idd)); 
        foreach($detailpo->result() as $r) {    
			$subArray['id_item']=$this->security->xss_clean($r->idd);
			$subArray['kode_item']=$this->security->xss_clean($r->sku);
			$subArray['nama_item']=$this->security->xss_clean($r->nama_item);
			$subArray['tgl_expired']=$this->security->xss_clean(tgl_indo($r->tgl_expired)); 
			$subArray['tgl_expired_ymd']=$this->security->xss_clean($r->tgl_expired);   
			$subArray['satuan_kecil']=$this->security->xss_clean($r->satuan_kecil);      
			$subArray['kuantiti']=$this->security->xss_clean($r->kuantiti);      
			$subArray['sku']=$this->security->xss_clean($r->sku);     
            $arraysub[] =  $subArray ; 
        }  
        $datasub = $arraysub;
        $array[] =  $result ; 
        echo'{"datarows":'.json_encode($array).',"datasub":'.json_encode($datasub).'}';
    } 
    public function returedit(){ 
        cekajax(); 
        $simpan = $this->pembelian_model;
		$validation = $this->form_validation; 
        $validation->set_rules($simpan->rulesreturedit());
		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
			$data['errors'] = $errors;
        }else{ 		
			if($simpan->updatedataretur()){ 
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
    public function returhapus(){ 
        cekajax(); 
        $hapus = $this->pembelian_model;
        if($hapus->hapusdataretur()){ 
            $data['success']= true;
            $data['message']="Berhasil menghapus data"; 
        }else{    
            $errors="fail";
			$data['errors'] = $errors;
        }
        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data); 
    } 
    
    public function printretur(){ 
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_retur($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_retur($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
        $this->load->view('member/pembelian/printretur',$data);
    }
    public function pdfretur()
	{
        $idd = $this->security->xss_clean($this->uri->segment(3)); 
        $data['po_data'] = $this->pembelian_model->get_retur($idd); 
        $data['detail_po']  = $this->pembelian_model->detail_retur($idd);  
        $data['profil'] = $this->pembelian_model->data_profil(); 
        if($data['po_data'] != TRUE) show_404(); 
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Legal']);
		$data = $this->load->view('member/pembelian/pdfretur', $data, TRUE);
        $mpdf->setTitle("Retur Pembelian ".$idd);
		$mpdf->WriteHTML($data);
		$mpdf->Output("Retur Pembelian ".$idd.".pdf", "D"); 
    }
    function po_data(){  
        cekajax();
        $po_hari = $this->db->select('*')->from('purchase_order')->where('tgl_po ="'. date('Y-m-d').'"')->get()->num_rows();
        $po_minggu = $this->db->select('*')->from('purchase_order')->where('tgl_po BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->num_rows();
        $po_bulan = $this->db->select('*')->from('purchase_order')->where('tgl_po BETWEEN "'. date('Y-m-01'). '" and "'. date('Y-m-t').'"')->get()->num_rows();
        
        $result = array(   
            "po_bulan" => $this->security->xss_clean($po_bulan),
            "po_hari" => $this->security->xss_clean($po_hari),
            "po_minggu" => $this->security->xss_clean($po_minggu),
        );    
        echo'['.json_encode($result).']';
    }

    function pembelian_data(){  
        cekajax();
        $pembelian_hari = $this->db->select('*')->from('pembelian_langsung')->where('tgl_pembelian ="'. date('Y-m-d').'"')->get()->num_rows();
        $pembelian_minggu = $this->db->select('*')->from('pembelian_langsung')->where('tgl_pembelian BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->num_rows();
        $pembelian_bulan = $this->db->select('*')->from('pembelian_langsung')->where('tgl_pembelian BETWEEN "'. date('Y-m-01'). '" and "'. date('Y-m-t').'"')->get()->num_rows();
        
        $result = array(   
            "pembelian_bulan" => $this->security->xss_clean($pembelian_bulan),
            "pembelian_hari" => $this->security->xss_clean($pembelian_hari),
            "pembelian_minggu" => $this->security->xss_clean($pembelian_minggu),
        );    
        echo'['.json_encode($result).']';
    }

    function penerimaan_data(){  
        cekajax();
        $penerimaan_hari = $this->db->select('*')->from('penerimaan_barang')->where('tanggal_penerimaan ="'. date('Y-m-d').'"')->get()->num_rows();
        $penerimaan_minggu = $this->db->select('*')->from('penerimaan_barang')->where('tanggal_penerimaan BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->num_rows();
        $penerimaan_bulan = $this->db->select('*')->from('penerimaan_barang')->where('tanggal_penerimaan BETWEEN "'. date('Y-m-01'). '" and "'. date('Y-m-t').'"')->get()->num_rows();
        
        $result = array(   
            "penerimaan_bulan" => $this->security->xss_clean($penerimaan_bulan),
            "penerimaan_hari" => $this->security->xss_clean($penerimaan_hari),
            "penerimaan_minggu" => $this->security->xss_clean($penerimaan_minggu),
        );    
        echo'['.json_encode($result).']';
    }

    function retur_data(){  
        cekajax();
        $retur_hari = $this->db->select('*')->from('retur_pembelian')->where('tanggal_retur ="'. date('Y-m-d').'"')->get()->num_rows();
        $retur_minggu = $this->db->select('*')->from('retur_pembelian')->where('tanggal_retur BETWEEN "'. date('Y-m-d', strtotime('monday this week')). '" and "'. date('Y-m-d', strtotime('sunday this week')).'"')->get()->num_rows();
        $retur_bulan = $this->db->select('*')->from('retur_pembelian')->where('tanggal_retur BETWEEN "'. date('Y-m-01'). '" and "'. date('Y-m-t').'"')->get()->num_rows();
        
        $result = array(   
            "retur_bulan" => $this->security->xss_clean($retur_bulan),
            "retur_hari" => $this->security->xss_clean($retur_hari),
            "retur_minggu" => $this->security->xss_clean($retur_minggu),
        );    
        echo'['.json_encode($result).']';
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {    
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('dashboard_model'); 
    } 
	public function index()
	{  
        level_user('dashboard','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/beranda/beranda');  
    }
    public function logout()
	{ 
        $this->session->sess_destroy();  
        redirect(base_url());
    } 
    public function penjualan_2_minggu(){ 
        cekajax(); 
        $now = new DateTime('12 days ago');
        $interval = new DateInterval( 'P1D');
        $period = new DatePeriod( $now, $interval, 13); 
        foreach( $period as $day) {
            $tgl = $day->format( 'Y-m-d');  
            $data['jumlah'] = $this->dashboard_model->penjualan($tgl); 
            $data['tanggal'] = $tgl;
            $data_array[] = $data;
        } 
        echo json_encode($data_array);
    }
    public function cash_2_minggu(){ 
        cekajax();
        $now = new DateTime('12 days ago');
        $interval = new DateInterval( 'P1D');
        $period = new DatePeriod( $now, $interval, 13); 
        foreach( $period as $day) {
            $tgl = $day->format( 'Y-m-d');   
            $masuk = $this->dashboard_model->cash_masuk($tgl); 
            $data['masuk'] = $masuk->total == null ? 0 : $masuk->total;
            $keluar = $this->dashboard_model->cash_keluar($tgl); 
            $data['keluar'] = $keluar->total == null ? 0 : $keluar->total;
            $data['tanggal'] = $tgl;
            $data_array[] = $data;
        } 
        echo json_encode($data_array);
    }

    public function laporan_ringkas(){ 
        cekajax();    
        $total_penjualan_hari_ini = $this->dashboard_model->total_penjualan_hari_ini();
        $total_penjualan_minggu_ini = $this->dashboard_model->total_penjualan_minggu_ini(); 
        $total_penjualan_bulan_ini = $this->dashboard_model->total_penjualan_bulan_ini();  
        $akan_jatuh_tempo = $this->dashboard_model->akan_jatuh_tempo();  
        $sudah_jatuh_tempo = $this->dashboard_model->sudah_jatuh_tempo();  
        $dibayar_minggu = $this->dashboard_model->dibayar_minggu();  
        $total_hutang_belum_bayar = $this->dashboard_model->total_hutang_belum_bayar();  
        $total_piutang_belum_bayar = $this->dashboard_model->total_piutang_belum_bayar();   
        $total_po = $this->db->count_all('purchase_order');
        $total_pembelian = $this->db->count_all('pembelian_langsung');  
        $total_penerimaan = $this->db->count_all('penerimaan_barang'); 
        $total_retur = $this->db->count_all('retur_pembelian');  
         
        $result = array(   
            "total_po" => $this->security->xss_clean($total_po." Transaksi"),
            "total_pembelian" => $this->security->xss_clean($total_pembelian." Transaksi"),
            "total_penerimaan" => $this->security->xss_clean($total_penerimaan." Transaksi"),
            "total_retur" => $this->security->xss_clean($total_retur." Transaksi"),
            "akan_jatuh_tempo" => $this->security->xss_clean($akan_jatuh_tempo." Transaksi"),
            "sudah_jatuh_tempo" => $this->security->xss_clean($sudah_jatuh_tempo." Transaksi"),
            "total_hutang_belum_bayar" => $this->security->xss_clean(rupiah($total_hutang_belum_bayar->total)),
            "total_penjualan_minggu_ini" => $this->security->xss_clean(rupiah($total_penjualan_minggu_ini->total)),
            "total_piutang_belum_bayar" => $this->security->xss_clean(rupiah($total_piutang_belum_bayar->total)),
            "total_penjualan_hari_ini" => $this->security->xss_clean(rupiah($total_penjualan_hari_ini->total)),
            "total_penjualan_bulan_ini" => $this->security->xss_clean(rupiah($total_penjualan_bulan_ini->total)),
            "dibayar_minggu" => $this->security->xss_clean(rupiah($dibayar_minggu->total)),
         );    
        echo'['.json_encode($result).']';
    }
     
    

    public function produk_kadaluarsa(){     
        cekajax();    
        $subitem= $this->dashboard_model->get_produk_kadaluarsa(); 
        $arraysub =[];
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_item;
			$subArray['nama_item']=$r->nama_item;  
			$subArray['tgl_expired']= tgl_indo($r->tgl_expired);       
            $arraysub[] =  $subArray ; 
        }   
        echo'{"datasub":'.json_encode($arraysub).'}';
    }

    public function produk_terlaris(){     
        cekajax();    
        $subitem= $this->dashboard_model->get_produk_terlaris(); 
        $arraysub =[];
        foreach($subitem as $r) {   
			$subArray['kode_item']=$r->kode_item;
			$subArray['nama_item']=$r->nama_item;   
			$subArray['total']=$r->total ." ". $r->satuan;   
            $arraysub[] =  $subArray ; 
        }   
        echo'{"datasub":'.json_encode($arraysub).'}';
    }

}

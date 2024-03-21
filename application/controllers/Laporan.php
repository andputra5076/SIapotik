<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./phpspreadsheet/vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 

class Laporan extends CI_Controller {   
    function __construct(){
        parent::__construct();
        if($this->session->userdata('login') != TRUE){    
            redirect(base_url('login'));
        }    
        $this->load->model('laporan_model');
        $this->load->library('form_validation');
        $this->load->helper(array('string','security','form'));
        $this->load->library('Ajax_pagination');
        $this->perPage = 100;
    } 
	public function index()
	{   
        level_user('laporan','index',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $this->load->view('member/laporan/beranda');
    }   
    
	public function pembelian()
	{    
        level_user('laporan','pembelian',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['supplier'] = $this->db->get('master_supplier')->result(); 
        $this->load->view('member/laporan/pembelian',$data);
    }   
	public function laporanpembelian()
	{   
        $conditions = array(); 
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
         
        $supplier = $this->input->get('supplier');
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate'); 
        $conditions['search']['supplier'] = $supplier;
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        //total rows count
        $totalRec = count($this->laporan_model->getrowspembelian($conditions)); 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'laporan/laporanpembelian';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->laporan_model->getrowspembelian($conditions);
        
        //load the view
        $this->load->view('member/laporan/pembelian_view', $data, false);
    }   
    
    function excel_pembelian(){       
        
        $spreadsheet = new Spreadsheet();
        $supplier = $this->input->get('supplier');
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate'); 
        $conditions['search']['supplier'] = $supplier;
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        $conditions['kategori']['excel'] = "excel"; 
        $postdata = $this->laporan_model->getrowspembelian($conditions); 

        $spreadsheet->getProperties()->setCreator('Paber Panjaitan')
        ->setLastModifiedBy('Paber Panjaitan')
        ->setTitle('Laporan Format Excel')
        ->setSubject('Laporan Format Excel');
 
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nomor Faktur')
        ->setCellValue('B1', 'Tanggal Pembelian')
        ->setCellValue('C1', 'Kode Supplier')
        ->setCellValue('D1', 'Nama Supplier')
        ->setCellValue('E1', 'Total')
        ->setCellValue('F1', 'Pembayaran')
        ->setCellValue('G1', 'Termin')
        ->setCellValue('H1', 'Keterangan')
        ;
 
        $i=2; 
        foreach($postdata as $post) { 
            $tgl = tgl_indo($post['tgl_pembelian']);
            $total = rupiah($post['total']);
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $post['nomor_faktur'])
        ->setCellValue('B'.$i, $tgl)
        ->setCellValue('C'.$i, $post['supplier'])
        ->setCellValue('D'.$i, $post['nama_supplier'])
        ->setCellValue('E'.$i, $total)
        ->setCellValue('F'.$i, $post['pembayaran'])
        ->setCellValue('G'.$i, $post['termin']." Hari")
        ->setCellValue('H'.$i, $post['keterangan']);
        $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Pembelian');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Pembelian.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;  
    }

	public function stok()
	{    
        level_user('laporan','stok',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
       $this->load->view('member/laporan/stok');
    }   
    
	public function laporanstok()
	{   
        $conditions = array(); 
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
          
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate');  
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        //total rows count
        $totalRec = count($this->laporan_model->getrowsstok($conditions)); 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'laporan/laporanstok';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->laporan_model->getrowsstok($conditions);
        
        //load the view
        $this->load->view('member/laporan/stok_view', $data, false);
    }   
    
    function excel_stok(){       
        
        $spreadsheet = new Spreadsheet(); 
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate');  
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        $conditions['kategori']['excel'] = "excel"; 
        $postdata = $this->laporan_model->getrowsstok($conditions); 

        $spreadsheet->getProperties()->setCreator('Paber Panjaitan')
        ->setLastModifiedBy('Paber Panjaitan')
        ->setTitle('Laporan Format Excel')
        ->setSubject('Laporan Format Excel');
 
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Tanggal')
        ->setCellValue('B1', 'Kode Item')
        ->setCellValue('C1', 'Nama Item')
        ->setCellValue('D1', 'Tanggal Expired')
        ->setCellValue('E1', 'Transaksi')
        ->setCellValue('F1', 'Masuk')
        ->setCellValue('G1', 'Keluar')
        ->setCellValue('H1', 'Satuan')
        ;
 
        $i=2; 
        foreach($postdata as $post) { 
            $tgl = tgl_indo($post['tanggal']);
            $expired = tgl_indo($post['tgl_expired']); 
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $tgl)
        ->setCellValue('B'.$i, $post['kode_item'])
        ->setCellValue('C'.$i, $post['nama_item'])
        ->setCellValue('D'.$i, $expired)
        ->setCellValue('E'.$i, $post['jenis_transaksi'])
        ->setCellValue('F'.$i, $post['jumlah_masuk']) 
        ->setCellValue('G'.$i, $post['jumlah_keluar']) 
        ->setCellValue('H'.$i, $post['satuan_kecil']);
        $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Purchase Order');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Stok.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;  
    }
    
	public function penjualan()
	{     
        level_user('laporan','penjualan',$this->session->userdata('kategori'),'read') > 0 ? '': show_404();
        $data['admin'] = $this->db->get('master_admin')->result(); 
        $this->load->view('member/laporan/penjualan',$data);
    }   
    
	public function laporanpenjualan()
	{   
        $conditions = array(); 
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
         
        $kasir = $this->input->get('kasir');
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate'); 
        $conditions['search']['kasir'] = $kasir;
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        //total rows count
        $totalRec = count($this->laporan_model->getrowspenjualan($conditions)); 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'laporan/laporanpenjualan';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->laporan_model->getrowspenjualan($conditions);
        
        //load the view
        $this->load->view('member/laporan/penjualan_view', $data, false);
    }   
    
    function excel_penjualan(){       
        
        $spreadsheet = new Spreadsheet();
        $kasir = $this->input->get('kasir');
        $firstdate = $this->input->get('firstdate');
        $lastdate = $this->input->get('lastdate'); 
        $conditions['search']['kasir'] = $kasir;
        $conditions['search']['firstdate'] = $firstdate;
        $conditions['search']['lastdate'] = $lastdate;
        $conditions['kategori']['excel'] = "excel"; 
        $postdata = $this->laporan_model->getrowspenjualan($conditions); 

        $spreadsheet->getProperties()->setCreator('Paber Panjaitan')
        ->setLastModifiedBy('Paber Panjaitan')
        ->setTitle('Laporan Format Excel')
        ->setSubject('Laporan Format Excel');
 
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Tanggal')
        ->setCellValue('B1', 'Kasir')
        ->setCellValue('C1', 'Upah Peracik')
        ->setCellValue('D1', 'Harga Item')
        ->setCellValue('E1', 'Total Harga') 
        ;
 
        $i=2; 
        foreach($postdata as $post) { 
            $tgl = tgl_indo($post['tanggal']);
            $total_upah_peracik = rupiah($post['total_upah_peracik']);
            $total_harga_item = rupiah($post['total_harga_item']);
            $total = rupiah($post['total']);
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $tgl)
        ->setCellValue('B'.$i, $post['nama_admin'])
        ->setCellValue('C'.$i, $total_upah_peracik)
        ->setCellValue('D'.$i, $total_harga_item)
        ->setCellValue('E'.$i, $total)
        ;
        $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Laporan Penjualan');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Penjualan.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;  
    }

} 
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
foreach ($penerimaan_data as $penerimaan_data) {
	      
?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<title> Penerimaan Barang <?php echo $penerimaan_data['nomor_rec'];?></title> 
    <style>
    .invoice-box {
        width: 21cm;
        margin: auto;
        padding: 10px;
        border: 2px solid #eee;     
        color: #555;
    } 
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 1px;
        vertical-align: top;
    } 
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title { 
        line-height: 45px;
        color: #333;
    }
     
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 2px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 21cm) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block; 
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block; 
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    } 
    .rincianitem {
        margin-top:20px;  
        padding : 3px;    border-collapse: collapse;
    }
    .rincianitem thead th {
        border: 1px solid #999; 
        padding: 2px;
        font-size:13px;
        text-align:left;
    }
    .rincianitem tr td {
        border: 1px solid #999;
        font-size:13px;
        padding: 2px;
        text-align:left;
    }
    .kuantiti{
        width:80px;
    }
  
    .footer {  
        padding : 3px;    border-collapse: collapse;
        
    } 
    .footer tr td {
        border: 1px solid #999;
        font-size:13px;
        padding: 2px;
        text-align:left;
    } 
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table style="border-bottom:1px solid;">
                        <tr>
                            <td class="title">
                            <img src="<?php echo base_url()?>assets/images/<?php echo $profil->row()->logo; ?>" width="200">
						
                            </td>
                            <td  align="right">
                                <h2>Penerimaan Barang</h2>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
							<b><?php echo $profil->row()->nama_apotek; ?></b>
							<br/>
							<?php echo $profil->row()->alamat; ?> 
                            </td>
                            
                            <td align="right" width="50%">
                                <table>
                                    <tr>
                                        <td>Nomor Record</td>
                                        <td width="5%">:</td>
                                        <td># <?php echo $penerimaan_data['nomor_rec'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Faktur</td>
                                        <td width="5%">:</td>
                                        <td># <?php echo $penerimaan_data['nomor_faktur'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor PO</td>
                                        <td width="5%">:</td>
                                        <td># <?php echo $penerimaan_data['nomor_po'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Penerimaan</td>
                                        <td width="5%">:</td>
                                        <td><?php echo tgl_indo($penerimaan_data['tanggal_penerimaan']); ?></td>
                                    </tr>    
                                    <tr>
                                        <td>Diterima Oleh</td>
                                        <td>:</td>
                                        <td> <?php echo $this->security->xss_clean($penerimaan_data['penerima']);?></td>
							        </tr>    
                                    <tr>
                                        <td>Nama Supplier</td>
                                        <td>:</td>
                                        <td> <?php echo $this->security->xss_clean($penerimaan_data['nama_supplier']);?></td>
							        </tr>  
                                </table>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
            
        <table class="rincianitem">
                    <thead>
						<tr>
							<th>No</th>
							<th>No SKU</th>
							<th>Nama Item</th> 
							<th>Tanggal Expired</th>   
							<th class="kuantiti">Qty</th>   
						</tr>
					</thead>
					<tbody>
                    <?php 
                    $no = 0;
					foreach($detail_penerimaan->result() as $r) {
					$no = $no + 1; 
					?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $this->security->xss_clean($r->sku);?></td> 
							<td><?php echo $this->security->xss_clean($r->nama_item);?></td> 
							<td><?php echo $this->security->xss_clean(tgl_indo($r->tgl_expired));?></td>   
							<td><?php echo $this->security->xss_clean($r->kuantiti);?> <?php echo $this->security->xss_clean($r->satuan_kecil);?></td> 
						</tr> 
					<?php  
					} ?> 
        </table>
        <table>  
            <tr>
                <td><b>Keterangan : </b>
                    <table class="footer" style="width:400px;"> 
                        <tr> 
                         <td><?php echo $this->security->xss_clean($penerimaan_data['keterangan']);?><br/> </td>
                        </tr>
                    </table>
                </td>
            </tr> 
        </table>
        <br/>
        <br/>
        <br/>
        <br/>
        <table align="center" style="width:100%;">
            <tr>
                <td align="center">Disiapkan Oleh</td>
                <td align="center" style="text-align:center">Disetujui Oleh</td>
                <td align="center">Diketahui Oleh</td>
            </tr> 
            <tr>
                <td align="center"><br/><br/><br/><hr  style="border-bottom:1px solid #000; width:50%;"/></td> 
                <td align="center"><br/><br/><br/><hr  style="border-bottom:1px solid #000; width:50%;"/></td> 
                <td align="center"><br/><br/><br/><hr  style="border-bottom:1px solid #000; width:50%;"/></td> 
            </tr>
	    </table>
    </div>
	
	<script>
		window.print();
		</script> 
</body>
</html>

<?php }
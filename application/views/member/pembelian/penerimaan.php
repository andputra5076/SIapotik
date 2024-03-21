<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html class="fixed sidebar-left-collapsed">
	<head>  
		<meta charset="UTF-8"> 
		<link rel="shortcut icon" href="<?php echo base_url()?>/assets/images/favicon.png" type="image/ico">   
		<title>Apotek</title>    
		<meta name="author" content="Paber">   
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/theme.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/skins/default.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/theme-custom.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/pnotify/pnotify.custom.css" />

		<!-- Head Libs -->
		<script src="<?php echo base_url()?>/assets/vendor/modernizr/modernizr.js"></script>
	</head>
	<body class="bgbody">
		<section class="body">

			<?php $this->load->view("komponen/header.php") ?>
			<div class="inner-wrapper"> 
				<?php $this->load->view("komponen/sidebar.php") ?>
				<section role="main" class="content-body">
					<header class="page-header">  
						<h2>Penerimaan Barang</h2>
					</header>  
					<!-- start: page -->
                    <section class="panel"> 
                        <div class="panel-body">       

                            <div class="row"> 
                            <div class="col-md-12 col-lg-12 col-xl-4">
                                <div class="row">
                                    <div class="col-md-4 col-xl-12">
                                        <section class="panel">
                                            <div class="panel-body bg-primary">
                                                <div class="widget-summary"> 
                                                    <div class="widget-summary-col">
                                                        <div class="summary">
                                                            <h4 class="title">Jumlah Penerimaan Hari Ini</h4>
                                                            <div class="info">
                                                                <strong class="amount" id="penerimaan_hari_ini"></strong>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div> 
                                    <div class="col-md-4 col-xl-12">
                                        <section class="panel">
                                            <div class="panel-body bg-primary">
                                                <div class="widget-summary"> 
                                                    <div class="widget-summary-col">
                                                        <div class="summary">
                                                            <h4 class="title">Jumlah Penerimaan Minggu Ini</h4>
                                                            <div class="info">
                                                                <strong class="amount" id="penerimaan_minggu_ini"></strong>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div> 
                                    <div class="col-md-4 col-xl-12">
                                        <section class="panel">
                                            <div class="panel-body bg-primary">
                                                <div class="widget-summary"> 
                                                    <div class="widget-summary-col">
                                                        <div class="summary">
                                                            <h4 class="title">Jumlah Penerimaan Bulan Ini</h4>
                                                            <div class="info">
                                                                <strong class="amount" id="penerimaan_bulan_ini"></strong>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        

                        </div>
                    </section>
                    <section class="panel">
                        <header class="panel-heading">    
                            <div class="row show-grid">
                                <div class="col-md-6" align="left"><h2 class="panel-title">Data Penerimaan Barang</h2></div>
                                <?php  
                                echo level_user('pembelian','penerimaan',$this->session->userdata('kategori'),'add') > 0 ? '<div class="col-md-6" align="right"><a class="btn btn-success" href="#"  data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah</a></div>':'';
                                ?> 
							</div>
                        </header>
                        <div class="panel-body"> 
                                <table class="table table-bordered table-hover table-striped" id="penerimaandata">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tanggal Penerimaan</th>
                                            <th>Nomor Record</th>
                                            <th>Nomor Faktur</th>
                                            <th>Penerima</th>   
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table> 
                        </div>
                    </section>
					<!-- end: page -->
				</section>
			</div>
		</section>

		
        <div class="modal fade bd-example-modal-lg" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:90%">
                <div class="modal-content">
                <section class="panel panel-primary">
                    <?php echo form_open('pembelian/penerimaantambah',' id="FormulirTambah" enctype="multipart/form-data"');?>  
                    <header class="panel-heading">
                        <h2 class="panel-title">Form Penerimaan Barang</h2>
                    </header>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group mt-lg nomor_faktur">
                                <label class="col-sm-3 control-label">Nomor Faktur<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" required id="nomor_faktur" name="nomor_faktur" required>  
                                        <option value="">Pilih Faktur</option>
    									<?php foreach ($faktur as $supp): ?>
                                        <option value="<?php echo $supp->nomor_faktur;?>"><?php echo $supp->nomor_faktur;?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group mt-lg nomor_po">
                                <label class="col-sm-3 control-label">Nomor PO<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control nomor_po" readonly/>
                                    <input type="hidden" name="nomor_po" class="nomor_po"/>
                                </div>
                            </div>     
                            <div class="form-group mt-lg supplier">
                                <label class="col-sm-3 control-label">Supplier<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control supplier" readonly/>
                                </div>
                            </div>     
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-lg tanggal_penerimaan">
                                <label class="col-sm-3 control-label">Tanggal Penerimaan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="tanggal_penerimaan" class="form-control tanggal" data-plugin-datepicker required/>
                                </div>
                            </div> 
                            <div class="form-group penerima">
                                <label class="col-sm-3 control-label">Diterima Oleh<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="penerima" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group keterangan">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea rows="2" class="form-control"   name="keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row" style="overflow-x: auto;white-space: nowrap;"> 
                        <div class="col-md-12">
                            <h3>Rincian Item Yang Diterima</h3> 
                            <div class="table-responsive" style="max-height:420px;"> 
                                <table class="table table-bordered table-hover table-striped dataTable no-footer listitemditerima">
                                <thead>
                                    <tr> 
                                        <th style="min-width:200px;">Nomor SKU</th>
                                        <th style="min-width:400px;">Nama Item</th>
                                        <th style="min-width:150px;">Tanggal Expired</th> 
                                        <th style="min-width:100px;">Satuan</th> 
                                        <th style="min-width:100px;">Kuantiti Dipesan</th>  
                                        <th style="min-width:100px;">Kuantiti Diterima</th>  
                                    </tr>
                                </thead>
                                <tbody> 
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-primary modal-confirm" type="submit" id="submitform">Submit</button>
                                <button class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </footer>
                    </form>
                </section>
                </div>
            </div>
        </div> 
        <div class="modal fade bd-example-modal-lg" id="detailData"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:90%">
                <div class="modal-content">
                <section class="panel panel-primary">   
                    <header class="panel-heading">
                        <div class="row">
                            <div class="col-md-3 text-left"> 
                            <h2 class="panel-title">Detail Penerimaan</h2>  
                            </div>
                            <div class="col-md-9 text-right">
                                <!-- Tautan PDF yang dinonaktifkan -->
                                <a class="btn btn-success disabled" id="linkpdf" style="visibility: hidden;"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                <a class="btn btn-success" id="linkprint" target="_blank"><i class="fa fa-print"></i> Print</a>
                            </div>
                        </div>
                    </header>
                    <div class="panel-body" id="showdetail"> 
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </footer> 
                </section>
                </div>
            </div>
        </div>

 
        <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel  panel-danger">
                    <header class="panel-heading">
                        <h2 class="panel-title">Konfirmasi Hapus Data</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-icon">
                                <i class="fa fa-question-circle"></i>
                            </div>
                            <div class="modal-text">
                                <h4>Yakin ingin menghapus data ini ?</h4> 
                            </div>
                        </div>
					</div>
                    <footer class="panel-footer"> 
                        <div class="row">
                            <div class="col-md-12 text-right"> 
                                <?php echo form_open('pembelian/penerimaanhapus',' id="FormulirHapus"');?> 
                                <input type="hidden" name="idd" id="idddelete">
                                <button type="submit" class="btn btn-danger" id="submitformHapus">Delete</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </footer>
                </section>
                </div>
            </div>
        </div>   

        <!-- Vendor -->
		<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/select2/select2.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<script src="<?php echo base_url()?>assets/javascripts/theme.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="<?php echo base_url()?>assets/javascripts/theme.init.js"></script> 
		<script type="text/javascript">
        $('.tanggal').datepicker({
            format: 'yyyy-mm-dd' 
        }); 		
		var tabelpenerimaan = $('#penerimaandata').DataTable({  
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": "<?php echo base_url()?>pembelian/datapenerimaan",
				"type": "GET"
			}, 
			"columnDefs": [
				{ 
					"targets": [ 0 ], 
					"orderable": false, 
				},
			], 
		}); 
        function laporan_ringkas(){   
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url()?>pembelian/penerimaan_data', 
                dataType    : 'json',
                success: function(response) {  
                    $.each(response, function(i, item) {  
                    $('#penerimaan_bulan_ini').html(item.penerimaan_bulan);  
                    $('#penerimaan_minggu_ini').html(item.penerimaan_minggu);  
                    $('#penerimaan_hari_ini').html(item.penerimaan_hari);   
                    }); 
                }
            });  
            return false;
        }
        laporan_ringkas(); 
        $('#nomor_faktur').change(function(){
            var dataId = $(this).val();     
            $(".listitemditerima").find("tr:gt(0)").remove(); 
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url()?>pembelian/pembeliandetail',
                data: 'id=' + dataId,
                dataType 	: 'json',
                success: function(response) { 
                    $.each(response.datarows, function(i, item) {   
                            $('.nomor_po').val(item.nomor_po);    
                            $('.supplier').val(item.supplier);    
                    }); 
                    var datarow =''; 
                    $.each(response.datasub, function(i, itemsub) {
                        datarow+="<tr><td>"+itemsub.sku+"</td>"; 
                        datarow+="<td>"+itemsub.nama_item+"</td>"; 
                        datarow+="<td>"+itemsub.tgl_expired+"</td>";   
                        datarow+="<td>"+itemsub.satuan_kecil+"</td>"; 
                        datarow+="<td>"+itemsub.kuantiti+"</td>"; 
                        datarow+="<td><input type='number' name='kuantiti[]' required class='form-control'></td>";
                        datarow+="<input type='hidden' name='kode_item[]' value='"+itemsub.kode_item+"'>";
                        datarow+="<input type='hidden' name='sku[]' value='"+itemsub.sku+"'>";
                        datarow+="<input type='hidden' name='nama_item[]' value='"+itemsub.nama_item+"'>";
                        datarow+="<input type='hidden' name='tgl_expired[]' value='"+itemsub.tgl_expired_ymd+"'>";
                        datarow+="<input type='hidden' name='satuan_kecil[]' value='"+itemsub.satuan_kecil+"'>";
                        datarow+="</tr>"; 
                    });   
                    $('.listitemditerima').append(datarow);
                }
            });  
            return false; 
        }); 
        document.getElementById("FormulirTambah").addEventListener("submit", function (e) {  
			blurForm();       
			$('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitform").setAttribute('disabled','disabled');
			$('#submitform').html('Loading ...');
			var form = $('#FormulirTambah')[0];
			var formData = new FormData(form);
			var xhrAjax = $.ajax({
			type 		: 'POST',
			url 		: $(this).attr('action'),
			data 		: formData, 
			processData: false,
			contentType: false,
			cache: false, 
			dataType 	: 'json'
			}).done(function(data) { 
			if ( ! data.success) {		 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    document.getElementById("submitform").removeAttribute('disabled');  
                    $('#submitform').html('Submit');    
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) { 
                            var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                            $('.'+key).addClass('has-error');
                            $('input[name="' + key + '"]').after(msg);  
                            $('textarea[name="' + key + '"]').after(msg);  
                        }
                        if (key == 'fail') {   
                            new PNotify({
                                title: 'Notifikasi',
                                text: data.errors[key],
                                type: 'danger'
                            }); 
                        }
                    }    
                } else {  
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll(); 
                    tabelpenerimaan.ajax.reload();   
					laporan_ringkas();			
                    document.getElementById("submitform").removeAttribute('disabled'); 
                    document.getElementById("FormulirTambah").reset();  
                    $('#submitform').html('Submit');  
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.message,
                        type: 'success'
                    });  
                    $('#tambahData').modal('hide'); 
                }
                }).fail(function(data) { 
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            });
               
               
        function detail(elem){
            var dataId = $(elem).data("id");   
            $('#detailData').modal();    
            $('#showdetail').html('Loading...'); 
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url()?>pembelian/penerimaandetail',
                data: 'id=' + dataId,
                dataType 	: 'json',
                success: function(response) { 
                    var datarow='<div class="row">';
                    $.each(response.datarows, function(i, item) {
                        document.getElementById('linkprint').setAttribute('href', '<?php echo base_url()?>pembelian/printpenerimaan/'+item.nomor_rec);
                        document.getElementById('linkpdf').setAttribute('href', '<?php echo base_url()?>pembelian/pdfpenerimaan/'+item.nomor_rec);
                        
                        datarow+='<div class="col-md-6">';
                        datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                        datarow+="<tr><td>Nomor Record</td><td>: "+item.nomor_rec+"</td></tr>";
                        datarow+="<tr><td>Nomor Faktur</td><td>: "+item.nomor_faktur+"</td></tr>";
                        datarow+="<tr><td>Nomor PO </td><td>: "+item.nomor_po+"</td></tr>";
                        datarow+="<tr><td>Supplier</td><td>: "+item.nama_supplier+"</td></tr>"; 
                        datarow+="</table>";
                        datarow+='</div>';
                        datarow+='<div class="col-md-6">';
                        datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                        datarow+="<tr><td>Tanggal Penerimaan</td><td>: "+item.tanggal_penerimaan+"</td></tr>";
                        datarow+="<tr><td>Diterima Oleh</td><td>: "+item.penerima+"</td></tr>";
                        datarow+="<tr><td>Keterangan</td><td>: "+item.keterangan+"</td></tr>";
                        datarow+="</table>";
                        datarow+='</div>';
                    });
                    datarow+='</div>';
                    datarow+='<div class="row"><div class="col-md-12">';
                    datarow+='<h3>Rincian</h3>';
                    datarow+='<div class="table-responsive" style="max-height:420px;">';  
                    datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                    datarow+="<thead><tr>";
                    datarow+="<th>No SKU</th>";
                    datarow+="<th>Nama Item</th>";
                    datarow+="<th>Tanggal Expired</th>"; 
                    datarow+="<th>Satuan</th>"; 
                    datarow+="<th>Kuantiti</th>"; 
                    datarow+="</tr></thead>";
                    datarow+="<tbody>";
                    
                    $.each(response.datasub, function(i, itemsub) {
                        datarow+="<tr>";
                        datarow+="<td>"+itemsub.sku+"</td>"; 
                        datarow+="<td>"+itemsub.nama_item+"</td>"; 
                        datarow+="<td>"+itemsub.tgl_expired+"</td>"; 
                        datarow+="<td>"+itemsub.satuan_kecil+"</td>"; 
                        datarow+="<td>"+itemsub.kuantiti+"</td>";   
                        datarow+="</tr>"; 
                    });  
                    datarow+="</tbody>";
                    datarow+="</table>";
                    datarow+="</div>";
                    datarow+='</div></div>';
                    $('#showdetail').html(datarow);
                }
            });  
            return false;
        }
		    
            function hapus(elem){ 
		        var dataId = $(elem).data("id");
                document.getElementById("idddelete").setAttribute('value', dataId);
        		$('#modalHapus').modal();        
            }
            document.getElementById("FormulirHapus").addEventListener("submit", function (e) {  
			blurForm();       
			$('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitformHapus").setAttribute('disabled','disabled');
			$('#submitformHapus').html('Loading ...');
			var form = $('#FormulirHapus')[0];
			var formData = new FormData(form);
			var xhrAjax = $.ajax({
			type 		: 'POST',
			url 		: $(this).attr('action'),
			data 		: formData, 
			processData: false,
			contentType: false,
			cache: false, 
			dataType 	: 'json'
			}).done(function(data) { 
			if ( ! data.success) {		 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    document.getElementById("submitformHapus").removeAttribute('disabled');  
                    $('#submitformHapus').html('Delete');     
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) { 
                        if (key == 'fail') {   
                            new PNotify({
                                title: 'Notifikasi',
                                text: data.errors[key],
                                type: 'danger'
                            }); 
                        }
                    }      
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll();   
                    tabelpenerimaan.ajax.reload();
					laporan_ringkas();			
                    document.getElementById("submitformHapus").removeAttribute('disabled'); 
                    $('#modalHapus').modal('hide');        
                    document.getElementById("FormulirHapus").reset();    
                    $('#submitformHapus').html('Delete'); 
                    new PNotify({
                        title: 'Notifikasi',
                        text: data.message,
                        type: 'success'
                    });   
                }
                }).fail(function(data) { 
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            });    

        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        </script>
	</body>
</html>
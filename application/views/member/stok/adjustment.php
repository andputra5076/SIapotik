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
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/stylesheets/theme.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>/assets/stylesheets/skins/default.css" />
        <link rel="stylesheet" href="<?php echo base_url()?>/assets/stylesheets/theme-custom.css">
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
						<h2>Stok Adjustment</h2>  
					</header>  
					<!-- start: page -->
                    <section class="panel">
                        <header class="panel-heading">    
                            <div class="row show-grid">
                                <div class="col-md-6" align="left"><h2 class="panel-title">Data Stok Adjustment</h2></div>
                                <?php  
                                echo level_user('stok','adjustment',$this->session->userdata('kategori'),'add') > 0 ? '<div class="col-md-6" align="right"><a class="btn btn-success" href="#"  data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah</a></div>':'';
                                ?> 
							</div>
                        </header>
                        <div class="panel-body"> 
                                <table class="table table-bordered table-hover table-striped" id="stokdata">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tanggal</th>
                                            <th>Nomor Record</th>
                                            <th>Kode Item</th>
                                            <th>Nama Item</th>
                                            <th>Tanggal Expired</th>
                                            <th>Stok Berkurang</th>
                                            <th>Satuan</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table> 
                        </div>
                    </section>
					<!-- end: page -->
				</section>
			</div>
		</section>

		
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel panel-primary">
                    <?php echo form_open('stok/stokadjustmenttambah',' id="FormulirTambah"');?>  
                    <header class="panel-heading">
                        <h2 class="panel-title">Tambah Stok Adjustment</h2>
                    </header>
                    <div class="panel-body"> 
                            <div class="form-group mt-lg tanggal">
                                <label class="col-sm-3 control-label">Tanggal<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="tanggal" class="form-control tanggalform" required/>
                                </div>
                            </div> 
                            <div class="form-group kode_item">
                                <label class="col-sm-3 control-label">Kode Item<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-icon">
                                    <input type="text" name="kode_item" data-toggle="modal" data-target="#modal-listitems"  class="form-control kode-item" required/>
                                    <span class="input-group-addon"><span class="icon"><i class="fa fa-search"></i></span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group nama_item">
                                <label class="col-sm-3 control-label">Nama Item<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text"  class="form-control nama_itemview" readonly/>
                                    <input type="hidden" name="nama_item"  class="nama_itemview" required/>
                                    <input type="hidden" name="satuan_kecil"  class="satuan-kecil" required/>
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label class="col-sm-3 control-label">Stok Sebelumnya <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control stok_sebelum" readonly required/>
                                    <input type="hidden" name="stok_sebelum" class="stok_sebelum" required/>
                               </div>
                            </div> 
                            <div class="form-group kuantiti_berubah">
                                <label class="col-sm-3 control-label">Stok Berkurang <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" name="kuantiti_berubah" class="form-control" required/>
                                </div>
                            </div> 
                            <div class="form-group tgl_expired">
                                <label class="col-sm-3 control-label">Tanggal Expired<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="tgl_expired" class="form-control tanggalform" required/>
                                </div>
                            </div>
                            <div class="form-group keterangan">
                                <label class="col-sm-3 control-label">Keterangan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <textarea rows="2" class="form-control" name="keterangan" required></textarea>
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
  
        <div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel panel-primary">   
                    <header class="panel-heading">
                        <h2 class="panel-title">Detail Stok Adjustment</h2>
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
							<?php echo form_open('stok/stokadjustmenthapus',' id="FormulirHapus"');?>  
							<input type="hidden" name="idd" id="idddelete">
							<input type="hidden" name="kuantiti" id="kuantitiberubah"> 
							<input type="hidden" name="kode_item" id="kodeitemId"> 
							<button type="submit" class="btn btn-danger" id="submitformHapus">Delete</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</form>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
		
        <div class="modal fade bd-example-modal-lg" id="modal-listitems"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <section class="panel">   
                    <header class="panel-heading">
                        <h2 class="panel-title">Data Produk</h2>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped" id="itemsdata">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th> 
                                    <th>Kategori</th>  
                                    <th>Satuan Kecil</th>  
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> 
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
        $('.tanggalform').datepicker({
            format: 'yyyy-mm-dd' 
        }); 
		
		var tableitems = $('#itemsdata').DataTable({  
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": "<?php echo base_url()?>pembelian/pilihanitem",
				"type": "GET"
			}, 
			"columnDefs": [
				{ 
					"targets": [ 4 ], 
					"orderable": false, 
				},
			],  
        });  
		var tablestok = $('#stokdata').DataTable({  
			"serverSide": true, 
			"order": [], 
			"ajax": {
				"url": "<?php echo base_url()?>stok/stokadjustment",
				"type": "GET"
			}, 
			"columnDefs": [
				{ 
					"targets": [ 4 ], 
					"orderable": false, 
				},
			],  
        });  
		
        function pilihitem(elem){  
            var namaitem = $(elem).data("namaitem"); 
            var satuan = $(elem).data("satuan"); 
            var id = $(elem).data("id");  
            var stok = $(elem).data("stok");  
            $('.kode-item').val(id); 
            $('.nama_itemview').val(namaitem);   
            $('.satuan-kecil').val(satuan);    
            $('.stok_sebelum').val(stok);    
            $('#modal-listitems').modal('hide');  
        }
           
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
                    tablestok.ajax.reload();  
					tableitems.ajax.reload();  
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
                    url: '<?php echo base_url()?>stok/stokadjustmentdetail',
                    data: 'id=' + dataId,
                    dataType 	: 'json',
                    success: function(response) { 
                        var datarow='';
                        $.each(response, function(i, item) {
                            datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                            datarow+="<tr><td>Nomor Record</td><td>: <b>"+item.nomor_ref+"</b></td></tr>";
                            datarow+="<tr><td>Tanggal</td><td>: "+item.tanggal+"</td></tr>";
                            datarow+="<tr><td>Kode Item</td><td>: "+item.kode_item+"</td></tr>";
                            datarow+="<tr><td>Nama Item</td><td>: "+item.nama_item+"</td></tr>"; 
                            datarow+="<tr><td>Stok Berkurang</td><td>: "+item.kuantiti_berubah+" "+item.satuan_kecil+"</td></tr>";
                            datarow+="<tr><td>Tanggal Expired</td><td>: "+item.tgl_expired+"</td></tr>"; 
                            datarow+="<tr><td>Keterangan</td><td>: "+item.keterangan+"</td></tr>";
                            datarow+="</table>";
                        });
                        $('#showdetail').html(datarow);
                    }
                });  
                return false;
            }
            
            
            function hapus(elem){ 
		        var dataId = $(elem).data("id");
		        var datakuantiti= $(elem).data("kuantiti");
		        var kodeitem= $(elem).data("kodeitem");
                document.getElementById("idddelete").setAttribute('value', dataId);
                document.getElementById("kodeitemId").setAttribute('value', kodeitem);
                document.getElementById("kuantitiberubah").setAttribute('value', datakuantiti);
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
                    tablestok.ajax.reload();
					tableitems.ajax.reload();  
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
              
        </script>
	</body>
</html>
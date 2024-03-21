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
						<h2>Cash in Cash out</h2>  
					</header>  
					<!-- start: page --> 
                    <section class="panel"> 
                        <div class="panel-body">     
                            <div class="row"> 
                                <div class="col-md-12 col-lg-12 col-xl-4">
                                    <div class="row">
                                        <div class="col-md-3 col-xl-12">
                                            <section class="panel">
                                                <div class="panel-body bg-primary">
                                                    <div class="widget-summary"> 
                                                        <div class="widget-summary-col">
                                                            <div class="summary">
                                                                <h4 class="title">Pemasukan Hari Ini</h4>
                                                                <div class="info">
                                                                    <strong class="amount" id="masuk_hari_ini"></strong>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div> 
                                        <div class="col-md-3 col-xl-12">
                                            <section class="panel">
                                                <div class="panel-body bg-primary">
                                                    <div class="widget-summary"> 
                                                        <div class="widget-summary-col">
                                                            <div class="summary">
                                                                <h4 class="title">Pemasukan Minggu Ini</h4>
                                                                <div class="info">
                                                                    <strong class="amount" id="masuk_minggu_ini"></strong>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div> 
                                        <div class="col-md-3 col-xl-12">
                                            <section class="panel">
                                                <div class="panel-body bg-primary">
                                                    <div class="widget-summary"> 
                                                        <div class="widget-summary-col">
                                                            <div class="summary">
                                                                <h4 class="title">Pengeluaran Hari Ini</h4>
                                                                <div class="info">
                                                                    <strong class="amount" id="keluar_hari_ini"></strong>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div> 
                                        <div class="col-md-3 col-xl-12">
                                            <section class="panel">
                                                <div class="panel-body bg-primary">
                                                    <div class="widget-summary"> 
                                                        <div class="widget-summary-col">
                                                            <div class="summary">
                                                                <h4 class="title">Pengeluaran Minggu Ini</h4>
                                                                <div class="info">
                                                                    <strong class="amount" id="keluar_minggu_ini"></strong>
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
                                <div class="col-md-6" align="left"><h2 class="panel-title">Data Cash in Cash out</h2></div>
                                <?php  
                                echo level_user('keuangan','cashinout',$this->session->userdata('kategori'),'add') > 0 ? '<div class="col-md-6" align="right"><a class="btn btn-success" href="#"  data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah</a></div>':'';
                                ?> 
							</div>
                        </header>
                        <div class="panel-body"> 
                            <table class="table table-bordered table-hover table-striped" id="cashincashoutdata">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tanggal</th> 
                                        <th>Kode Rekening</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Nominal</th> 
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
                    <?php echo form_open('keuangan/cashincashout_tambah',' id="FormulirTambah"');?>  
                    <header class="panel-heading">
                        <h2 class="panel-title">Tambah Data Cash in Cash out</h2>
                    </header>
                    <div class="panel-body">
                            <div class="form-group mt-lg kategori">
                                <label class="col-sm-3 control-label">Kategori<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="kategori" id="kategori" required>    
                                        <option value="">Pilih Kategori</option>
                                        <option value="pengeluaran">pengeluaran</option>
                                        <option value="pemasukan">pemasukan</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group mt-lg kode_rekening">
                                <label class="col-sm-3 control-label">Nama Rekening<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="kode_rekening" id="kode_rekening" required>     
                                    </select> 
                                </div>
                            </div> 
                            <div class="form-group judul">
                                <label class="col-sm-3 control-label">Nomor Rekening</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nomor_rekening_tampil" class="form-control" readonly />
                                </div>
                            </div>  
                            <div class="form-group mt-lg tanggal">
                                <label class="col-sm-3 control-label">Tanggal<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="tanggal" class="form-control tanggalformat" data-plugin-datepicker required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg nominal">
                                <label class="col-sm-3 control-label">Nominal<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nominal" class="form-control mask_price" required/>
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
         
        <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel panel-primary">
                    <?php echo form_open('keuangan/cashedit',' id="FormulirEdit"');?>  
                    <input type="hidden" name="idd" id="idd">
                    <header class="panel-heading">
                        <h2 class="panel-title">Edit Data </h2>
                    </header>
                    <div class="panel-body">
                            <div class="form-group mt-lg kategori">
                                <label class="col-sm-3 control-label">Kategori<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="kategori" id="kategoriedit" required>    
                                        <option value=""selected disabled >Pilih Kategori</option>
                                        <option value="pengeluaran">pengeluaran</option>
                                        <option value="pemasukan">pemasukan</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group mt-lg kode_rekening">
                                <label class="col-sm-3 control-label">Nama Rekening<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="kode_rekening" id="kode_rekeningedit" required>     
                                    </select> 
                                </div>
                            </div> 
                            <div class="form-group judul">
                                <label class="col-sm-3 control-label">Nomor Rekening</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nomor_rekening_tampil_edit" class="form-control" readonly />
                                </div>
                            </div>  
                            <div class="form-group mt-lg tanggal">
                                <label class="col-sm-3 control-label">Tanggal<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="tanggal" id="tanggaledit" class="form-control tanggalformat" data-plugin-datepicker required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg nominal">
                                <label class="col-sm-3 control-label">Nominal<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nominal" id="nominaledit" class="form-control mask_price" required/>
                                </div>
                            </div>
                            <div class="form-group keterangan">
                                <label class="col-sm-3 control-label">Keterangan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <textarea rows="2" class="form-control" name="keterangan" id="keteranganedit" required></textarea>
                                </div>
                            </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-primary modal-confirm" type="submit" id="submitformEdit">Submit</button>
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
                        <h2 class="panel-title">Detail Transaksi</h2>
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
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus Data </h4>
                    </div>
                    <div class="modal-body">
                            <p>Yakin ingin menghapus data ini ?</p>
                    </div>
                    <div class="modal-footer"> 
                        <?php echo form_open('keuangan/cashhapus',' id="FormulirHapus"');?>  
                        <input type="hidden" name="idd" id="idddelete">
                        <button type="submit" class="btn btn-danger" id="submitformHapus">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </form>
                    </div>
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
            $('.tanggalformat').datepicker({
                format: 'yyyy-mm-dd' 
            }); 
            var tablecashincashout = $('#cashincashoutdata').DataTable({ 
            "ajax": { 
                url : "<?php echo base_url()?>keuangan/datacashincashout", 
                type : 'GET' 
                }, 
            });
            function laporan_ringkas(){   
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>keuangan/cashinout_data', 
                    dataType    : 'json',
                    success: function(response) {  
                        $.each(response, function(i, item) {  
                        $('#masuk_minggu_ini').html(item.masuk_minggu);  
                        $('#keluar_minggu_ini').html(item.keluar_minggu);  
                        $('#masuk_hari_ini').html(item.masuk_hari);  
                        $('#keluar_hari_ini').html(item.keluar_hari);  
                        }); 
                    }
                });  
                return false;
            }
            laporan_ringkas(); 
            $('#kategori').change(function(){ 
                var dataKategori = $(this).val(); 
                $.ajax({
                type: 'GET',
                url: '<?php echo base_url()?>keuangan/datarekeningkode',
                data: 'kategori=' + dataKategori,
                dataType    : 'json',
                success: function(response) {  
                    var datarow ='<option value="">Pilih Nama Rekening</option>';  
                    $.each(response.datarows, function(i, a) { 
                        datarow += '<option value="'+a.kode_rekening+'">'+a.nama_rekening+'</option>';  
                    });    
                    $('#kode_rekening').html(datarow);
                } ,
                error: function() { 
                    $('#kode_rekening').html('');  
                }
                }); 
            });
            
            $('#kode_rekening').change(function(){ 
                var rekening = $(this).val();   
                document.getElementById("nomor_rekening_tampil").setAttribute('value', rekening);
                        
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
                        window.setTimeout(function() {  
                        document.getElementById("submitform").removeAttribute('disabled');  
                        $('#submitform').html('Submit');    
                        var objek = Object.keys(data.errors);  
                        for (var key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) { 
                                var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                                $('.'+key).addClass('has-error');
                                $('input[name="' + key + '"]').after(msg);  
                            }
                        }   
                        }, 500);
                        return false;
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll(); laporan_ringkas(); 
                    window.setTimeout(function() {   
                        document.getElementById("submitform").removeAttribute('disabled'); 
                        document.getElementById("FormulirTambah").reset();  
                        $('#submitform').html('Submit');tablecashincashout.ajax.reload();  
                    }, 1000);
                    window.setTimeout(function() {  
                        new PNotify({
                            title: 'Notifikasi',
                            text: data.message,
                            type: 'success'
                        }); 
                    }, 500); 
                }
                }).fail(function(data) {   
                    alert('request gagal');
                    location.reload();
                }); 
                e.preventDefault(); 
            }); 
            
            function edit(elem){
		        var dataId = $(elem).data("id");    
                document.getElementById("idd").setAttribute('value', dataId);
        		$('#editData').modal();        
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>keuangan/cashdetail',
                    data: 'id=' + dataId,
                    dataType 	: 'json',
                    success: function(response) {  
                        $.each(response, function(i, item) { 
                        $("#kategoriedit").select2("val", item.kategori);  
                        document.getElementById("keteranganedit").value = item.keterangan;
                        document.getElementById("nomor_rekening_tampil_edit").value = item.kode_rekening;
                        document.getElementById("tanggaledit").value = item.tanggalYmd;
                        document.getElementById("nominaledit").value = item.nominalInt;               
                            $.ajax({
                            type: 'GET',
                            url: '<?php echo base_url()?>keuangan/datarekeningkode',
                            data: 'kategori=' + item.kategori,
                            dataType    : 'json',
                            success: function(response) {  
                                var datarow ='<option disabled>Pilih Nama Rekening</option>';  
                                $.each(response.datarows, function(i, a) { 
                                    datarow += '<option value="'+a.kode_rekening+'">'+a.nama_rekening+'</option>';  
                                });    
                                $('#kode_rekeningedit').html(datarow); 
                                $("#kode_rekeningedit").select2("val", item.kode_rekening);  
                            } ,
                            error: function() { 
                                $('#kode_rekeningedit').html('');  
                            }
                            });
                        }); 
                    }
                });     
            }
            document.getElementById("FormulirEdit").addEventListener("submit", function (e) {  
			blurForm();       
			
            $('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitformEdit").setAttribute('disabled','disabled');
			$('#submitformEdit').html('Loading ...');
			var form = $('#FormulirEdit')[0];
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
                        window.setTimeout(function() {  
                        document.getElementById("submitformEdit").removeAttribute('disabled');  
                        $('#submitformEdit').html('Submit');    
                        var objek = Object.keys(data.errors);  
                        for (var key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) { 
                                var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                                $('.'+key).addClass('has-error');
                                $('input[name="' + key + '"]').after(msg);
                                $('select[name="' + key + '"]').after(msg);  
                            }
                        }   
                        }, 500);
                        return false;
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll(); laporan_ringkas();
                    window.setTimeout(function() {   
                        document.getElementById("submitformEdit").removeAttribute('disabled'); 
                		$('#editData').modal('hide');        
                        document.getElementById("FormulirEdit").reset();    
                        $('#submitformEdit').html('Submit');tablecashincashout.ajax.reload();  
                    }, 1000);
                    window.setTimeout(function() {  
                        new PNotify({
                            title: 'Notifikasi',
                            text: data.message,
                            type: 'success'
                        }); 
                    }, 500); 
                }
                }).fail(function(data) {    
                    alert('request gagal');
                    location.reload();
                }); 
                e.preventDefault(); 
            }); 
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
                        window.setTimeout(function() {  
                        document.getElementById("submitformHapus").removeAttribute('disabled');  
                        $('#submitformHapus').html('Delete');     
                        new PNotify({
                            title: 'Warning',
                            text: 'terjadi kesalahan, refresh browser anda',
                            type: 'danger'
                        });    
                        }, 500);
                        return false;
                } else { 
                    $('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
                    PNotify.removeAll(); laporan_ringkas();
                    window.setTimeout(function() {   
                        document.getElementById("submitformHapus").removeAttribute('disabled'); 
                		$('#modalHapus').modal('hide');        
                        document.getElementById("FormulirHapus").reset();    
                        $('#submitformHapus').html('Delete');tablecashincashout.ajax.reload();  
                    }, 1000);
                    window.setTimeout(function() {  
                        new PNotify({
                            title: 'Notifikasi',
                            text: data.message,
                            type: 'success'
                        }); 
                    }, 500); 
                }
                }).fail(function(data) {   
                    alert('request gagal');
                    location.reload();
                }); 
                e.preventDefault(); 
            }); 
            function detail(elem){
                var dataId = $(elem).data("id");   
                $('#detailData').modal();    
                $('#showdetail').html('Loading...'); 
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>keuangan/cashdetail',
                    data: 'id=' + dataId,
                    dataType    : 'json',
                    success: function(response) { 
                        var datarow='';
                        $.each(response, function(i, item) {
                            datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                            datarow+="<tr><td>Kategori</td><td>: "+item.kategori+"</td></tr>";
                            datarow+="<tr><td>Nama Rekening</td><td>: "+item.nama_rekening+"</td></tr>";
                            datarow+="<tr><td>Kode Rekening</td><td>: "+item.kode_rekening+"</td></tr>";
                            datarow+="<tr><td>Nominal</td><td>: "+item.nominal+"</td></tr>";
                            datarow+="<tr><td>Tanggal</td><td>: "+item.tanggal+"</td></tr>";
                            datarow+="<tr><td>Keterangan</td><td>: "+item.keterangan+"</td></tr>";
                            datarow+="</table>";
                        });
                        $('#showdetail').html(datarow);
                    }
                });  
                return false;
            }
            
            $('#kategoriedit').change(function(){ 
                var dataKategori = $(this).val(); 
                document.getElementById("nomor_rekening_tampil_edit").value = "";
                $.ajax({
                type: 'GET',
                url: '<?php echo base_url()?>keuangan/datarekeningkode',
                data: 'kategori=' + dataKategori,
                dataType    : 'json',
                success: function(response) {  
                    var datarow ='<option disabled selected>Pilih Nama Rekening</option>';  
                    $.each(response.datarows, function(i, a) { 
                        datarow += '<option value="'+a.kode_rekening+'">'+a.nama_rekening+'</option>';  
                    });    
                    $('#kode_rekeningedit').html(datarow);
                } ,
                error: function() { 
                    $('#kode_rekeningedit').html('');  
                }
                }); 
            }); 
            $('#kode_rekeningedit').change(function(){ 
                var rekening = $(this).val();    
                document.getElementById("nomor_rekening_tampil_edit").value = rekening; 
            }); 
        </script>
	</body>
</html>
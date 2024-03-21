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
						<h2>Master Racikan</h2>
					</header>  
					<!-- start: page -->
                    <section class="panel">
                        <header class="panel-heading">    
                            <div class="row show-grid">
                                <div class="col-md-6" align="left"><h2 class="panel-title">Data Racikan</h2></div>
                                <?php  
                                echo level_user('master','racikan',$this->session->userdata('kategori'),'add') > 0 ? '<div class="col-md-6" align="right"><a class="btn btn-success" href="#"  data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah</a></div>':'';
                                ?> 
							</div>
                        </header>
                        <div class="panel-body"> 
                                <table class="table table-bordered table-hover table-striped" id="racikandata">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Kode Racikan</th>
                                            <th>Nama Racikan</th>  
                                            <th>Harga Jual</th> 
                                            <th>Upah Peracik</th> 
                                            <th>Aturan Pakai</th>  
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

		
        <div class="modal fade bd-example-modal-lg" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:90%">
                <div class="modal-content">
					<section class="panel panel-primary">
                    <?php echo form_open('master/racikantambah',' id="FormulirTambah" enctype="multipart/form-data"');?>  
                    <header class="panel-heading">
                        <h2 class="panel-title">Tambah Racikan</h2>
                    </header>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-lg kategori">
                                <label class="col-sm-3 control-label">Pilih Kategori<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="kategori" required>  
    									<?php foreach ($kategori as $kat): ?>
                                        <option value="<?php echo $kat->id;?>"><?php echo $kat->id;?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group mt-lg kode_item">
                                <label class="col-sm-3 control-label">Kode Racikan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode_item" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg nama_item">
                                <label class="col-sm-3 control-label">Nama Racikan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_item" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg satuan">
                                <label class="col-sm-3 control-label">Pilih Satuan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="satuan" required>  
    									<?php foreach ($satuan as $sat): ?>
                                        <option value="<?php echo $sat->id;?>"><?php echo $sat->id;?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group gambar">
                                <label class="col-sm-3 control-label">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" name="gambar" class="form-control"/>
                                </div>
                            </div>
                            
                    </div>
						<div class="col-md-6">   
                            <div class="form-group harga_jual">
                                <label class="col-sm-3 control-label">Harga Jual<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="harga_jual" class="form-control mask_price" required />
                                </div>
                            </div> 
                            <div class="form-group upah_peracik">
                                <label class="col-sm-3 control-label">Upah Peracik<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="upah_peracik" class="form-control mask_price" required />
                                </div>
                            </div> 
							<div class="form-group aturan_pakai">
                                <label class="col-sm-3 control-label">Aturan Pakai</label>
                                <div class="col-sm-9">
                                    <input type="text" name="aturan_pakai" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group keterangan">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea rows="2" class="form-control" name="keterangan"></textarea>
                                </div>
                            </div>
						</div>
					</div>
					
                    <div class="row">
						<div class="col-md-12">
							<h3>Detail Obat</h3> 
							<a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" id="tambahObat"><i class="fa fa-plus"></i> Tambah Obat</a>
						</div> 
						<div class="col-md-12">
							<div class="table-responsive" style="max-height:420px;">
								<table class="table table-bordered table-hover table-striped dataTable no-footer listobat">
									<thead>
										<tr>
											<td>Kode Obat (Barcode)</td>
											<td>Nama Obat</td>
											<td>Jumlah Obat Dipakai</td>
											<td colspan="2">Jumlah Obat Dibuat</td> 
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
                        <h2 class="panel-title">Detail Racikan</h2>
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
        <div class="modal fade bd-example-modal-lg" id="editData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:90%">
                <div class="modal-content">
                <section class="panel panel-primary">
                    <?php echo form_open('master/racikanedit',' id="FormulirEdit" enctype="multipart/form-data"');?>  
                    <input type="hidden" name="idd" id="idd">
                    <header class="panel-heading">
                        <h2 class="panel-title">Edit Racikan</h2>
                    </header>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-lg kategori">
                                <label class="col-sm-3 control-label">Pilih Kategori<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="kategori" id="kategori" required>  
    									<?php foreach ($kategori as $kat): ?>
                                        <option value="<?php echo $kat->id;?>"><?php echo $kat->id;?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group mt-lg kode_item">
                                <label class="col-sm-3 control-label">Kode Racikan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode_item" id="kode_item" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg nama_item">
                                <label class="col-sm-3 control-label">Nama Racikan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_item" id="nama_item" class="form-control" required/>
                                </div>
                            </div>
                            <div class="form-group mt-lg satuan">
                                <label class="col-sm-3 control-label">Pilih Satuan<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control" name="satuan" id="satuan" required>  
    									<?php foreach ($satuan as $sat): ?>
                                        <option value="<?php echo $sat->id;?>"><?php echo $sat->id;?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group harga_jual">
                                <label class="col-sm-3 control-label">Harga Jual<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="harga_jual" id="harga_jual" class="form-control mask_price" required />
                                </div>
                            </div> 
                            <div class="form-group upah_peracik">
                                <label class="col-sm-3 control-label">Upah Peracik<span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="upah_peracik" id="upah_peracik" class="form-control mask_price" required />
                                </div>
                            </div> 
                            <div class="form-group gambar">
                                <label class="col-sm-3 control-label">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" name="gambar" class="form-control"/><br>
                                    <img id="gambar" width="200" alt="gambar produk">
                                </div>
                            </div>
                            <div class="form-group aturan_pakai">
                                <label class="col-sm-3 control-label">Aturan Pakai</label>
                                <div class="col-sm-9">
                                    <input type="text" name="aturan_pakai" id="aturan_pakai" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group keterangan">
                                <label class="col-sm-3 control-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea rows="2" class="form-control" name="keterangan" id="keterangan"></textarea>
                                </div>
                            </div>
                            
                    </div>
                    <div class="col-md-6">                    
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Detail Obat</h3> 
                                <a type="button" class="mb-xs mt-xs mr-xs btn btn-primary" id="tambahObatedit"><i class="fa fa-plus"></i> Tambah Obat</a>
                            </div>
                        </div>
                        <div class="table-responsive" style="max-height:420px;">
                        <table class="table table-bordered table-striped table-condensed mb-none listobatedit">
							<thead>
                                <tr>
                                    <td>Kode Obat (Barcode)</td>
                                    <td>Nama Obat</td>
                                    <td>Jumlah Obat Dipakai</td>
                                    <td colspan="2">Jumlah Obat Dibuat</td> 
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

        <div class="modal fade" id="modal-listitems"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <section class="panel panel-primary">   
                    <header class="panel-heading">
                        <h2 class="panel-title">Data Obat</h2>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped" id="itemsdata">
                            <thead>
                                <tr>
                                    <th>Kode Item (Barcode)</th>
                                    <th>Nama Item</th> 
                                    <th>Kategori</th> 
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
                                <?php echo form_open('master/racikanhapus',' id="FormulirHapus"');?>  
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
        var tableitems = $('#itemsdata').DataTable({  
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    "url": "<?php echo base_url()?>master/pilihanobat",
                    "type": "GET"
                }, 
                "columnDefs": [
                    { 
                        "targets": [ 3 ], 
                        "orderable": false, 
                    },
                ],  
        });  
        var tableracikan = $('#racikandata').DataTable({  
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    "url": "<?php echo base_url()?>master/dataracikan",
                    "type": "GET"
                }, 
                "columnDefs": [
                    { 
                        "targets": [ 0 ], 
                        "orderable": false, 
                    },
                ],  
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
                    tableracikan.ajax.reload();   
                    document.getElementById("submitform").removeAttribute('disabled'); 
                    $('#tambahData').modal('hide'); 
                    document.getElementById("FormulirTambah").reset();  
                    $('#submitform').html('Submit');   
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
                  
            function detail(elem){
		        var dataId = $(elem).data("id");   
        		$('#detailData').modal();    
                $('#showdetail').html('Loading...'); 
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>master/racikandetail',
                    data: 'id=' + dataId,
                    dataType 	: 'json',
                    success: function(response) { 
                        var datarow='<div class="row"><div class="col-md-6">';
                        $.each(response.datarows, function(i, item) {
                            datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                            datarow+="<tr><td>Kode Racikan</td><td>: "+item.kode_item+"</td></tr>";
                            datarow+="<tr><td>Jenis</td><td>: "+item.jenis+"</td></tr>";
                            datarow+="<tr><td>Kategori</td><td>: "+item.kategori+"</td></tr>";
                            datarow+="<tr><td>Nama Racikan</td><td>: "+item.nama_item+"</td></tr>";
                            datarow+="<tr><td>Harga Jual</td><td>: "+item.harga_jual+"</td></tr>";
                            datarow+="<tr><td>Upah Peracik</td><td>: "+item.upah_peracik+"</td></tr>";
                            datarow+="<tr><td>Satuan</td><td>: "+item.satuan+"</td></tr>";
                            datarow+="<tr><td>Gambar</td><td> <img src='<?php echo base_url()?>images/"+item.gambar+"' width='200' ></td></tr>";
                            datarow+="<tr><td>Aturan Pakai</td><td>: "+item.aturan_pakai+"</td></tr>";
                            datarow+="<tr><td>Keterangan</td><td>: "+item.keterangan+"</td></tr>";
                            datarow+="</table>";
                        });
                        datarow+='</div>';
                        datarow+='<div class="col-md-6"><h3>Rincian Obat</h3>';
                        datarow+='<div class="table-responsive" style="max-height:420px;">';  
                        datarow+='<table class="table table-bordered table-hover table-striped dataTable no-footer">';
                        datarow+="<thead><tr>";
                        datarow+="<th>Kode Obat (Barcode)</th>";
                        datarow+="<th>Nama Obat</th>";
                        datarow+="<th>Jumlah Obat Dibuat</th>";
                        datarow+="<th>Jumlah Obat Dipakai</th>";
                        datarow+="</tr></thead>";
                        datarow+="<tbody>";
                       
                        $.each(response.datasub, function(i, itemsub) {
                            datarow+="<tr>";
                            datarow+="<td>"+itemsub.kode_item+"</td>"; 
                            datarow+="<td>"+itemsub.nama_item+"</td>"; 
                            datarow+="<td>"+itemsub.jumlah_obat_dibuat+"</td>"; 
                            datarow+="<td>"+itemsub.jumlah_obat_dipakai+"</td>"; 
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
            var x = 0; 
            function edit(elem){
		        var dataId = $(elem).data("id");   
                document.getElementById("idd").setAttribute('value', dataId);
                $(".listobatedit").find("tr:not(:first)").remove();
                $('#editData').modal();        
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url()?>master/racikandetail',
                    data: 'id=' + dataId,
                    dataType 	: 'json',
                    success: function(response) {  
                        $.each(response.datarows, function(i, item) {                             
                            $("#kategori").select2("val", item.kategori);
                            document.getElementById("kode_item").value = item.kode_item;
                            document.getElementById("nama_item").value = item.nama_item;        
                            $("#satuan").select2("val", item.satuan);
                            document.getElementById("harga_jual").value = item.harga_jual_edit;     
                            document.getElementById("upah_peracik").value = item.upah_peracik_edit;
                        document.getElementById("gambar").src = '<?php echo base_url()?>images/'+item.gambar;      
                            document.getElementById("aturan_pakai").value = item.aturan_pakai;     
                            document.getElementById("keterangan").value = item.keterangan;     
                        });  

                        var datarow='';
                        $.each(response.datasub, function(i, itemsub) {
                            x= x + 1;
                            datarow+='<tr><td><div class="input-group input-group-icon" style="width:150px;"><input value="'+itemsub.kode_item+'" type="text" data-urutan="'+x+'" data-toggle="modal" data-target="#modal-listitems"  class="form-control kode-item'+x+'" placeholder="Pilih Obat"><span class="input-group-addon"><span class="icon"><i class="fa fa-search"></i></span></span></div></td>';
                            datarow+='<td><input value="'+itemsub.kode_item+'" type="hidden" class="kode-item'+x+'" name="kode_obat[]"> <input type="text" value="'+itemsub.nama_item+'" name="nama_obat[]" class="form-control nama-obat'+x+'"></td>';
                            datarow+='<td><input  value="'+itemsub.jumlah_obat_dibuat+'" type="number" name="jumlah_obat_dibuat[]" size="3" class="form-control jumlah-obat-dibuat'+x+'"></td>';
                            datarow+='<td><input value="'+itemsub.jumlah_obat_dipakai+'" type="number" name="jumlah_obat_dipakai[]"  size="3" class="form-control jumlah-obat-dipakai'+x+'"></td>';
                            datarow+='<td><a href="javascript:void(0);" class="mb-xs mt-xs mr-xs btn btn-danger deleterowedit"><i class="fa fa-trash-o"></i></a></td></tr>'; 
                        });  
                        $('.listobatedit').append(datarow); 

                    }
                });   
                return false;
            }
            
        var max_fields_edit      = 1000; 
        var wrapperItem_edit        = $(".listobatedit");
        var add_button_mg_edit      = $("#tambahObatedit"); 
        $(add_button_mg_edit).click(function(e){
            e.preventDefault();
            if(x < max_fields_edit){
                x=x+1;       
                var formtambah='<tr><td><div class="input-group input-group-icon" style="width:150px;"><input  type="text" data-urutan="'+x+'" data-toggle="modal" data-target="#modal-listitems"  class="form-control kode-item'+x+'" placeholder="Pilih Obat" ><span class="input-group-addon"><span class="icon"><i class="fa fa-search"></i></span></span></div></td>';
                formtambah+='<td><input type="hidden" class="kode-item'+x+'" name="kode_obat[]"> <input type="text" name="nama_obat[]" class="form-control nama-obat'+x+'"></td>';
                formtambah+='<td><input type="number" name="jumlah_obat_dibuat[]" size="3" class="form-control jumlah-obat-dibuat'+x+'"></td>';
                formtambah+='<td><input type="number" name="jumlah_obat_dipakai[]"  size="3" class="form-control jumlah-obat-dipakai'+x+'"></td>';
                formtambah+='<td><a href="javascript:void(0);" class="mb-xs mt-xs mr-xs btn btn-danger deleterowedit"><i class="fa fa-trash-o"></i></a></td></tr>'; 
                $(wrapperItem_edit).append(formtambah); 
            }
            else
            { 
			document.getElementById("tambahObatedit").setAttribute('disabled','disabled'); 
            alert('Maksimal '+max_fields_edit+' form')
            }
        });    
        $(wrapperItem_edit).on("click",".deleterowedit", function(e){
            e.preventDefault(); $(this).parent().parent().remove();
            document.getElementById("tambahObatedit").removeAttribute('disabled');  
        }) 
 
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
                    document.getElementById("submitformEdit").removeAttribute('disabled');  
                    $('#submitformEdit').html('Submit');    
                    var objek = Object.keys(data.errors);  
                    for (var key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) { 
                            var msg = '<div class="help-block" for="'+key+'">'+data.errors[key]+'</span>';
                            $('.'+key).addClass('has-error');
                            $('input[name="' + key + '"]').after(msg);  
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
                    tableracikan.ajax.reload();    
                    document.getElementById("submitformEdit").removeAttribute('disabled'); 
                    $('#editData').modal('hide');        
                    document.getElementById("FormulirEdit").reset();    
                    $('#submitformEdit').html('Submit');   
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
                    tableracikan.ajax.reload();
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
                   // window.setTimeout(function() {  location.reload();}, 2000);
                }); 
                e.preventDefault(); 
            }); 
               
        var max_fields      = 1000; 
        var wrapperItem     = $(".listobat");
        var add_button_mg   = $("#tambahObat");
        var x = 0;  
        $(add_button_mg).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x=x+1;       
                var formtambah='<tr><td><div class="input-group input-group-icon" style="width:150px;"><input type="text" data-urutan="'+x+'" name="idd[]" data-toggle="modal" data-target="#modal-listitems"  class="form-control kode-item'+x+'" placeholder="Pilih Obat"  ><span class="input-group-addon"><span class="icon"><i class="fa fa-search"></i></span></span></div></td>';
                formtambah+='<td><input type="hidden" class="kode-item'+x+'" name="kode_obat[]"> <input type="text" name="nama_obat[]" class="form-control nama-obat'+x+'"></td>';
                formtambah+='<td><input type="number" name="jumlah_obat_dibuat[]" size="3" class="form-control jumlah-obat-dibuat'+x+'"></td>';
                formtambah+='<td><input type="number" name="jumlah_obat_dipakai[]"  size="3" class="form-control jumlah-obat-dipakai'+x+'"></td>';
                formtambah+='<td><a href="javascript:void(0);" class="mb-xs mt-xs mr-xs btn btn-danger deleterow"><i class="fa fa-trash-o"></i></a></td></tr>'; 
                $(wrapperItem).append(formtambah); 
            }
            else
            { 
			document.getElementById("tambahObat").setAttribute('disabled','disabled'); 
            alert('Maksimal '+max_fields+' form')
            }
        });    
        $(wrapperItem).on("click",".deleterow", function(e){
            e.preventDefault(); $(this).parent().parent().remove();
            document.getElementById("tambahObat").removeAttribute('disabled');  
        })  
        

        $(document).on('shown.bs.modal','#modal-listitems', function (e) {
            var urutan = $(e.relatedTarget).data('urutan');     
            createCookie("urutan-row-obat", urutan, 30);
        });   
        
        function pilihobat(elem){ 
            urutan = readCookie("urutan-row-obat");
            var namaitem = $(elem).data("namaitem"); 
            var id = $(elem).data("id");  
            $('.kode-item'+urutan).val(id);
            $('.nama-obat'+urutan).val(namaitem); 
            $('.jumlah-obat-dibuat'+urutan).val('1'); 
            $('.jumlah-obat-dipakai'+urutan).val('1');  
            $('#modal-listitems').modal('hide');   
            eraseCookie("urutan-row-obat");
        }
		
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
        </script>
	</body>
</html>
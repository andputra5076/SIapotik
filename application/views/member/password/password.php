<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html class="fixed sidebar-left-collapsed">
	<head>  
		<meta charset="UTF-8"> 
		<link rel="shortcut icon" href="<?php echo base_url()?>/assets/images/favicon.png" type="image/ico">   
		<title>Apotek</title>    
		<meta name="author" content="Paber"> 
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/theme.css" /> 
		<link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/skins/default.css" /> 
		<link rel="stylesheet" href="<?php echo base_url()?>assets/stylesheets/theme-custom.css"> 
		<link rel="stylesheet" href="<?php echo base_url()?>assets/vendor/pnotify/pnotify.custom.css" />
		<script src="<?php echo base_url()?>assets/vendor/modernizr/modernizr.js"></script>  
	</head>
	<body>
		<section class="body">

			<?php $this->load->view("komponen/header.php") ?>
			<div class="inner-wrapper"> 
				<?php $this->load->view("komponen/sidebar.php") ?>
				<section role="main" class="content-body">
					<header class="page-header">  
						<h2>Edit Password</h2>  
					</header>  
					<!-- start: page -->
                    <div class="row">
						<div class="col-md-6">
                            <?php echo form_open('password/gantipassword',' id="Formulir" ',' class="form-horizontal" ');?>   
							 	<section class="panel">
									<header class="panel-heading"> 

										<h2 class="panel-title">Form Edit Password</h2> 
									</header>
									<div class="panel-body">
										<div class="form-group password">
											<label class="col-sm-4 control-label">Password: </label>
											<div class="col-sm-8">
												<input type="password" name="password" class="form-control">
											</div>
										</div>
										<div class="form-group password2">
											<label class="col-sm-4 control-label">Konfirmasi Password: </label>
											<div class="col-sm-8">
												<input type="password" name="password2" class="form-control">
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<button class="btn btn-primary" id="submitform">Submit </button>
										<button type="reset" class="btn btn-default">Reset</button>
									</footer>
								</section>
							</form>
						</div>
					</div>

					
					<!-- end: page -->
				</section>
			</div>
		</section>

		<!-- Vendor -->
		<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>  
		<script src="<?php echo base_url()?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo base_url()?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="<?php echo base_url()?>assets/javascripts/theme.js"></script> 
		<script src="<?php echo base_url()?>assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="<?php echo base_url()?>assets/javascripts/theme.init.js"></script>  
        <script> 
		$(document).ready(function() {
			document.getElementById("Formulir").addEventListener("submit", function (e) {  
                PNotify.removeAll();  
				blurForm();       
	            $('.form-group').removeClass('has-error');
				document.getElementById("submitform").setAttribute('disabled','disabled');
				$('#submitform').html('Loading ...');
				var form = $('#Formulir')[0];
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
							$('.'+key).addClass('has-error');   
								new PNotify({
									title: 'Notifikasi Eror',
									text: data.errors[key],
									type: 'error'
								}); 
						}
					}  
				} else { 
					$('input[name=<?php echo $this->security->get_csrf_token_name();?>]').val(data.token);
					document.getElementById("submitform").removeAttribute('disabled'); 
					document.getElementById("Formulir").reset();  
					$('#submitform').html('Submit'); 
					new PNotify({
						title: 'Notifikasi',
						text: data.message,
						type: 'success'
					}); 
				}
				}).fail(function(data) {  
					document.getElementById("submitform").removeAttribute('disabled'); 
					$('#submitform').html('Submit');     
                    new PNotify({
                        title: 'Notifikasi',
                        text: "Request gagal, browser akan direload",
                        type: 'danger'
                    }); 
                    window.setTimeout(function() {  location.reload();}, 2000);
				}); 
				e.preventDefault(); 
			});
		});
        </script>

	</body>
</html>
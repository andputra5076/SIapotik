<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">

<head>
	<!-- Basic -->
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="<?php echo base_url() ?>/assets/images/favicon.png" type="image/ico">
	<title>Apotek</title>
	<meta name="keywords" content="Aplikasi salon kecantikan" />
	<meta name="author" content="Manigom">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/skins/default.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme-custom.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.css" />
	<script src="<?php echo base_url() ?>assets/vendor/modernizr/modernizr.js"></script>
</head>

<body class="bglogin">
	<!-- start: page -->
	<section class="body-sign">
		<div class="center-sign">
			<a href="<?php echo base_url() ?>" class="logo pull-left">
				<img src="<?php echo base_url() ?>assets/images/<?php echo $this->db->get_where('profil_apotek', array('id' => '1'), 1)->row()->logo; ?>" height="54" alt="Logo" />
			</a>

			<div class="panel panel-sign">
				<div class="panel-title-sign mt-xl text-right">
					<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Login</h2>
				</div>
				<div class="panel-body">
					<?php echo form_open('login/authlogin', ' id="Formulir" '); ?>
					<div class="form-group mb-lg username">
						<label class="control-label">Username</label>
						<div class="input-group input-group-icon">
							<input name="username" type="text" class="form-control input-lg" />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-user"></i>
								</span>
							</span>
						</div>
					</div>

					<div class="form-group mb-lg password">
						<div class="input-group input-group-icon ">
							<input name="password" type="password" class="form-control input-lg" />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-lock"></i>
								</span>
							</span>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
						</div>
						<div class="col-sm-6 text-right">
							<button type="submit" class="btn btn-primary btn-block btn-lg" id="submitform">Login</button>
						</div>
					</div>

					</form>
					<br>
				</div>
			</div>

		</div>
	</section>
	<!-- end: page -->

	<!-- Vendor -->
	<script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script src="<?php echo base_url() ?>assets/javascripts/theme.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.js"></script>
	<script src="<?php echo base_url() ?>assets/javascripts/theme.init.js"></script>
	<script>
		document.getElementById("Formulir").addEventListener("submit", function(e) {
			blurForm();
			$('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitform").setAttribute('disabled', 'disabled');
			$('#submitform').html('Loading ...');
			var form = $('#Formulir')[0];
			var formData = new FormData(form);
			var xhrAjax = $.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				dataType: 'json'
			}).done(function(data) {
				if (!data.success) {
					$('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(data.token);
					window.setTimeout(function() {
						document.getElementById("submitform").removeAttribute('disabled');
						$('#submitform').html('Login');
						var objek = Object.keys(data.errors);
						for (var key in data.errors) {
							if (data.errors.hasOwnProperty(key)) {
								var msg = '<div class="help-block" for="' + key + '">' + data.errors[key] + '</span>';
								$('.' + key).addClass('has-error');
								$('input[name="' + key + '"]').after(msg);
							}
						}
					}, 500);
					return false;
				} else {
					$('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(data.token);
					PNotify.removeAll();
					document.getElementById("submitform").removeAttribute('disabled');
					document.getElementById("Formulir").reset();
					$('#submitform').html('Login');
					new PNotify({
						title: 'Notifikasi',
						text: data.message,
						type: 'success'
					});
					window.location = '<?php echo base_url() ?>' + data.beranda;
				}
			}).fail(function(data) {
				document.getElementById("submitform").removeAttribute('disabled');
				$('#submitform').html('Login');
				new PNotify({
					title: 'Notifikasi',
					text: "Request gagal, browser akan direload",
					type: 'danger'
				});
				window.setTimeout(function() {
					location.reload();
				}, 2000);
			});
			e.preventDefault();
		});
	</script>


</body>

</html>
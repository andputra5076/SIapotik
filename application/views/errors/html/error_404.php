<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed">
	<head>
	
		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
 
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-error error-outside">
			<div class="center-error">

				<div class="row">
					<div class="col-sm-8">
						<div class="main-error mb-xlg">
							<h2 class="error-code text-dark text-center text-semibold m-none">400 <i class="fa fa-file"></i></h2>
							<p class="error-explanation text-left">Maaf halaman anda cari tidak ada atau anda tidak memiliki hak akses untuk halaman tersebut.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<h4 class="text">Mulai lagi dari link dibawah</h4>
						<ul class="nav nav-list primary">
							<li><a href="javascript:history.back()"><i class="fa fa-caret-right text-dark"></i> Back to previous page</a></li>
							<li><a href="<?php echo config_item('base_url'); ?>dashboard/logout"><i class="fa fa-caret-right text-dark"></i> Login</a></li> 
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/jquery/jquery.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?php echo config_item('base_url'); ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo config_item('base_url'); ?>assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo config_item('base_url'); ?>assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo config_item('base_url'); ?>assets/javascripts/theme.init.js"></script>

	</body>
</html>
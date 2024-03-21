<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html class="fixed sidebar-left-collapsed">

<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="<?php echo base_url() ?>/assets/images/favicon.png" type="image/ico">
	<title>Apotek</title>
	<meta name="author" content="Paber">
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/skins/default.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme-custom.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/isotope/jquery.isotope.css" />
	<script src="<?php echo base_url() ?>assets/vendor/modernizr/modernizr.js"></script>
	<style type="text/css">
		.nama_produk {
			overflow: hidden;
			text-overflow: ellipsis;
			display: -webkit-box;
			line-height: 18px;
			/* fallback */
			height: 45px;
			/* fallback */
			max-height: 39px;
			/* fallback */
			-webkit-line-clamp: 2;
			/* number of lines to show */
			-webkit-box-orient: vertical;
		}

		.fit-image {
			width: 100%;
			object-fit: cover;
			height: 120px;
			/* only if you want fixed height */
		}

		.panel-featured-primary {
			margin-top: -15px;
		}
	</style>
</head>

<body class="bgbody">
	<section class="body">
		<!-- start: header -->

		<header class="header">
			<div class="logo-container">
				<a href="<?php echo base_url() ?>" class="logo">
					<img src="<?php echo base_url() ?>assets/images/logo.png" height="35" alt="Logo" />
				</a>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>

			<div class="header-right">
				<ul class="notifications">
					<!--
		        <li>
		        <a href="#" type="button" class="mb-xs mt-xs mr-xs btn btn-primary">
		        	<i class="fa  fa-list"></i> Retur</a>
		        </li> 
			-->
					<li>
						<a href="#" data-toggle="modal" data-target="#modal-hold" type="button" class="mb-xs mt-xs mr-xs btn btn-primary">
							<i class="fa  fa-list"></i> Data Hold</a>
					</li>
				</ul>


				<span class="separator"></span>
				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown">
						<div class="profile-info">
							<span class="name"><?php echo $this->session->userdata('nama_admin'); ?></span>
							<span class="role"><?php echo $this->session->userdata('nama_kategori'); ?></span>
						</div>
						<i class="fa custom-caret"></i>
					</a>
					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>password"><i class="fa fa-lock"></i> Ganti Password</a>
							</li>
							<li>
								<a role="menuitem" href="<?php echo base_url() ?>dashboard/logout"><i class="fa fa-power-off"></i> Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: page -->
			<div class="row">
				<div class="col-md-12  col-xl-5 col-lg-5">
					<section class="panel-featured-left panel-featured-primary">
						<div class="panel-body">
							<div class="input-group mb-md">
								<input type="text" class="form-control" value="Walk in Customer" readonly="" id="customer">
								<input type="hidden" name="customer" id="customer_dipilih">
								<div class="input-group-btn">
									<button tabindex="-1" class="btn btn-primary" type="button">Pembeli</button>
									<button tabindex="-1" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
										<span class="caret"></span>
									</button>
									<ul role="menu" class="dropdown-menu pull-right">
										<li><a href="#" id="onwalkcustomer">Walk in Customer</a></li>
										<li><a href="#" data-toggle="modal" data-target="#tambahData">Customer Baru</a></li>
										<li><a href="#" data-toggle="modal" data-target="#modal-pembeli">Data Customer</a></li>
									</ul>
								</div>
							</div>
						</div>
					</section>
					<br />
					<section class="panel-featured-left panel-featured-primary">
						<div class="panel-body  table-responsive" style="max-height:300px;" id="Keranjang">
							<table class="table table-responsive table-bordered table-hover table-striped dataTable no-footer">
								<thead>
									<tr>
										<th>Produk</th>
										<th>Kuantiti</th>
										<th>Harga</th>
										<th>Diskon</th>
										<th>Total</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="6" align="center"> Belum ada produk dipilih</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="panel-featured-left panel-featured-primary">

						<div class="panel-body" id="TotalBiaya">
							<table class="table table-striped">
								<tr>
									<th style="text-align: left;">Sub Total</th>
									<th style="text-align: right;">Rp 0</th>
								</tr>
								<tr class="primary">
									<th style="text-align: left;">Total</th>
									<th style="text-align: right;">Rp 0</th>
								</tr>
							</table>
						</div>
					</section>
					<section class="panel-featured-left panel-featured-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#modalHapus" id="canceltransaksi" disabled="disabled">Cancel</button>
								</div>
								<div class="col-md-4">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#modalHold" id="holdtransaksi" disabled="disabled">Hold</button>
								</div>
								<div class="col-md-4">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modal-payment" id="paymenttransaksi" disabled="disabled">Payment</button>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-md-12 col-lg-7 col-xl-7">
					<section class="panel-featured-right panel-featured-primary">
						<div class="panel-body">
							<div class="input-group mb-md">
								<input type="text" class="form-control" id="keywords" placeholder="Search Product Keyword" onkeyup="searchFilter()">
								<a class="input-group-addon btn-success btn"><i class="fa fa-search"></i></a>
								<select id="sortBy" onchange="searchFilter()" class="form-control">
									<option value="">Sort By</option>
									<option value="asc">Ascending</option>
									<option value="desc">Descending</option>
								</select>
							</div>
							<div class="row mg-files" id="postList" style="max-height: 500px;overflow-y: scroll;">

								<!-- END Product-->
								<?php if (!empty($posts)) : foreach ($posts as $post) : ?>

										<div class="col-sm-12 col-md-3 col-lg-3">
											<div class="thumbnail">
												<div class="thumb-preview">
													<img src="<?php echo base_url() ?>/images/<?php echo $post['gambar']; ?>" class="img-responsive fit-image" alt="Foto Produk">
												</div>
												<span class="mg-title nama_produk">
													<?php if ($post['jenis'] == 'racikan') echo "<b>[racikan]</b>"; ?> <?php echo $post['nama_item']; ?>
												</span>
												<span class="mg-title">
													<a style="text-decoration: none; cursor: default;">Jumlah Stok Tersedia</a>
													<?php echo $post['stok']; ?>
												</span>
												<div class="row">
													<div class="col-md-12">
														<span class="text-bold">
															<?php echo rupiah($post['harga_jual']); ?>
														</span>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<a id="beli-item<?php echo $post['kode_item']; ?>" class="btn btn-xs btn-success" onclick="beli(this)" data-barcode="<?php echo $post['kode_item']; ?>"><i class="fa fa-shopping-cart"></i> Beli Produk</a>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach;
								else : ?>
									<div class="col-sm-12 col-md-12 col-lg-12">
										<p>Product not available.</p>
									</div>
								<?php endif; ?>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<ul class="pagination">
										<?php echo $this->ajax_pagination->create_links(); ?>
									</ul>
								</div>

								<!-- END PRoduct-->
							</div>
						</div>
					</section>
				</div>
			</div>
			<!-- end: page -->
		</div>
	</section>

	<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<section class="panel panel-primary">
					<?php echo form_open('master/pembelitambah', ' id="FormulirTambah"'); ?>
					<header class="panel-heading">
						<h2 class="panel-title">Tambah pembeli</h2>
					</header>
					<div class="panel-body">
						<div class="form-group mt-lg kode_dokter">
							<label class="col-sm-3 control-label">Rekomendasi Dokter<span></span></label>
							<div class="col-sm-9">
								<select data-plugin-selectTwo class="form-control" name="kode_dokter">
									<option value="">Pilih Dokter</option>
									<?php foreach ($dokter as $dok) : ?>
										<option value="<?php echo $dok->kode_dokter; ?>"><?php echo $dok->nama_dokter; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group mt-lg nama_pembeli">
							<label class="col-sm-3 control-label">Nama pembeli<span class="required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="nama_pembeli" class="form-control" required />
							</div>
						</div>
						<div class="form-group jenis_kelamin">
							<label class="col-sm-3 control-label">Jenis Kelamin<span class="required">*</span></label>
							<div class="col-sm-9">
								<div class="radio-custom radio-primary">
									<input id="awesome" name="jenis_kelamin" type="radio" value="laki-laki" required>
									<label for="awesome">Laki-laki</label>
								</div>
								<div class="radio-custom radio-primary">
									<input id="very-awesome" name="jenis_kelamin" type="radio" value="perempuan">
									<label for="very-awesome">Perempuan</label>
								</div>
							</div>
						</div>
						<div class="form-group telepon">
							<label class="col-sm-3 control-label">Telepon</label>
							<div class="col-sm-9">
								<input type="text" name="telepon" class="form-control" />
							</div>
						</div>
						<div class="form-group email">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="text" name="email" class="form-control" />
							</div>
						</div>
						<div class="form-group handphone">
							<label class="col-sm-3 control-label">Handphone<span class="required">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="handphone" class="form-control" required />
							</div>
						</div>
						<div class="form-group alamat">
							<label class="col-sm-3 control-label">Alamat<span class="required">*</span></label>
							<div class="col-sm-9">
								<textarea rows="2" class="form-control" name="alamat" required></textarea>
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

	<div class="modal fade" id="modal-pembeli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<section class="panel panel-primary">
					<header class="panel-heading">
						<h2 class="panel-title">Data Customer</h2>
					</header>
					<div class="panel-body">
						<table class="table table-bordered table-hover table-striped" id="pembelidata">
							<thead>
								<tr>
									<th>Nama pembeli</th>
									<th>Jenis Kelamin</th>
									<th>Handphone</th>
									<th>Email</th>
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
						<h2 class="panel-title">Konfirmasi Pembatalan</h2>
					</header>
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-icon">
								<i class="fa fa-question-circle"></i>
							</div>
							<div class="modal-text">
								<h4>Yakin ingin membatalkan transaksi ?</h4>
							</div>
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-danger" id="Batalkan">Ya, Saya Yakin</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</footer>
				</section>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalHold" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<?php echo form_open('penjualan/holdtransaksi', ' id="FormulirHold"'); ?>
				<section class="panel  panel-primary">
					<header class="panel-heading">
						<h2 class="panel-title">Konfirmasi Hold Transaksi </h2>
					</header>
					<div class="panel-body">
						<div class="modal-wrapper">
							<div class="modal-icon">
								<i class="fa fa-question-circle"></i>
							</div>
							<div class="modal-text">
								<h4>Yakin ingin hold transaksi ini ?</h4>
							</div>
							<div class="form-group keterangan_hold">
								<div class="col-sm-12">
									<textarea rows="2" placeholder="Tambahkan Keterangan" maxlength="100" class="form-control" name="keterangan_hold"></textarea>
								</div>
							</div>
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<input type="hidden" name="idd" id="idddelete">
								<button type="submit" class="btn btn-danger" id="submitformHold">Ya, Saya Yakin</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</footer>
				</section>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-hold" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<section class="panel panel-primary">
					<header class="panel-heading">
						<h2 class="panel-title">Data Hold</h2>
					</header>
					<div class="panel-body">
						<table class="table table-bordered table-hover table-striped" id="listhold">
							<thead>
								<tr>
									<th>No</th>
									<th>Keterangan</th>
									<th>Waktu</th>
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


	<div class="modal fade bd-example-modal-lg" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width:60%">
			<div class="modal-content">
				<?php echo form_open('penjualan/submitpayment', ' id="FormulirPayment"'); ?>
				<input type="hidden" name="post_totalbelanja" id="post_totalbelanja" value="0">
				<section class="panel panel-primary">
					<header class="panel-heading">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
						<h2 class="panel-title">Checkout dan Pembayaran</h2>
					</header>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3">
								<div class="btn-group-vertical col-md-12">
									<h3 class="text-semibold text-dark text-uppercase mb-none text-center">Nominal</h3>
									<input type="hidden" id="Valtotalharusdibayar">
									<button type="button" class="btn btn-primary" id="totalharusdibayar"></button>
									<button type="button" onclick="cash(this)" data-nominal="5000" class="btn btn-success">Rp 5.000</button>
									<button type="button" onclick="cash(this)" data-nominal="10000" class="btn btn-success">Rp 10.000</button>
									<button type="button" onclick="cash(this)" data-nominal="20000" class="btn btn-success">Rp 20.000</button>
									<button type="button" onclick="cash(this)" data-nominal="50000" class="btn btn-success">Rp 50.000</button>
									<button type="button" onclick="cash(this)" data-nominal="100000" class="btn btn-success">Rp 100.000</button>
									<button type="button" onclick="cash(this)" data-nominal="200000" class="btn btn-success">Rp 200.000</button>
									<button type="button" onclick="clearcash()" class="btn btn-danger">Clear</button>
								</div>
							</div>

							<div class="col-md-9">
								<section class="panel">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Total Dibayar</label>
												<input type="text" name="totaldibayar[]" id="totaldibayar1" value="0" class="form-control mask_price" required />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Cara Bayar</label>
												<select class="form-control cara_bayar" name="cara_bayar[]" id="cara_bayar1">
													<option value="cash">cash</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row" id="noncash1" style="display:none;">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Swipe" name="swipe[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Card No" name="card_no[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Holder name" name="holder_name[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Month" name="month[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Year" name="year[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Security code" name="security_code[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<select class="form-control" name="bank[]" id="bank1">
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"></label>
												<textarea rows="2" placeholder="Catatan Pembayaran" class="form-control" name="catatan[]"></textarea>
											</div>
										</div>
									</div>
									<div class="row" id="tambah1">
										<div class="col-md-12">
											<div class="form-group">
												
											</div>
										</div>
									</div>
								</section>


								<section class="panel" id="formbayar2" style="display:none;">
									<header>
										<a href="#" class="fa fa-times" id="tutup1"> Tutup</a>
									</header>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Total Dibayar</label>
												<input type="text" name="totaldibayar[]" id="totaldibayar2" value="0" class="form-control mask_price" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Cara Bayar</label>
												<select class="form-control cara_bayar" name="cara_bayar[]" id="cara_bayar2">
													<option value="cash">cash</option>
													<option value="credit card">credit card</option>
													<option value="debet">debet</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row" id="noncash2" style="display:none;">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Swipe" name="swipe[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Card No" name="card_no[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Holder name" name="holder_name[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Month" name="month[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Year" name="year[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<input type="text" placeholder="Security code" name="security_code[]" class="form-control" />
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label"></label>
												<select class="form-control" name="bank[]" id="bank2">
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"></label>
												<textarea rows="2" placeholder="Catatan Pembayaran" class="form-control" name="catatan[]"></textarea>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover mb-none">
									<tr>
										<th>
											<h4>Total Belanja</h4>
										</th>
										<th>
											<h4 class="text-dark" id="TotalBelanja"></h4>
											<input type="hidden" id="TotalBelanjaInt">
										</th>
										<th>
											<h4>Total Dibayar</h4>
										</th>
										<th>
											<h4 class="text-dark">Rp <span id="GrandTotalDibayar">0</span></h4>
										</th>
									</tr>
									<tr>
										<th>
											<h4>Total Item</h4>
										</th>
										<th>
											<h4 class="text-dark" id="TotalKuantiti"></h4>
										</th>
										<th>
											<h4>Kembalian</h4>
										</th>
										<th>
											<h4 class="text-dark">Rp <span id="Kembalian">0</span></h4>
										</th>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-right">
								<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success btn-lg btn-block" id="submitPayment" disabled>Submit Payment</button>
							</div>
						</div>
					</footer>
				</section>
				</form>
			</div>
		</div>
	</div>


	<!-- Vendor -->
	<script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/isotope/jquery.isotope.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
	<script src="<?php echo base_url() ?>assets/vendor/pnotify/pnotify.custom.js"></script>
	<script src="<?php echo base_url() ?>assets/javascripts/theme.js"></script>
	<script src="<?php echo base_url() ?>assets/javascripts/theme.init.js"></script>
	<script>
		function paymentsubmit(total, dibayar) {
			if (total <= dibayar) {
				document.getElementById("submitPayment").removeAttribute('disabled');
			} else {
				document.getElementById("submitPayment").setAttribute('disabled', 'disabled');
			}
		}
		$('#totaldibayar1').keyup(function() {
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var nilai_1 = $(this).val();
			nilai_1 = nilai_1.replace(/\./g, '');
			var nilai_2 = document.getElementById("totaldibayar2").value;
			nilai_2 = nilai_2.replace(/\./g, '');
			var nilaibayar = Number(nilai_1) + Number(nilai_2);
			var kembalian = (nilaibayar - totalbelanja) < 1 ? '0' : (nilaibayar - totalbelanja);
			$('#GrandTotalDibayar').html(formatNumber(nilaibayar));
			$('#Kembalian').html(formatNumber(kembalian));
			paymentsubmit(totalbelanja, nilaibayar);
		});
		$('#totaldibayar2').keyup(function() {
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var nilai_2 = $(this).val();
			nilai_2 = nilai_2.replace(/\./g, '');
			var nilai_1 = document.getElementById("totaldibayar1").value;
			nilai_1 = nilai_1.replace(/\./g, '');
			var nilaibayar = Number(nilai_1) + Number(nilai_2);
			var kembalian = (nilaibayar - totalbelanja) < 1 ? '0' : (nilaibayar - totalbelanja);
			$('#GrandTotalDibayar').html(formatNumber(nilaibayar));
			$('#Kembalian').html(formatNumber(kembalian));
			paymentsubmit(totalbelanja, nilaibayar);
		});
		$('#cara_bayar1').change(function() {
			var carabayar = $(this).val();
			if (carabayar !== 'cash') {
				document.getElementById("noncash1").style.display = "block";
				$.ajax({
					type: 'GET',
					url: '<?php echo base_url() ?>penjualan/bankjenis',
					data: 'jenis=' + carabayar,
					dataType: 'json',
					success: function(response) {
						var datarow = '';
						$.each(response.datasub, function(i, itemsub) {
							datarow += "<option value='" + itemsub.singkatan + "'>" + itemsub.singkatan + "</option>";
						});
						$('#bank1').html(datarow);
					}
				});
			} else {
				document.getElementById("noncash1").style.display = "none";
			}
		});
		$('#cara_bayar2').change(function() {
			var carabayar = $(this).val();
			if (carabayar !== 'cash') {
				document.getElementById("noncash2").style.display = "block";
				$.ajax({
					type: 'GET',
					url: '<?php echo base_url() ?>penjualan/bankjenis',
					data: 'jenis=' + carabayar,
					dataType: 'json',
					success: function(response) {
						var datarow = '';
						$.each(response.datasub, function(i, itemsub) {
							datarow += "<option value='" + itemsub.singkatan + "'>" + itemsub.singkatan + "</option>";
						});
						$('#bank2').html(datarow);
					}
				});
			} else {
				document.getElementById("noncash2").style.display = "none";
			}
		});
		$('#btntambah1').click(function() {
			document.getElementById("tambah1").style.display = "none";
			document.getElementById("formbayar2").style.display = "block";
		});
		$('#tutup1').click(function() {
			document.getElementById("tambah1").style.display = "block";
			document.getElementById("formbayar2").style.display = "none";
			$('#totaldibayar2').val('0');
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var nilai_2 = 0;
			var nilai_1 = document.getElementById("totaldibayar1").value;
			nilai_1 = nilai_1.replace(/\./g, '');
			var nilaibayar = Number(nilai_1) + Number(nilai_2);
			var kembalian = (nilaibayar - totalbelanja) < 1 ? '0' : (nilaibayar - totalbelanja);
			$('#GrandTotalDibayar').html(formatNumber(nilaibayar));
			$('#Kembalian').html(formatNumber(kembalian));
			paymentsubmit(totalbelanja, nilaibayar);
		});

		function cash(elem) {
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var nilai_1 = document.getElementById("totaldibayar1").value;
			nilai_1 = nilai_1.replace(/\./g, '');
			var nilai_2 = document.getElementById("totaldibayar2").value;
			nilai_2 = nilai_2.replace(/\./g, '');
			var nilaibayar = Number(nilai_1) + Number(nilai_2);
			var nominal = $(elem).data("nominal");
			nominal = nominal + Number(nilaibayar);
			paymentsubmit(totalbelanja, nominal);
			var kembalian = (nominal - totalbelanja) < 1 ? '0' : (nominal - totalbelanja);
			nominal = formatNumber(nominal);
			$('#totaldibayar1').val(nominal);
			$('#GrandTotalDibayar').html(formatNumber(nominal));
			$('#Kembalian').html(formatNumber(kembalian));
		}
		document.getElementById("totalharusdibayar").addEventListener("click", function(e) {
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var nilai_1 = document.getElementById("totaldibayar1").value;
			nilai_1 = nilai_1.replace(/\./g, '');
			var nilai_2 = document.getElementById("totaldibayar2").value;
			nilai_2 = nilai_2.replace(/\./g, '');
			var nilaibayar = Number(nilai_1) + Number(nilai_2);
			var nominal = document.getElementById("Valtotalharusdibayar").value;
			nominal = Number(nominal) + Number(nilaibayar);
			paymentsubmit(totalbelanja, nominal);
			var kembalian = (nominal - totalbelanja) < 1 ? '0' : (nominal - totalbelanja);
			nominal = formatNumber(nominal);
			$('#totaldibayar1').val(nominal);
			$('#GrandTotalDibayar').html(formatNumber(nominal));
			$('#Kembalian').html(formatNumber(kembalian));
		});

		function formatNumber(num) {
			return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
		}

		function clearcash() {
			var totalbelanja = document.getElementById("TotalBelanjaInt").value;
			var kembalian = 0;
			$('#totaldibayar1').val('0');
			$('#totaldibayar2').val('0');
			$('#GrandTotalDibayar').html(formatNumber(0));
			$('#Kembalian').html(formatNumber(kembalian));
			document.getElementById("tambah1").style.display = "block";
			document.getElementById("formbayar2").style.display = "none";
			paymentsubmit(totalbelanja, 0);
		}
		var stack_bottomright = {
			"dir1": "up",
			"dir2": "left",
			"firstpos1": 15,
			"firstpos2": 15
		};

		function pilihhold(elem) {
			var idkeranjang = $(elem).data("id");
			PNotify.removeAll();
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/tampilkanhold',
				data: 'idkeranjang=' + idkeranjang,
				dataType: 'json',
				success: function(response) {
					$('#customer').val(response.nama_pembeli);
					$('#customer_dipilih').val(response.id_pembeli);
					keranjang();
					tablehold.ajax.reload();
					$('#modal-hold').modal('hide');
				}
			});
		}

		function beli(elem) {
			var kodebarcode = $(elem).data("barcode");
			document.getElementById("beli-item" + kodebarcode).setAttribute('disabled', 'disabled');
			var pembeli = document.getElementById("customer_dipilih").value;
			if (kodebarcode != '') {
				$.ajax({
					type: 'GET',
					url: '<?php echo base_url() ?>penjualan/tambahkeranjangbarcode',
					data: 'barcode=' + kodebarcode + '&pembeli=' + pembeli,
					dataType: 'json',
					success: function(response) {
						if (response.response == '0') {
							new PNotify({
								title: 'Notifikasi',
								text: 'Kode Barcode Tidak Ditemukan',
								type: 'warning'
							});
						} else if (response.response == 'stok kosong') {
							new PNotify({
								title: 'Notifikasi',
								text: 'Stok Kosong',
								type: 'warning'
							});
						} else {
							keranjang()
							document.getElementById("beli-item" + kodebarcode).removeAttribute('disabled');
						}
					}
				});
			}
		}

		function tambah(elem) {
			var idd = $(elem).data("kode");
			document.getElementById("tambah" + idd).setAttribute('disabled', 'disabled');
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/keranjangtambah',
				data: 'idd=' + idd,
				dataType: 'json',
				success: function(response) {
					keranjang()
				}
			});
		}

		function kurang(elem) {
			var idd = $(elem).data("kode");
			document.getElementById("kurang" + idd).setAttribute('disabled', 'disabled');
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/keranjangkurang',
				data: 'idd=' + idd,
				dataType: 'json',
				success: function(response) {
					keranjang()
				}
			});
		}

		function hapus(elem) {
			var idd = $(elem).data("kode");
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/keranjanghapus',
				data: 'idd=' + idd,
				dataType: 'json',
				success: function(response) {
					keranjang()
				}
			});
		}

		function update_pembeli() {
			var pembeli = document.getElementById("customer_dipilih").value;
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/update_pembeli',
				data: 'pembeli=' + pembeli,
				dataType: 'json',
				success: function(response) {
					keranjang()
				}
			});
		}

		document.getElementById("onwalkcustomer").addEventListener("click", function(e) {
			$('#customer').val('Walk in Customer');
			$('#customer_dipilih').val('');
			update_pembeli();
		});

		function pilihpembeli(elem) {
			var namapembeli = $(elem).data("namapembeli");
			var idpembeli = $(elem).data("id");
			$('#customer').val(namapembeli);
			$('#customer_dipilih').val(idpembeli);
			$('#modal-pembeli').modal('hide');
			update_pembeli();
		}

		var tablepembeli = $('#pembelidata').DataTable({
			"ajax": {
				url: "<?php echo base_url() ?>penjualan/datapembeli",
				type: 'GET'
			},
		});

		var tablehold = $('#listhold').DataTable({
			"ajax": {
				url: "<?php echo base_url() ?>penjualan/datahold",
				type: 'GET'
			},
		});

		function searchFilter(page_num) {
			page_num = page_num ? page_num : 0;
			var keywords = $('#keywords').val();
			var sortBy = $('#sortBy').val();
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url(); ?>penjualan/ajaxPaginationData/' + page_num,
				data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy,
				beforeSend: function() {
					$('.loading').show();
				},
				success: function(html) {
					$('#postList').html(html);
				}
			});
		}
		document.getElementById("FormulirTambah").addEventListener("submit", function(e) {
			blurForm();
			$('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitform").setAttribute('disabled', 'disabled');
			$('#submitform').html('Loading ...');
			var form = $('#FormulirTambah')[0];
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
					document.getElementById("submitform").removeAttribute('disabled');
					$('#submitform').html('Submit');
					var objek = Object.keys(data.errors);
					for (var key in data.errors) {
						if (data.errors.hasOwnProperty(key)) {
							var msg = '<div class="help-block" for="' + key + '">' + data.errors[key] + '</span>';
							$('.' + key).addClass('has-error');
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
					$('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(data.token);
					PNotify.removeAll();
					tablepembeli.ajax.reload();
					document.getElementById("submitform").removeAttribute('disabled');
					$('#tambahData').modal('hide');
					document.getElementById("FormulirTambah").reset();
					$('#submitform').html('Submit');
					new PNotify({
						title: 'Notifikasi',
						text: data.message,
						type: 'success'
					});
					$('#customer').val(data.pembeli);
					$('#customer_dipilih').val(data.id_pembeli);
					update_pembeli();
					$('#tambahData').modal('hide');
				}
			}).fail(function(data) {
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
		

		function keranjang() {
			$('#cara_bayar1').val('cash');
			$('#cara_bayar2').val('cash');
			$('#totaldibayar1').val('0');
			$('#totaldibayar2').val('0');
			$('#GrandTotalDibayar').html('0');
			document.getElementById("noncash1").style.display = "none";
			document.getElementById("noncash2").style.display = "none";
			document.getElementById("tambah1").style.display = "block";
			document.getElementById("formbayar2").style.display = "none";
			$('#Kembalian').html('0');
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/keranjangdetail',
				dataType: 'json',
				success: function(response) {
					if (response.datarows != '') {
						var viewtotal = '<table class="table table-striped">';
						var totalharusdibayar, totalharusdibayarInt, TotalKuantiti, TotalBelanja;
						$.each(response.datarows, function(i, item) {
							if (item.total_upah_peracik_int > 0) {
								viewtotal += '<tr>';
								viewtotal += '<th style="text-align: left;">Total Upah Peracik</th>';
								viewtotal += '<th style="text-align: right;">' + item.total_upah_peracik + '</th>';
								viewtotal += '</tr>';
							}
							viewtotal += '<tr>';
							viewtotal += '<th style="text-align: left;">Sub Total</th>';
							viewtotal += '<th style="text-align: right;">' + item.total_harga_item + '</th>';
							viewtotal += '</tr>';
							viewtotal += '<tr  class="primary">';
							viewtotal += '<th style="text-align: left;">Total</th>';
							viewtotal += '<th style="text-align: right;">' + item.total + '</th>';
							viewtotal += '</tr> ';
							totalharusdibayar = item.total;
							totalharusdibayarInt = item.totalInt;
							TotalKuantiti = item.totalKuantiti;
							TotalBelanja = item.total;
						});
						viewtotal += '</table>';
						$('#TotalBiaya').html(viewtotal);
						$('#TotalBelanja').html(TotalBelanja);
						$('#TotalBelanjaInt').val(totalharusdibayarInt);
						$('#post_totalbelanja').val(totalharusdibayarInt);
						$('#totalharusdibayar').html(totalharusdibayar);
						$('#TotalKuantiti').html(TotalKuantiti);
						$('#Valtotalharusdibayar').val(totalharusdibayarInt);

					} else {
						var viewtotal = '<table class="table table-striped">';
						viewtotal += '<tr><th style="text-align: left;">Sub Total</th>';
						viewtotal += '<th style="text-align: right;">Rp 0</th>';
						viewtotal += '</tr>';
						viewtotal += '<tr  class="primary">';
						viewtotal += '<th style="text-align: left;">Total</th>';
						viewtotal += '<th style="text-align: right;">Rp 0</th>';
						viewtotal += '</tr></table>';
						$('#TotalBiaya').html(viewtotal);
						$('#totalharusdibayar').html('Rp 0');
					}
					if (response.datasub != '') {
						var datarow = '<table class="table table-responsive table-bordered table-hover table-striped dataTable no-footer" style="font-size:11px;">';
						datarow += '<thead>';
						datarow += '<tr><th>Produk</th><th>Kuantiti</th><th style="min-width:70px;">Harga</th><th style="min-width:70px;">Diskon</th><th style="min-width:90px;">Total</th><th></th></tr></thead><tbody>';
						$.each(response.datasub, function(i, itemsub) {
							datarow += '<tr>';
							datarow += '<td>' + itemsub.nama_item + '</td>';
							datarow += '<td>';
							datarow += '<div>';
							datarow += '<div class="input-group" style="width:110px;">';
							datarow += '<input type="text" readonly style="background-color:#fff;" value="' + itemsub.kuantiti + '" data-kode="' + itemsub.id + '"  class="spinner-input form-control" maxlength="3">';
							datarow += '<div class="spinner-buttons input-group-btn">';
							datarow += '<button type="button"   id="tambah' + itemsub.id + '" onclick="tambah(this)" data-kode="' + itemsub.id + '" class="btn btn-sm spinner-up">';
							datarow += '<i class="fa fa-angle-up"></i>';
							datarow += '</button>';
							datarow += '<button type="button" id="kurang' + itemsub.id + '" onclick="kurang(this)" data-kode="' + itemsub.id + '" class="btn btn-sm spinner-down">';
							datarow += '<i class="fa fa-angle-down"></i>';
							datarow += '</button>';
							datarow += '</div>';
							datarow += '</div>';
							datarow += '</div>';
							datarow += '</td>';
							datarow += '<td>' + itemsub.harga + '</td>';
							datarow += '<td>' + itemsub.diskon + '</td>';
							datarow += '<td>' + itemsub.total + '</td>';
							datarow += '<td><a class="btn btn-danger btn-xs"  onclick="hapus(this)" data-kode="' + itemsub.id + '" ><i class="fa fa-trash-o"></i></a></td>';
							datarow += '</tr>';
						});
						datarow += '</tbody></table>';
						$('#Keranjang').html(datarow);
						document.getElementById("canceltransaksi").removeAttribute('disabled');
						document.getElementById("holdtransaksi").removeAttribute('disabled');
						document.getElementById("paymenttransaksi").removeAttribute('disabled');
					} else {

						var datarow = '<table class="table table-responsive table-bordered table-hover table-striped dataTable no-footer" style="font-size:11px;">';
						datarow += '<thead>';
						datarow += '<tr><th>Produk</th><th>Kuantiti</th><th style="min-width:70px;">Harga</th><th style="min-width:70px;">Diskon</th><th style="min-width:90px;">Total</th><th></th></tr></thead><tbody>';
						datarow += '<tr><td colspan="6"align="center" >Belum ada produk dipilih</td></tr>';
						datarow += '</tbody></table>';
						$('#Keranjang').html(datarow);
						document.getElementById("canceltransaksi").setAttribute('disabled', 'disabled');
						document.getElementById("holdtransaksi").setAttribute('disabled', 'disabled');
						document.getElementById("paymenttransaksi").setAttribute('disabled', 'disabled');
					}
				}
			});
		}
		keranjang();

		document.getElementById("Batalkan").addEventListener("click", function(e) {
			PNotify.removeAll();
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>penjualan/canceltransaksi',
				dataType: 'json',
				success: function(response) {
					window.setTimeout(function() {
						new PNotify({
							title: 'Notifikasi',
							text: 'Berhasil mereset transaksi',
							type: 'success',
							addclass: 'stack-bottomright',
							stack: stack_bottomright
						});
						keranjang()
						$('#customer').val('Walk in Customer');
						$('#customer_dipilih').val('');
						$('#modalHapus').modal('hide');
					}, 500);
				}
			});
		});

		document.getElementById("FormulirHold").addEventListener("submit", function(e) {
			blurForm();
			$('.help-block').hide();
			$('.form-group').removeClass('has-error');
			document.getElementById("submitformHold").setAttribute('disabled', 'disabled');
			$('#submitformHold').html('Loading ...');
			var form = $('#FormulirHold')[0];
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
						document.getElementById("submitformHold").removeAttribute('disabled');
						$('#submitformHold').html('Ya, Saya Yakin');
						var objek = Object.keys(data.errors);
						for (var key in data.errors) {
							if (data.errors.hasOwnProperty(key)) {
								var msg = '<div class="help-block" for="' + key + '">' + data.errors[key] + '</span>';
								$('.' + key).addClass('has-error');
								$('textarea[name="' + key + '"]').after(msg);
							}
						}
					}, 500);
					return false;
				} else {
					$('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(data.token);
					PNotify.removeAll();
					keranjang();
					tablehold.ajax.reload();
					document.getElementById("submitformHold").removeAttribute('disabled');
					$('#modalHold').modal('hide');
					document.getElementById("FormulirHold").reset();
					$('#submitformHold').html('Ya, Saya Yakin');
					window.setTimeout(function() {
						new PNotify({
							title: 'Notifikasi',
							text: 'Berhasil hold transaksi',
							type: 'success',
							addclass: 'stack-bottomright',
							stack: stack_bottomright
						});
						$('#customer').val('Walk in Customer');
						$('#customer_dipilih').val('');
						$('#modalHold').modal('hide');
					}, 500);
				}
			}).fail(function(data) {
				alert('request gagal');
				location.reload();
			});
			e.preventDefault();
		});


		document.getElementById("FormulirPayment").addEventListener("submit", function(e) {
			blurForm();
			document.getElementById("submitPayment").setAttribute('disabled', 'disabled');
			$('#submitPayment').html('Loading ...');
			var form = $('#FormulirPayment')[0];
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
					$('#submitPayment').html('Submit Payment');
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
					$('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(data.token);
					PNotify.removeAll();
					document.getElementById("FormulirPayment").reset();
					$('#submitPayment').html('Submit Payment');
					new PNotify({
						title: 'Notifikasi',
						text: data.message,
						type: 'success'
					});
					keranjang()
					$('#customer').val('Walk in Customer');
					$('#customer_dipilih').val('');
					$('#modal-payment').modal('hide');
				}
			}).fail(function(data) {
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
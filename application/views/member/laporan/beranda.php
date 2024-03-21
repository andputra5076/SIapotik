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
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/skins/default.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/theme-custom.css">
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/morris/morris.css" />
    <script src="<?php echo base_url() ?>assets/vendor/modernizr/modernizr.js"></script>
</head>

<body class="bgbody">
    <section class="body">

        <!-- start: header -->
        <?php $this->load->view("komponen/header.php") ?>
        <!-- end: header -->

        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <?php $this->load->view("komponen/sidebar.php") ?>
            <!-- end: sidebar -->

            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Laporan</h2>
                </header>

                <!-- start: page -->
                <section class="content-with-menu content-with-menu-has-toolbar media-gallery">
                    <div class="content-with-menu-container">
                        <div class="inner-menu-toggle">
                            <a href="#" class="inner-menu-expand" data-open="inner-menu">
                                show bar <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                        <menu id="content-menu" class="inner-menu" role="menu">
                            <div class="nano">
                                <div class="nano-content">
                                    <div class="inner-menu-toggle-inside">
                                        <a href="#" class="inner-menu-collapse">
                                            <i class="fa fa-chevron-up visible-xs-inline"></i><i class="fa fa-chevron-left hidden-xs-inline"></i> Hide Bar
                                        </a>
                                        <a href="#" class="inner-menu-expand" data-open="inner-menu">
                                            Show Bar <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </div>
                                    <div class="inner-menu-content">
                                        <div class="sidebar-widget m-none">
                                            <div class="widget-content">
                                                <ul class="mg-folders">
                                                    <li>
                                                        <a href="<?php echo base_url() ?>laporan/pembelian" class="menu-item"><i class="fa fa-folder"></i> Laporan Pembelian</a>
                                                        <div class="item-options">
                                                            <a href="<?php echo base_url() ?>laporan/pembelian">
                                                                <i class="fa fa-arrow-circle-o-left"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() ?>laporan/stok" class="menu-item"><i class="fa fa-folder"></i> Laporan Stok</a>
                                                        <div class="item-options">
                                                            <a href="<?php echo base_url() ?>laporan/stok">
                                                                <i class="fa fa-arrow-circle-o-left"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() ?>laporan/penjualan" class="menu-item"><i class="fa fa-folder"></i> Laporan Penjualan</a>
                                                        <div class="item-options">
                                                            <a href="<?php echo base_url() ?>laporan/penjualan">
                                                                <i class="fa fa-arrow-circle-o-left"></i>
                                                            </a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </menu>
                    </div>
                </section>
                <!-- end: page -->
            </section>
        </div>

    </section>


    <!-- Vendor -->
    <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="<?php echo base_url() ?>assets/javascripts/theme.js"></script>
    <script src="<?php echo base_url() ?>assets/javascripts/theme.init.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/raphael/raphael.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/morris/morris.js"></script>
    <script>
        $.ajax({
            url: '<?php echo base_url() ?>dashboard/cash_2_minggu', // getchart.php
            dataType: 'JSON',
            type: 'GET',
            success: function(response) {

                Morris.Line({
                    resize: true,
                    element: 'GrafikCash',
                    data: response,
                    xkey: 'tanggal',
                    ykeys: ['masuk', 'keluar'],
                    labels: ['Uang Masuk (Rp) ', 'Uang Keluar (Rp) '],
                    hideHover: true,
                    lineColors: ['#0088cc', '#734ba9'],
                    xLabelFormat: function(d) {
                        return ("0" + d.getDate()).slice(-2) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear();
                    },
                    xLabelAngle: 45,
                });
            }
        });


        $.ajax({
            url: '<?php echo base_url() ?>dashboard/laporan_ringkas', // getchart.php
            dataType: 'JSON',
            type: 'GET',
            success: function(response) {
                $.each(response, function(i, item) {
                    $('#akan_jatuh_tempo').html(item.akan_jatuh_tempo);
                    $('#dibayar_minggu_ini').html(item.dibayar_minggu);
                    $('#total_hutang_belum_bayar').html(item.total_hutang_belum_bayar);
                    $('#sudah_jatuh_tempo').html(item.sudah_jatuh_tempo);
                });
            }
        });
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>dashboard/produk_kadaluarsa',
            dataType: 'json',
            success: function(response) {
                var i = 0;
                var datarow = '';
                $.each(response.datasub, function(i, itemsub) {
                    i = i + 1;
                    datarow += "<tr><td>" + i + "</td>";
                    datarow += "<td>" + itemsub.kode_item + "</td>";
                    datarow += "<td>" + itemsub.nama_item + "</td>";
                    datarow += "<td>" + itemsub.tgl_expired + "</td>";
                    datarow += "</tr>";
                });
                if (datarow == '') {
                    $('#kadaluarsa').append('<tr><td colspan="4" align="center"> Tidak ada produk akan kadaluarsa</td></tr>');
                } else {
                    $('#kadaluarsa').append(datarow);
                }
            }
        });

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>dashboard/produk_terlaris',
            dataType: 'json',
            success: function(response) {
                var i = 0;
                var datarow = '';
                $.each(response.datasub, function(i, itemsub) {
                    i = i + 1;
                    datarow += "<tr><td>" + i + "</td>";
                    datarow += "<td>" + itemsub.kode_item + "</td>";
                    datarow += "<td>" + itemsub.nama_item + "</td>";
                    datarow += "<td>" + itemsub.total + "</td>";
                    datarow += "</tr>";
                });
                if (datarow == '') {
                    $('#produk_terlaris').append('<tr><td colspan="4" align="center"> Tidak ada produk data</td></tr>');
                } else {
                    $('#produk_terlaris').append(datarow);
                }
            }
        });

        $.ajax({
            url: '<?php echo base_url() ?>dashboard/penjualan_2_minggu', // getchart.php
            dataType: 'JSON',
            type: 'GET',
            data: {
                get_values: true
            },
            success: function(response) {
                Morris.Line({
                    resize: true,
                    element: 'GrafikPenjualan',
                    data: response,
                    xkey: 'tanggal',
                    ykeys: ['jumlah'],
                    labels: ['Jumlah Transaksi'],
                    hideHover: true,
                    lineColors: ['#0088cc'],
                    xLabelFormat: function(d) {
                        return ("0" + d.getDate()).slice(-2) + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear();
                    },
                    xLabelAngle: 45,
                });
            }
        });
    </script>

</body>

</html>